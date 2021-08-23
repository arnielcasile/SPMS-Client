$(document).ready(() => 
{
    $('#slc_overall_report_range').val('DAILY');
    $('#txt_overall_report_date_from').val(date_today);
    $('#txt_overall_report_date_to').val(date_today);
    $('#txt_overall_report_month_date_from').val(month_today);
    $('#txt_overall_report_month_date_to').val(month_today);
    $('#txt_overall_report_year_date_from').val(year_today);
    $('#txt_overall_report_year_date_to').val(year_today);
    OVERALL_GRAPH_REPORT.load_overall_graph_report();
});

const OVERALL_GRAPH_REPORT = (() => 
{
    let this_overall_graph_report = {};
    let date_from = '';
    let date_to = '';

    this_overall_graph_report.onchange_datepicker = () =>
    {
        if ($('#slc_overall_report_range').val() === 'YEARLY')
        {
            $('#txt_overall_report_date_from').prop('hidden', true);
            $('#txt_overall_report_date_to').prop('hidden', true);
            $('#txt_overall_report_month_date_from').prop('hidden', true);
            $('#txt_overall_report_month_date_to').prop('hidden', true);
            $('#txt_overall_report_year_date_from').prop('hidden', false);
            $('#txt_overall_report_year_date_to').prop('hidden', false);
        }
        else if ($('#slc_overall_report_range').val() === 'MONTHLY' || $('#slc_overall_report_range').val() === 'WEEKLY' 
                || $('#slc_overall_report_range').val() === 'WEEKLY HORENSO')
        {
            $('#txt_overall_report_date_from').prop('hidden', true);
            $('#txt_overall_report_date_to').prop('hidden', true);
            $('#txt_overall_report_month_date_from').prop('hidden', false);
            $('#txt_overall_report_month_date_to').prop('hidden', false);
            $('#txt_overall_report_year_date_from').prop('hidden', true);
            $('#txt_overall_report_year_date_to').prop('hidden', true);
        }
        else
        {
            $('#txt_overall_report_date_from').prop('hidden', false);
            $('#txt_overall_report_date_to').prop('hidden', false);
            $('#txt_overall_report_month_date_from').prop('hidden', true);
            $('#txt_overall_report_month_date_to').prop('hidden', true);
            $('#txt_overall_report_year_date_from').prop('hidden', true);
            $('#txt_overall_report_year_date_to').prop('hidden', true);
        }
    };

    this_overall_graph_report.load_overall_graph_report = () =>
    {
        if ($('#slc_overall_report_range').val() === 'YEARLY')
        {
            var first_date = new Date($('#txt_overall_report_year_date_from').val(), 0, 1); 
            var last_date = new Date($('#txt_overall_report_year_date_to').val(), 11, 31); 

            date_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
            ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));
            date_to =last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
            ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
                          
        }
        else if ($('#slc_overall_report_range').val() === 'MONTHLY' || $('#slc_overall_report_range').val() === 'WEEKLY' 
                    || $('#slc_overall_report_range').val() === 'WEEKLY HORENSO')
        {
            var from = new Date($('#txt_overall_report_month_date_from').val()); 
            var to = new Date($('#txt_overall_report_month_date_to').val()); 
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 
            
            date_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                            ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

            date_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                            ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
        }
        else
        {
            date_from = $('#txt_overall_report_date_from').val();
            date_to = $('#txt_overall_report_date_to').val();
        }

        if ($('#slc_overall_report_range').val() === '' || date_from === '' || date_to === '' || date_from === 'NaN-0NaN-0NaN' || date_to === 'NaN-0NaN-0NaN') //empty date
            toastr.error('Please complete the inputs', 'System Message')
        else if (date_from > date_to)
            toastr.error('Invalid date range', 'System Message')
        else
        {
           // $('.loader').show();
            instance.get(`overall-graph-report`,
            {
                params: ({
                            date_range      : $('#slc_overall_report_range').val(),
                            ticket_from       : date_from,
                            ticket_to         : date_to,
                            area_code       : area_code
                        })
            }).then((response) => 
            {
                if (response['statusText'] == 'OK') 
                {
                    console.log(response.data.data);
                    var data = response.data.data;

                    if (data.length === 0) 
                        toastr.warning('No data matched in the database. Thank you', 'System Message')
                    else 
                    {
                        OVERALL_GRAPH_REPORT.load_overall_chart(data);
                        OVERALL_GRAPH_REPORT.load_overall_table(data);
                    }
                }
                else 
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }).catch((error) => 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }).finally(() => { 
               // $('.loader').hide();
            })
        }
    };

    this_overall_graph_report.load_overall_chart = (datas) =>
    {

        var data = [];
            var counter = 0;
            var counter_data = 0;
            datas[0].forEach(function(entry) {
     
                data.push({
                            month       :entry,
                            issued      :datas[1][0][counter],
                            delivered   :datas[1][1][counter],
                            leadtime    :datas[1][3][counter],
                            trend       :datas[1][4][counter]
                        });

                counter+=1;
            });
           
            // console.log(data);
            // Apply chart themes
            am4core.useTheme(am4themes_animated);
            am4core.useTheme(am4themes_kelly);

            // Create chart instance
            var chart = am4core.create("chart_overall_graph", am4charts.XYChart);
            chart.data = data;

            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "month";
            categoryAxis.title.paddingTop = 40;
            categoryAxis.title.text = "DATE/ WEEK NUMBER";
            categoryAxis.title.paddingBottom = 15;
            categoryAxis.renderer.minGridDistance = 30;
            categoryAxis.renderer.labels.template.horizontalCenter = "right";
            categoryAxis.renderer.labels.template.verticalCenter = "middle";
            categoryAxis.renderer.labels.template.rotation = 270;
            categoryAxis.tooltip.disabled = true;
            categoryAxis.renderer.minHeight = 110;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            // valueAxis.title.text = "Issued Tickets";

            var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
            // valueAxis2.title.text = "LeadTime";
            valueAxis2.renderer.opposite = true;

            var series                      = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY    = "issued";
                series.dataFields.categoryX = "month";
                series.name                 = "Issued Tickets";

                // var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                // labelBullet.label.text = "{valueY}";
                // labelBullet.locationY = 0.5;
                // labelBullet.label.fill = am4core.color("#fff");
             
                // series.tooltip.label.textAlign    = "middle";
                // series.tooltip.pointerOrientation = "down";
                // series.tooltip.dy                 = -5;

                // series.columns.template.tooltipText   = "[bold]{valueY}[/]";
                // series.columns.template.showTooltipOn = "always";
                // series.columns.template.tooltipY      = 0;

                

            var series3                      = chart.series.push(new am4charts.ColumnSeries());
                series3.dataFields.valueY    = "delivered";
                series3.dataFields.categoryX = "month";
                series3.name                 = "Delivered";
               
                // series3.tooltip.label.textAlign    = "middle";
                // series3.tooltip.pointerOrientation = "down";
                // series3.tooltip.dy                 = -5;

                // series3.columns.template.tooltipText   = "[bold]{valueY}[/]";
                // series3.columns.template.showTooltipOn = "always";
                // series3.columns.template.tooltipY      = 0;



            var series2                      = chart.series.push(new am4charts.LineSeries());
                series2.dataFields.valueY    = "leadtime";
                series2.dataFields.categoryX = "month";
                series2.name                 = "Lead Time";
                series2.tooltipText          = "{name}: [bold]{valueY}[/]";
                series2.strokeWidth          = 3;
                series2.yAxis                = valueAxis2;

                
            // var bullet_2 = series2.bullets.push(new am4charts.CircleBullet());
            // bullet_2.circle.stroke = am4core.color("#fff");
            // bullet_2.circle.strokeWidth = 2;
            // bullet_2.tooltipText = "{valueY}[/]";

            // // Tooltip
            // series2.tooltip.label.textAlign = "left";
            // series2.tooltip.pointerOrientation = "down";
            // series.tooltip.dy = -5;
            // series2
            // bullet_2.showTooltipOn = "always";


            var lineSeries                      = chart.series.push(new am4charts.LineSeries());
                lineSeries.name                 = "Trend";
                lineSeries.dataFields.valueY    = "trend";
                lineSeries.dataFields.categoryX = "month";

            lineSeries.stroke      = am4core.color("#001787");
            lineSeries.strokeWidth = 3;

            lineSeries.propertyFields.strokeDasharray = "lineDash";
            lineSeries.tooltip.label.textAlign        = "middle";
            lineSeries.tooltipText                    = "{name}: [bold]{valueY}[/]";
            lineSeries.yAxis                          = valueAxis2;
            

            
            var bullet      = lineSeries.bullets.push(new am4charts.Bullet());
                bullet.fill = am4core.color("#001787");                         // tooltips grab fill from parent by default

                

            var circle             = bullet.createChild(am4core.Circle);
                circle.radius      = 4;
                circle.fill        = am4core.color("#fff");
                circle.strokeWidth = 3;

            // Add legend
            chart.legend = new am4charts.Legend();

            // Add cursor
            
           // chart.cursor = new am4charts.XYCursor();
            // Enable export 
            chart.exporting.menu = new am4core.ExportMenu(); 
    };

    this_overall_graph_report.load_overall_table = (datas) =>
    {
        // console.log(datas);
        var tr_head = '<tr>';
       var header_data= datas[0];
       var body_data= datas[1];
       tr_head += `<th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Issuance Date</th>`;
        header_data.forEach(function(entry) {
            tr_head += `<th style="text-align:center;horizontal-align:middle;vertical-align:middle; background-color:#63686d">${entry}</th>`;
        });
        tr_head += '</tr>';
        var td_label=['Total','Finish','Balance','Lead Time','Max day'];
        var count=0;
        var tr_body='';
        body_data.forEach(function(entry) {
            tr_body += '<tr>';
            tr_body += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle; color:white; background-color:#343a40">${td_label[count]}</td>`;
            entry.forEach(function(sub_entry) {
                tr_body += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${sub_entry}</td>`;
            });
            count+=1;
            tr_body += `</tr>`;
        });
    
        $('#table_overall_report_data thead').html(tr_head);
        $('#table_overall_report_data tbody').html(tr_body);
        $('#table_overall_report_data').DataTable().destroy();
        $('#table_overall_report_data thead').html(tr_head);
        $('#table_overall_report_data tbody').html(tr_body);
        $('#table_overall_report_data').DataTable({
            "scrollX" : true,
            "scrollY" : "200px",
            "paging": false,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true,
            "fnDrawCallback": function() {
                $('#tbody_overall_report_data td').each(function (){
                    if($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined')
                        $(this).text('');				
                }); 
            }
        });
    };

    return this_overall_graph_report;
})();