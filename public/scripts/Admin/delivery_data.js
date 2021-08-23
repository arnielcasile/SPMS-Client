$(document).ready(() => 
{
    $('#slc_delivery_data_range').val('DAILY');
    $('#txt_delivery_data_date_from').val(date_today);
    $('#txt_delivery_data_date_to').val(date_today);
    $('#txt_delivery_data_month_date_from').val(month_today);
    $('#txt_delivery_data_month_date_to').val(month_today);
    $('#slc_inhouse_delivery_data_range').val('DAILY');
    $('#txt_inhouse_delivery_data_date_from').val(date_today);
    $('#txt_inhouse_delivery_data_date_to').val(date_today);
    $('#txt_inhouse_delivery_data_month_date_from').val(month_today);
    $('#txt_inhouse_delivery_data_month_date_to').val(month_today);

    DELIVERY_DATA.load_delivery_data_list();
    DELIVERY_DATA.load_inhouse_delivery_data_list();
});

const DELIVERY_DATA = (() => 
{
    let this_delivery_data = {};
    let search_from = '';
    let search_to = '';

    this_delivery_data.onchange_datepicker = () =>
    {
        if ($('#slc_delivery_data_range').val() === 'MONTHLY')
        {
            $('#txt_delivery_data_date_from').prop('hidden', true);
            $('#txt_delivery_data_date_to').prop('hidden', true);
            $('#txt_delivery_data_month_date_from').prop('hidden', false);
            $('#txt_delivery_data_month_date_to').prop('hidden', false);
        }
        else
        {
            $('#txt_delivery_data_date_from').prop('hidden', false);
            $('#txt_delivery_data_date_to').prop('hidden', false);
            $('#txt_delivery_data_month_date_from').prop('hidden', true);
            $('#txt_delivery_data_month_date_to').prop('hidden', true);
        }

        if ($('#slc_inhouse_delivery_data_range').val() === 'MONTHLY')
        {
            $('#txt_inhouse_delivery_data_date_from').prop('hidden', true);
            $('#txt_inhouse_delivery_data_date_to').prop('hidden', true);
            $('#txt_inhouse_delivery_data_month_date_from').prop('hidden', false);
            $('#txt_inhouse_delivery_data_month_date_to').prop('hidden', false);
        }
        else
        {
            $('#txt_inhouse_delivery_data_date_from').prop('hidden', false);
            $('#txt_inhouse_delivery_data_date_to').prop('hidden', false);
            $('#txt_inhouse_delivery_data_month_date_from').prop('hidden', true);
            $('#txt_inhouse_delivery_data_month_date_to').prop('hidden', true);
        }
    };

    this_delivery_data.load_delivery_data_list = () => 
    {
        if ($('#slc_delivery_data_range').val() === 'MONTHLY')
        {
            var from = new Date($('#txt_delivery_data_month_date_from').val()); 
            var to = new Date($('#txt_delivery_data_month_date_to').val()); 
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 
            
            search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                            ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

            search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                            ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
        }
        else
        {
            search_from = $('#txt_delivery_data_date_from').val();
            search_to = $('#txt_delivery_data_date_to').val();
        }

        if ($('#slc_delivery_data_range').val() === '' || search_from === '' || search_to === '' || search_from === 'NaN-0NaN-0NaN' || search_to === 'NaN-0NaN-0NaN')
            toastr.error('Please complete the inputs', 'System Message')
        else if (search_from > search_to)
            toastr.error('Invalid date range', 'System Message')
        else
        {      
           // $('.loader').show();
            instance.get(`load-delivery-data`, 
            {
                params: ({
                            date_from        : search_from,
                            date_to          : search_to,
                            area_code        : area_code
                        })
            }).then((response) => 
            {
                var data = response.data.data;
                if (response['statusText'] == 'OK') 
                {
                    $('#thead_delivery_data').DataTable().destroy();
                    $('#tbody_delivery_data').empty();

                    if(data.length === 0)
                    {
                        $('#thead_delivery_data').DataTable().destroy();
                        $('#tbody_delivery_data').empty();
                        toastr.warning('No data matched in the database. Thank you', 'System Message')  ;
                    }
                    else
                    {
                        var tr = '';
                        $('#thead_delivery_data').DataTable().destroy();
                        $('#tbody_delivery_data').empty();
                        $.each(data, function () 
                        {    
                            tr += `<tr>
                                        <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.dr_control}</td>
                                        <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_count}</td>
                                        <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.pallet}</td> 
                                        <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.pcase}</td>
                                        <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.box}</td> 
                                        <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.bag}</td>
                                        <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.created_at}</td>
                                        <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.status}</td> 
                                        <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.destination}</td>
                                    </tr>`;
                        });
                    
        
                        $('#tbody_delivery_data').html(tr);
                        $('#thead_delivery_data').DataTable({
                            "scrollX": true,
                            "scrollY": true,
                            "paging": false,
                            "lengthChange": true,
                            "scrollY":        '50vh',
                            "scrollCollapse": true,
                            "searching": true,
                            "ordering": false,
                            "info": true,
                            "autoWidth": false,
                            "fnDrawCallback": function() {
                                $('#tbody_delivery_data td').each(function (){
                                    if($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined'){
                                        $(this).text('');				
                                    }
                                  }); 
                              },
                            dom: 'Blfrtip',
                            buttons: [ 
                                {
                                    extend: 'csv', 
                                    text: 'EXPORT CSV FILE'
                                }
                            ]
                        });
                    }
                }
                else 
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();
                }
            }).catch((error) => 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                console.log(error)
                document.getElementById('notification').play();
            }).finally(() => 
            {
              // $('.loader').hide();
            })
        };
    };
    // end ng delivery data

   
    

    this_delivery_data.load_inhouse_delivery_data_list = () => 
    {
        // alert(search_to)
        var range = $('#slc_inhouse_delivery_data_range').val();

        if (range === 'MONTHLY')
        {
            var from = new Date($('#txt_inhouse_delivery_data_month_date_from').val()); 
            var to = new Date($('#txt_inhouse_delivery_data_month_date_to').val()); 
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 
            
            search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                            ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

            search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
            ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
        }
        else
        {   
            search_from = $('#txt_inhouse_delivery_data_date_from').val();
            search_to =  $('#txt_inhouse_delivery_data_date_to').val();
        }
        if ($('#slc_inhouse_delivery_data_range').val() === '' || search_from === '' || search_to === '' || search_from === 'NaN-0NaN-0NaN' || search_to === 'NaN-0NaN-0NaN')
        toastr.error('Please complete the inputs', 'System Message')
        else if (search_from > search_to)
            toastr.error('Invalid date range', 'System Message')
        else
        {
           // $('.loader').show();
            instance.get(`load-inhouse`, 
            {
                params: ({
                            date_from        : search_from,
                            date_to          : search_to,
                            area_code        : area_code
                        })
            }).then((response) => 
            {
                var data = response.data.data;

                if (response['statusText'] == 'OK') 
                {
                    if(data.length == 0)
                    {
                        $('#thead_inhouse_delivery_data').DataTable().destroy();
                        $('#tbody_inhouse_delivery_data').empty();
                        toastr.warning('No data matched in the database. Thank you', 'System Message')  
                        document.getElementById('notification').play();
                    }
                    else
                    {
                        $('#thead_inhouse_delivery_data').DataTable().destroy();
                        $('#tbody_inhouse_delivery_data').empty();
        
                        var tr = '';
                        var counter = 0;
                        $.each(data, function () 
                        {   
                            counter ++;
                            tr += `<tr>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${counter}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_issue_date}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.dr_control}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.product_no}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_qty}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.manufacturing_no}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.breakdown}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.created_at}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.recipient}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.updated_at}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.remarks}</td> 
    
                         </tr>`;
                         });
    
                $('#tbody_inhouse_delivery_data').html(tr);
                $('#thead_inhouse_delivery_data').DataTable({
                    "scrollX": true,
                    "scrollY": true,
                    "paging": false,
                    "lengthChange": true,
                    "scrollY":        '50vh',
                    "scrollCollapse": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": false,
                    "fnDrawCallback": function() {
                        $('#tbody_inhouse_delivery_data td').each(function (){
                            if($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined'){
                                $(this).text('');				
                            }
                          }); 
                      },
                      dom: 'Blfrtip',
                                buttons: [
                                    {
                                        extend: 'csv',
                                        text: 'EXPORT CSV FILE'
                                    }
                                ]
                });
            
                    } 
                }
                else 
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();
                }

            }).catch((error) => 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                console.log(error)
                document.getElementById('notification').play();
            }).finally(() => 
            {
              // $('.loader').hide();
            })
    }
    }; 
     // end ng inhouse delivery data

    return this_delivery_data;
})();
