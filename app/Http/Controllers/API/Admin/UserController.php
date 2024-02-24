<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    public function index()
    {
        $list = User::all();
        return $this->sendResponse($list, 'User Lists.');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // Handle image upload
        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'uploads/profile/' . $imageName;
            Storage::disk('public')->put($imagePath, file_get_contents($image));
            $input['profile'] = $imagePath;
        }
        // Create user
        $user = User::create($input);

        if ($user) {
            return $this->sendResponse($user, 'User Added successfully.');
        } else {
            return $this->sendError('Error occurred while creating user.');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);

        if ($user) {
            return $this->sendResponse($user, 'User Details.');
        } else {
            return $this->sendError('Error occurred while creating user.');
        }
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'uploads/profile/' . $imageName;
            Storage::disk('public')->put($imagePath, file_get_contents($image));
            $input['profile'] = $imagePath;
        }
        // Update User
        $user = User::where('id',$id)->update($input);

        if ($user) {
            return $this->sendResponse($user, 'User Update successfully.');
        } else {
            return $this->sendError('Error occurred while Update user.');
        }

    }

    public function delete($id)
    {
        $user = user::where('id',$id)->delete();
        if ($user) {
            return $this->sendResponse($user, 'User Delete successfully.');
        } else {
            return $this->sendError('Error occurred while Delete user.');
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return $this->sendResponse($user, 'User Details.');
        } else {
            return $this->sendError('Error occurred while creating user.');
        }
    }
}
