<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Election;
use App\Services\AEService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Mail\VerificationMail;
use App\Models\NinServer;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

class UsersController extends Controller
{

    protected $aEService;

    public function __construct(AEService $aEService)
    {
        $this->aEService = $aEService;
    }

    public function welcome()
    {
        if (@auth()->check()) {
            $allElections = Election::with('contestants')->get();
            $totalUsers = User::all()->count();
            $elections =  $allElections->where('contestants', '!=', '[]');
            $allElectionsCount = $allElections->count();
            $allOngoingElectionsCount = $allElections->where('election_date', Carbon::today()->toDateString())->count();
            return view('welcome', compact('elections', 'totalUsers', 'allElectionsCount', 'allOngoingElectionsCount'));
        }
        return redirect("/login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $users = $this->getDecrptedUsers();
        if ($users != null) {
            $user = $users->where('email', $request['email'])->first();
            if ($user == null) {
                toast('Username or Password Invalid', 'alert');
                return redirect()->back();
            }
            $credentials['email'] = $user->encryptedEmail;
            if ($user->email_verified_at == null) {
                toast('Account has not been Verified, Please Verify your account', 'alert');
                return redirect()->back();
            }
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('email', $request['email']);
            $request->session()->put('name', $user->name);
            $request->session()->put('role', $user->role);
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function getDecrptedUsers()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return null; // No users found
        }
        foreach ($users as $user) {
            $decryptedEmail = $this->aEService->decrypt($user->email); //
            $decryptedRole = $this->aEService->decrypt($user->role); //
            $decryptedName = $this->aEService->decrypt($user->name); //
            $decryptedNIN = $this->aEService->decrypt($user->nin); //
            $user->encryptedEmail = $user->email;
            $user->encryptedName = $user->name;
            $user->encryptedNIN = $user->nin;
            $user->email = $decryptedEmail;
            $user->role = $decryptedRole;
            $user->name = $decryptedName;
            $user->nin = $decryptedNIN;
        }
        return $users;
    }

    public function otp(Request $request)
    {
        return view('otp');
    }

    public function forgotpassword(Request $request)
    {
        return view('forgotpassword');
    }



    public function forgot_password(Request $request)
    {
        $users = $this->getDecrptedUsers();
        if ($users != null) {
            $user = $users->where('email', $request['email'])
                ->first();
            if ($user != null) {
                $token = $this->sendForgotPasswordEmail($request['email']);
                $userDB = User::where('email', $user->encryptedEmail)->first();
                $userDB->token = $token;
                $userDB->save();
                toast('Please check your email for Verification', 'info');
                return redirect('/login');
            }
        }
        toast('E-mail is Invalid', 'info');
        return redirect('/register');
    }


    public function emailconfirm(Request $request)
    {
        return view('emailconfirm');
    }

    public function email_confirm(Request $request)
    {
        $users = $this->getDecrptedUsers();
        if ($users != null) {
            $user = $users->where('email', $request['email'])
                ->first();
            if ($user != null) {
                $token = $this->sendEmail($request['email']);
                $userDB = User::where('email', $user->encryptedEmail)->first();
                $userDB->token = $token;
                $userDB->save();
                toast('Please check your email for Verification', 'info');
                return redirect('/login');
            }
        }
        toast('E-mail is Invalid', 'info');
        return redirect('/register');
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
        $users = $this->getDecrptedUsers();
        if ($users != null) {
            $user = $users->where('email', $request['email'])
                ->first();
            if ($user != null) {
                toast('E-Mail already exist', 'info');
                return redirect('/register');
            }
            $ninexist = $users->where('nin', $request['nin'])->first();
            if ($ninexist != null) {
                toast('NIN already exist', 'info');
                return redirect('/register');
            }
        }
        $verifyNINFromServer = $this->verifyNINFromServer($validatedData['nin']);
        if ($verifyNINFromServer == null) {
            toast('Invalid NIN, Please check and try again', 'info');
            return redirect('/register');
        }

        // else {
        //     $nameValid = checkStringContainment($verifyNINFromServer->name,$validatedData['nin']);
        // }

        $address = $this->getAddress($request['lat'], $request['lon']);
        if ($address == null) {
            toast('Unable to get your location, Please try again', 'info');
            return redirect('/register');
        }
        $address_components = $address['results'][0]["components"];
        $emails_for_admins = array("adeshiname@gmail.com", "elfaithful@gmail.com");
        if (in_array($validatedData['email'], $emails_for_admins)) {
            $role = 'admin';
        }

        $user = User::create([
            'name' => $this->aEService->encrypt($validatedData['name']),
            'email' => $this->aEService->encrypt($validatedData['email']),
            'password' => Hash::make($validatedData['password']),
            'role' => $this->aEService->encrypt($role),
            'nin' => $this->aEService->encrypt($validatedData['nin'])
        ]);
        $info = UserInfo::create([
            'user_id' => $user->id,
            'lat' => $request['lat'],
            'lon' => $request['lon'],
            'lga' => $address_components['county'] ?? $address_components['quarter'],
            'state' => $address_components['state'] ?? $address_components['region'],
            'town' => $address_components['city'] ?? $address_components['town'] ?? $address_components['suburb'] ?? $address_components['county'],
            'country' => $address_components['country'],
            'country_code' => $address_components['country_code']
        ]);
        $token = $this->sendEmail($validatedData['email']);
        $user->token = $token;
        $user->save();
        toast('Please check your mail for email confirmation', 'info');
        return redirect('/login');
    }

    public function verifyOTP(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            if ($user->token == $request->otp) {
                $user->email_verified_at = Carbon::today()->toDateString();
                $user->save();
                return redirect('/login');
            } else {
                toast('Invalid User Info passed', 'alert');
                return redirect('/');
            }
        }
        toast('Invalid User Info passed', 'alert');
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
        try {
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
        } catch (Exception $ex) {
            return null;
        }
    }

    public function profile($email)
    {
        $users = $this->getDecrptedUsers();
        $user = $users->where('email', $email)->first();
        if ($user == null) {
            toast('User Not Found', 'alert');
            return redirect('/');
        }
        return view('profile', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $user = User::find($request['user_id'])->with('info')->first();
        $decryptedName = $this->aEService->decrypt($user->name);
        $recordUpdated = false;
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
        if ($decryptedName != $request['name']) {
            $user->name = $this->aEService->encrypt($request['name']);
            $recordUpdated = true;
        }
        if ($updateLocation) {
            $info = UserInfo::where('user_id', $user->id)->first();
            if ($info == null) {
                UserInfo::create([
                    'user_id' => $user->id,
                    'lat' => $request['lat'],
                    'lon' => $request['lon'],
                    'lga' => $address_components['county'] ?? $address_components['quarter'],
                    'state' => $address_components['state'] ?? $address_components['region'],
                    'town' => $address_components['city'] ?? $address_components['town'] ?? $address_components['suburb'] ?? $address_components['county'],
                    'country' => $address_components['country'],
                    'country_code' => $address_components['country_code']
                ]);
            } else {
                $info->lat = $request['lat'];
                $info->lon = $request['lon'];
                $info->lga = $address_components['county'] ?? $address_components['quarter'];
                $info->state = $address_components['state'] ?? $address_components['region'];
                $info->town = $address_components['city'] ?? $address_components['town'] ?? $address_components['suburb'];
                $info->country = $address_components['country'];
                $info->country_code = $address_components['country_code'];
                $info->save();
            }
        }
        if ($recordUpdated) {
            $user->save();
            toast('User Info Updated Successfully', 'success');
        }
        return redirect('/profile/' . $request['email']);
    }

    public function sendEmail($email)
    {
        // Generate confirmation link
        $token = Str::random(64); // Generate a random token
        $confirmationLink = route('confirm', ['token' => $token]); // Generate the confirmation link using a named route

        Mail::to($email)->send(new VerificationMail($confirmationLink));
        return $token;
    }

    public function sendForgotPasswordEmail($email)
    {
        // Generate confirmation link
        $token = Str::random(64); // Generate a random token
        $confirmationLink = route('passwordReset', ['token' => $token]); // Generate the confirmation link using a named route

        Mail::to($email)->send(new ForgotPassword($confirmationLink));
        return $token;
    }

    public function passwordReset($token)
    {
        $user = User::where('token', $token)->first();
        if ($user != null) {
            $email = $this->aEService->decrypt($user->email);
            return view('passwordReset', compact('email'));
        }
        return redirect('/');
    }

    public function updatePassword(Request $request)
    {

        $validatedData = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $users = $this->getDecrptedUsers();
        $user = $users->where('email', $validatedData['email'])->first();
        if ($user != null) {
            $userFromDb = User::find($user->id);
            $userFromDb->password = Hash::make($validatedData['password']);
            $userFromDb->save();
            toast('Password Updated Successfully', 'success');
            return redirect('/login');
        }
        toast('Something went wrong', 'alert');
        return redirect('/');
    }


    public function confirmEmail($token)
    {
        $user = User::where('token', $token)->first();
        if ($user != null) {
            $user->email_verified_at = Carbon::today()->toDateString();
            $user->save();
            toast('User Info Verified Successfully', 'success');
            return redirect('/login');
        }
        toast('Invalid User Info passed', 'alert');
    }

    public function verifyNINFromServer($nin)
    {
        $nin = NinServer::where('nin', $nin)->first();
        if ($nin != null) {
            return $nin;
        }
        return null;
    }

    public function checkStringContainment($valueA, $valueB)
    {
        $stringA = strtolower(str_replace(' ', '', $valueA));
        $stringB = strtolower(str_replace(' ', '', $valueB));

        if (strpos($stringA, $stringB) !== false) {
            //Contains
            return true;
        } else {
            return false;
        }
    }
}
