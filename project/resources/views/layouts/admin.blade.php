@extends('layouts.app')

@section('script')
    <script src="{{ asset('js/admin/adminResponse.js') }}"></script>
    <script src="{{ asset('js/admin/adminChartConfig.js') }}"></script>
    <script src="{{ asset('js/admin/adminUrlManage.js') }}"></script>
    <script src="{{ asset('js/admin/adminUserManage.js') }}"></script>
@endsection
@section('content')

    <div class="container info-container" style="padding-top: 50px; max-width: 1500px">
        <div class="col-2 float-left">
            <div class="list-group">
                <div href="#" class="list-group-item list-group-item-action active">

                </div>
                @yield('menu')
            </div>
        </div>
        <div class="col-10 float-left">
            <div class="list-group contents">
                @yield('contents')
            </div>
        </div>
    </div>
@endsection
