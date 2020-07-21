//URL 상세정보 요청
function requestUrlDetail(urlId) {
    let id = $(urlId).attr('id');
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: '/url/detail/' + id,
        dataType: 'json',
        success: function (data) {
            let dateTime = convertDate(data['created_at']);
            $('.detail-created-date').html("CREATED " + dateTime['ymd']);
            $('.detail-created-time').html("TIME " + dateTime['time']);
            $('.detail-original-url').html(data['original_url']);
            $('.detail-short-url').html(data['short_url']);
            $('.detail-count').html(data['count']);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

//시간 데이터 포맷
function convertDate(date) {
    let ymd = String(date).substring(0, 10);
    let time = String(date).substring(11, 19);
    return {
        'ymd': ymd,
        'time': time
    };
}

function test() {
    console.log($('#data').data("field"));
    $('#data').data("field", "awd");
    console.log($('#data').data('field'));
}

function search() {
    $(document).ready(function() {
        $("#url-search").keyup(function() {
            const k = $(this).val();
            $(".url-list-group > a").hide();
            const temp = $(".url-list-group > a > div:nth-child(1):contains('" + k + "')");
            $(temp).parent().show();
        })
    })
}
