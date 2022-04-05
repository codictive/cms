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
use Codictive\Cms\Models\VerificationCode;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('cms::auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(['mobile' => 'required|numeric|digits:11|starts_with:09']);
        if (! validateRecaptcha($request->input('g-recaptcha-response'))) {
            return redirect()->route('auth.show_login_form')->withErrors('اعتبارسنجی امنیتی تکمیل نشده است.');
        }

        $mobile = $request->input('mobile');
        $user   = User::byMobile($mobile);
        if (! $user) {
            $user        = User::create(['mobile' => $mobile, 'register_mobile' => $mobile]);
            $defaultRole = Role::where('slug', kv('auth.default_role'))->first();
            if ($defaultRole) {
                $user->roles()->attach($defaultRole->id);
            }
            $user->is_active = true;
        }
        if (! $user) {
            return redirect()->route('auth.show_login_form')->withErrors('اطلاعات وارد شده صحیح نیست.');
        }
        if (! $user->is_active) {
            return redirect()->route('auth.show_login_form')->withErrors('حساب شما مسدود است.');
        }

        VerificationCode::saveAndSend($mobile, VerificationCode::CONTEXT_LOGIN);
        $request->session()->put(AUTH_SESSION_MOBILE_KEY, $mobile);

        return redirect()->route('auth.show_verification_form');
    }

    public function showVerificationForm(Request $request)
    {
        $mobile = $request->session()->get(AUTH_SESSION_MOBILE_KEY);
        $user   = User::byMobile($mobile);

        return view('cms::auth.verify', ['user' => $user]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code'     => 'required|numeric|digits:5',
            'name'     => 'nullable',
            'email'    => 'nullable|email',
            'password' => 'nullable|confirmed',
        ]);
        $mobile = $request->session()->get(AUTH_SESSION_MOBILE_KEY);
        if (! $mobile) {
            return redirect()->route('auth.show_login_form')->withErrors('اطلاعات وارد شده نامعتبر است.');
        }

        if (! VerificationCode::check($mobile, $request->input('code'), VerificationCode::CONTEXT_LOGIN)) {
            return redirect()->route('auth.show_verification_form')->withErrors('کد وارد شده نامعتبر است.');
        }

        // make sure user exists and is active.
        $user = User::byMobile($mobile);
        if ($request->input('name')) {
            $user->update(['name' => $request->input('name')]);
        }
        if ($request->input('email')) {
            $user->update(['email' => $request->input('email')]);
        }
        if ($request->input('password')) {
            $user->update(['password' => Hash::make($request->input('email'))]);
        }
        if (! $user) {
            return redirect()->route('auth.show_login_form')->withErrors('اطلاعات وارد شده صحیح نیست.');
        }
        if (! $user->is_active) {
            return redirect()->route('auth.show_login_form')->withErrors('حساب شما مسدود است.');
        }

        // create new session.
        $token = Uuid::uuid4()->toString();
        AuthSession::create([
            'user_id'    => $user->id,
            'mobile'     => $user->mobile,
            'token'      => $token,
            'platform'   => 'web',
            'expires_at' => now()->addDays((int) kv('auth.session.expire_days')),
        ]);
        $request->session()->put(AUTH_SESSION_TOKEN_KEY, $token);
        SystemLog::info('[Controllers.Auth.AuthController.verify] User %d (%s) logged in.', $user->id, $user->mobile);

        if ($next = session()->pull('next')) {
            return redirect($next)->with('success', "{$user->name} خوش آمدید!");
        }

        return redirect()->route('admin.dashboard')->with('success', "{$user->name} خوش آمدید!");
    }

    public function showPasswordLoginForm()
    {
        return view('cms::auth.password_login');
    }

    public function passwordLogin(Request $request)
    {
        $request->validate([
            'mobile'   => 'required|numeric|digits:11|starts_with:09',
            'password' => 'required',
        ]);
        if (! validateRecaptcha($request->input('g-recaptcha-response'))) {
            return redirect()->route('auth.show_password_login_form')->withErrors('اعتبارسنجی امنیتی تکمیل نشده است.');
        }

        $mobile   = $request->input('mobile');
        $password = $request->input('password');
        // make sure user exists and is active.
        $user = User::byMobile($mobile);
        if (! $user) {
            return redirect()->route('auth.show_password_login_form')->withErrors('اطلاعات وارد شده صحیح نیست.');
        }
        if (! $user->is_active) {
            return redirect()->route('auth.show_password_login_form')->withErrors('حساب شما مسدود است.');
        }
        if (! Hash::check($password, $user->password)) {
            return redirect()->route('auth.show_password_login_form')->withErrors('گذرواژه وارد شده صحیح نیست.');
        }

        // create new session.
        $token = Uuid::uuid4()->toString();
        AuthSession::create([
            'user_id'    => $user->id,
            'mobile'     => $user->mobile,
            'token'      => $token,
            'platform'   => 'web',
            'expires_at' => now()->addDays((int) kv('auth.session.expire_days')),
        ]);
        $request->session()->put(AUTH_SESSION_TOKEN_KEY, $token);
        SystemLog::info('[Controllers.Admin.AuthController.passwordLogin] User %d (%s) logged in.', $user->id, $user->mobile);

        if ($next = session()->pull('next')) {
            return redirect($next)->with('success', "{$user->name} خوش آمدید!");
        }

        return redirect()->route('admin.dashboard')->with('success', "{$user->name} خوش آمدید!");
    }

    public function showPasswordResetRequestForm()
    {
        return view('cms::auth.password_reset_request');
    }

    public function passwordResetRequest(Request $request)
    {
        $request->validate(['mobile' => 'required|numeric|digits:11|starts_with:09']);
        if (! validateRecaptcha($request->input('g-recaptcha-response'))) {
            return redirect()->route('auth.show_password_reset_request_form')->withErrors('اعتبارسنجی امنیتی تکمیل نشده است.');
        }

        $mobile = $request->input('mobile');
        // make sure user exists and is active.
        $user = User::byMobile($mobile);
        if (! $user) {
            return redirect()->route('auth.show_password_reset_request_form')->withErrors('اطلاعات وارد شده صحیح نیست.');
        }
        if (! $user->is_active) {
            return redirect()->route('auth.show_password_reset_request_form')->withErrors('حساب شما مسدود است.');
        }

        VerificationCode::saveAndSend($mobile, VerificationCode::CONTEXT_PASSEWORD_RESET);
        $request->session()->put(AUTH_SESSION_MOBILE_KEY, $mobile);

        return redirect()->route('auth.show_password_reset_verification_form');
    }

    public function showPasswordResetVerificationForm()
    {
        return view('cms::auth.password_reset_verify');
    }

    public function passwordResetVerify(Request $request)
    {
        $request->validate([
            'code'     => 'required|numeric|digits:5',
            'password' => 'required',
        ]);

        $mobile = $request->session()->get(AUTH_SESSION_MOBILE_KEY);
        if (! $mobile) {
            return redirect()->route('auth.show_password_reset_request_form')->withErrors('اطلاعات وارد شده نامعتبر است.');
        }

        if (! VerificationCode::check($mobile, $request->input('code'), VerificationCode::CONTEXT_PASSEWORD_RESET)) {
            return redirect()->route('auth.show_password_reset_verification_form')->withErrors('کد وارد شده نامعتبر است.');
        }

        // make sure user exists and is active.
        $user = User::byMobile($mobile);
        if (! $user) {
            return redirect()->route('auth.show_password_reset_request_form')->withErrors('اطلاعات وارد شده صحیح نیست.');
        }
        if (! $user->is_active) {
            return redirect()->route('auth.show_password_reset_request_form')->withErrors('حساب شما مسدود است.');
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        // logout from everywhere.
        $user->sessions()->delete();

        // create new session.
        $token = Uuid::uuid4()->toString();
        AuthSession::create([
            'user_id'    => $user->id,
            'mobile'     => $user->mobile,
            'token'      => $token,
            'platform'   => 'web',
            'expires_at' => now()->addDays((int) kv('auth.session.expire_days')),
        ]);
        $request->session()->put(AUTH_SESSION_TOKEN_KEY, $token);

        return redirect()->route('admin.dashboard')->with('success', "{$user->name} خوش آمدید! گذرواژه جدید ذخیره شد.");
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
