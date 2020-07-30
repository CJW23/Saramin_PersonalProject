let totalConfig;
let totalChart;
let accessUrlChart;
let accessUrlConfig;
let accessLinkChart;
let accessLinkConfig;

function makeTotalAccessChart() {
    let accessData = JSON.parse($('#access-data').attr('data-field'));

    let ctx = document.getElementById('totalAccessChart').getContext('2d');
    totalConfig = createTotalAccessChartConfig(accessData);
    totalChart = new Chart(ctx, totalConfig);
}

function makeUrlAccessChart() {
    let ctx;
    let accessUrlData, accessLinkData;
    let accessUrlDataSet, accessLinkDataSet;

    accessUrlData = requestUrlAccessData();
    if (accessUrlData['rst'] !== 'false') {
        accessUrlDataSet = makeDayData(accessUrlData);

        //차트가 이미 생성되어있다면(다른 url을 클릭해서 차트가 만들어져있다면) 데이터만 조작하여 update
        if (accessUrlChart == null) {
            ctx = document.getElementById('urlAccessChart').getContext('2d');
            accessUrlConfig = createUrlAccessChartConfig(accessUrlDataSet);
            accessUrlChart = new Chart(ctx, accessUrlConfig);
        } else {
            accessUrlConfig.data.datasets[0].data = accessUrlDataSet['countData'];
            accessUrlChart.update();
        }
    }

    accessLinkData = requestLinkAccessData();
    if(accessLinkData['rst'] !== 'false'){
        accessLinkDataSet = makeLinkData(accessLinkData);
        //차트가 이미 생성되어있다면(다른 url을 클릭해서 차트가 만들어져있다면) 데이터만 조작하여 update
        if (accessLinkChart == null) {
            ctx = document.getElementById('linkAccessChart').getContext('2d');
            accessLinkConfig = createLinkAccessChartConfig(accessLinkDataSet);
            accessLinkChart = new Chart(ctx, accessLinkConfig);
        } else {
            accessLinkConfig.data.datasets[0].data = accessLinkDataSet['countData'];
            accessLinkChart.update();
        }
    }

}

function createUrlAccessChartConfig(dataSet) {
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
                        maxTicksLimit: 10
                    }

                }]
            }
        }
    };
}

function createTotalAccessChartConfig(accessData) {
    let dataSet = makeDayData(accessData);
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
                        maxTicksLimit: 10
                    }

                }]
            }
        }
    };
}

function createLinkAccessChartConfig(accessLinkData) {
    return {
        type: 'bar',
        data: {
            labels: accessLinkData['linkName'],
            datasets: [{
                backgroundColor: colorPackage(),
                label: 'Click',
                data: accessLinkData['linkCount'],
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
                        maxTicksLimit: 10
                    }

                }]
            }
        }
    };
}

function gridLinesConfig() {
    return {
        display: true,
        drawBorder: true,
        drawOnChartArea: false,
    };
}
