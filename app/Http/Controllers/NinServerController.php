<?php

namespace App\Http\Controllers;

use App\Models\NinServer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class NinServerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->get('role') == 'user') {
            toast('Unauthorized', 'info');
            return redirect('/');
        }
        $records = NinServer::all();
        return view('ninServer', compact('records'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'nin' => ['required', 'string', 'min:11', 'max:11', 'unique:nin_servers'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            foreach ($errors as $key => $messages) {
                foreach ($messages as $message) {
                    // Access the error key and value
                    toast("Error with {$key} : {$message}", 'info');
                }
            }
            return redirect('/ninserver');
        }

        $now = Carbon::now();
        $birthdate = Carbon::parse($request['dob']);
        $age = $now->diffInYears($birthdate);
        $oldenough = $age >= 18;
        if (!$oldenough) {
            toast('You need to be 18 or older', 'info');
            return redirect('/ninserver');
        }
        $record = NinServer::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'nin' => $request['nin']
        ]);

        $record->save();
        toast('Record Created Successfully', 'info');
        return redirect('/ninserver');
    }
}
