$(document).ready(() => 
{
    $('#txt_leadtime_date_from').val(date_today);
    $('#txt_leadtime_date_to').val(date_today);
    $('#slc_leadtime_range').val('DAILY');
    LEADTIME_DATA.load_leadtime_data_list($('#txt_leadtime_date_from').val(), $('#txt_leadtime_date_to').val());
    LEADTIME_DATA.guest_load_area_code();
});

const LEADTIME_DATA = (() => 
{
    $('#txt_leadtime_date_from').val(date_today);
    $('#txt_leadtime_date_to').val(date_today);
    $('#txt_leadtime_month_date_from').val(month_today);
    $('#txt_leadtime_month_date_to').val(month_today);

    let this_leadtime_data = {};
    let search_from = '';
    let search_to = '';
 
    this_leadtime_data.change_date_to = () => 
    {
        LEADTIME_DATA.dates();
        let date_from = new Date(search_from);
        let date_to = new Date(search_to);
        var _two_months_after = new Date(date_from);
        _two_months_after.setMonth(_two_months_after.getMonth() + 1);
        if(date_to > _two_months_after)
        {
            toastr.warning('Only maximum of one month search is allowed.', 'System Message');
            $('#txt_leadtime_month_date_to').val('');
            $('#txt_leadtime_date_to').val('');
        }

    };
    this_leadtime_data.guest_load_area_code = () => 
    {
        instance.get(`area-code-all`).then(function (response) 
        {
             var area_code_guest = `<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
             <a  href="#" onclick=LEADTIME_DATA.change_area_code("ALL"); class="m-menu__link m-menu__toggle">
                 <i class="m-menu__link-icon flaticon-map"></i>
                 <span class="m-menu__link-text" style="font-family:custom-font-body">
                     ALL
                 </span>
             </a></li>`;
            $.each(response['data'].data, function () 
            {    
                if(this.area_code != 'RECEIVER')
                {                 
                    area_code_guest+= `<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                    <a  href="#" onclick=LEADTIME_DATA.change_area_code("${this.area_code}"); class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-map"></i>
                        <span class="m-menu__link-text" style="font-family:custom-font-body">
                            ${this.area_code}
                        </span>
                    </a></li>`;
                }             
            });
            $("#guest-code-li").empty().append(area_code_guest);
        }).catch(function (error) 
        {
            console.log(error)
        }).finally(() => {})
    };

    this_leadtime_data.change_area_code = (code) => 
    {
        $('#txt_area_code').val(code);
    };

    this_leadtime_data.onchange_datepicker = () =>
    {
        if ($('#slc_leadtime_range').val() === 'MONTHLY')
        {
            $('#txt_leadtime_date_from').prop('hidden', true);
            $('#txt_leadtime_date_to').prop('hidden', true);
            $('#txt_leadtime_month_date_from').prop('hidden', false);
            $('#txt_leadtime_month_date_to').prop('hidden', false);
        }
        else
        {
            $('#txt_leadtime_date_from').prop('hidden', false);
            $('#txt_leadtime_date_to').prop('hidden', false);
            $('#txt_leadtime_month_date_from').prop('hidden', true);
            $('#txt_leadtime_month_date_to').prop('hidden', true);
        }
    };

    this_leadtime_data.dates= () => 
    {
        var range = $('#slc_leadtime_range').val();

        if (range === 'MONTHLY')
        {
            var from = new Date($('#txt_leadtime_month_date_from').val()); 
            var to = new Date($('#txt_leadtime_month_date_to').val()); 
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 
            
            search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                            ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

                            search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                            ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
        }
        else
        {   
            search_from = $('#txt_leadtime_date_from').val().split("-").join("-");
            search_to =  $('#txt_leadtime_date_to').val().split("-").join("-");
        }
    };

    this_leadtime_data.search_btn = () => 
    {
        LEADTIME_DATA.dates();
        LEADTIME_DATA.load_leadtime_data_list(search_from, search_to);         
    };

    this_leadtime_data.load_leadtime_data_list = (search_from, search_to) => 
    {
        if (search_from === '' || search_to === '' || search_from === 'NaN-0NaN-0NaN' || search_to === 'NaN-0NaN-0NaN')
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
            instance.get(`leadtime-data`, 
            {
                params: ({
                            ticket_from        : search_from,
                            ticket_to          : search_to,
                            area_code          : area_code
                        })
            }).then((response) => 
            {
                var data = response.data;
                if (response['statusText'] == 'OK') 
                {
                    if(data.length===0)
                    {
                        $('#thead_leadtime_data').DataTable().destroy();
                        $('#tbody_leadtime_data').empty();
                        toastr.warning('No data matched in the database. Thank you', 'System Message')  
                    }
                    else
                    {
                        $('#thead_leadtime_data').DataTable().destroy();
                        $('#tbody_leadtime_data').empty();
        
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
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_issue}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.checking}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.palletizing}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.dr_making}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.normal_status}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.normal_dr}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.normal_delivered}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.irreg_status}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.irreg_dr}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.irreg_delivered}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.receiving}</td> 
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.leadtime}</td> 
    
                         </tr>`;
                         });
    
                $('#tbody_leadtime_data').html(tr);
                $('#thead_leadtime_data').DataTable({
                    "scrollX": true,
                    "paging": false,
                    "lengthChange": true,
                    "scrollY":        '80vh',
                    "scrollCollapse": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                            text: 'EXPORT CSV FILE'
                        }
                    ],
                    "fnDrawCallback": function() {
                        $('#tbody_leadtime_data td').each(function (){
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

    return this_leadtime_data;
})();
