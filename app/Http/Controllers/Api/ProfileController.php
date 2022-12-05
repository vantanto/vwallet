<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ResponseTrait;

    public function edit(Request $request)
    {
        return $this->responseSuccess('Profile Edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $user->name = $request->name;
        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $file = $request->avatar;
            $filename = date('YmdHis') . $user->id . '.' . $file->extension();
            $user->avatar = 'avatar/' . $filename;

            Storage::disk('public')->put($user->avatar, file_get_contents($file));
        }
        $user->save();

        return $this->responseSuccess('profile-updated', [
            'user' => $user,
        ]);
    }
}
