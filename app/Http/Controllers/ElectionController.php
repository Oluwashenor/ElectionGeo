<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Http;

use stdClass;

class ElectionController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'unique:elections'],
            'election_date' => ['required'],
        ]);

        $election = Election::create([
            'name' => $validatedData['name'],
            'election_date' => $validatedData['election_date'],
        ]);
        toast('Election Created Successfully!', 'success');
        return redirect('/');
    }

    public function index()
    {
        $elections = Election::all();
        return view('elections', compact('elections'));
    }

    public function random_color()
    {
        // Generate a random number between 0 and 255 for each of the red, green, and blue components.
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);
        // Return the RGB color code.
        return "rgb($red, $green, $blue)";
    }

    public function manage($id)
    {
        $election = Election::find($id);
        $election_id = $election->id;
        $allvotes = $election->votes;
        $contestants = Contestant::where('election_id', $election_id)->get();
        $vote_result = [];
        foreach ($contestants as $contestant) {

            $contestant_voters = $allvotes->where('contestant_id', $contestant->id);
            $contestant->vote_count = $contestant_voters->count();
            $contestant->voters = $contestant_voters;
            $vote_info = new stdClass();
            $vote_info->contestant_name = $contestant->name;
            $vote_info->total_vote = $contestant_voters->count();
            $vote_info->color = $this->random_color();
            array_push($vote_result, $vote_info);
        }
        $vote_counts = $allvotes->count();
        return view('manage-election', compact('election_id', 'contestants', 'vote_counts', 'vote_result'));
    }
}
