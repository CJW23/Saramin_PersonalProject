let totalConfig;
let totalChart;
let urlChart;
let urlConfig;

function makeTotalAccessChart() {
    let accessData = JSON.parse($('#access-data').attr('data-field'));

    let ctx = document.getElementById('totalAccessChart').getContext('2d');
    totalConfig = createTotalAccessChartConfig(accessData);
    totalChart = new Chart(ctx, totalConfig);
}

function makeUrlAccessChart() {
    let ctx;
    let accessData;
    let dataSet;

    accessData = requestUrlAccessData();
    if (accessData['rst'] === 'false') {
        return;
    }

    dataSet = makeData(accessData);

    //차트가 이미 생성되어있다면(다른 url을 클릭해서 차트가 만들어져있다면) 데이터만 조작하여 update
    if (urlChart == null) {
        ctx = document.getElementById('UrlAccessChart').getContext('2d');
        urlConfig = createUrlAccessChartConfig(dataSet);
        urlChart = new Chart(ctx, urlConfig);
    } else {
        urlConfig.data.datasets[0].data = dataSet['countData'];
        urlChart.update();
    }
}

function createUrlAccessChartConfig(dataSet) {

    let gridLines = {
        display: true,
        drawBorder: true,
        drawOnChartArea: false,
    }

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
                    gridLines: gridLines
                }],
                yAxes: [{
                    gridLines: gridLines,
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
    let dataSet = makeData(accessData);
    var gridLines = {
        display: true,
        drawBorder: true,
        drawOnChartArea: false,
    }
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
                    gridLines: gridLines
                }],
                yAxes: [{
                    gridLines: gridLines,
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


