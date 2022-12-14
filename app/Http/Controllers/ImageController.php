<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function imageUpload(Request $request)
    {


        //Single Image Upload
        if ($request->has('image')) {
            $image = $request->image;

            $name = time() . '.' . $image->getClientOriginalExtension();

            $path = public_path('upload');

            $image->move($path, $name);

            return response()->json(['data' => '', 'url' => 'http://127.0.0.1:8000/upload/'.$name, 'status' => true], 200);
        }
    }
}
