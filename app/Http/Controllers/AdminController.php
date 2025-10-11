<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class AdminController extends Controller
{
    //

    public function getFullOverview(){
        $events = Event::with([
            'creator:id,name,email',
            'registrations',
            'teamRegistrations.members'
        ]) -> get();
        
    $formatted = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'event_code' => $event->event_code,
                'event_title' => $event->event_title,
                'description' => $event->description,
                'event_date' => $event->event_date,
                'creator_name' => $event->creator->name ?? 'Unknown',
                'creator_email' => $event->creator->email ?? null,
                'registrations' => $event->registrations->map(function ($r) {
                    return [
                        'id' => $r->id,
                        'participant_name' => $r->participant_name,
                        'email' => $r->email,
                        'role' => $r->role,
                    ];
                }),
                'teams' => $event->teamRegistrations->map(function ($t) {
                    return [
                        'id' => $t->id,
                        'team_name' => $t->team_name,
                        'status' => $t->status,
                        'members' => $t->members->map(function ($m) {
                            return [
                                'id' => $m->id,
                                'member_name' => $m->member_name,
                                'member_email' => $m->member_email,
                                'role' => $m->role,
                            ];
                        }),
                    ];
                }),
            ];
        });

        return response()->json($formatted, 200);

    }
}
