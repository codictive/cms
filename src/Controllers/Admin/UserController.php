<?php

namespace Codictive\Cms\Controllers\Admin;

use App\Traits\RequiresUser;
use Illuminate\Http\Request;
use Codictive\Cms\Models\Role;
use Codictive\Cms\Models\User;
use Illuminate\Validation\Rule;
use App\Events\UserCreatedEvent;
use Codictive\Cms\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Codictive\Cms\Controllers\Controller;

class UserController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::withTrashed()->join('profiles', 'users.id', '=', 'profiles.user_id');
        if ($request->query('id')) {
            $users = $users->where('users.id', $request->query('id'));
        }
        if ($request->query('mobile')) {
            $users = $users->where('mobile', 'LIKE', "%{$request->query('mobile')}%");
        }
        if ($request->query('email')) {
            $users = $users->where('email', 'LIKE', "%{$request->query('email')}%");
        }
        if ($request->query('query')) {
            $userIds = Profile::where('first_name', 'LIKE', "%{$request->query('query')}%")
                ->orWhere('last_name', 'LIKE', "%{$request->query('query')}%")
                ->pluck('user_id')->all();
            $users = $users->whereIn('users.id', $userIds);
        }
        if ($request->query('national_code')) {
            $userIds = Profile::where('national_code', 'LIKE', "%{$request->query('national_code')}%")->pluck('user_id')->all();
            $users   = $users->whereIn('users.id', $userIds);
        }
        if ($request->query('status')) {
            switch ($request->query('status')) {
                case 'active':
                    $users = $users->where('is_active', true);

                    break;

                case 'blocked':
                    $users = $users->where('is_active', false);

                    break;

                case 'approved':
                    $userIds = Profile::where('is_approved', true)->pluck('user_id')->all();
                    $users   = $users->whereIn('users.id', $userIds);

                    break;

                case 'not_approved':
                    $userIds = Profile::where('is_approved', false)->pluck('user_id')->all();
                    $users   = $users->whereIn('users.id', $userIds);

                    break;

                case 'deleted':
                    $users = $users->whereNotNull('deleted_at');

                    break;
            }
        }

        $perPage  = (int) $request->query('per_page') ?? 30;
        $orderBy  = $request->query('order_by')       ?? 'users.id';
        $orderDir = $request->query('order_dir')      ?? 'DESC';
        $users    = $users->select(['profiles.name', 'users.*'])->orderBy($orderBy, $orderDir)->paginate($perPage);

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'mobile'   => 'required|numeric|digits:11|starts_with:09|unique:users',
            'email'    => 'nullable|email|unique:users',
            'name'     => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'mobile'            => $request->input('mobile'),
            'register_mobile'   => $request->input('mobile'),
            'email'             => $request->input('email'),
            'password'          => Hash::make($request->input('password')),
        ]);
        UserCreatedEvent::dispatch($user, ['name' => $request->input('name')], $request->input('roles'));

        return redirect()->route('admin.users.index')->with('success', "کاربر {$user->name} ایجاد شد.");
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'mobile'   => ['required', 'numeric', 'digits:11', 'starts_with:09', Rule::unique('users')->ignore($user->id)],
            'email'    => ['nullable', 'email', Rule::unique('users')->ignore($user->id)],
            'name'     => 'required',
            'password' => 'nullable',
        ]);

        $user->update($request->all());
        $user->name = $request->input('name');
        $user->profile->save();
        $user->roles()->detach();
        foreach ($request->input('roles') as $roleId) {
            $user->roles()->attach($roleId);
        }

        if ($request->has('password')) {
            $user->password  = Hash::make($request->input('password'));
        }
        $user->is_active   = $request->has('active');
        $user->is_verified = $request->has('verify');
        $user->save();

        return redirect()->route('admin.users.index')->with('info', "کاربر {$user->name} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('warning', "کاربر {$user->name} حذف شد.");
    }

    public function editProfile(User $user)
    {
        return view('admin.users.edit_profile', ['user' => $user]);
    }

    public function updateProfile(Request $request, User $user)
    {
        $request->validate([
            'name'          => 'required',
            'gender'        => ['required', Rule::in(Profile::GENDER_MALE, Profile::GENDER_FEMALE)],
            'national_code' => 'nullable|digits:10|numeric',
            'image'         => 'nullable|image|max:2048',
            'province_id'   => 'nullable|numeric|exists:provinces,id',
            'city_id'       => 'nullable|numeric|exists:cities,id',
            'district_id'   => 'nullable|numeric|exists:districts,id',
        ]);

        $user->profile->update($request->all());
        $user->profile->is_approved = $request->has('is_approved');
        if ($request->hasFile('image')) {
            $user->profile->image = moveFile($request->file('image'), Profile::STORAGE_DIR);
        }
        $user->profile->save();

        return redirect()->route('admin.users.show', $user->id)->with('info', "پروفایل کاربر {$user->name} ذخیره شد.");
    }
}
