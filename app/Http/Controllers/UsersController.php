<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Election;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{

    public function welcome()
    {
        if (@auth()->check()) {
            $allElections = Election::with('contestants')->get();
            $elections =  $allElections->where('contestants', '!=', '[]');
            return view('welcome', compact('elections'));
        }
        return redirect("/login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Register
    public function register(Request $request)
    {
        $role = 'user';
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nin' => ['required', 'string', 'min:11', 'max:11', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($request["lat"] == null || $request["lon"] == null) {
            toast('Please grant location Permission and try again', 'info');
            return redirect('/register');
        }
        $address = $this->getAddress($request['lat'], $request['lon']);
        $address_components = $address['results'][0]["components"];
        $emails_for_admins = array("adeshiname@gmail.com");
        if (in_array($validatedData['email'], $emails_for_admins)) {
            $role = 'admin';
        }
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $role,
            'nin' => $validatedData['nin']
        ]);
        $info = UserInfo::create([
            'user_id' => $user->id,
            'lat' => $request['lat'],
            'lon' => $request['lon'],
            'lga' => $address_components['county'] ?? $address_components['quarter'],
            'state' => $address_components['state'] ?? $address_components['region'],
            'town' => $address_components['city'] ?? $address_components['town'],
            'country' => $address_components['country'],
            'country_code' => $address_components['country_code']
        ]);
        $token = $this->sendEmail($validatedData['email']);
        Auth::login($user);
        return redirect('/');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    private function getAddress($lat, $lon)
    {
        $response = Http::get('https://api.opencagedata.com/geocode/v1/json?key=7ed3f82e9fcf42f0aebf417009a1d527&q=' . $lat . ',' . $lon . '&no_annotations=1&pretty=1');
        if ($response->ok()) {
            $data = $response->json();
            return $data;
            // do something with the response data
        } else {
            $errorMessage = $response->json()['message'];
            return $errorMessage;
            // handle the error
        }
    }

    public function saveVoterSession(Request $request)
    {
        $request->session()->put('email', $request['email']);
        $request->session()->put('name', $request['name']);
    }

    public function profile($email)
    {
        $user = User::where('email', $email)->with('info')->get()[0];
        if ($user->count() == 0) {
            toast('User Not Found', 'alert');
            return redirect('/voting');
        }
        return view('profile', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $user = User::where('email', $request['email'])->with('info')->get()[0];
        $updateLocation = false;
        if (($user->info == null) || ($user->info->lat != $request['lat']) || ($user->info->lon != $request['lon'])) {
            $updateLocation = true;
            $address = $this->getAddress($request['lat'], $request['lon']);
            $address_components = $address['results'][0]["components"];
        }
        if ($user == null) {
            toast('User Not Found', 'alert');
            return redirect('/voting');
        }
        $user->name = $request['name'];
        if ($updateLocation) {
            $info = UserInfo::where('user_id', $user->id)->first();
            if ($info == null) {
                UserInfo::create([
                    'user_id' => $user->id,
                    'lat' => $request['lat'],
                    'lon' => $request['lon'],
                    'lga' => $address_components['county'] ?? $address_components['quarter'],
                    'state' => $address_components['state'] ?? $address_components['region'],
                    'town' => $address_components['city'],
                    'country' => $address_components['country'],
                    'country_code' => $address_components['country_code']
                ]);
            } else {
                $info->lat = $request['lat'];
                $info->lon = $request['lon'];
                $info->lga = $address_components['county'] ?? $address_components['quarter'];
                $info->state = $address_components['state'] ?? $address_components['region'];
                $info->town = $address_components['city'];
                $info->country = $address_components['country'];
                $info->country_code = $address_components['country_code'];
                $info->save();
            }
        }
        $user->save();
        toast('User Info Updated Successfully', 'success');
        return redirect('/profile/' . $request['email']);
    }

    public function sendEmail($email)
    {
        $min = 100;
        $max = 999;

        $partA = rand($min, $max);
        $partB = rand($min, $max);
        $token = $partA . "-" . $partB;
        Mail::to($email)->send(new VerificationMail($token));
        return $token;
    }
    // $a=array("Volvo"=>"XC90","BMW"=>"X5","Toyota"=>"Highlander");
    // print_r(array_keys($a));
    // 
}
