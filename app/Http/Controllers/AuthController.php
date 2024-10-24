<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Laravel\Socialite\Facades\Socialite;
use Mail;
use Str;
use Validator;
class AuthController extends Controller
{
    public function login()
    {
        $TURNSTILE_SITE_KEY = '0x4AAAAAAAkBOb9tQfO7707L';
        return view('pages.login', compact('TURNSTILE_SITE_KEY'));
    }
    public function _login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
            'cf-turnstile-response' => 'required'
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        // check token verify 
        $TURNSTILE_SECRET_KEY = '0x4AAAAAAAkBOeaAPPObjlMYJTcb_7gPcfg';
        $token = $request->input('cf-turnstile-response');
        if (!$token || $token == '') {
            return redirect()->back()->withInput()->with('message', 'Xác thực không thành công!');
        }
        $ip = $request->ip();
        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $TURNSTILE_SECRET_KEY,
            'response' => $token,
            'remoteip' => $ip,
        ]);
        $data = $response->json();
        if (!$data['success']) {
            return redirect()->back()->withInput()->with('message', 'Xác thực thất bại vui lòng thử lại!');
        }

        // continues login
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Email not found.'])->withInput();
        }

        if ($user && Hash::check($request->password, $user->password)) {
            $redirect_url = session('redirect_url') ?? '/';
            session()->forget('redirect_url');
            auth()->login($user);
            return redirect($redirect_url);
        } else {
            return redirect()->back()->withErrors(['password' => 'Password incorrect.'])->withInput();
        }
    }
    public function register()
    {
        return view('pages.register');
    }
    public function _register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $list_avatars = [
            'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg',
            'https://img.freepik.com/free-psd/3d-illustration-bald-person-with-glasses_23-2149436184.jpg',
            'https://img.freepik.com/free-psd/3d-illustration-person-with-glasses_23-2149436191.jpg',
            'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436178.jpg'
        ];
        $user = User::create([
            'uuid' => Str::uuid(),
            'email' => $request->email,
            'name' => explode('@', $request->email)[0],
            'password' => Hash::make($request->password),
            'avatar' => $list_avatars[rand(0, count($list_avatars) - 1)],
            'role' => 2
        ]);

        auth()->login($user);

        $redirect_url = session('redirect_url') ?? '/';
        session()->forget('redirect_url');
        return redirect($redirect_url);
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
    public function forgotpassword()
    {
        return view('pages.forgotpassword');
    }
    public function _forgotpassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Email not found.'])->withInput();
        }
        // send mail 
        $token = Str::random(60);
        $user->remember_token = $token;
        $user->save();

        $url = "http://127.0.0.1:8000/auth/forgot-password/" . $token;

        $data['email'] = $request->email;
        $data['title'] = "Xác nhận thay đổi mật khẩu mới tại Quin News";
        $data['url'] = $url;
        $data['user'] = $user;

        Mail::send("pages.email", ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        });
        return redirect()->back()->with('success', true);


    }
    public function forgotpassword_token($token)
    {
        $check_token = User::where('remember_token', $token)->exists();
        return view('pages.forgot_change', compact('check_token', 'token'));
    }
    public function _forgotpassword_token($token)
    {
        $validate = Validator::make(request()->all(), [
            'password' => 'required|string|min:8|confirmed'
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $check_token = User::where('remember_token', $token)->first();


        if (!$check_token) {
            return redirect()->back()->with('error', 'Token không hợp lệ!')->withInput();
        }
        $check_token->password = Hash::make(request('password'));
        $check_token->remember_token = null;
        $check_token->save();
        return redirect()->route('login')->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        $data = Socialite::driver($provider)->stateless()->user();
        $email = $data->user['email'];
        $checkUser = User::where('email', $email)->first();
        if ($checkUser) {
            auth()->login($checkUser);
        } else {
            if ($provider == 'google') {
                $avatar = $data->user['picture'];
                $first_name = $data->user['family_name'];
                $last_name = $data->user['given_name'];
                $name = $first_name . ' ' . $last_name;
            } else {
                $avatar = $data->user['avatar_url'];
                $name = $data->user['name'];
            }
            $newUser = User::create([
                'uuid' => Str::uuid(),
                'email' => $email,
                'avatar' => $avatar,
                'name' => $name,
                'role' => 2
            ]);

            auth()->login($newUser);
        }

        $redirect_url = session('redirect_url') ?? '/';
        session()->forget('redirect_url');
        return redirect($redirect_url);


    }
}
