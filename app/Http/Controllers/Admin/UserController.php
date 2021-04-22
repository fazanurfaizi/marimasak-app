<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Http\Request;
use Str;
use Image;

class UserController extends Controller
{
    protected $uploadPath;

    public function __construct() {
        $this->uploadPath = public_path('uploads/users/');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::where('role', 'admin')
            ->when($request->search, function($query) use ($request) {
                $search = $request->search;
                return $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })->latest()->paginate(10);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = 'admin';

        if($request->hasFile('image')) {

            if(!file_exists($this->uploadPath)) {
                mkdir($this->uploadPath, 777, true);
            }

            $image = $request->image;
            $ext = $request->image->getClientOriginalExtension();
            $imageName = Str::uuid() . '.' . $ext;
            $thumbnail = Image::make($image->getRealPath())->resize(1024, 512);
            $savedImage = Image::make($thumbnail)->save($this->uploadPath . $imageName);
            $user->avatar = $imageName;
        }

        $user->save();

        return redirect('users')->withSuccess('Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if($request->hasFile('image')) {

            if(!file_exists($this->uploadPath)) {
                mkdir($this->uploadPath, 777, true);
            }

            $image = $request->image;
            $ext = $request->image->getClientOriginalExtension();
            $imageName = Str::uuid() . '.' . $ext;
            $thumbnail = Image::make($image->getRealPath())->resize(1024, 1024);
            $savedImage = Image::make($thumbnail)->save($this->uploadPath . $imageName);

            if($user->avatar !== null) {
                unlink($this->uploadPath . $user->avatar);
            }

            $user->update([
                'avatar' => $imageName
            ]);
        }

        return redirect('users')->withSuccess('Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->avatar !== null) {
            unlink($this->uploadPath . $user->avatar);
        }
        $user->delete();

        return redirect(url()->previous());
    }
}
