<?php

namespace App\Http\Controllers;

use App\Models\User;

/**
 * Description of ProfileController
 *
 * @author user
 */
class ProfileController extends Controller
{
    public function profile(User $user)
    {
        return view('pages.profile', ['user' => $user]);
    }
}
