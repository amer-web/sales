<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemoController extends Controller
{
    public function showJqueryImageUpload()
    {
        return view('demos.jqueryimageupload');
    }

    public function saveJqueryImageUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|max:1000',
        ]);

        if ($validator->fails()) {

            return $validator->errors();
        }

        $status = "";

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            // Rename image
            $filename = $image->getFilename().time().'.'.$image->guessExtension();
            $image->move(public_path('user_image/'),$filename);
            if(auth()->user()->user_image != null)
            {
                unlink(public_path(auth()->user()->user_image));
            }
            auth()->user()->user_image = 'user_image/' . $filename;
            auth()->user()->save();


            $status = "uploaded";
        }

        return response($status,200);
    }
}
