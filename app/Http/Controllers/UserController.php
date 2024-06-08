<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display list of users
     * @return View
     */
    public function create(): View
    {
        return view('users', ['users' => \App\Models\User::role('Normal User')->paginate(5)]);
    }

    /**
     * Display edit form of the user
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('user_update', ['user' => $user]);
    }

    public function update(User $user)
    {
        $validator = Validator::make(request()->all(), [
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'string|max:100',
        ]);

        $validator->validated();

        if (request()->hasFile('image')) {
            $image_extension = request()->file('image')->extension();
            $filename = request()->file('image')->store('', ['disk' => 'images']);
            $user->image = $filename;
        }

        $user->name = request('name');
        $user->save();

        return redirect()->back();
    }
}
