<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Models\TeamRegistration;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class TeamController extends Controller
{
    //

    public function createTeam(Request $request){

        $validator = FacadesValidator::make($request ->all(), [
            'event_id' => 'required|exists:events,id',
            'team_name' => 'required|string|max:255',
            'members' => 'nullable|array', // optional array of members
        ]);


        //FAILED 
        if($validator ->fails()) {
            return response()->json(['error' => 'Validation failed', 'details' => $validator->errors()],422);
        }

        $user = $request->user();
        if(!$user){
            return response()-> json(['error' => 'Unauthorized'], 401);
        }

        //Create Team
        //     protected $fillable = ['team_code','event_id', 'leader_id', 'team_name', 'status'];

        $team = TeamRegistration::create([
            'event_id' => $request->event_id,
            'leader_id' => $user->id,
            'team_name' => $request->team_name,
            'status' => 'registered',
        ]);

        // add members optional
        if($request->has ('members')) {
            foreach($request->members as $member){
                TeamMember::create([
                    'team_registration_id' => $team->id,
                    'member_name' => $member['member_name'] ?? '',
                    'member_email' => $member['member_email'] ?? '',
                    'role' => $member['role'] ?? null,
                    'member_id' => $user->id, // default assign to leader, adjust as needed
                ]);
            }
        }

        return response()->json([
            'message' => 'Team created successfully',
            'team' => $team,
        ], 201);
    }   

    // Get All Items under one event
    public function getTeamsByEvent($event_id)
        {
            $teams = TeamRegistration::with('members')
                ->where('event_id', $event_id)
                ->get();

            return response()->json($teams);
        }

    //  Delete a team (admin only)
    public function deleteTeam($id)
        {
            $team = TeamRegistration::find($id);
            if (!$team) {
                return response()->json(['error' => 'Team not found'], 404);
            }

            $team->delete();

            return response()->json(['message' => 'Team deleted successfully']);
        }



}
