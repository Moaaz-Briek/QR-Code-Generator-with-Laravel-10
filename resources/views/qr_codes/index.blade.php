@extends('layouts.header')
@section('content')
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-8 left">
            <form method="post" action="{{route('do_qr_builder')}}">
                @csrf
                <div class="form-group mb-2">
                    <label for="name">Select Qr Type</label>
                    <select name="qr_type" id="qr_type" class="form-control">
                        {{-- Session is used in case of a successful code generation and we want to make the type being seleceted --}}
                        {{-- Error is used in case of a wrong code generation and we want to make the type being seleceted --}}
                        <option disabled value="">Select Qr Type</option>
                        <option selected @if(session('type') === 'text') selected @endif id="text" @error('body') selected @enderror value="text">Text</option>
                        <option @if(session('type') === 'phone') selected @endif id="phone" @error('phone') selected @enderror value="phone">Phone</option>
                        <option @if(session('type') === 'email') selected @endif id="email" @error('to') selected @enderror value="email">Email</option>
                        <option @if(session('type') === 'sms') selected @endif id="sms" @error('phoneNumber') selected @enderror value="sms">Sms</option>
                        <option @if(session('type') === 'geo') selected @endif id="geo" @error('latitude') selected @enderror value="geo">Geo</option>
                        <option @if(session('type') === 'wifi') selected @endif id="wifi" @error('ssid') selected @enderror value="wifi">Wifi</option>
                    </select>
                </div>
                <div id="text" class="form-group type" style="display: none">
                    <label for="body">Qr Text</label>
                    <textarea type="text" name="body" class="form-control" style="resize: none" cols="3" rows="4">{{old('body')}}</textarea>
                    @error('body')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div id="phone" class="form-group type" style="display: none">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" value="{{old('phone')}}" class="form-control">
                    @error('phone')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div id="email" class="type" style="display: none">
                    <div class="form-group">
                        <label for="to">To:</label>
                        <input type="text" name="to" value="{{old('to')}}" class="form-control">
                        @error('to')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" name="subject" value="{{old('subject')}}" class="form-control">
                        @error('subject')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email_body">Body:</label>
                        <input type="text" name="email_body" value="{{old('email_body')}}" class="form-control">
                        @error('email_body')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div id="sms" class="type" style="display: none">
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number:</label>
                        <input type="text" name="phoneNumber" value="{{old('phoneNumber')}}" class="form-control">
                        @error('phoneNumber')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea type="text" name="message" rows="4" cols="5" class="form-control" style="resize: none">{{old('message')}}</textarea>
                        @error('message')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div id="geo" class="row type" style="display: none">
                    <div class="form-group col-6">
                        <label for="latitude">Latitude:</label>
                        <input type="text" name="latitude" value="{{old('latitude')}}" class="form-control">
                        @error('latitude')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="longitude">Longitude:</label>
                        <input type="text" name="longitude" value="{{old('longitude')}}" class="form-control">
                        @error('longitude')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div id="wifi" class="type row" style="display: none">
                    <div class="form-group col-6">
                        <label for="encryption">Encryption:</label>
                        <select name="encryption" class="form-control">
                            <option value="">Select Encryption Type</option>
                            <option value="WPA/WEP">WPA/WEP</option>
                            <option value="WPA">WPA</option>
                        </select>
                        @error('encryption')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="ssid">SSID:</label>
                        <input type="text" name="ssid" value="{{old('ssid')}}" class="form-control">
                        @error('ssid')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="password">Password:</label>
                        <input type="text" name="password" value="{{old('password')}}" class="form-control">
                        @error('password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="hidden">Hidden:</label>
                        <select name="hidden" class="form-control">
                            <option value="">Select Status</option>
                            <option @error('true') selected @enderror value="true">True</option>
                            <option @error('false') selected @enderror value="false">False</option>
                        </select>
                        @error('hidden')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <hr>
                <div id="fieldsRelatedToTextType">
                    <div class="row mb-3">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="qr_size">Qr Size</label>
                                <select name="qr_size" class="form-control">
                                    <option value="">Select Size</option>
                                    <option value="300">300x300</option>
                                    <option value="300">600x600</option>
                                    <option value="300">900x900</option>
                                </select>
                                @error('qr_size')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="qr_image_type">Qr Type</label>
                                <select name="qr_image_type" class="form-control">
                                    <option value="">Select Image Type</option>
                                    <option value="png">PNG</option>
                                    <option value="svg">SVG</option>
                                    <option value="eps">EPS</option>
                                </select>
                                @error('qr_image_type')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="qr_correction">Qr Correction</label>
                                <select name="qr_correction" class="form-control">
                                    <option value="">Select Qr Correction</option>
                                    <option value="L">7%</option>
                                    <option value="M">15%</option>
                                    <option value="Q">25%</option>
                                    <option value="H">30%</option>
                                </select>
                                @error('qr_correction')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="qr_encoding">Qr Character Encoding</label>
                                <select name="qr_encoding" class="form-control">
                                    <option value="">Select Character Encoding</option>
                                    <option value="UTF-8">UTF-8</option>
                                    <option value="ISO-8859-1">ISO-8859-1</option>
                                    <option value="ISO-8859-2">ISO-8859-2</option>
                                    <option value="ISO-8859-3">ISO-8859-3</option>
                                    <option value="ISO-8859-4">ISO-8859-4</option>
                                    <option value="ISO-8859-5">ISO-8859-5</option>
                                    <option value="ISO-8859-6">ISO-8859-6</option>
                                    <option value="ISO-8859-7">ISO-8859-7</option>
                                    <option value="ISO-8859-8">ISO-8859-8</option>
                                    <option value="ISO-8859-9">ISO-8859-9</option>
                                    <option value="ISO-8859-10">ISO-8859-10</option>
                                    <option value="ISO-8859-11">ISO-8859-11</option>
                                    <option value="ISO-8859-12">ISO-8859-12</option>
                                    <option value="ISO-8859-13">ISO-8859-13</option>
                                    <option value="ISO-8859-14">ISO-8859-14</option>
                                    <option value="ISO-8859-15">ISO-8859-15</option>
                                    <option value="ISO-8859-16">ISO-8859-16</option>
                                    <option value="SHIFT-JIS">SHIFT-JIS</option>
                                    <option value="WINDOWS-1250">WINDOWS-1250</option>
                                    <option value="WINDOWS-1251">WINDOWS-1251</option>
                                    <option value="WINDOWS-1252">WINDOWS-1252</option>
                                    <option value="WINDOWS-1256">WINDOWS-1256</option>
                                    <option value="UTF-16BE">UTF-16BE</option>
                                    <option value="ASCII">ASCII</option>
                                    <option value="GBK">GBK</option>
                                    <option value="EUC-KR">EUC-KR</option>
                                </select>
                                @error('qr_encoding')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="qr_eye">Qr Eye</label>
                                <select name="qr_eye" class="form-control">
                                    <option value="">Select Qr Eye</option>
                                    <option value="square">Square</option>
                                    <option value="circle">Circle</option>
                                </select>
                                @error('qr_eye')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="qr_margin">Qr Margin</label>
                                <input type="number" name="qr_margin" value="{{old('qr_margin')}}" class="form-control" min="0" max="100" step="1">
                                @error('qr_margin')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="qr_style">Qr Style</label>
                                <select name="qr_style" class="form-control">
                                    <option value="">Select Qr Style</option>
                                    <option value="square">Square</option>
                                    <option value="dot">Dot</option>
                                    <option value="round">Round</option>
                                </select>
                                @error('qr_style')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="qr_color">Qr Color</label>
                                <input name="qr_color" type="color" class="form-control" value="{{old('qr_color', '#000000')}}">
                                @error('qr_color')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{--Qr Background & background Transparent--}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qr_background_color">Qr Background Color</label>
                                <input name="qr_background_color" type="color" class="form-control" value="{{old('qr_background_color', '#FFFFFF')}}">
                                @error('qr_background_color')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qr_background_transparent">Qr Background Transparent</label>
                                <input type="number" name="qr_background_transparent" value="{{old('qr_background_transparent')}}" class="form-control" min="0" max="100" step="1">
                                @error('qr_background_transparent')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{--Eye color Inner & outer 0--}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qr_eye_color_inner_0">Qr Eye Color Inner 0</label>
                                <input name="qr_eye_color_inner_0" type="color" class="form-control" value="{{old('qr_eye_color_inner_0', '#000000')}}">
                                @error('qr_eye_color_inner_0')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qr_eye_color_outer_0">Qr Eye Color Outer 0</label>
                                <input name="qr_eye_color_outer_0" type="color" class="form-control" value="{{old('qr_eye_color_outer_0', '#000000')}}">
                                @error('qr_eye_color_outer_0')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{--Eye color Inner & outer 1--}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qr_eye_color_inner_1">Qr Eye Color Inner 1</label>
                                <input name="qr_eye_color_inner_1" type="color" class="form-control" value="{{old('qr_eye_color_inner_1', '#000000')}}">
                                @error('qr_eye_color_inner_1')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qr_eye_color_outer_1">Qr Eye Color Outer 1</label>
                                <input name="qr_eye_color_outer_1" type="color" class="form-control" value="{{old('qr_eye_color_outer_1', '#000000')}}">
                                @error('qr_eye_color_outer_1')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{--Eye color Inner & outer 2--}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qr_eye_color_inner_2">Qr Eye Color Inner 2</label>
                                <input name="qr_eye_color_inner_2" type="color" class="form-control" value="{{old('qr_eye_color_inner_2', '#000000')}}">
                                @error('qr_eye_color_inner_2')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qr_eye_color_outer_2">Qr Eye Color Outer 2</label>
                                <input name="qr_eye_color_outer_2" type="color" class="form-control" value="{{old('qr_eye_color_outer_2', '#000000')}}">
                                @error('qr_eye_color_outer_2')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{--Gradient--}}
                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="qr_gradient_start">Qr Gradient start</label>
                                <input name="qr_gradient_start" type="color" class="form-control" value="{{old('qr_gradient_start', '#000000')}}">
                                @error('qr_gradient_start')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="qr_gradient_end">Qr Gradient end</label>
                                <input name="qr_gradient_end" type="color" class="form-control" value="{{old('qr_gradient_end', '#000000')}}">
                                @error('qr_gradient_end')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="qr_gradient_type">Qr Gradient type</label>
                                <select name="qr_gradient_type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="vertical">Vertical</option>
                                    <option value="horizontal">Horizontal</option>
                                    <option value="diagonal">Diagonal</option>
                                    <option value="inverse_diagonal">Inverse_diagonal</option>
                                    <option value="radial">Radial</option>
                                </select>
                                @error('qr_gradient_type')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" name="submit" class="btn btn-primary">
                        Generate Qr Code
                    </button>
                </div>
            </form>
        </div>
        <div class="col-4 text-center p-3">
            <h4>Output</h4>
            <hr>
            <div class="">
            <div class="image_holder">
                @if(session('image_name'))
                    @if(pathinfo(session('image_name'))['extension'] === 'eps')
                        <p>Qr Code Available, <a download href="{{asset('qr_code/'. session('image_name'))}}">Click here </a>to download it</p>
                    @else
                        <img src="{{asset('qr_code/'. session('image_name'))}}" alt="{{session('image_name')}}" class="img-fluid">
                        <p>Qr Code Available, <a download href="{{asset('qr_code/'. session('image_name'))}}">Click here </a>to download it</p>
                    @endif
                @elseif(session('img'))
                    <div class="text-center">
                        {{session('img')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
    <script>
        $('#qr_type').on('change', function (){
            //Hide all types and remove the required attribute from all inputs
            $('.image_holder').empty();
            $("div .type").hide();
            $('div .type :input').removeAttr('required');
            //Hide the fields Related To Text qr code Type in case it's not a text type
            let id = $('#qr_type').children(":selected").attr('id');
            if (id !== 'text') {
                $('#fieldsRelatedToTextType').hide();
            } else {
                $('#fieldsRelatedToTextType').fadeIn(500);
            }
            // Show the selected type and bind required attribute to it.
            $("div #"+id+" :input").attr("required", 'required').fadeIn();
            $("div #" + id).fadeIn(500);
        });

        //This part of code is needed in case of arising errors of incorrect validation,
        //The qr type will be selected if there was an error, and after return back with errors
        //we want to show the hidden div linked with type.
        let id = $('#qr_type').children(":selected").attr('id');
        $("div #" + id).fadeIn(500);
        //Reloading page
        if (id !== 'text') {
            $('#fieldsRelatedToTextType').hide();
        } else {
            $('#fieldsRelatedToTextType').fadeIn(500);
        }
        //
    </script>
@endsection
