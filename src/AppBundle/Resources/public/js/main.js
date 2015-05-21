$(document).ready(function(){

    NProgress.start();

    $.getJSON(url+'shares/api/chart/'+share, function (data) {

        var chArr = [];

        if(!data.chart.error){

            if(data.chart.result[0] && data.chart.result[0].indicators.quote[0]){

                var result = data.chart.result[0];

                for (var i in result.indicators.quote[0].close) {

                    chArr.push([(result.timestamp[i] * 1000), result.indicators.quote[0].close[i]]);
                }

                NProgress.done();

                $('.chart').highcharts('StockChart', {
                    title: {
                        text: 'Стоимость портфеля акции от времени',
                        x: 0
                    },
                    yAxis: {
                        title: {
                            text: ''
                        }
                    },
                    tooltip: {
                        pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: <b>{point.y}</b><br/>',
                        valueSuffix: ''
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    rangeSelector: {
                        selected: 1
                    },
                    series: [{
                        name: share,
                        data: chArr,
                        tooltip: {
                            valueDecimals: 2
                        }
                    }]
                });
            }
        }
    });
});