<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update1(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }



        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Validate the incoming request data
    $validatedData = $request->validated();

    // If there's an image in the request, handle the upload
    if ($request->hasFile('image')) {
        if ($user->image) {
            Storage::delete($user->image);
        }
        $image = $request->file('image');

        $filename = time() . '_' . $image->getClientOriginalName();
        $validatedData['image'] = $image->storeAs('user', $filename);
    }

    $user->fill($validatedData);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Save the updated user
    $user->save();

    // Redirect back to the profile edit page with a success message
    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
