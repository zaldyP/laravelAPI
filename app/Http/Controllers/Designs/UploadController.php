<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Jobs\UploadImage;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        //validate the request
        $this->validate($request,[
           'image' => ['required', 'mimes:jpg,jpeg,gif,bmp,png', 'max:2048']
        ]);

        //get the image
        $image = $request->file('image');
        $image_path = $image->getPathname();

        //get the original file name and replace any spaces with
        //Business card.png = timestamp()_business_card.png
        $filename = time()."_". preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        //move image to temporary location
        $temp = $image->storeAs('/uploads/original', $filename, 'tmp');

        //create database records for the design
        $designs = auth()->user()->designs()->create([
            'image' => $filename,
            'disk' => config('site.upload_disk')
        ]);

        //dispatch a job to handle the image manipulation
        $this->dispatch(new UploadImage($designs));

        return response()->json([$designs], 200);

    }
}
