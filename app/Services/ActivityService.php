<?php 

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityService {

    public static function activity($eventSlug = null, $keyword = null) {
        try {
            $activity               = new ActivityLog();
            $activity->user_id      = Auth::user()->id; 
            $activity->event_slug   = $eventSlug;
            $activity->keyword      = $keyword;
            $activity->save();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function getRecomendation($exceptId = null) {
        try {
            $recomendationBaseKeyword = ActivityLog::where("user_id", Auth::user()->id)
                ->select("keyword")
                ->selectRaw('count(keyword) as qty')
                ->whereNotNull("keyword")
                ->groupBy("keyword")
                ->orderBy('qty', 'DESC')
                ->first();

            $recomendationBaseSlug = ActivityLog::where("user_id", Auth::user()->id)
                ->select("event_slug")
                ->selectRaw('count(event_slug) as qty')
                ->whereNotNull("event_slug")
                ->groupBy("event_slug")
                ->orderBy('qty', 'DESC')
                ->first();
            
            $keyword    = $recomendationBaseKeyword->keyword ?? null;
            $slug       = $recomendationBaseSlug->event_slug ?? null;
            $eventIdAll = collect([]);

           
            if($keyword) {
                $eventKeyword = Event::select("id")->where("event_type", "LIKE", "%$keyword%")
                ->orWhereHas("eventLabelLists", function($q) use ($keyword) {
                    $q->where("name", "LIKE", "%$keyword%");
                })
                ->orWhereHas("company", function($q) use($keyword) {
                    $q->where("name", "LIKE", "%$keyword%");
                })
                ->orWhereHas("eventDetail", function($q) use($keyword) {
                    $q->where("title", "LIKE", "%$keyword%");
                });

                if($eventKeyword->count() > 0) {
                    $eventKeywordId = $eventKeyword->pluck('id');
                    $eventIdAll     = $eventIdAll->merge($eventKeywordId);
                };
                
                
            }

            if($slug) {
                $eventSlugSearch = Event::with(["eventLabelLists"])
                    ->where("event_slug", $slug)
                    ->first();

                if($eventSlugSearch) {
                    if($eventSlugSearch->eventLabelLists->isNotEmpty()) {
                        $labelLists = $eventSlugSearch->eventLabelLists->pluck("name")->toArray();
                        $eventWithSlug = Event::query();
                        foreach($labelLists as $label){
                            $eventWithSlug->whereHas("eventLabelLists", function($q) use ($label) {
                                $q->where("name", "LIKE", "%$label%");
                            });
                        }
                        
                        $eventWithSlugId = $eventWithSlug->pluck("id")->toArray();
                        $eventIdAll      = $eventIdAll->merge($eventWithSlugId);
                    }
                   
                }
            }

            if($eventIdAll->isNotEmpty()) {
                return Event::whereIn("id" ,$eventIdAll->toArray())
                    ->where("id", "!=", $exceptId)
                    ->paginate(3);
            } else {
                return Event::inRandomOrder()->paginate(3);
            }           
        } catch (\Exception $th) {
            return null;
        }
    }
}