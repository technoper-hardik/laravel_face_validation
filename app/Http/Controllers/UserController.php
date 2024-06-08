<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        return view('users', ['users' => User::role('Normal User')->paginate(5)]);
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
            $file = request()->file('image');
            try {
                $response = Http::attach(
                    'image',
                    file_get_contents($file->getPathname()),
                    $file->getClientOriginalName(),
                    ['Content-Type' => 'image/jpeg']
                )->post('http://127.0.0.1:5000/detect_faces');
                if (($faces = $response->json('faces')) == 1) {
                    if ($user->image) {
                        // Delete old image
                        try {
                            Storage::disk('images')->delete($user->image);
                        } catch (\Exception) {}
                    }
                    // Save new image
                    $filename = $file->store('', ['disk' => 'images']);
                    $user->image = $filename;
                    $user->image_verified_at = now();
                } else {
                    return redirect()->back()->with('message', 'There was an error in image, There are ' . $faces . ' face detected!');
                }
            } catch (\Exception) {}
        }

        $user->name = request('name');
        $user->save();

        return redirect()->back()->with('message', 'Successfully updated profile!');
    }
}
