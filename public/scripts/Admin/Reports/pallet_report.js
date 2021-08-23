$(document).ready(() => 
{
    $('#slc_pallet_report_range').val('DAILY');
    $('#txt_pallet_report_date_from').val(date_today);
    $('#txt_pallet_report_date_to').val(date_today);
    $('#txt_pallet_report_month_date_from').val(month_today);
    $('#txt_pallet_report_month_date_to').val(month_today);
    PALLET_REPORT.load_pallet_report();
});

const PALLET_REPORT = (() => 
{
    let this_pallet_report = {};
    let date_from = '';
    let date_to = '';

    this_pallet_report.onchange_datepicker = () =>
    {
        if ($('#slc_pallet_report_range').val() === 'MONTHLY')
        {
            $('#txt_pallet_report_date_from').prop('hidden', true);
            $('#txt_pallet_report_date_to').prop('hidden', true);
            $('#txt_pallet_report_month_date_from').prop('hidden', false);
            $('#txt_pallet_report_month_date_to').prop('hidden', false);
        }
        else
        {
            $('#txt_pallet_report_date_from').prop('hidden', false);
            $('#txt_pallet_report_date_to').prop('hidden', false);
            $('#txt_pallet_report_month_date_from').prop('hidden', true);
            $('#txt_pallet_report_month_date_to').prop('hidden', true);
        }
    };

    this_pallet_report.load_pallet_report = () =>
    {
        if ($('#slc_pallet_report_range').val() === 'MONTHLY')
        {
            var from = new Date($('#txt_pallet_report_month_date_from').val()); 
            var to = new Date($('#txt_pallet_report_month_date_to').val()); 
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 
            
            date_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                            ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

            date_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                            ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
        }
        else
        {
            date_from = $('#txt_pallet_report_date_from').val();
            date_to = $('#txt_pallet_report_date_to').val();
        }

        if ($('#slc_pallet_report_range').val() === '' || date_from === '' || date_to === '' || date_from === 'NaN-0NaN-0NaN' || date_to === 'NaN-0NaN-0NaN') //empty date
            toastr.error('Please complete the inputs', 'System Message')
        else if (date_from > date_to)
            toastr.error('Invalid date range', 'System Message')
        else
        {
           // $('.loader').show();
            instance.get(`load-pallet-report`,
            {
                params: ({
                            date_range      : $('#slc_pallet_report_range').val(),
                            date_from       : date_from,
                            date_to         : date_to,
                            area_code       : area_code
                        })
            }).then((response) => 
            {
                if (response['statusText'] == 'OK') 
                {
                    var data = response.data.data;

                    if (data.length === 0) 
                        toastr.warning('No data matched in the database. Thank you', 'System Message')
                    else 
                    {
                        //Table Header
                        var tr_head = '<tr>';
                        for (var i = 0; i < data[0].length; i++)
                            tr_head += `<th style="text-align:center;horizontal-align:middle;vertical-align:middle;">${data[0][i]}</th>`;
                        tr_head += '</tr>';

                        //Table Body
                        var tr_body = '<tr>';
                        for (var s = 0; s < data[1].length; s++)
                        {
                            for (var d = 0; d < data[0].length; d++)
                                tr_body += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${data[1][s][d]}</td>`;
                            tr_body += `</tr>`;
                        }
                    
                        $('#table_pallet_report_data thead').html(tr_head);
                        $('#table_pallet_report_data tbody').html(tr_body);
                        $('#table_pallet_report_data').DataTable().destroy();
                        $('#table_pallet_report_data thead').html(tr_head);
                        $('#table_pallet_report_data tbody').html(tr_body);
                        $('#table_pallet_report_data').DataTable({
                            rowsGroup: [0],
                            "scrollX" : true,
                            "scrollY" : "500px",
                            "paging": false,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": false,
                            "info": true,
                            "autoWidth": true,
                            "fnDrawCallback": function() {
                                $('#tbody_pallet_report_data td').each(function (){
                                    if($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined')
                                        $(this).text('');				
                                }); 
                            }
                        });
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

    return this_pallet_report;
})();