@extends('layouts.layout')

@section('content')
    <div>
        <input type="text" name="enter_url" id="enter_url">
        <button onclick="requestCreateUrl()">Convert</button>
        <a href="" id="shortUrl"></a>
    </div>
@endsection()
