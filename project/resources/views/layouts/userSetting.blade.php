@extends('layouts.app')

@section('content')
    <div class="container info-container" style="padding-top: 50px; max-width: 1000px">
        <div class="col-4 float-left">
            <div class="list-group">
                <div href="#" class="list-group-item list-group-item-action active">
                    {{Auth::user()->nickname}} 정보
                </div>
                @yield('menu')
            </div>
        </div>
        <div class="col-8 float-left">
            <div class="list-group contents">
                @yield('contents')
            </div>
        </div>
    </div>
@endsection
