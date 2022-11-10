<?php 

namespace App\Services;

use Illuminate\Support\Facades\Log;

class GoogleCalendarService {
    
    protected $client;

    public function __construct($request)
    {
        $client = new \Google_Client();
        $guzzle = new \GuzzleHttp\Client(['curl' => array(CURLOPT_SSL_VERIFYPEER => false )]);
        $client->setAuthConfig(storage_path('google-oauth.json'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);
        $client->setHttpClient($guzzle);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');

        // $tokenCache = (new ListQueryRepository())->getCacheKey('token_google_calendar'); //check the access token exist or not on db 
        $tokenApi   = '';
        // if(!$tokenCache) {
            if(!$request->get('code')) {
                $authUrl    = $client->createAuthUrl(); //process to get url for get access token
                $filterUrl  = filter_var($authUrl, FILTER_SANITIZE_URL); 
                header("Location: " . $filterUrl); //redirect to google for oauth
                exit();
            } else {
                $authenticate = $client->authenticate($request->get('code'));
                $request->session()->put('access_token', $client->getAccessToken());
                $tokenGoogle  = Cache::with([])
                    ->where('key', 'token_google_calendar')
                    ->first();

                // save the accessToken into table cache
                if(!$tokenGoogle) {
                    $tokenGoogle        = new Cache();
                    $tokenGoogle->key   = 'token_google_calendar';
                }
                $tokenGoogle->value     = json_encode($client->getAccessToken(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $tokenGoogle->save();
                $tokenApi               = $client->getAccessToken();
            }
        // } else {
            // $tokenApi   = json_decode($tokenCache['value'], true);
        // }
        $client->setAccessToken($tokenApi); // set access token for all services google
        $this->client   = $client;
    }

    public function index() {
        try {
            $service        = new \Google_Service_Calendar($this->client);
            $calendarId     = 'primary';
            $optParams      = [
                'maxResults'    => 10,
                'orderBy'       => 'startTime',
                'singleEvents'  => true,
                'timeMin'       => date('c')
            ];
    
            $results    = $service->events->listEvents($calendarId, $optParams);
            if(!$results) {
                Log::error('Something Wrong With Connection to google calendar api service :'. json_encode($results['message']));
            }
                
            return redirect(url('/backend'));
        } catch (\Exception $e) {
            return returnCustom("Something Wrong Exception Google Calendar Get Event". $e->getMessage());
        }
    }

    public function saveOrUpdateEvents($data = [], $eventId = '', $emailAttends = '', $isUpdate = false) {
        try {
            $service = new \Google_Service_Calendar($this->client);

            if($isUpdate) {
                $findEvent = $service->events->get('primary', $eventId);
                if($findEvent->status == null) {
                    return returnCustom("Event Not Found!");
                }
            }

            $eventDate      = $data['event_date'];
            $startHour      = $data['start_hour'];
            $endHour        = $data['end_hour'];
            $existingAttend = [];
            $guests         = [];

            if($isUpdate) {
                $guests = $findEvent->getAttendees();
            }

            // get all email guest on existing event
            if(count($guests) > 0) {
                foreach($guests as $key => $guest) {
                    $existingAttend[] = [
                        'email'             => $guests[$key]->email,
                        'responseStatus'    => $guests[$key]->responseStatus
                    ];
                }
            }
            
            if(count($emailAttends) > 1) {
                for($i = 0; $i < count($emailAttends); $i++) {
                    $emailPeserta[] = [
                        'email'          => $emailAttends[$i],
                        'responseStatus' => null
                    ];
                }
            } else {
                $emailPeserta   = !empty($emailAttends) ? array(['email' => $emailAttends, 'responseStatus' => null]) : [];
            }

            $mergeEmail     = array_merge($emailPeserta, $existingAttend); // merge existing guest with new guest
            $eventParams = new \Google_Service_Calendar_Event(array(
                'summary'        => $data['seminar_title'],
                'location'       => $data['city'],
                'description'    => trim(preg_replace("/&#?[a-z0-9]+;/i"," ",strip_tags($data['desc']))),
                'start'          => [
                    'dateTime' => date('c', strtotime("$eventDate $startHour")) // make date time to format RFC3339
                ],
                'end'            => [
                    'dateTime' => date('c', strtotime("$eventDate $endHour"))  // make date time to format RFC3339
                ],
                'attendees' => $mergeEmail,
                'reminders' => [
                    'useDefault'    => FALSE,
                    'overrides'     => [
                        ['method' => 'email' ,'minutes' => 24 * 60],
                        ['method' => 'popup' ,'minutes' => 10]
                    ],
                ],
                'guestsCanSeeOtherGuests' => false,
            ));

            // opt params for send invitation to users
            $optParams = [
                'sendNotifications' => true,
                'sendUpdates'       => 'all'
            ];

            $response = '';
            if($isUpdate) {
                $response = $service->events->patch('primary', $findEvent->getId(), $eventParams, $optParams); // update existing event
            } else {
                $response = $service->events->insert('primary', $eventParams, $optParams); //create new event
            }

            return returnCustom($response, true);
        } catch (\Exception $e) {
            return returnCustom("Something Wrong Exception Create/Update New Event :" . $e->getMessage());
        }
    }
    
    public function deleteEvents($eventId){
        try {
            $service = new \Google_Service_Calendar($this->client);
            
            $findEvent = $service->events->get('primary', $eventId);
            if($findEvent->status == null) {
                return returnCustom("Event Not Found!");
            }
            
            $service->events->delete('primary', $eventId);

            return returnCustom("Delete event Success!" , true);
        } catch (\Exception $e) {
            return returnCustom("Something Wrong Exception delete event Google Calendar : " . $e->getMessage());
        }
    }
}