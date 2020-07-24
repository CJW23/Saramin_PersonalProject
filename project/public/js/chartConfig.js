var config;
var totalChart;

function makeTotalAccessChart() {
    var ctx = document.getElementById('totalAccessChart').getContext('2d');
    config = createTotalAccessChartConfig();
    totalChart = new Chart(ctx, config);
}

function makeUrlAccessChart() {
    var ctx = document.getElementById('UrlAccessChart').getContext('2d');
    var config = createUrlAccessChartConfig();
    new Chart(ctx, config);
}

function createUrlAccessChartConfig() {
    var gridLines = {
        display: true,
        drawBorder: true,
        drawOnChartArea: false,
    }
    let dataSet = makeTotalAccessData();
    return {
        type: 'bar',
        data: {
            labels: dataSet['dateArr'],
            datasets: [{
                backgroundColor: colorPackage(),
                label: 'Click',
                data: dataSet['countData'],
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 0
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

function createTotalAccessChartConfig() {

    var gridLines = {
        display: true,
        drawBorder: true,
        drawOnChartArea: false,
    }
    let dataSet = makeTotalAccessData();
    return {
        type: 'line',
        data: {
            labels: dataSet['dateArr'],
            datasets: [{
                backgroundColor: colorPackage(),
                label: 'Click',
                data: dataSet['countData'],
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 0
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

function makeTotalAccessData() {
    let accessData = JSON.parse($('#accessData').attr('data-field'));
    //날짜 리스트
    let dateArr = getDates(lastWeek(), new Date())
        .map((v) => v.toISOString().slice(5, 10))
        .join(" ")
        .split(' ');

    //날짜별 접근 횟수 저장
    let countData = [];
    let cnt = 0;
    let dataLength = accessData.length;

    //날짜별 접근 횟수 리스트 생성
    for (let i = 0; i < dateArr.length; i++) {
        //접근한 날짜가 존재하면
        if (cnt < dataLength && accessData[cnt]['dates'] === dateArr[i]) {
            countData.push(Number(accessData[cnt]['count']));
            ++cnt;
        } else {
            countData.push(0);
        }
    }
    return {
        'countData': countData,
        'dateArr': dateArr
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
    var monthOfYear = d.getMonth();
    d.setMonth(monthOfYear - 1);
    return d
}

function lastWeek() {
    var d = new Date()
    var day = d.getDate();
    d.setDate(day - 7);
    return d
}

////////////


