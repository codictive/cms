<?php

namespace Codictive\Cms\Controllers\Auth;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Codictive\Cms\Models\Role;
use Codictive\Cms\Models\User;
use Codictive\Cms\Models\SystemLog;
use Illuminate\Support\Facades\Hash;
use Codictive\Cms\Models\AuthSession;
use Codictive\Cms\Controllers\Controller;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('cms::auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        if (! validateRecaptcha((string) $request->input('g-recaptcha-response'))) {
            return redirect()->route('auth.show_login_form')->withErrors('اعتبارسنجی امنیتی تکمیل نشده است.');
        }

        $email = $request->input('email');
        if (! $email) {
            return redirect()->route('auth.show_login_form')->withErrors('اطلاعات وارد شده نامعتبر است.');
        }

        $user = User::byEmail($email);
        if (! $user) {
            return redirect()->route('auth.show_login_form')->withErrors('اطلاعات وارد شده نامعتبر است.');
        }
        if (! Hash::check($request->input('password'), $user->password)) {
            return redirect()->route('auth.show_login_form')->withErrors('اطلاعات وارد شده نامعتبر است.');
        }
        if (! $user->is_active) {
            return redirect()->route('auth.show_login_form')->withErrors('حساب شما مسدود است.');
        }
        if (! $user->is_verified) {
            return redirect()->route('auth.show_login_form')->withErrors('شما ایمیل خود را تائید نکرده‌اید.');
        }

        // create new session.
        $token = Uuid::uuid4()->toString();
        AuthSession::create([
            'user_id'    => $user->id,
            'email'      => $user->email,
            'token'      => $token,
            'ip'         => $request->ip(),
        ]);
        $request->session()->put('auth_token', $token);
        SystemLog::info('AuthController.login', 'User %d (%s) logged in.', $user->id, $user->email);

        if ($next = session()->pull('next')) {
            return redirect($next)->with('success', "{$user->name} خوش آمدید!");
        }

        return redirect()->route('admin.dashboard')->with('success', "{$user->name} خوش آمدید!");
    }

    public function showRegisterForm()
    {
        return view('cms::auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        if (! validateRecaptcha($request->input('g-recaptcha-response'))) {
            return redirect()->route('auth.show_register_form')->withErrors('اعتبارسنجی امنیتی تکمیل نشده است.');
        }

        $user = User::create([
            'name'     => $request->input('name'),
            'mobile'   => $request->input('mobile'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $r = Role::default();
        if ($r) {
            $user->roles()->attach($r);
        }

        // TODO: send email with activation token.

        // create new session.
        $token = Uuid::uuid4()->toString();
        AuthSession::create([
            'user_id'    => $user->id,
            'email'      => $user->email,
            'token'      => $token,
            'ip'         => $request->ip(),
        ]);
        $request->session()->put('auth_token', $token);
        SystemLog::info('AuthController.register', 'User %d (%s) registered.', $user->id, $user->email);

        if ($next = session()->pull('next')) {
            return redirect($next)->with('success', "{$user->name} خوش آمدید!");
        }

        return redirect()->route('admin.dashboard')->with('success', "{$user->name} خوش آمدید!");
    }

    public function logout(Request $request)
    {
        $token   = $request->session()->get('auth_token');
        $session = AuthSession::byToken($token, ['user']);
        $session->delete();

        $request->session()->forget('auth_token');
        SystemLog::info('AuthController.logout', 'User %d (%s) logged out.', $session->user->id, $session->user->email);

        return redirect()->route('auth.show_login_form')->with('info', 'خدانگهدار!');
    }
}
