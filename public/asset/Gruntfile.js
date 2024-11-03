module.exports = function(grunt) {
    grunt.initConfig({
		sass: {
			options: {
                includePaths: ['node_modules/bootstrap-sass/asset/stylesheets']
            },
            dist: {
				options: {
					outputStyle: 'compressed'
				},
                files: [{
                    '/css/mooli.min.css': 'scss/main.scss', 	                        /* 'All main SCSS' */
				}]
            }
        },
        uglify: {
          my_target: {
            files: {
                '/bundles/libscripts.bundle.js':          ['/vendor/jquery/jquery-3.5.1.min.js','/vendor/bootstrap/js/bootstrap.bundle.js'], /* main js*/
                '/bundles/vendorscripts.bundle.js':       ['/vendor/metisMenu/metisMenu.js','/vendor/jquery-slimscroll/jquery.slimscroll.min.js','/vendor/bootstrap-progressbar/js/bootstrap-progressbar.min.js','/vendor/jquery-sparkline/js/jquery.sparkline.min.js'], /* coman js*/

                '/bundles/mainscripts.bundle.js':         ['js/common.js'], /*coman js*/

                '/bundles/apexcharts.bundle.js':          ['/vendor/apexcharts/apexcharts.min.js'], /* Apex chart js*/
                '/bundles/c3.bundle.js':                  ['/vendor/c3/c3.min.js','/vendor/c3/d3.v3.min.js'], /* c 3 chart js*/
                '/bundles/morrisscripts.bundle.js':       ['/vendor/raphael/raphael.min.js','/vendor/morrisjs/morris.js'], /* Morris Plugin Js */
                '/bundles/knob.bundle.js':                ['/vendor/jquery-knob/jquery.knob.min.js'], /* knob js*/
                '/bundles/chartist.bundle.js':            ['/vendor/chartist/js/chartist.min.js','/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js','/vendor/chartist-plugin-axistitle/chartist-plugin-axistitle.min.js','/vendor/chartist-plugin-legend-latest/chartist-plugin-legend.js','/vendor/chartist/Chart.bundle.js'], /*chartist js*/
                '/bundles/easypiechart.bundle.js':        ['/vendor/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js','/vendor/jquery.easy-pie-chart/easy-pie-chart.init.js'],
                '/bundles/flotscripts.bundle.js':         ['/vendor/flot-charts/jquery.flot.js','/vendor/flot-charts/jquery.flot.resize.js','/vendor/flot-charts/jquery.flot.pie.js','/vendor/flot-charts/jquery.flot.categories.js','/vendor/flot-charts/jquery.flot.time.js'], /* Flot Chart js*/

                '/bundles/jvectormap.bundle.js':          ['/vendor/jvectormap/jquery-jvectormap-2.0.3.min.js','/vendor/jvectormap/jquery-jvectormap-world-mill-en.js','/vendor/jvectormap/jquery-jvectormap-in-mill.js','/vendor/jvectormap/jquery-jvectormap-us-aea-en.js'], /* jvectormap js*/
                '/bundles/fullcalendarscripts.bundle.js': ['/vendor/fullcalendar/moment.min.js','/vendor/fullcalendar/fullcalendar.js'],   /* calender page js */
                '/bundles/datatablescripts.bundle.js':    ['/vendor/jquery-datatable/jquery.dataTables.min.js','/vendor/jquery-datatable/dataTables.bootstrap4.min.js'], /* Jquery DataTable Plugin Js  */
                }
            }
        }
    });
    grunt.loadNpmTasks("grunt-sass");
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask("buildcss", ["sass"]);
    grunt.registerTask("buildjs", ["uglify"]);
};
