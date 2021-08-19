<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class GitLabAuthentication extends Controller
{
    public function gitlabLogin()
    {
        return Socialite::driver('gitlab')->scopes(['read_user'])->redirect();
    }
    public function handlegitlabCallback()
    {
        $userSocial = Socialite::driver('gitlab')->user();

        $user = User::where(['gitlab_id' => $userSocial->id])->first();

        if ($user) {
            Auth::login($user);

            $userupdate = User::where(['gitlab_id' => $userSocial->id])->first();
            $userupdate->name = $userSocial->name;
            $userupdate->email = $userSocial->email;
            $userupdate->save();

            // If the user is an admin, take them to the intended URL before login, or default to the admin controller.
            return redirect('/');

        } else {
            $newuser = new User();
            $newuser->gitlab_id=$userSocial->id;
            $newuser->name = $userSocial->name;
            $newuser->email = $userSocial->email;
            $newuser->save();
            $user = User::where(['gitlab_id' => $userSocial->id])->first();
            Auth::login($user);
            return redirect('/');
        }

    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');

    }



}
