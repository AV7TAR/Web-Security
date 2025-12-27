<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * صفحة اللوجين
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * تنفيذ اللوجين
     */
    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Invalid email or password.');
    }

    /**
     * صفحة التسجيل (لو محتاجاها)
     */
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    /**
     * تنفيذ التسجيل
     */
    public function doRegister(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'confirmed', 'min:6'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // المستخدم العادي بياخد role user
        $user->assignRole('user');

        Auth::login($user);

        return redirect()->route('home');
    }

    /**
     * الصفحة الرئيسية (Home / Dashboard)
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Logout
     */
    public function doLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Helper: منع employee من التعديل على admin
     */
    protected function ensureCanModifyUser(User $user): void
    {
        $current = auth()->user();

        // لو اليوزر الهدف Admin، واليوزر الحالي مش Admin → ممنوع
        if ($user->hasRole('admin') && !$current->hasRole('admin')) {
            abort(403, 'You are not allowed to modify admin accounts.');
        }
    }

    /**
     * قائمة اليوزرز
     */
    public function index()
    {
        $users = User::with('roles')->orderByDesc('id')->get();

        return view('users.index', compact('users'));
    }

    /**
     * فورم إنشاء يوزر جديد
     */
    public function create()
    {
        $roles = ['admin', 'employee', 'user', 'instructor', 'student'];

        return view('users.form', [
            'user'  => new User(),
            'roles' => $roles,
        ]);
    }

    /**
     * فورم تعديل يوزر
     */
    public function edit(User $user)
    {
        $this->ensureCanModifyUser($user);

        $roles = ['admin', 'employee', 'user', 'instructor', 'student'];

        return view('users.form', [
            'user'  => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * حفظ يوزر (create / update)
     */
    public function save(Request $request)
    {
        $current = auth()->user();

        $data = $request->validate([
            'id'       => ['nullable', 'integer', 'exists:users,id'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . ($request->id ?? 'null')],
            'role'     => ['required', 'string', 'in:admin,employee,user,instructor,student'],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        // employee ماينفعش يدي role admin لحد
        if (!$current->hasRole('admin') && $data['role'] === 'admin') {
            abort(403, 'Only admins can assign the admin role.');
        }

        if (!empty($data['id'])) {
            // UPDATE
            $user = User::findOrFail($data['id']);

            $this->ensureCanModifyUser($user);

            $user->name  = $data['name'];
            $user->email = $data['email'];

            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();
        } else {
            // CREATE
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => !empty($data['password'])
                    ? Hash::make($data['password'])
                    : Hash::make('Password123!'),
            ]);
        }

        // تحديث الـ roles
        $user->syncRoles([$data['role']]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User saved successfully.');
    }

    /**
     * حذف يوزر
     */
    public function delete(User $user)
    {
        $this->ensureCanModifyUser($user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * فورم تغيير الباسورد
     */
    public function passwordForm(User $user)
    {
        $this->ensureCanModifyUser($user);

        return view('users.password', compact('user'));
    }

    /**
     * حفظ الباسورد الجديد
     */
    public function passwordSave(Request $request, User $user)
    {
        $this->ensureCanModifyUser($user);

        $data = $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'Password updated successfully.');
    }
}
