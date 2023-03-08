<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function index()
    {
        return view('qr_codes.qr_builder');
    }

    public function do_qr_builder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $name = $request->input('name');
        $image_name = Str::slug($name) . '.png'; //Moaaz Briek => moaaz-briek.png
        $body = $request->input('body');

        QrCode::format('png')->generate($body, '../public/qr_code/'. $image_name);

        return back()->with([
            'status' => 'Qr Code Generated Successfully',
            'image_name' => $image_name,
        ]);
    }
}
