<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Schedule;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home() {
        $events = Event::take(6)->inRandomOrder()->get();
        return view('frontend.pages.home', compact('events'));
    }

    public function profile() {
        return view('frontend.pages.profile');
    }

    public function eventList(Request $request) {
        $events = Event::paginate(6);
        return view('frontend.pages.events' , compact('events'));
    }

    public function seeMoreAjaxEventList(Request $request) {
        $events = Event::paginate(6);
        return response()->json($events);
    }

    public function eventDetail($id) {
        $event = Event::findOrFail($id);
        return view('frontend.pages.events-detail', compact('event'));
    }

    public function paymentEvents(Request $request) {
        return view('frontend.pages.payments');
    }
}
