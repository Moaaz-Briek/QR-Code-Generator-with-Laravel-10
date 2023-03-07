<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $body = $request->input('body');
        $qr_code = QrCode::generate($body);

        return back()->with([
           'status' => 'Qr Code Generated Successfully',
           'code' => $qr_code,
        ]);
    }
}
