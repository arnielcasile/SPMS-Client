$(document).ready(() => 
{
    $('#txt_week_status_from').val(first_week);
    $('#txt_week_status_to').val(last_week);

    DASHBOARD.delivery_leadtime()
    DASHBOARD.load_week_status(area_code)
    DASHBOARD.load_area_code();
    DASHBOARD.ticket_chart();
    DASHBOARD.chart_status(area_code);
  
});

const DASHBOARD = (() => 
{
    let this_dashboard = {};
    let data = [];
    this_dashboard.load_animation = () =>
    {
        $("#div_main").addClass("important animate__animated animate__fadeInDown animate__delay-5s");
        $("#div_chart_status").addClass("important animate__animated animate__fadeInDown animate__delay-4s");
        $("#div_delivery_leadtime").addClass("important animate__animated animate__fadeInDown animate__delay-3s");
    }

    this_dashboard.delivery_leadtime = () =>
    {
        var date_from = $("#txt_week_status_from").val();
        var date_to   = $("#txt_week_status_to").val();
        instance.get(`delivery_leadtime`, 
        {
            params: ({
                date_from          : date_from,
                date_to            : date_to,
            })
        }).then((response) => 
        {
            // var test =[];
            // test[0]={"P14":"255","C2":"1","C1":"122","total_qty":"378","ticket_issue_date":"2020-08-18"};
            // test[1]={"P14":"1","C2":"1","C1":"501","total_qty":"503","ticket_issue_date":"2020-08-19"};
            // test[2]={"P14":"100","C2":"1","C1":"133","total_qty":"737","ticket_issue_date":"2020-08-20"};
            var data_array=response.data;    
            data=[];
            console.log(data_array);
            for (var i = 0; i < data_array.length; i++) 
            {
                data.push(data_array[i]);     
            }
            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("chart_delivery_leadtime", am4charts.XYChart);
            chart.data = data;

            
            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "ticket_issue_date";
            categoryAxis.title.paddingTop = 40;
            categoryAxis.title.text = "TICKET ISSUE DATE";
            categoryAxis.title.paddingBottom = 15;
            categoryAxis.renderer.minGridDistance = 30;
            categoryAxis.renderer.labels.template.horizontalCenter = "right";
            categoryAxis.renderer.labels.template.verticalCenter = "middle";
            categoryAxis.renderer.labels.template.rotation = 315;
            categoryAxis.tooltip.disabled = true;
            categoryAxis.renderer.minHeight = 110;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

            var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis2.renderer.opposite = true;

            var series_name=[];
            for (var i = 0; i < data_array.length; i++) 
            {
                for (const [key, value] of Object.entries(data_array[i])) 
                {
                    if(!(series_name.indexOf(key) != -1))
                    {
                        if(key!="ticket_issue_date")
                        {
                            series_name.push(key);
                        }
                    }
                       
                  }
            }

            for (var j = 0; j < series_name.length; j++) 
            {
                if(series_name[j]!='total_qty')
                {
                    var series                        = chart.series.push(new am4charts.ColumnSeries());
                        series.dataFields.valueY      = series_name[j];
                        series.dataFields.categoryX   = 'ticket_issue_date';
                        series.name                   = series_name[j];
                        series.tooltipText            = "{name}: [bold]{valueY}[/]";
                        series.strokeWidth            = 3;
                        series.columns.template.width = am4core.percent(95);

                }
                else
                {
                      var series2                      = chart.series.push(new am4charts.LineSeries());
                          series2.dataFields.valueY    = "total_qty";
                          series2.dataFields.categoryX = "ticket_issue_date";
                          series2.name                 = "Total Quantity"
                          series2.tooltipText          = "{name}: [bold]{valueY}[/]";
                          series2.strokeWidth          = 3;
                        //   series2.yAxis                = valueAxis2;
                        var bullet      = series2.bullets.push(new am4charts.Bullet());
                        bullet.fill = am4core.color("#001787");                         // tooltips grab fill from parent by default
        
                        
        
                    var circle             = bullet.createChild(am4core.Circle);
                        circle.radius      = 4;
                        circle.fill        = am4core.color("#fff");
                        circle.strokeWidth = 3;
                }
            }
      
            chart.legend = new am4charts.Legend();
            chart.cursor = new am4charts.XYCursor();
        }).catch((error) => 
        {
            toastr.error('Problems encountered. Please contact the administrator. Thank you', 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 2000);
        }).finally(() => 
        {
         
        })
     

    }

    this_dashboard.chart_status = (status) => 
    {   
        var date_from = $("#txt_week_status_from").val();
        var date_to   = $("#txt_week_status_to").val();
       // $('.loader').show();
        instance.get(`report-delivery-status`,
            {
                params: ({
                    status         : 'ALL',
                    issue_from     : first_date_month,
                    issue_to       : last_date_month,
                    due_from       : first_date_month,
                    due_to         : last_date_month,
                    warehouse_class: status,
                })
            }).then((response) => {
                if (response['statusText'] == 'OK') {

                    var datas = response.data.data;
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
                        
                        var series                     = chart.series.push(new am4charts.PieSeries());
                            series.dataFields.value    = "total";
                            series.dataFields.category = "status";
                        series.ticks.template.events.on("ready", hideSmall);
                        series.ticks.template.events.on("visibilitychanged", hideSmall);
                        series.labels.template.events.on("ready", hideSmall);
                        series.labels.template.events.on("visibilitychanged", hideSmall);
                        
                        
                        series.slices.template.cornerRadius      = 10;
                        series.slices.template.innerCornerRadius = 7;
                        series.slices.template.draggable         = true;
                        series.slices.template.inert             = true;
                        series.alignLabels                       = false;
                        
                        series.hiddenState.properties.startAngle = 90;
                        series.hiddenState.properties.endAngle   = 90;
                        
                        var slice = series.slices.template;
                        slice.states.getKey("hover").properties.scale = 1;
                        slice.states.getKey("active").properties.shiftRadius = 0;

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
                        var data_array=[];
                        for (var i = 0; i < datas[0].length; i++) {
                            tr_head += `
                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;white-space: nowrap;">${datas[0][i]}</th>`;
                        }
                        tr_head += `</tr>`;
                        $('#thead_daily_status').append(tr_head);

                        var tr_body;
                        $('#table_daily_status').DataTable().destroy();
                        $('#tbody_daily_status').empty();
                        for (var s = 0; s < datas[1].length; s++) {
                            tr_body += `<tr>`;
                            for (var d = 0; d < datas[0].length; d++) 
                            {
                            //    /console.log(datas);
                                tr_body += `
                                <td style="text-align:center;horizontal-align:middle;vertical-align:middle;white-space: nowrap;">${datas[1][s][d]}</td>`;
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
                            },
                            fixedColumns:   {
                                leftColumns: 1,
                                rightColumns: 1
                            }
                        });

                    }
                }
                else {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    setTimeout(
                        function() 
                        {
                            window.location.reload();
                        }, 2000);
                }
            }).catch((error) => {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                setTimeout(
                    function() 
                    {
                        window.location.reload();
                    }, 2000);
            }).finally(() => {
               // $('.loader').hide();
            })
        
    };

    this_dashboard.load_area_code = () => 
    {
        instance.get(`area-code-all`).then(function (response) 
        {
            var area_code = `<li class="m-nav__section m-nav__section--first">
            <span class="m-nav__section-text">
               CHOOSE AREA CODE
            </span>
             </li>`;            

            $.each(response['data'].data, function () 
            {    
                if(this.area_code != 'RECEIVER')
                {
                    area_code+= `<li class="m-nav__item"><a href="#" class='m-nav__link' onclick='DASHBOARD.load_week_status("${this.area_code}")'>
                    <i class='m-nav__link-icon flaticon-map'></i>
                    <span class='m-nav__link-text'>
                        ${this.area_code}
                    </span>
                    </a> </li>`;
                }             
            });
            $("#li_week_status_area_codes").empty().append(area_code);
        }).catch(function (error) 
        {
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 2000);
            console.log(error)
        }).finally(() => {})
    };

    this_dashboard.change_area_code = (code) => 
    {
        $('#txt_area_code').val(code);
    };

    this_dashboard.load_week_status = (code) => 
    {
        
        var date_from=$("#txt_week_status_from").val();
        var date_to=  $("#txt_week_status_to").val();
        var area_code=code;
        if (date_from === ''
            || date_to === ''
            || date_from === 'NaN-0NaN-0NaN'
            || date_to === 'NaN-0NaN-0NaN') 
        {
            toastr.error('Please complete the inputs', 'System Message')
        }
        else if(date_from > date_to)
        {
            toastr.error('Date from must less than date to.', 'System Message')
        }
        else
        {
           // $('.loader').show();
            instance.get(`week-status`,
            {
                params: ({
                            date_from          : date_from,
                            date_to            : date_to,
                            area_code          : area_code,       
                        })
            }).then((response) => 
            {
                if (response['statusText'] == 'OK') 
                {
                var datas=response.data.data;
               // console.log(datas);
                var arr=[];
                var ticket_chart_arr=[];
                var total_delivered=0, total_wip=0,count=0;
                for(x=0;x<datas.length;x++)
                {
                    total_delivered+=datas[x][1];
                    total_wip+=datas[x][2];
                
                    ticket_chart_arr.push({
                        date:datas[x][0],
                        value1:datas[x][1],
                        value2:datas[x][2],
                    });
                }
                arr.push(
                {
                    status: "WIP",
                    total: total_delivered
                });

                arr.push(
                {
                    status: "Delivered",
                    total: total_wip
                });
                 
                // Themes start
                am4core.useTheme(am4themes_animated);
                // Themes end
                
                var chart = am4core.create("div_unprocessed_ticket", am4charts.PieChart3D);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                
                chart.legend = new am4charts.Legend();
                
                chart.data = arr;
                
                chart.innerRadius = 100;
                
                var series                          = chart.series.push(new am4charts.PieSeries());
                    series.dataFields.value         = "total";
                    series.dataFields.category      = "status";
                    series.labels.template.disabled = true;

                var label                           = series.createChild(am4core.Label);
                    label.text                      = area_code;
                    label.horizontalCenter          = "middle";
                    label.verticalCenter            = "middle";
                    label.fontSize                  = 30;
                    
                DASHBOARD.chart_status(code);
                DASHBOARD.ticket_chart(ticket_chart_arr);
                DASHBOARD.delivery_leadtime()
                }
            }).catch((error) => 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                setTimeout(
                    function() 
                    {
                        window.location.reload();
                    }, 2000);
            }).finally(() => { 
           // $('.loader').hide();
            })
        }
    };

    this_dashboard.ticket_chart = (ticket_chart_arr) => 
    {
        var chart = am4core.create("div_ticket_chart", am4charts.XYChart);

        // Add data
        chart.data = ticket_chart_arr;

        // Create axes
        // var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        // dateAxis.renderer.minGridDistance = 25;
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.dataFields.category = "date";
        dateAxis.renderer.grid.template.location = 0;
        dateAxis.renderer.minGridDistance = 30;
        dateAxis.renderer.labels.template.horizontalCenter = "right";
        dateAxis.renderer.labels.template.verticalCenter = "middle";
        dateAxis.renderer.labels.template.rotation = 315;
        dateAxis.tooltip.disabled = true;
        dateAxis.renderer.minHeight = 110;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value1";
        series.dataFields.dateX = "date";
        
        series.strokeWidth = 2;
        series.minBulletDistance = 10;
        series.tooltipText = `DELIVERED:{value1}\nWIP:{value2}`;
        series.tooltip.pointerOrientation = "vertical";

        // Create series
        var series2 = chart.series.push(new am4charts.LineSeries());
        series2.dataFields.valueY = "value2";
        series2.dataFields.dateX = "date";
        series2.strokeWidth = 2;
        series2.strokeDasharray = "3,4";
        // series2.stroke = series.stroke;

       

        // var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        // valueAxis.renderer.minWidth = 50;

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.xAxis = dateAxis;
    }

    this_dashboard.load_delivery_status = (range_status_,range_search_from_,range_search_to_,deliv_search_from_,deliv_search_to_) =>
    {
       // $('.loader').show();
        instance.get(`report-delivery-status`,
        {
            params: ({
                        status              : range_status_,
                        issue_from          : range_search_from_,
                        issue_to            : range_search_to_,
                        due_from            : deliv_search_from_,
                        due_to              : deliv_search_to_,
                        warehouse_class     : area_code,
                    })
        }).then((response) => 
        {
            //console.log(response)
            if (response['statusText'] == 'OK') 
            {
                    var datas=response.data.data;
                    var data=[];
                    for(var x = 0; x < datas[1].length-1; x++)
                    {  
                        var status_=datas[1][x][0];
                        var total_=datas[1][x][datas[1][x].length-1];
                        data.push(
                        {
                            status : status_,
                            total : total_
                        });        
                    }

                    if (datas.length === 0) 
                    {
                        toastr.warning('No data matched in the database. Thank you', 'System Message')
                    }  
                    else 
                    {
                        am4core.useTheme(am4themes_animated);

                        var chart = am4core.create("chart_status", am4charts.PieChart3D);
                        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                        chart.legend = new am4charts.Legend();
                        chart.data=data;

                        var series = chart.series.push(new am4charts.PieSeries3D());
                        series.dataFields.value = "total";
                        series.dataFields.category = "status";
                       
                    }
            }
            else 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                setTimeout(
                    function() 
                    {
                        window.location.reload();
                    }, 2000);
            }
        }).catch((error) => 
        {
            toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 2000);
        }).finally(() => { 
       // $('.loader').hide();
        })
    };

    this_dashboard.load_issuance_count = (range_status_,range_search_from_,range_search_to_,deliv_search_from_,deliv_search_to_) =>
    {
       // $('.loader').show();
        instance.get(`report-issuance-payee`,
        {
            params: ({
                status              : range_status_,
                issue_from          : range_search_from_,
                issue_to            : range_search_to_,
                due_from            : deliv_search_from_,
                due_to              : deliv_search_to_,
                warehouse_class     : area_code,
                    })
        }).then((response) => 
        {
            if (response['statusText'] == 'OK') 
            {
                    var datas=response.data.data;
                    var data=[];
                    for(var x = 0; x < datas[1].length; x++)
                    {  
                        var status_=datas[1][x][0];
                        var total_=datas[1][x][datas[1][x].length-1];

                        if(status_ !== 'TOTAL')
                        {
                            data.push(
                            {
                                status : status_,
                                total : total_
                            });     
                        }   
                    }

                    if (datas.length === 0) 
                    {
                        toastr.warning('No data matched in the database. Thank you', 'System Message')
                    }  
                    else 
                    {
                        am4core.useTheme(am4themes_animated);

                        var chart = am4core.create("chart_count", am4charts.XYChart);
                        chart.data = data;

                        // Create axes
                        let categoryAxis                                           = chart.xAxes.push(new am4charts.CategoryAxis());
                            categoryAxis.dataFields.category                       = "status";
                            categoryAxis.renderer.labels.template.rotation         = 270;
                            categoryAxis.renderer.labels.template.hideOversized    = false;
                            categoryAxis.renderer.minGridDistance                  = 20;
                            categoryAxis.renderer.labels.template.horizontalCenter = "right";
                            categoryAxis.renderer.labels.template.verticalCenter   = "middle";
                            categoryAxis.tooltip.label.rotation                    = 270;
                            categoryAxis.tooltip.label.horizontalCenter            = "right";
                            categoryAxis.tooltip.label.verticalCenter              = "middle";

                        let valueAxis                  = chart.yAxes.push(new am4charts.ValueAxis());
                            valueAxis.title.text       = "Total";
                            valueAxis.title.fontWeight = "bold";

                        // Create series
                        var series                              = chart.series.push(new am4charts.ColumnSeries3D());
                            series.dataFields.valueY            = "total";
                            series.dataFields.categoryX         = "status";
                            series.name                         = "Status";
                            series.tooltipText                  = "{categoryX}: [bold]{valueY}[/]";
                            series.columns.template.fillOpacity = .8;

                        var columnTemplate               = series.columns.template;
                            columnTemplate.strokeWidth   = 2;
                            columnTemplate.strokeOpacity = 1;
                            columnTemplate.stroke        = am4core.color("#FFFFFF");

                        columnTemplate.adapter.add("fill", function(fill, target) {
                        return chart.colors.getIndex(target.dataItem.index);
                        })

                        columnTemplate.adapter.add("stroke", function(stroke, target) {
                        return chart.colors.getIndex(target.dataItem.index);
                        })

                        chart.cursor = new am4charts.XYCursor();
                        chart.cursor.lineX.strokeOpacity = 0;
                        chart.cursor.lineY.strokeOpacity = 0;
                    }
            }
            else 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                setTimeout(
                    function() 
                    {
                        window.location.reload();
                    }, 2000);
            }
        }).catch((error) => 
        {
            toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 2000);
        }).finally(() => { 
       // $('.loader').hide();
        })
    };

    this_dashboard.load_issuance_payee = (range_status_,range_search_from_,range_search_to_,deliv_search_from_,deliv_search_to_) =>
    {
       // $('.loader').show();
        instance.get(`report-delivery-quantity`,
        {
            params: ({
                status              : range_status_,
                issue_from          : range_search_from_,
                issue_to            : range_search_to_,
                due_from            : deliv_search_from_,
                due_to              : deliv_search_to_,
                warehouse_class     : area_code,
                    })
        }).then((response) => 
        {
            if (response['statusText'] == 'OK') 
            {
                    var datas=response.data.data;
                    var data=[];
                    for(var x = 0; x < datas[1].length; x++)
                    {  
                        var status_=datas[1][x][0];
                        var total_=datas[1][x][datas[1][x].length-1];
                        if(status_ !== 'TOTAL')
                        {
                            data.push(
                            {
                                status : status_,
                                total : total_
                            });     
                        }      
                    }
                    if (data.length === 0) 
                    {
                        toastr.warning('No data matched in the database. Thank you', 'System Message')
                    }  
                    else 
                    {
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
                        valueAxis.renderer.grid.template.disabled = false;

                        // Create series
                        var series = chart.series.push(new am4charts.ConeSeries());
                        series.dataFields.valueY = "total";
                        series.dataFields.categoryX = "status";
                        

                        var columnTemplate = series.columns.template;
                        columnTemplate.adapter.add("fill", function(fill, target) {
                        return chart.colors.getIndex(target.dataItem.index);
                        })

                        columnTemplate.adapter.add("stroke", function(stroke, target) {
                        return chart.colors.getIndex(target.dataItem.index);
                        })
                    }
            }
            else 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                setTimeout(
                    function() 
                    {
                        window.location.reload();
                    }, 2000);
            }
        }).catch((error) => 
        {
            toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 2000);
        }).finally(() => { 
       // $('.loader').hide();
        })
    };

    this_dashboard.days_converter = (t) =>
    {
        var cd = 24 * 60 * 60 * 1000,
            ch = 60 * 60 * 1000,
            d = Math.floor(t / cd),
            h = Math.floor( (t - d * cd) / ch),
            m = Math.round( (t - d * cd - h * ch) / 60000),
            pad = function(n){ return n < 10 ? '0' + n : n; };
        if( m === 60 ){
        h++;
        m = 0;
        }
        if( h === 24 ){
        d++;
        h = 0;
        }
        return d;
    };

    
    this_dashboard.tracking_detailed = () => 
    {
        $('#mod_tracking').modal('show');
    };

    this_dashboard.track_change_type = () => 
    {
        if($('#spn_head_type').text()=='Normal')
        {
            $('#spn_head_type').text('Irregularity');
            $('#spn_head_type').css('color', '#FFB822'); 
            $("#div_track_irregularity_contents").prop('hidden',false);
            $("#div_track_normal_contents").prop('hidden',true);
        }
        else
        {
            $('#spn_head_type').text('Normal');
            $('#spn_head_type').css('color', '#05E177'); 
            $("#div_track_normal_contents").prop('hidden',false);
            $("#div_track_irregularity_contents").prop('hidden',true);
        }
        
    };

    this_dashboard.track = () =>
    {
        let ticket_no=$("#txt_ticket_no").val();
        let normal_content='';
        let irregularity_content='';
        $("#txt_ticket_no").removeClass("border-purple");
        $("#txt_ticket_no").removeClass("animate__animated animate__bounceIn");
        if(ticket_no == "" || ticket_no == null)
        {
            toastr.warning('Please enter ticket number. Thank you', 'System Message')
            $("#txt_ticket_no").addClass("important animate__animated animate__bounceIn");
            $("#txt_ticket_no").addClass("important border-purple");
            $("#txt_ticket_no").focus();
        }
        else
        {
           // $('.loader').show();
        instance.get(`search-data`, 
        {
            params: ({
                    ticket_no: ticket_no,
                    })
        }).then((response) => 
        {
            var data = response.data.data[0];
           
            if (response['statusText'] == 'OK') 
            {
                if(response.data.data.length===0)
                {
                    toastr.warning('No data matched in the database. Thank you', 'System Message')  
                    $('#div_track_default').prop('hidden', false);
                    $('#div_track_details').prop('hidden', true);
                    $('#div_track_normal_contents').css("overflow-y", "hide");
                    
                }
                else
                {
                      $('#div_track_default').prop('hidden', true);
                      $('#div_track_details').prop('hidden', false);
                      $("#spn_head").text($("#txt_ticket_no").val());
                      $("#spn_sub_head").text(data.order_download_no);
                      $("#txt_ticket_no").val('');
                    //start normal
                      if(data.delivery_normal_created_at!=null)
                      {
                        normal_content=normal_content+
                         `<a href="#" class="list-group-item list-group-item-action" style="border-left: 5px solid #FFB822">
                         <div class="d-flex w-100 justify-content-between" >
                         <h5 class="mb-1">Delivery</h5>
                         <small>${(DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.delivery_normal_created_at.replace(/-/g,'/')))) > 0 ? DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.delivery_normal_created_at.replace(/-/g,'/')))) + ' days ago' : 'Done a while ago.' )}.</small>
                         </div>
                         <p class="mb-1">${data.delivery_normal_users_id}</p>
                         <small>Person In-Charge</small>
                         </a>`;
                         $('#div_track_normal_contents').css("overflow-y", "scroll");
                      }
                      else if(data.dr_makings_normal_created_at!=null)
                      {
                        normal_content=normal_content+
                         `<a href="#" class="list-group-item list-group-item-action" style="border-left: 7px solid #0FCCA6;">
                         <div class="d-flex w-100 justify-content-between" >
                         <h5 class="mb-1">Delivery</h5>
                         <small></small>
                         </div>
                         <p class="mb-1"></p>
                         <small>No Person In-Charge at the moment.</small>
                         </a>`;
                         $('#div_track_normal_contents').css("overflow-y", "scroll");
                      }

                      if(data.dr_makings_normal_created_at!=null)
                      {
                        normal_content=normal_content+
                         `<a href="#" class="list-group-item list-group-item-action" style="border-left: 5px solid lightgray">
                         <div class="d-flex w-100 justify-content-between" >
                         <h5 class="mb-1">DR Making</h5>
                         <small>${(DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.dr_makings_normal_created_at.replace(/-/g,'/')))) > 0 ? DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.dr_makings_normal_created_at.replace(/-/g,'/')))) + ' days ago' : 'Done a while ago.' )}.</small>
                         </div>
                         <p class="mb-1">${data.dr_makings_normal_users_id}</p>
                         <small>Person In-Charge</small>
                         </a>`;
                         $('#div_track_normal_contents').css("overflow-y", "scroll");
                      }
                      else if(data.palletizing_normal_created_at!=null)
                      {
                        normal_content=normal_content+
                         `<a href="#" class="list-group-item list-group-item-action" style="border-left: 7px solid #0FCCA6;">
                         <div class="d-flex w-100 justify-content-between" >
                         <h5 class="mb-1">DR Making</h5>
                         <small></small>
                         </div>
                         <p class="mb-1"></p>
                         <small>No Person In-Charge at the moment.</small>
                         </a>`;
                         $('#div_track_normal_contents').css("overflow-y", "scroll");
                      }

                      if(data.palletizing_normal_created_at!=null)
                      {
                        normal_content=normal_content+
                         `<a href="#" class="list-group-item list-group-item-action" style="border-left: 5px solid lightgray">
                         <div class="d-flex w-100 justify-content-between" >
                         <h5 class="mb-1">Palletizing</h5>
                         <small>${(DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.palletizing_normal_created_at.replace(/-/g,'/')))) > 0 ? DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.palletizing_normal_created_at.replace(/-/g,'/')))) + ' days ago' : 'Done a while ago.' )}.</small>
                         </div>
                         <p class="mb-1">${data.palletizing_normal_users_id}</p>
                         <small>Person In-Charge</small>
                         </a>`;
                      }
                      else if(data.checking_normal_created_at!=null)
                      {
                        normal_content=normal_content+
                         `<a href="#" class="list-group-item list-group-item-action" style="border-left: 7px solid #0FCCA6;">
                         <div class="d-flex w-100 justify-content-between" >
                         <h5 class="mb-1">Palletizing</h5>
                         <small></small>
                         </div>
                         <p class="mb-1"></p>
                         <small>No Person In-Charge at the moment.</small>
                         </a>`;
                      }

                     if(data.checking_normal_created_at!=null)
                     {
                        normal_content=normal_content+
                        `<a href="#" class="list-group-item list-group-item-action" style="border-left: 5px solid lightgray">
                        <div class="d-flex w-100 justify-content-between" >
                        <h5 class="mb-1">Checking</h5>
                        <small>${(DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.checking_normal_created_at.replace(/-/g,'/')))) > 0 ? DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.checking_normal_created_at.replace(/-/g,'/')))) + ' days ago' : 'Done a while ago.' )}.</small>
                        </div>
                        <p class="mb-1">${data.checking_normal_user_id}</p>
                        <small>Person In-Charge</small>
                        </a>`;
                     }
                     else
                     {
                        normal_content=normal_content+
                        `<a href="#" class="list-group-item list-group-item-action" style="border-left: 7px solid #0FCCA6;">
                        <div class="d-flex w-100 justify-content-between" >
                        <h5 class="mb-1">Checking</h5>
                        <small></small>
                        </div>
                        <p class="mb-1"></p>
                        <small>No Person In-Charge at the moment.</small>
                        </a>`;
                     }  
                    //end normal
                     
                    //start irregularity
                    if(data.delivery_irregularity_created_at!=null)
                    {
                        irregularity_content=irregularity_content+
                       `<a href="#" class="list-group-item list-group-item-action" style="border-left: 5px solid #FFB822">
                       <div class="d-flex w-100 justify-content-between" >
                       <h5 class="mb-1">Delivery</h5>
                       <small>${(DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.delivery_irregularity_created_at.replace(/-/g,'/')))) > 0 ? DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.delivery_irregularity_created_at.replace(/-/g,'/')))) + ' days ago' : 'Done a while ago.' )}.</small>
                       </div>
                       <p class="mb-1">${data.delivery_irregularity_users_id}</p>
                       <small>Person In-Charge</small>
                       </a>`;
                       $('#div_track_irregularity_contents').css("overflow-y", "scroll");
                    }
                    else if(data.dr_makings_irregularity_created_at!=null)
                    {
                        irregularity_content=irregularity_content+
                       `<a href="#" class="list-group-item list-group-item-action" style="border-left: 7px solid #0FCCA6;">
                       <div class="d-flex w-100 justify-content-between" >
                       <h5 class="mb-1">Delivery</h5>
                       <small></small>
                       </div>
                       <p class="mb-1"></p>
                       <small>No Person In-Charge at the moment.</small>
                       </a>`;
                       $('#div_track_irregularity_contents').css("overflow-y", "scroll");
                    }

                    if(data.dr_makings_irregularity_created_at!=null)
                    {
                        irregularity_content=irregularity_content+
                       `<a href="#" class="list-group-item list-group-item-action" style="border-left: 5px solid lightgray">
                       <div class="d-flex w-100 justify-content-between" >
                       <h5 class="mb-1">DR Making</h5>
                       <small>${(DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.dr_makings_irregularity_created_at.replace(/-/g,'/')))) > 0 ? DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.dr_makings_irregularity_created_at.replace(/-/g,'/')))) + ' days ago' : 'Done a while ago.' )}.</small>
                       </div>
                       <p class="mb-1">${data.dr_makings_irregularity_users_id}</p>
                       <small>Person In-Charge</small>
                       </a>`;
                       $('#div_track_irregularity_contents').css("overflow-y", "scroll");
                    }
                    else if(data.palletizing_irregularity_created_at!=null)
                    {
                        irregularity_content=irregularity_content+
                       `<a href="#" class="list-group-item list-group-item-action" style="border-left: 7px solid #0FCCA6;">
                       <div class="d-flex w-100 justify-content-between" >
                       <h5 class="mb-1">DR Making</h5>
                       <small></small>
                       </div>
                       <p class="mb-1"></p>
                       <small>No Person In-Charge at the moment.</small>
                       </a>`;
                       $('#div_track_irregularity_contents').css("overflow-y", "scroll");
                    }

                    if(data.palletizing_irregularity_created_at!=null)
                    {
                        irregularity_content=irregularity_content+
                       `<a href="#" class="list-group-item list-group-item-action" style="border-left: 5px solid lightgray">
                       <div class="d-flex w-100 justify-content-between" >
                       <h5 class="mb-1">Palletizing</h5>
                       <small>${(DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.palletizing_irregularity_created_at.replace(/-/g,'/')))) > 0 ? DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.palletizing_irregularity_created_at.replace(/-/g,'/')))) + ' days ago' : 'Done a while ago.' )}.</small>
                       </div>
                       <p class="mb-1">${data.palletizing_irregularity_users_id}</p>
                       <small>Person In-Charge</small>
                       </a>`;
                    }
                    else if(data.checking_irregularity_created_at!=null)
                    {
                        irregularity_content=irregularity_content+
                       `<a href="#" class="list-group-item list-group-item-action" style="border-left: 7px solid #0FCCA6;">
                       <div class="d-flex w-100 justify-content-between" >
                       <h5 class="mb-1">Palletizing</h5>
                       <small></small>
                       </div>
                       <p class="mb-1"></p>
                       <small>No Person In-Charge at the moment.</small>
                       </a>`;
                    }

                   if(data.checking_irregularity_created_at!=null)
                   {
                    irregularity_content=irregularity_content+
                      `<a href="#" class="list-group-item list-group-item-action" style="border-left: 5px solid lightgray">
                      <div class="d-flex w-100 justify-content-between" >
                      <h5 class="mb-1">Checking</h5>
                      <small>${(DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.checking_irregularity_created_at.replace(/-/g,'/')))) > 0 ? DASHBOARD.days_converter(Math.abs(new Date() -new Date(data.checking_irregularity_created_at.replace(/-/g,'/')))) + ' days ago' : 'Done a while ago.' )}.</small>
                      </div>
                      <p class="mb-1">${data.checking_irregularity_user_id}</p>
                      <small>Person In-Charge</small>
                      </a>`;
                   }
                   else
                   {
                    irregularity_content=irregularity_content+
                      `<a href="#" class="list-group-item list-group-item-action" style="border-left: 7px solid #0FCCA6;">
                      <div class="d-flex w-100 justify-content-between" >
                      <h5 class="mb-1">Checking</h5>
                      <small></small>
                      </div>
                      <p class="mb-1"></p>
                      <small>No Person In-Charge at the moment.</small>
                      </a>`;
                   }             
                   //end irregularity

                   $("#div_track_normal_contents").empty().append(normal_content);
                   $("#div_track_irregularity_contents").empty().append(irregularity_content);
                   $("#div_track_normal_contents").prop('hidden',false);
                   $("#div_track_irregularity_contents").prop('hidden',true);
                }
            }
            else 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }

        }).catch((error) => 
        {
            console.log(error)
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 2000);
        }).finally(() => 
        {
          // $('.loader').hide();
        })
        }
        
        
    };

    return this_dashboard;
})();