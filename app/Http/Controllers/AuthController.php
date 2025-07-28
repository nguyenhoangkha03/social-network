<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:200|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'hoten' => 'nullable|string|max:200',
            'diachi' => 'nullable|string|max:200',
            'gioitinh' => 'nullable|integer',
            'email' => 'required|email|max:200|unique:users,email',
            'sodienthoai' => 'nullable|numeric',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'username.unique' => 'Tên đăng nhập đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'sodienthoai.numeric' => 'Số điện thoại phải là số.',
        ]);
        var_dump($request->all());
        $hinhanh = null;
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $hinhanh = file_get_contents($file->getRealPath());
        }
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'hoten' => $request->hoten,
            'diachi' => $request->diachi,
            'gioitinh' => $request->gioitinh,
            'email' => $request->email,
            'sodienthoai' => $request->sodienthoai,
            'trangthai' => true,
            'hinhanh' => $hinhanh,
        ]);
        return redirect()->route('login')->with('success', 'Đăng ký thành công!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', // username hoặc email
            'password' => 'required',
        ]);
        $user = User::where('username', $request->login)
            ->orWhere('email', $request->login)
            ->first();
        if ($user && Hash::check($request->password, $user->password)) {
            // Đăng nhập thành công
            session(['user_id' => $user->user_id]);
            // Kiểm tra nếu là admin
            $admins = config('admins.accounts');
            if (isset($admins[$user->username]) && $admins[$user->username] === $request->password) {
                $request->session()->put('admin_logged_in', true);
                return redirect('/admin');
            }
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        }
        return back()->withErrors(['login' => 'Sai tài khoản hoặc mật khẩu']);
    }
}
