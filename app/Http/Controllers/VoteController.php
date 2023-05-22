<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Vote;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

use stdClass;

class VoteController extends Controller
{
    public function index(Request $request)
    {
        //Trying to fetch current user's Email either through session or AUTH
        $email = is_null(auth()->user()) ? null : auth()->user()->email;
        if (is_null($email)) {
            $email = is_null($request->session()->get('email')) ? null : $request->session()->get('email');
        }
        if ($email == null) {
            //If email cant be found from session and Auth method redirect to login
            return redirect("/login");
        }
        //fetching all elections along side there contestants already declared in thier models
        $user = User::where('email', $email)->with('info')->first();
        $allElections = Election::with('contestants')->get();
        $elections =  $allElections->where('contestants', '!=', '[]');
        foreach ($elections as $ele) {
            $can_vote = $this->validCoordinates($user->info->lat, $user->info->lon, $ele->top_left_lat, $ele->top_left_lng, $ele->bottom_right_lat, $ele->bottom_right_lng);
            if ($can_vote) {
                $ele['valid_gis'] = true;
            } else {
                $ele['valid_gis'] = false;
            }
        }
        $users_votes = Vote::where('email', $email)->get();
        if ($users_votes->isEmpty()) {
            if ($elections->isEmpty()) {
                toast('There are currently no ongoing Elections', 'info');
                return view('voters', compact('elections',  'user'));
            } else {
                return view('voters', compact('elections', 'user'));
            }
        } else {
            $users_votes_id = array_column($users_votes->toArray(), 'election_id');
            foreach ($elections as $election) {
                if (in_array($election->id, $users_votes_id)) {
                    $election['voted'] = true;
                }
            }
            return view('voters', compact('elections', 'user'));
        }
    }

    public function create(Request $request)
    {
        $email = "";
        $name = "";
        $request->session()->get('name');
        if (is_null(auth()->user())) {
            $email = $request->session()->get('email');
            $name = $request->session()->get('name');
        } else {
            $name = auth()->user()->name;
            $email = auth()->user()->email;
        }
        $alreadyVoted = Vote::where('election_id', $request["election"])
            ->where('email', $email)->get();

        if (!$alreadyVoted->isEmpty()) {
            // Meaning the user has voted for this same election
            toast('You already voted for this election!', 'info');
            return redirect('/voting');
        }
        $vote = Vote::create([
            'contestant_id' => $request["contestant"],
            'election_id' => $request["election"],
            'email' => $email,
            'name' => $name
        ]);
        toast('Thank you for Voting!', 'success');
        return redirect('/voting');
    }

    public function getVoterSession(Request $request)
    {
    }

    public function validCoordinates($latitude, $longitude, $topLeftLat, $topLeftLng, $bottomRightLat, $bottomRightLng)
    {
        return ($latitude >= $bottomRightLat &&
            $latitude <= $topLeftLat &&
            $longitude >= $topLeftLng &&
            $longitude <= $bottomRightLng
        );
    }
}
