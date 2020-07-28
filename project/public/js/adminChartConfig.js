function makeChart() {
    let dayUrlDataSet = makeData(JSON.parse($('#day-url-data').attr('data-field')));
    let dayUserDataSet = makeData(JSON.parse($('#day-user-data').attr('data-field')));

    new Chart(document.getElementById('day-url-count').getContext('2d'),
        createDayUrlCountChartConfig(dayUrlDataSet));
    new Chart(document.getElementById('day-user-count').getContext('2d'),
        createDayUserCountChartConfig(dayUserDataSet));
}

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
                        stepSize: 1
                    }

                }]
            }
        }
    };
}

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
                        stepSize: 1
                    }

                }]
            }
        }
    };
}

function gridLinesConfig(){
    return {
        display: true,
        drawBorder: true,
        drawOnChartArea: false,
    };
}
