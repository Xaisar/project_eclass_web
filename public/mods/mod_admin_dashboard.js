$(document).ready(function () {
    renderStudentByGender();
    renderStudentByMajor();
});

function getChartColorsArray(r) {
    r = $(r).attr("data-colors");
    return (r = JSON.parse(r)).map(function (r) {
        r = r.replace(" ", "");
        if (-1 == r.indexOf("--")) return r;
        r = getComputedStyle(document.documentElement).getPropertyValue(r);
        return r || void 0
    })
}


async function renderStudentByGender() {
    var piechartColors = getChartColorsArray("#student-by-gender")
    const {
        data: chartData
    } = await requestChartData('student-by-gender');
    $('#male-label').text(chartData.male + ' Siswa');
    $('#female-label').text(chartData.female + ' Siswa');
    $('#other-label').text(chartData.other + ' Siswa');

    var options = {
        series: [chartData.male, chartData.female, chartData.other],
        chart: {
            width: 227,
            height: 227,
            type: "pie"
        },
        labels: ["Laki-Laki", "Perempuan", "Lainnya"],
        colors: piechartColors,
        stroke: {
            width: 0
        },
        legend: {
            show: !1
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                }
            }
        }]
    };

    var chart = new ApexCharts(
        document.querySelector('#student-by-gender'),
        options
    );
    chart.render();
}
async function renderStudentByMajor() {
    var barColor = getChartColorsArray("#student-by-major")
    const {
        data: chartData
    } = await requestChartData('student-by-major');

    var options = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: !1
            }
        },
        plotOptions: {
            bar: {
                horizontal: !0
            }
        },
        dataLabels: {
            enabled: !1
        },
        series: [{
            name: 'Jumlah Siswa',
            data: chartData.map(major => major.total)
        }],
        colors: barColor,
        grid: {
            borderColor: "#f1f1f1"
        },
        xaxis: {
            categories: chartData.map(major => major.name)
        }
    };

    var chart = new ApexCharts(
        document.querySelector('#student-by-major'),
        options
    );
    chart.render();
}
async function requestChartData(chartRouteName, prefix = 'administrator') {
    const res = await fetch(
        `${$('meta[name=base-url]').attr(
            'content'
        )}/${prefix}/dashboard/${chartRouteName}`
    );
    const data = await res.json();
    return data;
}
if (typeof drEvent === 'undefined') {
    const drEvent = $('#input-file-now').dropify();

    drEvent.on('dropify.beforeClear', function (event, element) {
        return swal.fire({
            title: 'Question?',
            type: 'question',
            text: "Do you really want to delete \"" + element.file.name + "\" ?"
        })
    });

    drEvent.on('dropify.afterClear', function (event, element) {
        swal.fire({
            title: 'Success',
            type: 'success',
            text: 'File deleted'
        })
    });
}
