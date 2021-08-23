$(document).ready(() => 
{
    $('#txt_parts_status_date_from').val(date_today);
    $('#txt_parts_status_date_to').val(date_today);
    $('#txt_parts_status_month_date_from').val(month_today);
    $('#txt_parts_status_month_date_to').val(month_today);
    $('#slc_parts_status_range').val('DAILY');
    // PARTS_STATUS.load_parts_status_list();
});

const PARTS_STATUS = (() => 
{
    let this_parts_status = {};
    let search_from = '';
    let search_to = '';

    this_parts_status.onchange_datepicker = () =>
    {
        if ($('#slc_parts_status_range').val() === 'MONTHLY')
        {
            $('#txt_parts_status_date_from').prop('hidden', true);
            $('#txt_parts_status_date_to').prop('hidden', true);
            $('#txt_parts_status_month_date_from').prop('hidden', false);
            $('#txt_parts_status_month_date_to').prop('hidden', false);
        }
        else
        {
            $('#txt_parts_status_date_from').prop('hidden', false);
            $('#txt_parts_status_date_to').prop('hidden', false);
            $('#txt_parts_status_month_date_from').prop('hidden', true);
            $('#txt_parts_status_month_date_to').prop('hidden', true);
        }
    };

    this_parts_status.load_parts_status_list = () => 
    {
        if ($('#slc_parts_status_range').val() === 'MONTHLY')
        {
            var from = new Date($('#txt_parts_status_month_date_from').val()); 
            var to = new Date($('#txt_parts_status_month_date_to').val()); 
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 
            
            search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                            ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

            search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                            ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
        }
        else
        {
            search_from = $('#txt_parts_status_date_from').val();
            search_to = $('#txt_parts_status_date_to').val();
        }

        if (search_from === '' || search_to === ''|| search_from === 'NaN-0NaN-0NaN' || search_to === 'NaN-0NaN-0NaN')
        {
            toastr.error('Please complete the inputs', 'System Message')
        }
        else if (search_from > search_to)
        {
            toastr.error('Invalid date range', 'System Message')
        }
        else
        {         
           // $('.loader').show();
            instance.get(`parts-status`, 
            {
                params: ({
                            txt_parts_status_date_from        : search_from,
                            txt_parts_status_date_to          : search_to,
                            area_code                         : area_code
                        })
            }).then((response) => 
            {
                var data = response.data.data;;
                if (response['statusText'] == 'OK') 
                {   
                    if(data.length===0)
                    {
                        $('#thead_parts_status').DataTable().destroy();
                        $('#tbody_parts_status').empty();
                        toastr.warning('No data matched in the database. Thank you', 'System Message')  
                    }
                    else
                    {
                        $('#thead_parts_status').DataTable().destroy();
                        $('#tbody_parts_status').empty();

                        var tr = '';
                        $.each(data, function () 
                        {    
                            tr += `<tr>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.warehouse_class}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.item_no}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_qty}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.stock_address}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.manufacturing_no}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.destination_code}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.payee_name}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_due_date}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_no}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.order_download_no}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_issue_date}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.normal_status}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.normal_dr}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.normal_delivered}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.irreg_status}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.irreg_dr}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.irreg_delivered}</td>
                                </tr>`;
                        });

                        $('#tbody_parts_status').html(tr);
                        $('#thead_parts_status').DataTable({
                            "scrollX": true,
                            "scrollY": true,
                            "paging": false,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": false,
                            "info": true,
                            "autoWidth": true,
                            'scrollY':        '80vh',
                            'scrollCollapse': true,
                            dom: 'Blfrtip',
                            buttons: [
                                {
                                    extend: 'csv',
                                    text: 'EXPORT CSV FILE'
                                }
                            ],
                            "fnDrawCallback": function() {
                                $('#tbody_parts_status td').each(function (){
                                    if($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined'){
                                        $(this).text('');				
                                    }
                                  }); 
                              }
                        });
                    }
                }
                else 
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                }
            }).catch((error) => 
            {
                console.log(error)
            }).finally(() => 
            {
                // $('.loader').hide();
            })
        }
    };

    return this_parts_status;
})();
