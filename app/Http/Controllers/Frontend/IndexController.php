<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home() {
        $events = Schedule::take(6)->inRandomOrder()->get();
        return view('frontend.pages.home', compact('events'));
    }

    public function profile() {
        return view('frontend.pages.profile');
    }

    public function eventList(Request $request) {
        $events = Schedule::paginate(6);
        return view('frontend.pages.events' , compact('events'));
    }

    public function seeMoreAjaxEventList(Request $request) {
        $events = Schedule::paginate(6);
        return response()->json($events);
    }

    public function eventDetail($id) {
        $event = Schedule::findOrFail($id);
        return view('frontend.pages.events-detail', compact('event'));
    }
}
