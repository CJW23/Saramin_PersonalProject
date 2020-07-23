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
            let dateTime = convertDate(data[0]['created_at']);
            $('.detail-created-date').html("CREATED " + dateTime['ymd']);
            $('.detail-created-time').html("TIME " + dateTime['time']);
            $('.detail-original-url').html(data[0]['original_url']);
            $('.detail-short-url').html(data[0]['short_url']);
            $('.detail-count').html(data[0]['count']);
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

function makeAccessTimeData() {
    var ctx = document.getElementById('myChart').getContext('2d');
    var config = createConfig();
    new Chart(ctx, config);
}

function createConfig() {
    let accessData = JSON.parse($('#accessData').attr('data-field'));
    let dateArr = getDates(lastMonth(), new Date())
        .map((v) => v.toISOString().slice(5, 10))
        .join(" ")
        .split(' ');

    let countData = [], cnt = 0, dataLength = accessData.length;
    console.log("accessdata: " + accessData);
    console.log("dataArr: " + dateArr);
    console.log("dataLength: " + dataLength);
    for (let i = 0; i < dateArr.length; i++) {
        //접근한 날짜가 존재하면
        if (cnt < dataLength && accessData[cnt]['dates'] === dateArr[i]) {
            countData.push(Number(accessData[cnt]['count']));
            ++cnt;
        } else {
            countData.push(0);
        }
    }
    var gridLines = {
        display: true,
        drawBorder: true,
        drawOnChartArea: false,
    }
    return {
        type: 'bar',
        data: {
            labels: dateArr,
            datasets: [{
                backgroundColor: colorPackage(),
                label: 'Click',
                data: countData,
            }]
        },
        options: {
            responsive: true,

            scales: {
                x: {
                    gridLines: gridLines
                },
                y: {
                    gridLines: gridLines,
                    min: 0,
                    max: 100,
                    ticks: {
                        stepSize: 10
                    }
                }
            }
        }
    };
}

//////한달전 날짜에서 현재 날짜까지의 리스트 구하는 함수
function getDates(start, end) {
    var arr = [];
    for (dt = start; dt <= end; dt.setDate(dt.getDate() + 1)) {
        arr.push(new Date(dt));
    }
    return arr;
}

function lastMonth() {
    var d = new Date()
    var monthOfYear = d.getMonth()
    d.setMonth(monthOfYear - 1)
    return d
}
////////////

function colorPackage(){
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
