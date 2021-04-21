<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use Auth;
use Image;
use Str;

class ProfileController extends Controller
{

    protected $uploadPath;

    public function __construct() {
        $this->uploadPath = public_path('uploads/users/');
    }

    public function update(Request $request) {
        $user = Auth::user();
        $user->name = $request->name ?? $user->name;
        $user->phone = $request->phone ?? $user->phone;
        $user->address = $request->address ?? $user->address;

        if($request->hasFile('image')) {

            if(!file_exists($this->uploadPath)) {
                mkdir($this->uploadPath, 777, true);
            }

            $image = $request->image;
            $ext = $request->image->getClientOriginalExtension();
            $imageName = (string) Str::uuid() . '.' . $ext;
            $thumbnail = Image::make($image->getRealPath())->resize(1024, 512);
            $savedImage = Image::make($thumbnail)->save($this->uploadPath . $imageName);
            $user->avatar = $imageName;
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully'
        ]);
    }

}
