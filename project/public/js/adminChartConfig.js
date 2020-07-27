function makeUserCountChart() {
    let ctx = document.getElementById('day-url-count').getContext('2d');
    let config = createUserCountChartConfig();
    new Chart(ctx, config);
}

function createUserCountChartConfig() {
    let gridLines = {
        display: true,
        drawBorder: true,
        drawOnChartArea: false,
    }

    return {
        type: 'bar',
        data: {
            labels: ['a', 'b', 'c'],
            datasets: [{
                backgroundColor: colorPackage(),
                label: 'Click',
                data: [1, 2, 3],
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
