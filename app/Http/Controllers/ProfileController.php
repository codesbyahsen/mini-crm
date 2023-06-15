<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileAddressUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UploadAvatarRequest;
use App\Models\User;
use App\Traits\AjaxResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    use AjaxResponse;

    /**
     * Display the user's profile.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $fullAddress = $user->getFullAddress();
        $user = $user->toArray();
        $user['full_address'] = $fullAddress;
        if ($request->ajax()) {
            return $this->success('User profile fetched successfully.', $user);
        }

        $countries = DB::table('countries')->select('id', 'name')->get();

        return view('profile.index', [
            'user' => $request->user(),
            'countries' => $countries
        ]);
    }

    public function avatar(Request $request)
    {
        if (!empty($request->user()->avatar)) {
            return $this->success('Avatar fetched successfully.', $request->user()->avatar);
        } else {
            return $this->error('not_found', Response::HTTP_NOT_FOUND);
        }
    }

    public function edit(Request $request)
    {
        return response()->json(
            [
                'success' => true,
                'message' => 'User fetched successfully.',
                'data' => $request->user()->getAttributes()
            ],
            200
        );
    }

    /**
     * Update the user's profile information.
     */
    public function updatePersonal(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return $this->success('Profile Updated');
    }

    public function updateAddress(ProfileAddressUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return $this->success('Address Updated');
    }

    public function uploadAvatar(UploadAvatarRequest $request, User $profile)
    {
        try {
            $avatar = null;
            if ($request->hasFile('avatar')) {
                $avatar = saveResizeImage($request->avatar, 'user-avatar', 100, 100);
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
