<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ImageFileController extends Controller
{
    public function index()
    {
        return view('my-images');
    }

    public function imageFileUpload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:4096',
        ]);

        $image = $request->file('file');
        $input['file'] = time().'.'.$image->getClientOriginalExtension();

        $imgFile = Image::make($image->getRealPath());

        $imgFile->text('Test Text', 120, 100, function($font) {
            $font->size(32);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('bottom');
            $font->angle(90);
        })
            ->resize(200, 300)
            ->save(public_path('upload').DIRECTORY_SEPARATOR.$input['file'], 100);

        return back()
            ->with('success','File successfully uploaded.')
            ->with('fileName',$input['file']);
    }
}
