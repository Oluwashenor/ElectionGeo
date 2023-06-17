<?php

namespace App\Http\Controllers;

use App\Models\NinServer;
use Illuminate\Http\Request;

class NinServerController extends Controller
{
    public function index()
    {
        $records = NinServer::all();
        return view('ninServer', compact('records'));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'nin' => ['required', 'string', 'min:11', 'max:11', 'unique:nin_servers'],
        ]);

        $record = NinServer::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'nin' => $validatedData['nin']
        ]);

        $record->save();
        toast('Record Created Successfully', 'info');
        return redirect('/ninserver');
    }
}
