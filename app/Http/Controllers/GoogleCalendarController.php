<?php

namespace App\Http\Controllers;

use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;

class GoogleCalendarController extends Controller
{
    protected $googleService;
    public function __construct(GoogleCalendarService $googleService)
    {
        $this->googleService = $googleService;
    }

    public function redirectToGoogle()
    {
        return redirect()->away($this->googleService->getClient()->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        $this->googleService->authenticate($request->get('code'));
        return redirect('/')->with('success', 'Google Calendar connected!');
    }

    public function showEvents()
    {
        $events = $this->googleService->listEvents();
        return view('events.index', compact('events'));
    }
    
    public function storeEvent(Request $request)
    {
        $eventData = [
            'summary' => $request->summary,
            'start' => ['dateTime' => $request->start],
            'end' => ['dateTime' => $request->end],
        ];

        $event = $this->googleService->createEvent($eventData);
        return redirect()->back()->with('success', 'Event created: ' . $event->getSummary());
    }
}
