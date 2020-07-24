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
            $('#empty-select').hide();
            let dateTime = convertDate(data[0]['created_at']);
            $('.detail-created-date').html("CREATED " + dateTime['ymd'] + " " + dateTime['time']);
            $('.detail-name-url').html(data[0]['name_url']);
            $('.detail-original-url').attr('href', data[0]['original_url']).html(data[0]['original_url']);
            $('.detail-short-url').attr('href', "http://" + data[0]['short_url']).html(data[0]['short_url']);
            $('.detail-count').html("TOTAL : " + data[0]['count']);
            $('#short-url').val(data[0]['short_url']);
            $('#exist-select').show();
            makeUrlAccessChart();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

//Total 데이터 요청
function requestTotalData() {
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: '/users/data/total',
        dataType: 'json',
        success: function (data) {
            $('#total-num').html(data[0]['total_num']);
            $('#total-sum').html(data[0]['total_sum']);
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

function copyUrl() {
    $('#short-url').select();
    document.execCommand('copy');
}

function search() {
    $(document).ready(function () {
        $("#url-search").keyup(function () {
            const k = $(this).val();
            $(".url-list-group > .url-list").hide();
            const temp = $(".url-list-group > .url-list > div > div:nth-child(1):contains('" + k + "')");
            $(temp).parent().parent().show();
        })
    })
}

//URL 체크시 1개 이상 체크하면 view에 띄움
function urlCheck() {
    let count = $('input:checkbox[name=url-check]:checked').length;
    if (count > 0) {
        $('.url-detail-view').hide();
        $('.url-delete-view').show();
        let html = count + "개의 URL이 선택되었습니다<br><br>";
        $('#url-count').html(html);
    } else {
        $('.url-detail-view').show();
        $('.url-delete-view').hide();
    }
}


function colorPackage() {
    return [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ];
}
