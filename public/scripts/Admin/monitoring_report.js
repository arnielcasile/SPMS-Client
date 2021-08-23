$(document).ready(() => {

    $('#txt_mr_range_date_from').val(date_today);
    $('#txt_mr_range_date_to').val(date_today);
    $('#txt_mr_deliv_date_from').val(date_today);
    $('#txt_mr_deliv_date_to').val(date_today);

    $('#txt_mr_range_date_month_from').val(month_today);
    $('#txt_mr_range_date_month_to').val(month_today);

    $('#txt_mr_deliv_date_month_from').val(month_today);
    $('#txt_mr_deliv_date_month_to').val(month_today);
    MONITORING_REPORT.load();
    MONITORING_REPORT.load_tables('ALL', date_today, date_today, date_today, date_today);

});

const MONITORING_REPORT = (() => {
    let this_monitoring_report = {};
    let range_search_from = '';
    let range_search_to = '';
    let range_status = '';
    let deliv_search_from = '';
    let deliv_search_to = '';
   
    this_monitoring_report.load = () => {
        
        instance.get(`load-process`).then(function (response) {
            var status = "";
            status = `<option selected value="ALL">ALL</option>`;

            $.each(response['data'].data, function () {
                status += `<option class="select-option" value="${this.id}">${this.process}</option>`;
                $("#slc_mr_status").html(status);
            });
        }).catch(function (error) {
            console.log(error)
        }).finally(() => { })
    };

    this_monitoring_report.onchange_datepicker = () => {
        if ($('#slc_mr_range').val() === 'MONTHLY') {
            $('#txt_mr_range_date_from').prop('hidden', true);
            $('#txt_mr_range_date_to').prop('hidden', true);
            $('#txt_mr_range_date_month_from').prop('hidden', false);
            $('#txt_mr_range_date_month_to').prop('hidden', false);
        }
        else {
            $('#txt_mr_range_date_from').prop('hidden', false);
            $('#txt_mr_range_date_to').prop('hidden', false);
            $('#txt_mr_range_date_month_from').prop('hidden', true);
            $('#txt_mr_range_date_month_to').prop('hidden', true);
        }

        if ($('#slc_mr_deliv_due_date').val() === 'MONTHLY') {
            $('#txt_mr_deliv_date_from').prop('hidden', true);
            $('#txt_mr_deliv_date_to').prop('hidden', true);
            $('#txt_mr_deliv_date_month_from').prop('hidden', false);
            $('#txt_mr_deliv_date_month_to').prop('hidden', false);
        }
        else {
            $('#txt_mr_deliv_date_from').prop('hidden', false);
            $('#txt_mr_deliv_date_to').prop('hidden', false);
            $('#txt_mr_deliv_date_month_from').prop('hidden', true);
            $('#txt_mr_deliv_date_month_to').prop('hidden', true);
        }
    };

    this_monitoring_report.search_btn = () => {

            toastr.info('Please wait. Refrain from clicking the search when loading.', 'System Message');
            $("#btn_search").prop('disabled',true);
            if ($('#slc_mr_range').val() === 'MONTHLY') {
                var from = new Date($('#txt_mr_range_date_month_from').val());
                var to = new Date($('#txt_mr_range_date_month_to').val());
                var first_date = new Date(from.getFullYear(), from.getMonth(), 1);
                var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0);

                range_search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' +
                    ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

                range_search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' +
                    ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
            }
            else {
                range_search_from = $('#txt_mr_range_date_from').val();
                range_search_to = $('#txt_mr_range_date_to').val();
            }

            if ($('#slc_mr_deliv_due_date').val() === 'MONTHLY') {
                var from = new Date($('#txt_mr_deliv_date_month_from').val());
                var to = new Date($('#txt_mr_deliv_date_month_to').val());
                var first_date = new Date(from.getFullYear(), from.getMonth(), 1);
                var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0);

                deliv_search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' +
                    ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

                deliv_search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' +
                    ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));


            }
            else {
                deliv_search_from = $('#txt_mr_deliv_date_from').val();
                deliv_search_to = $('#txt_mr_deliv_date_to').val();
            }
            range_status = $("#slc_mr_status option:selected").text();

            if (range_search_from === ''
                || range_search_to === ''
                || deliv_search_from === ''
                || deliv_search_to === ''

                || range_search_from === 'NaN-0NaN-0NaN'
                || range_search_to === 'NaN-0NaN-0NaN'
                || deliv_search_from === 'NaN-0NaN-0NaN'
                || deliv_search_to === 'NaN-0NaN-0NaN') {
                toastr.error('Please complete the inputs', 'System Message');
                setInterval
                (function () {
                    $("#btn_search").prop('disabled',false);
                
                }, 3000); 
            }
            else if ((range_search_from > range_search_to) || (deliv_search_from > deliv_search_to))
            {
                toastr.error('Invalid date range', 'System Message');
                    setInterval
                    (function () {
                        $("#btn_search").prop('disabled',false);
                    
                    }, 3000);            }
            else {

                MONITORING_REPORT.clean_tables();
                MONITORING_REPORT.load_tables(range_status, range_search_from, range_search_to, deliv_search_from, deliv_search_to);
                setInterval
                (function () {
                    $("#btn_search").prop('disabled',false);
                
                }, 3000); 
            }
    };

    this_monitoring_report.load_delivery_status = (range_status_, range_search_from_, range_search_to_, deliv_search_from_, deliv_search_to_) => {
       // $('.loader').show();
        instance.get(`report-delivery-status`,
            {
                params: ({
                    status: range_status_,
                    issue_from: range_search_from_,
                    issue_to: range_search_to_,
                    due_from: deliv_search_from_,
                    due_to: deliv_search_to_,
                    warehouse_class: area_code,
                })
            }).then((response) => {
                if (response['statusText'] == 'OK') {

                    var datas = response.data.data;
                    console.log(datas);
                    var data = [];
                    for (var x = 0; x < datas[1].length - 1; x++) {
                        var status_ = datas[1][x][0];
                        var total_ = datas[1][x][datas[1][x].length - 1];
                        data.push(
                            {
                                status: status_,
                                total: total_
                            });
                    }

                    if (datas.length === 0) {
                        toastr.warning('No data matched in the database. Thank you', 'System Message')
                    }
                    else {
                        var greater_zero=0;
                        for (var x = 0; x < datas[1].length - 1; x++) 
                        {                          
                            if(datas[1][x][datas[1][x].length - 1] > 0)
                            {
                                greater_zero+=1;
                            } 
                        }         
                        if(greater_zero === 0)
                        {
                            toastr.warning('No data matched in the database. Thank you', 'System Message')
                            $("#div_daily_status").prop('hidden',true);                           
                        }
                        else
                        {
                            $("#div_daily_status").prop('hidden',false);
                        }
                        var chart = am4core.create("chart_status", am4charts.PieChart);
                        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                        
                        chart.data = data;
                        chart.radius = am4core.percent(70);
                        chart.innerRadius = am4core.percent(40);
                        chart.startAngle = 180;
                        chart.endAngle = 360;  
                        
                        var series = chart.series.push(new am4charts.PieSeries());
                        series.dataFields.value = "total";
                        series.dataFields.category = "status";
                        series.ticks.template.events.on("ready", hideSmall);
                        series.ticks.template.events.on("visibilitychanged", hideSmall);
                        series.labels.template.events.on("ready", hideSmall);
                        series.labels.template.events.on("visibilitychanged", hideSmall);
                        
                        series.slices.template.cornerRadius = 10;
                        series.slices.template.innerCornerRadius = 7;
                        series.slices.template.draggable = true;
                        series.slices.template.inert = true;
                        series.alignLabels = false;
                        
                        series.hiddenState.properties.startAngle = 90;
                        series.hiddenState.properties.endAngle = 90;
                        
                        function hideSmall(ev) {
                            if (ev.target.dataItem.values.value.percent < 5) {
                              ev.target.hide();
                            }
                            else {
                              ev.target.show();
                            }
                          }
                          
                        chart.legend = new am4charts.Legend();
                        $('#thead_daily_status').empty();
                        var tr_head = '<tr>';
                        for (var i = 0; i < datas[0].length; i++) {
                            tr_head += `
                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">${datas[0][i]}</th>`;
                        }
                        tr_head += `</tr>`;
                        $('#thead_daily_status').append(tr_head);

                        var tr_body;
                        $('#table_daily_status').DataTable().destroy();
                        $('#tbody_daily_status').empty();
                        for (var s = 0; s < datas[1].length; s++) {
                            tr_body += `<tr>`;
                            for (var d = 0; d < datas[0].length; d++) {
                                tr_body += `
                                <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${datas[1][s][d]}</td>`;
                            }
                            tr_body += `</tr>`;
                        }
                        $('#tbody_daily_status').append(tr_body);


                        $('#table_daily_status').DataTable({
                            "scrollX": true,
                            "scrollY": "300px",
                            "paging": false,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": false,
                            "info": true,
                            "autoWidth": true,
                            "fnDrawCallback": function () {
                                $('#tbody_daily_status td').each(function () {
                                    if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') {
                                        $(this).text('');
                                    }
                                });
                            }
                        });

                    }
                }
                else {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                }
            }).catch((error) => {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }).finally(() => {
               // $('.loader').hide();
            })
    };

    this_monitoring_report.load_issuance_count = (range_status_, range_search_from_, range_search_to_, deliv_search_from_, deliv_search_to_) => {
       // $('.loader').show();
        instance.get(`report-issuance-payee`,
            {
                params: ({
                    status: range_status_,
                    issue_from: range_search_from_,
                    issue_to: range_search_to_,
                    due_from: deliv_search_from_,
                    due_to: deliv_search_to_,
                    warehouse_class: area_code,
                })
            }).then((response) => {
                if (response['statusText'] == 'OK') {
                    var datas = response.data.data;
                    var data = [];
                    for (var x = 0; x < datas[1].length; x++) {
                        var status_ = datas[1][x][0];
                        var total_ = datas[1][x][datas[1][x].length - 1];

                        if (status_ !== 'TOTAL') {
                            data.push(
                                {
                                    status: status_,
                                    total: total_
                                });
                        }
                    }

                    if (datas.length === 0) {
                        toastr.warning('No data matched in the database. Thank you', 'System Message')
                    }
                    else {
                        var greater_zero=0;
                        for (var x = 0; x < datas[1].length - 1; x++) 
                        {                          
                            if(datas[1][x][datas[1][x].length - 1] > 0)
                            {
                                greater_zero+=1;
                            } 
                        }         
                        if(greater_zero === 0)
                        {
                            
                            $("#div_issuance_count").prop('hidden',true);                           
                        }
                        else
                        {
                            $("#div_issuance_count").prop('hidden',false);
                        }

                        am4core.useTheme(am4themes_animated);
                        // Themes end

                        // Create chart instance
                        var chart = am4core.create("chart_count", am4charts.XYChart);
                        chart.scrollbarX = new am4core.Scrollbar();

                        // Add data
                        chart.data = data

                        // Create axes
                        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "status";
                        categoryAxis.renderer.grid.template.location = 0;
                        categoryAxis.renderer.minGridDistance = 30;
                        categoryAxis.renderer.labels.template.horizontalCenter = "right";
                        categoryAxis.renderer.labels.template.verticalCenter = "middle";
                        categoryAxis.renderer.labels.template.rotation = 270;
                        categoryAxis.tooltip.disabled = true;
                        categoryAxis.renderer.minHeight = 110;

                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        valueAxis.renderer.minWidth = 50;

                        // Create series
                        var series = chart.series.push(new am4charts.ColumnSeries());
                        series.sequencedInterpolation = true;
                        series.dataFields.valueY = "total";
                        series.dataFields.categoryX = "status";
                        series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
                        series.columns.template.strokeWidth = 0;

                        series.tooltip.pointerOrientation = "vertical";

                        series.columns.template.column.cornerRadiusTopLeft = 10;
                        series.columns.template.column.cornerRadiusTopRight = 10;
                        series.columns.template.column.fillOpacity = 0.8;

                        // on hover, make corner radiuses bigger
                        var hoverState = series.columns.template.column.states.create("hover");
                        hoverState.properties.cornerRadiusTopLeft = 0;
                        hoverState.properties.cornerRadiusTopRight = 0;
                        hoverState.properties.fillOpacity = 1;

                        series.columns.template.adapter.add("fill", function(fill, target) {
                        return chart.colors.getIndex(target.dataItem.index);
                        });

                        // Cursor
                        chart.cursor = new am4charts.XYCursor();

                        $('#thead_issuance_count').empty();
                        var tr_head = '<tr>';
                        tr_head += '';
                        for (var i = 0; i < datas[0].length; i++) {
                            tr_head += `
                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">${datas[0][i]}</th>`;
                        }
                        tr_head += `</tr>`;
                        $('#thead_issuance_count').append(tr_head);

                        var tr_body;
                        $('#table_issuance_count').DataTable().destroy();
                        $('#tbody_issuance_count').empty();
                        for (var s = 0; s < datas[1].length; s++) {
                            tr_body += `<tr>`;
                            for (var d = 0; d < datas[0].length; d++) {
                                tr_body += `
                                <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${datas[1][s][d]}</td>`;
                            }
                            tr_body += `</tr>`;
                        }
                        $('#tbody_issuance_count').append(tr_body);


                        $('#table_issuance_count').DataTable({
                            "scrollX": true,
                            "scrollY": "300px",
                            "paging": false,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": false,
                            "info": true,
                            "autoWidth": true,
                            "fnDrawCallback": function () {
                                $('#tbody_issuance_count td').each(function () {
                                    if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') {
                                        $(this).text('');
                                    }
                                });
                            }
                        });

                    }
                }
                else {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                }
            }).catch((error) => {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }).finally(() => {
               // $('.loader').hide();
            })
    };

    this_monitoring_report.load_issuance_payee = (range_status_, range_search_from_, range_search_to_, deliv_search_from_, deliv_search_to_) => {
       // $('.loader').show();
        instance.get(`report-delivery-quantity`,
            {
                params: ({
                    status: range_status_,
                    issue_from: range_search_from_,
                    issue_to: range_search_to_,
                    due_from: deliv_search_from_,
                    due_to: deliv_search_to_,
                    warehouse_class: area_code,
                })
            }).then((response) => {
                if (response['statusText'] == 'OK') {
                    var datas = response.data.data;
                    var data = [];
                    for (var x = 0; x < datas[1].length; x++) {
                        var status_ = datas[1][x][0];
                        var total_ = datas[1][x][datas[1][x].length - 1];
                        if (status_ !== 'TOTAL') {
                            data.push(
                                {
                                    status: status_,
                                    total: total_
                                });
                        }
                    }
                    if (data.length === 0) {
                        toastr.warning('No data matched in the database. Thank you', 'System Message')
                    }
                    else {
                        var greater_zero=0;
                        for (var x = 0; x < datas[1].length - 1; x++) 
                        {                          
                            if(datas[1][x][datas[1][x].length - 1] > 0)
                            {
                                greater_zero+=1;
                            } 
                        }         
                        if(greater_zero === 0)
                        {
                            
                            $("#div_issuance_sum").prop('hidden',true);                           
                        }
                        else
                        {
                            $("#div_issuance_sum").prop('hidden',false);
                        }
                        am4core.useTheme(am4themes_material);
                        am4core.useTheme(am4themes_animated);

                        var chart = am4core.create("chart_sum", am4charts.XYChart3D);
                        chart.paddingBottom = 30;
                        chart.angle = 35;
                        chart.data = data;

                        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "status";
                        categoryAxis.renderer.grid.template.location = 0;
                        categoryAxis.renderer.minGridDistance = 20;
                        categoryAxis.renderer.inside = true;
                        categoryAxis.renderer.grid.template.disabled = true;

                        let labelTemplate = categoryAxis.renderer.labels.template;
                        labelTemplate.rotation = -90;
                        labelTemplate.horizontalCenter = "left";
                        labelTemplate.verticalCenter = "middle";
                        labelTemplate.dy = 10; // moves it a bit down;
                        labelTemplate.inside = false; // this is done to avoid settings which are not suitable when label is rotated

                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        valueAxis.renderer.grid.template.disabled = true;

                        // Create series
                        var series = chart.series.push(new am4charts.ConeSeries());
                        series.dataFields.valueY = "total";
                        series.dataFields.categoryX = "status";

                        var columnTemplate = series.columns.template;
                        columnTemplate.adapter.add("fill", function (fill, target) {
                            return chart.colors.getIndex(target.dataItem.index);
                        })

                        columnTemplate.adapter.add("stroke", function (stroke, target) {
                            return chart.colors.getIndex(target.dataItem.index);
                        })
                        $('#thead_issuance_sum').empty();
                        var tr_head = '<tr>';
                        for (var i = 0; i < datas[0].length; i++) {
                            tr_head += `
                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">${datas[0][i]}</th>`;
                        }
                        tr_head += `</tr>`;
                        $('#thead_issuance_sum').append(tr_head);

                        var tr_body;
                        $('#table_issuance_sum').DataTable().destroy();
                        $('#tbody_issuance_sum').empty();
                        for (var s = 0; s < datas[1].length; s++) {
                            tr_body += `<tr>`;
                            for (var d = 0; d < datas[0].length; d++) {
                                tr_body += `
                                <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${datas[1][s][d]}</td>`;
                            }
                            tr_body += `</tr>`;
                        }
                        $('#tbody_issuance_sum').append(tr_body);


                        $('#table_issuance_sum').DataTable({
                            "scrollX": true,
                            "scrollY": "300px",
                            "paging": false,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": false,
                            "info": true,
                            "autoWidth": true,
                            "fnDrawCallback": function () {
                                $('#tbody_issuance_sum td').each(function () {
                                    if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') {
                                        $(this).text('');
                                    }
                                });
                            }
                        });

                    }
                }
                else {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                }
            }).catch((error) => {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }).finally(() => {
               // $('.loader').hide();
            })
    };

    this_monitoring_report.clean_tables = () => {
        $('#table_daily_status').DataTable().destroy();
        $('#tbody_daily_status').empty();
        $('#table_issuance_count').DataTable().destroy();
        $('#tbody_issuance_count').empty();
        $('#table_issuance_sum').DataTable().destroy();
        $('#tbody_issuance_sum').empty();
    };

    this_monitoring_report.load_tables = (range_status, range_search_from, range_search_to, deliv_search_from, deliv_search_to) => {
        MONITORING_REPORT.load_delivery_status(range_status, range_search_from, range_search_to, deliv_search_from, deliv_search_to);
        MONITORING_REPORT.load_issuance_count(range_status, range_search_from, range_search_to, deliv_search_from, deliv_search_to);
        MONITORING_REPORT.load_issuance_payee(range_status, range_search_from, range_search_to, deliv_search_from, deliv_search_to);
    };

    return this_monitoring_report;
})();