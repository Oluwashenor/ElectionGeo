<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UsersController extends Controller
{

    public function welcome()
    {
        if (@auth()->check()) {
            return view('welcome');
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

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($request["lat"] == null || $request["lon"] == null) {
            toast('Please grant location Permission and try again', 'info');
            return redirect('/adminlogin');
        }
        $address = $this->getAddress($request['lat'], $request['lon']);
        $address_components = $address['results'][0]["components"];
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        $info = UserInfo::create([
            'user_id' => $user->id,
            'lat' => $request['lat'],
            'lon' => $request['lon'],
            'lga' => $address_components['county'],
            'state' => $address_components['state'],
            'town' => $address_components['city'],
            'country' => $address_components['country'],
            'country_code' => $address_components['country_code']
        ]);
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

    public function voterslogin(Request $request)
    {

        $user_exist = User::where('email', $request['email'])->get();
        if ($user_exist->isEmpty()) {

            if ($request["lat"] == null || $request["lon"] == null) {
                toast('Please grant location Permission and try again', 'info');
                return redirect('/login');
            }
            $address = $this->getAddress($request['lat'], $request['lon']);
            $address_components = $address['results'][0]["components"];

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make("password"),
            ]);
            $info = UserInfo::create([
                'user_id' => $user->id,
                'lat' => $request['lat'],
                'lon' => $request['lon'],
                'lga' => $address_components['county'] ?? $address_components['quarter'],
                'state' => $address_components['state'],
                'town' => $address_components['city'],
                'country' => $address_components['country'],
                'country_code' => $address_components['country_code']
            ]);
        }
        $this->saveVoterSession($request);
        return redirect('/voting');
    }

    public function saveVoterSession(Request $request)
    {
        $request->session()->put('email', $request['email']);
        $request->session()->put('name', $request['name']);
    }
}
