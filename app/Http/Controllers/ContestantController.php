<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use Illuminate\Http\Request;
use Alert;

class ContestantController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $election = Contestant::create([
            'name' => $validatedData['name'],
            'election_id' => $request['election_id']
        ]);
        Alert::success('Success', 'Contestant Created');
        return redirect('/manage-election/' . $request['election_id']);
    }

    public function delete($contestant_id, $election)
    {
        $contestant = Contestant::find($contestant_id);
        $contestant->delete();
        return redirect('/manage-election/' . $election);
    }
}
