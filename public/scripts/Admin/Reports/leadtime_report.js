$(document).ready(() => 
{
    $('#slc_leadtime_report_range').val('DAILY');
    $('#txt_leadtime_report_date_from').val(date_today);
    $('#txt_leadtime_report_date_to').val(date_today);
    $('#txt_leadtime_report_month_date_from').val(month_today);
    $('#txt_leadtime_report_month_date_to').val(month_today);
    $('#txt_leadtime_report_year_date_from').val(year_today);
    $('#txt_leadtime_report_year_date_to').val(year_today);
    LEADTIME_REPORT.load_leadtime_report();
});

const LEADTIME_REPORT = (() => 
{
    let this_leadtime_report = {};
    let date_from = '';
    let date_to = '';

    this_leadtime_report.onchange_datepicker = () =>
    {
        if ($('#slc_leadtime_report_range').val() === 'YEARLY')
        {
            $('#txt_leadtime_report_date_from').prop('hidden', true);
            $('#txt_leadtime_report_date_to').prop('hidden', true);
            $('#txt_leadtime_report_month_date_from').prop('hidden', true);
            $('#txt_leadtime_report_month_date_to').prop('hidden', true);
            $('#txt_leadtime_report_year_date_from').prop('hidden', false);
            $('#txt_leadtime_report_year_date_to').prop('hidden', false);
        }
        else if ($('#slc_leadtime_report_range').val() === 'MONTHLY')
        {
            $('#txt_leadtime_report_date_from').prop('hidden', true);
            $('#txt_leadtime_report_date_to').prop('hidden', true);
            $('#txt_leadtime_report_month_date_from').prop('hidden', false);
            $('#txt_leadtime_report_month_date_to').prop('hidden', false);
            $('#txt_leadtime_report_year_date_from').prop('hidden', true);
            $('#txt_leadtime_report_year_date_to').prop('hidden', true);
        }
        else
        {
            $('#txt_leadtime_report_date_from').prop('hidden', false);
            $('#txt_leadtime_report_date_to').prop('hidden', false);
            $('#txt_leadtime_report_month_date_from').prop('hidden', true);
            $('#txt_leadtime_report_month_date_to').prop('hidden', true);
            $('#txt_leadtime_report_year_date_from').prop('hidden', true);
            $('#txt_leadtime_report_year_date_to').prop('hidden', true);
        }
    };

    this_leadtime_report.load_leadtime_report = () =>
    {
        if ($('#slc_leadtime_report_range').val() === 'YEARLY')
        {
            var year_first_date = new Date($('#txt_leadtime_report_year_date_from').val(), 0, 1); 
            var year_last_date = new Date($('#txt_leadtime_report_year_date_to').val(), 11, 31); 

            date_from = year_first_date.getFullYear() + '-' + ((year_first_date.getMonth() > 8) ? (year_first_date.getMonth() + 1) : ('0' + (year_first_date.getMonth() + 1))) + '-' + ((year_first_date.getDate() > 9) ? year_first_date.getDate() : ('0' + year_first_date.getDate()));
            date_to = year_last_date.getFullYear() + '-' + ((year_last_date.getMonth() > 8) ? (year_last_date.getMonth() + 1) : ('0' + (year_last_date.getMonth() + 1))) + '-' + ((year_last_date.getDate() > 9) ? year_last_date.getDate() : ('0' + year_last_date.getDate()));
        }
        else if ($('#slc_leadtime_report_range').val() === 'MONTHLY')
        {
            var from = new Date($('#txt_leadtime_report_month_date_from').val()); 
            var to = new Date($('#txt_leadtime_report_month_date_to').val()); 
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 
            
            date_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));
            date_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
        }
        else
        {
            date_from = $('#txt_leadtime_report_date_from').val();
            date_to = $('#txt_leadtime_report_date_to').val();
        }

        if ($('#slc_leadtime_report_range').val() === '' || date_from === '' || date_to === '' || date_from === 'NaN-0NaN-0NaN' || date_to === 'NaN-0NaN-0NaN') //empty date
        {
            toastr.error('Please complete the inputs', 'System Message');
        }    
        else if (date_from > date_to)
        {
            toastr.error('Invalid date range', 'System Message');
        }
        else
        {
           // $('.loader').show();
            instance.get(`leadtime-report`,
            {
                params: ({
                            date_range      : $('#slc_leadtime_report_range').val(),
                            ticket_from     : date_from,
                            ticket_to       : date_to,
                            area_code       : area_code
                        })
            })
            .then((response) => 
            {
                console.log(response.data.data);
                if (response['statusText'] == 'OK') 
                {
                    var data = response.data.data;

                    if (data.length === 0) 
                    {
                        toastr.warning('No data matched in the database. Thank you', 'System Message');
                    }
                    else 
                    {
                        var tr_head = '<tr>';
                        var column = data[0].length - 6; // length of dynamic data
                        for (var i = 0; i < 6; i++) // plot fixed columns of table
                        {
                            tr_head += `<th style="text-align:center;horizontal-align:middle;vertical-align:middle;" rowspan="2">${data[0][i]}</th>`;
                        }
                        tr_head += `<th style="text-align:center;horizontal-align:middle;vertical-align:middle;" rowspan="1" colspan='${column}'>Delivery Data</th>`;
                        tr_head += '</tr>';
                        tr_head += '<tr>';
                        for (var x = 6; x < data[0].length; x++) // plot dynamic columns of table
                        {
                            tr_head += `<th style="text-align:center;horizontal-align:middle;vertical-align:middle;">${data[0][x]}</th>`;
                        }
                        tr_head += '</tr>';


                        var tr_body;
                     
                        for (var s = 0; s < data[1].length; s++)
                        {
                            var counter = 0;
                            tr_body += `<tr>`;
                            for (var d = 0; d < data[0].length; d++)
                            {
                                if(d <= 5)
                                    tr_body += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${data[1][s][d]}</td>`;
                                else
                                {
                                    tr_body += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${data[1][s][6][counter]}</td>`;
                                    counter++;
                                }
                            }
                            tr_body += `</tr>`;
                        }
                        $('#table_leadtime_report_data thead').html(tr_head);
                        $('#table_leadtime_report_data tbody').html(tr_body);
                        $('#table_leadtime_report_data').DataTable().destroy();
                        $('#table_leadtime_report_data thead').html(tr_head);
                        $('#table_leadtime_report_data tbody').html(tr_body);
                        $('#table_leadtime_report_data').DataTable(
                        {
                            "scrollX" : true,
                            "scrollY" : "500px",
                            "paging": false,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": false,
                            "info": true,
                            "autoWidth": true,
                        });
                    }
                }
                else 
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message');
                }
                  
            })
            .catch((error) => 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message');
            })
            .finally(() => { 
               // $('.loader').hide();
            })
        }
    };

    return this_leadtime_report;
})();