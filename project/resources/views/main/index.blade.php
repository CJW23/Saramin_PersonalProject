@extends('layouts.layout')

@section('content')
    <div>
        <input type="text" name="enter_url" id="enter_url">
        <button onclick="test()">Convert</button>
        <a href="" id="shortUrl"></a>
    </div>
    <script>
        function test() {
            $.ajax({
                //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '/url',
                dataType: 'json',
                data: {
                    'url': $('#enter_url').val(),
                    'userid': 1
                },
                success: function (data) {
                    console.log(data);
                    if(data['shortUrl'] == "false"){
                        $("#shortUrl").text("유효하지 않은 URL");
                    }
                    else {
                        $("#shortUrl").text(data['shortUrl']);
                        $("#shortUrl").attr("href", data['shortUrl']);
                    }
                    //console.log(data);
                },
                error: function (data) {
                    console.log("error");
                }
            });
        }
    </script>
@endsection()
