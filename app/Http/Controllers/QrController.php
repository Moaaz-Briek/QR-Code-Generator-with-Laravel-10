<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Color\Hex;

class QrController extends Controller
{
    protected string $body;
    protected string $phone;
    protected string $qr_type;
    protected string $image_name;
    protected string $subject;
    protected string $to;
    protected string $phoneNumber;
    protected string $message;
    protected string $latitude;
    protected string $longitude;
    protected string $encryption;
    protected string $ssid;
    protected string $password;
    protected string $hidden;

    public function index()
    {
        return view('qr_codes.index');
    }

    public function do_qr_builder(Request $request)
    {
        $this->qr_type = $request->input('qr_type');
        switch ($this->qr_type) {
            case 'text':
                $validator = Validator::make($request->all(), [
                    'body' => 'required',
                ]);
                if (!$validator->fails()) {
                    $this->body = $request->input('body');
                }
                break;
            case 'phone':
                $validator = Validator::make($request->all(), [
                    'phone' => 'required',
                ]);
                if (!$validator->fails()) {
                    $this->phone = $request->input('phone');
                }
                break;
            case 'email':
                $validator = Validator::make($request->all(), [
                    'to' => 'required|email',
                ]);
                if (!$validator->fails()) {
                    $this->to = $request->input('to');
                    $this->subject = $request->input('subject') ?? '';
                    $this->body = $request->input('email_body') ?? '';
                }
                break;
            case 'sms':
                $validator = Validator::make($request->all(), [
                    'phoneNumber' => 'required',
                ]);
                if (!$validator->fails()) {
                    $this->phoneNumber = $request->input('phoneNumber');
                    $this->message = $request->input('message') ?? '';
                }
                break;
            case 'geo':
                $validator = Validator::make($request->all(), [
                    'latitude' => 'required',
                    'longitude' => 'required',
                ]);
                if (!$validator->fails()) {
                    $this->latitude = $request->input('latitude');
                    $this->longitude = $request->input('longitude');
                }
                break;
            case 'wifi':
                $validator = Validator::make($request->all(), [
                    'ssid' => 'required',
                ]);
                if (!$validator->fails()) {
                    $this->encryption = $request->input('encryption') ?? '';
                    $this->ssid = $request->input('ssid');
                    $this->password = $request->input('password') ?? '';
                    $this->hidden = $request->input('hidden') ?? false;
                }
                break;
        }
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $qr_size = $request->input('qr_size') ?? '300';
        $qr_image_type = $request->input('qr_image_type') ?? 'png';
        $qr_correction = $request->input('qr_correction') ?? 'H';
        $qr_encoding = $request->input('qr_encoding') ?? 'UTF-8';
        $qr_eye = $request->input('qr_eye') ?? 'square';
        $qr_margin = $request->input('qr_margin') ?? 0;
        $qr_style = $request->input('qr_style') ?? 'square';
        $qr_color = Hex::fromString($request->input('qr_color') ?? '#000000')->toRgb();
        $qr_background_color = Hex::fromString($request->input('qr_background_color') ?? '#000000')->toRgb();
        $qr_background_transparent = $request->input('qr_background_transparent') ?? 0;
        $qr_eye_color_inner_0 = Hex::fromString($request->input('qr_eye_color_inner_0') ?? '#000000')->toRgb();
        $qr_eye_color_outer_0 = Hex::fromString($request->input('qr_eye_color_outer_0') ?? '#000000')->toRgb();
        $qr_eye_color_inner_1 = Hex::fromString($request->input('qr_eye_color_inner_1') ?? '#000000')->toRgb();
        $qr_eye_color_outer_1 = Hex::fromString($request->input('qr_eye_color_outer_1') ?? '#000000')->toRgb();
        $qr_eye_color_inner_2 = Hex::fromString($request->input('qr_eye_color_inner_2') ?? '#000000')->toRgb();
        $qr_eye_color_outer_2 = Hex::fromString($request->input('qr_eye_color_outer_2') ?? '#000000')->toRgb();
        $qr_gradient_start = Hex::fromString($request->input('qr_gradient_start') ?? '#000000')->toRgb();
        $qr_gradient_end = Hex::fromString($request->input('qr_gradient_end') ?? '#000000')->toRgb();
        $qr_gradient_type = $request->input('qr_gradient_type') ?? 'vertical';

        $qr = QrCode::format($qr_image_type);
        $qr->size($qr_size);
        $qr->errorCorrection($qr_correction);
        $qr->encoding($qr_encoding);
        $qr->eye($qr_eye);
        $qr->margin($qr_margin);
        $qr->style($qr_style);
        $qr->color($qr_color->red(), $qr_color->green(), $qr_color->blue());
        $qr->backgroundColor($qr_background_color->red(), $qr_background_color->green(), $qr_background_color->blue(), $qr_background_transparent);
        $qr->eyeColor(0,
            $qr_eye_color_inner_0->red(),
            $qr_eye_color_inner_0->green(),
            $qr_eye_color_inner_0->blue(),
            $qr_eye_color_outer_0->red(),
            $qr_eye_color_outer_0->green(),
            $qr_eye_color_outer_0->blue()
        );
        $qr->eyeColor(1,
            $qr_eye_color_inner_1->red(),
            $qr_eye_color_inner_1->green(),
            $qr_eye_color_inner_1->blue(),
            $qr_eye_color_outer_1->red(),
            $qr_eye_color_outer_1->green(),
            $qr_eye_color_outer_1->blue()
        );
        $qr->eyeColor(2,
            $qr_eye_color_inner_2->red(),
            $qr_eye_color_inner_2->green(),
            $qr_eye_color_inner_2->blue(),
            $qr_eye_color_outer_2->red(),
            $qr_eye_color_outer_2->green(),
            $qr_eye_color_outer_2->blue()
        );
        $qr->gradient(
            $qr_gradient_start->red(),
            $qr_gradient_start->green(),
            $qr_gradient_start->blue(),
            $qr_gradient_end->red(),
            $qr_gradient_end->green(),
            $qr_gradient_end->blue(),
            $qr_gradient_type,
        );
        $this->image_name = Str::slug(time()) . '.' . $qr_image_type; //Moaaz Briek => moaaz-briek.png

        if ($this->qr_type == 'text') {
            $qr->generate($this->body, '../public/qr_code/'. $this->image_name);
            $array = ['image_name' => $this->image_name];
        } elseif ($this->qr_type == 'phone') {
            $array = ['img' => QrCode::phoneNumber($this->phone)];
        } elseif ($this->qr_type == 'email') {
            $array = ['img' => QrCode::email($this->to, $this->subject, $this->body)];
        } elseif ($this->qr_type == 'sms') {
            $array = ['img' => QrCode::SMS($this->phoneNumber, $this->message)];
        } elseif ($this->qr_type == 'geo') {
            $array = ['img' => QrCode::geo($this->latitude, $this->longitude)];
        } elseif ($this->qr_type == 'wifi') {
            $array = ['img' => QrCode::wifi($this->encryption, $this->ssid, $this->password, $this->hidden)];
        }
        return back()->with([
            ...$array,
            'status' => 'Qr Code Generated Successfully',
            'type' => $this->qr_type,
        ]);
    }

    public function scan()
    {
        return view('qr_codes.scan');
    }
}
