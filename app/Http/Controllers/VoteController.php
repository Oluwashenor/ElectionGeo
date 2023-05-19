<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Vote;

class VoteController extends Controller
{
    public function index()
    {
        $elections = Election::all();
        return view('voters', compact('elections'));
    }

    public function create(Request $request)
    {
        $vote = Vote::create([
            'contestant_id' => $request["contestant"],
            'election_id' => $request["election"],
            'email' => $request["email"],
            'name' => $request["name"]
        ]);
        return redirect('/');
    }

    public function voterslogin(Request $request)
    {
        $this->saveVoterSession($request);
        return redirect('/voters');
    }

    public function saveVoterSession(Request $request)
    {
        $request->session()->put('email', $request['email']);
        $request->session()->put('phone', $request['email']);
    }
}
