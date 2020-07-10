@extends('layouts.layout')

@section('content')
    <div>
        <input type="text" name="enter_url" id="enter_url">
        <button onclick="test()">Convert</button>

    </div>
    <script>
        function test() {
            $.ajax({
                //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '/url',
                dataType: 'text',
                data: {
                    'url': $('#enter_url').val(),
                    'userid': 1
                },
                success: function (data) {
                    console.log(data);
                },
                error: function (data) {
                    console.log("error" + data);
                }
            });
        }
    </script>
@endsection()
