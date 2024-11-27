<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imgupload;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ImageUploadController extends Controller
{
  public function showUploadPage()
  {
    return view('dashboard.imageuploads.imageupload');
  }

  public function fileUpload(Request $req)
  {
    $req->validate([
      'imageFile' => 'required',
      'imageFile.*' => 'mimes:jpeg,jpg,png,gif'
    ]);
    if ($req->hasfile('imageFile')) {
      foreach ($req->file('imageFile') as $file) {
        $name = $file->getClientOriginalName();
        $file->move(public_path() . '/uploads/', $name);
        $imgData[] = $name;
      }
      $UploadModel = new Imgupload();
      $UploadModel->name = json_encode($imgData);
      $UploadModel->image_path = json_encode($imgData);

      $UploadModel->save();
      return back()->with('shout', 'File has been uploaded!');
    }
  }
}
