@extends('layouts.app')

@section('content')
    awdawdawd
    <div class="container" style="max-width: 800px">
        <div class="col-3 float-left">
            <p>{{Auth::user()->name}}</p>
            <p>{{Auth::user()->name}}</p>
            <p>{{Auth::user()->name}}</p>
            <p>{{Auth::user()->name}}</p>
            <p>{{Auth::user()->name}}</p>
            <p>{{Auth::user()->name}}</p>
        </div>
        <div class="col-9 float-left">
            <p>{{Auth::user()->nickname}}</p>
            <p>{{Auth::user()->nickname}}</p>
            <p>{{Auth::user()->nickname}}</p>
            <p>{{Auth::user()->nickname}}</p>
            <p>{{Auth::user()->nickname}}</p>
            <p>{{Auth::user()->nickname}}</p>
        </div>
    </div>
    <!--
    <div class="row justify-content-center">
        <div class="col-4">
            <p>{{Auth::user()->name}}</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-4">
            <p>{{Auth::user()->nickname}}</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-3">
            <p>{{Auth::user()->phone}}</p>
        </div>
    </div>
    -->
@endsection
