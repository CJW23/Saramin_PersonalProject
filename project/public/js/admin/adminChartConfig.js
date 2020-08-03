/**
 * 관리자 모든 차트 생성
 */
function makeChart() {
    let dayUrlDataSet = makeDayData(JSON.parse($('#day-url-data').attr('data-field')));
    let dayUserDataSet = makeDayData(JSON.parse($('#day-user-data').attr('data-field')));
    let dayAccessUrlDataSet = makeDayData(JSON.parse($('#day-access-url-data').attr('data-field')));
    new Chart(document.getElementById('day-url-count').getContext('2d'),
        createDayUrlCountChartConfig(dayUrlDataSet));
    new Chart(document.getElementById('day-user-count').getContext('2d'),
        createDayUserCountChartConfig(dayUserDataSet));
    new Chart(document.getElementById('day-access-url-count').getContext('2d'),
        createDayAccessUrlCountChartConfig(dayAccessUrlDataSet));

}

/**
 * 일별 URL 등록 차트 설정
 * @param dataSet 데이터 JSON
 */
function createDayUrlCountChartConfig(dataSet) {
    console.log(dataSet);
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
            scales: {
                xAxes: [{
                    gridLines: gridLinesConfig()
                }],
                yAxes: [{
                    gridLines: gridLinesConfig(),
                    scaleLabel: {
                        display: true,
                    },
                    ticks: {
                        min: 0,
                        maxTicksLimit: 6
                    }

                }]
            }
        }
    };
}

/**
 * 일별 유저 회원가입 차트 설정
 * @param dataSet 데이터 JSON
 */
function createDayUserCountChartConfig(dataSet) {
    console.log(dataSet);
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
            scales: {
                xAxes: [{
                    gridLines: gridLinesConfig()
                }],
                yAxes: [{
                    gridLines: gridLinesConfig(),
                    scaleLabel: {
                        display: true,
                    },
                    ticks: {
                        min: 0,
                        maxTicksLimit: 6
                    }

                }]
            }
        }
    };
}

/**
 * 일별 URL 접근 차트 설정
 * @param dataSet 데이터 JSON
 */
function createDayAccessUrlCountChartConfig(dataSet) {
    console.log(dataSet);
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
            scales: {
                xAxes: [{
                    gridLines: gridLinesConfig()
                }],
                yAxes: [{
                    gridLines: gridLinesConfig(),
                    scaleLabel: {
                        display: true,
                    },
                    ticks: {
                        min: 0,
                        maxTicksLimit: 6
                    }

                }]
            }
        }
    };
}


