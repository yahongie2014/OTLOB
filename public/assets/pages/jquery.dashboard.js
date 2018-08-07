
/**
* Theme: Adminto Admin Template
* Author: Coderthemes
* Dashboard
*/

!function($) {
    "use strict";

    var Dashboard1 = function() {
    	this.$realData = []
    };

    //creates Bar chart
    Dashboard1.prototype.createBarChart  = function(element, data, xkey, ykeys, labels, lineColors) {
        Morris.Bar({
            element: element,
            data: data,
            xkey: xkey,
            ykeys: ykeys,
            labels: labels,
            hideHover: 'auto',
            resize: true, //defaulted to true
            gridLineColor: '#eeeeee',
            barSizeRatio: 0.2,
            barColors: lineColors
        });
    },

    //creates line chart
    Dashboard1.prototype.createLineChart = function(element, data, xkey, ykeys, labels, opacity, Pfillcolor, Pstockcolor, lineColors) {
        Morris.Line({
          element: element,
          data: data,
          xkey: xkey,
          ykeys: ykeys,
          labels: labels,
          fillOpacity: opacity,
          pointFillColors: Pfillcolor,
          pointStrokeColors: Pstockcolor,
          behaveLikeLine: true,
          gridLineColor: '#eef0f2',
          hideHover: 'auto',
          resize: true, //defaulted to true
          pointSize: 0,
          lineColors: lineColors
        });
    },

    //creates Donut chart
    Dashboard1.prototype.createDonutChart = function(element, data, colors) {
        Morris.Donut({
            element: element,
            data: data,
            resize: true, //defaulted to true
            colors: colors
        });
    },
    
    
    Dashboard1.prototype.init = function($barData,$catData,$donutData,$donutColors) {

        //creating bar chart
        /*var $barData  = [
            { y: '2010', a: 75 },
            { y: '2011', a: 42 },
            { y: '2012', a: 75 },
            { y: '2013', a: 38 },
            { y: '2014', a: 19 },
            { y: '2015', a: 93 }
        ];*/
        this.createBarChart('morris-bar-example', $barData, 'year', ['total'], ['Total'], ['#188ae2']);

        //create line chart
        /*var $data  = [
            { y: '2008', a: 50, b: 0 },
            { y: '2009', a: 75, b: 50 },
            { y: '2010', a: 30, b: 80 },
            { y: '2011', a: 50, b: 50 },
            { y: '2012', a: 75, b: 10 },
            { y: '2013', a: 50, b: 40 },
            { y: '2014', a: 75, b: 50 },
            { y: '2015', a: 100, b: 70 }
          ];
        this.createLineChart('morris-line-example', $data, 'y', ['a','b'], ['مطاعم','حفلات'],['0.9'],['#5b69bc'],['#ff8acc'], ['#188ae2','#35b8e0']);*/

        this.createBarChart('morris-line-example', $catData, 'catName', ['total'], ['Total'], ['#35b8e0']);
        //creating donut chart
        // var $donutData = [
        //         {label: "مطاعم", value: 12},
        //         {label: "قاعات حفلات", value: 30},
        //         {label: "طباخات ", value: 20},
        //         {label: "ادوات حفلات ", value: 40},
        //         {label: "منسق حفلات ", value: 60},
        //         {label: "احتيجات الخدمه", value: 30}
        //     ];
        this.createDonutChart('morris-donut-example', $donutData ,$donutColors);

    },
        Dashboard1.prototype.init2 = function($orderByStatus,$donutColors) {
            this.createDonutChart('morris-donut-example2', $orderByStatus ,$donutColors);
        },
    //init
    $.Dashboard1 = new Dashboard1, $.Dashboard1.Constructor = Dashboard1
}(window.jQuery)

//initializing 
// function($) {
//     "use strict";
//     $.Dashboard1.init();
// }(window.jQuery);