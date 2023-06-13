<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UploadAvatarRequest;
use App\Models\User;
use App\Traits\AjaxResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    use AjaxResponse;

    /**
     * Display the user's profile.
     */
    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    public function avatar(Request $request)
    {
        return $this->success('Avatar fetched successfully.', $request->user()->avatar);
    }

    public function edit(Request $request)
    {
        return response()->json(
            [
                'success' => true,
                'message' => 'User fetched successfully.',
                'data' => $request->user()
            ],
            200
        );
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function uploadAvatar(UploadAvatarRequest $request, User $profile)
    {
        try {
            $avatar = null;
            if ($request->hasFile('avatar')) {
                $avatar = saveResizeImage($request->avatar, 'avatar', 100, 100);
            }
            $profile->update(['avatar' => $avatar]);
            return $this->success('Avatar uploaded successfully');
        } catch (ModelNotFoundException $exception) {
            return $this->error('not_found', Response::HTTP_NOT_FOUND);
        }
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
