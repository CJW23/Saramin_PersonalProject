@extends('layouts.app')

@section('content')
    <br><br>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-4">
                    <img src="{{url('/images/saramin_bi_blue_english.png')}}" />
                </div>
            </div>
            <br><br>
            <div class="row justify-content-center">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="enter_url" id="enter_url" placeholder="Enter your URL">
                    <div class="input-group-append">
                        <button onclick="requestCreateUrl()" class="btn btn-primary " type="button">Convert</button>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-4" id="test">
                    <a href="" id="shortUrl"></a>
                </div>
            </div>
        </div>
    </div>
@endsection()
