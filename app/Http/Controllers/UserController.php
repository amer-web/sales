<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function add_user()
    {
        return view('user.add');
    }

    public function create_user(CreateUserRequest $request)
    {
        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect('/')->with('success', 'تم حفظ المستخدم الجديد بنجاح');
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function edit_profile()
    {
        return view('user.editprofile');
    }

    public function edit_profile_update(Request $request)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->user()->id]
        ]);
        auth()->user()->update([
           'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email
        ]);

        return redirect()->route('profile.user')->with('success','تم تعديل البيانات بنجاح');
    }

    public function change_password()
    {
        return view('user.change-password');
    }
    public function update_password(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ],[
            'old_password.required' => 'هذا الحقل مطلوب',
            'new_password.required' => 'هذا الحقل مطلوب',
            'new_password.confirmed' => 'يجب أن تكون كلمة السر متطابقان'
        ]);

        if(Hash::check($request->old_password, auth()->user()->password)){
            auth()->user()->update([
                'password' => Hash::make($request->new_password)
            ]);
            return redirect('/')->with('success', 'تم تغير كلمة السر بنجاح');
        }
        return redirect()->back()->with('error', 'تأكد من كلمة السر الحالية');
    }
}
