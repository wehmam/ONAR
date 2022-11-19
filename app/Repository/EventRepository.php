<?php 

namespace App\Repository;

use App\Models\Event;
use App\Models\EventDetail;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventRepository {

    public function createOrUpdateEvent($params, $id = null) {
        try {

            DB::beginTransaction();

            $findEvent = Event::find($id);
            if(!$findEvent) {
                $events = new Event();
            } else {
                $events = $findEvent;
            }

            $events->company_id = $params["company_id"];
            $events->event_type = $params["event_type"];
            $events->has_active = $params["has_active"];
            $events->event_slug = self::createSlug($params["title"]);
            // if(!$findEvent) {
                // $lastEvent = Event::whereNotNull('event_number')
                //     ->orderBy('id', 'DESC')
                //     ->take(1)
                //     ->first('event_number');

                // if(!$lastEvent) {
                //     $eventNumber = 'ONR' . date('ymd') . '0001';
                // } else {
                //     $explode = explode('ONR', $lastEvent->event_number);

                //     if (strlen($explode[1]) > 10) {
                //         $date = date('Ymd');
                //         $day = substr($explode[1], 0, 8);
                //         $num = substr($explode[1], -3);
                //     } else {
                //         $date = date('ymd');
                //         $day = substr($explode[1], 0, 6);
                //         $num = substr($explode[1], -4);
                //     }

                //     if($day == $date) {
                //         $eventNumber = 'ONR' . date('ymd') . sprintf('%04d', (int) $num + 1);
                //     } else {
                //         $eventNumber = 'ONR' . date('ymd') . sprintf('%04d', 1);
                //     }
                // }
                // $events->event_number = $eventNumber;
            // }            
            $events->save();

            $findEventDetail = EventDetail::where("event_id", $events->id)
                ->first();
            
            if(!$findEventDetail) {
                $eventDetail = new EventDetail();
                $eventDetail->event_id = $events->id;
            } else {
                $eventDetail = $findEventDetail;
            }
            
            $eventDetail->title = $params["title"];
            $eventDetail->price = $params["price"];
            $eventDetail->event_date = $params["event_date"];
            $eventDetail->start_hour = $params["start_hour"];
            $eventDetail->end_hour = $params["end_hour"];

            
            if(isset($params["upload_image"])) {
                if($findEventDetail) {
                    if(Storage::exists($findEventDetail->banner)) {
                        Storage::delete($findEventDetail->banner);
                    }
                }
                $eventDetail->banner =  Storage::putFile("public/images/schedules" , $params["upload_image"]);
            } 

            $eventDetail->event_location = $params["event_location"] ;
            $eventDetail->description = $params["description"];
            $eventDetail->max_capacity = $params["max_capacity"];
            $eventDetail->link_event = $params["event_link"];
            $eventDetail->save();

            $labels = collect([]);
            foreach($params["event_label"] as $eventLabel) {
                $labels->push([
                    "name"  => $eventLabel
                ]); 
            }

            if(!is_null($events->eventLabelLists)) {
                $events->eventLabelLists()->delete();
            }
                $events->eventLabelLists()->createMany($labels->toArray());

            DB::commit();

            return responseCustom("Sukses Create or update event", true);
        } catch (\Exception $e) {
            DB::rollBack();
            return responseCustom($e->getMessage(), false);
        }
    }

    public function registerEvent($params) {
        try {
            $user  = Auth::user();
            $event = Event::where("event_slug", $params["event_slug"])
                ->first();

            $findRegistration = Registration::where([
                ["user_id", $user->id],
                ["event_id", $event->id]
            ])->first();
            
            if($findRegistration) {
                return responseCustom($findRegistration->invoice , true);
            }

            $register = new Registration();
            $register->user_id  = $user->id;
            $register->event_id = $event->id;

            $lastEvent = Registration::whereNotNull('invoice')
                ->orderBy('id', 'DESC')
                ->take(1)
                ->first('invoice');

            if(!$lastEvent) {
                $eventNumber = 'ONR' . date('ymd') . '0001';
            } else {
                $explode = explode('ONR', $lastEvent->invoice);

                if (strlen($explode[1]) > 10) {
                    $date = date('Ymd');
                    $day = substr($explode[1], 0, 8);
                    $num = substr($explode[1], -3);
                } else {
                    $date = date('ymd');
                    $day = substr($explode[1], 0, 6);
                    $num = substr($explode[1], -4);
                }

                if($day == $date) {
                    $eventNumber = 'ONR' . date('ymd') . sprintf('%04d', (int) $num + 1);
                } else {
                    $eventNumber = 'ONR' . date('ymd') . sprintf('%04d', 1);
                }
            }

            $register->invoice      = $eventNumber;
            $register->total_price  = $event->eventDetail->price;
            $register->save();

            return responseCustom($register->invoice, true);
        } catch (\Exception $e) {
            return responseCustom("Something Wrong!", false);
        }
    }

    public static function createSlug($str, $delimiter = "-") {
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }
}