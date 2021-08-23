$(document).ready(() =>
{
    $('#txt_picker_date_from').val(date_today);
    $('#txt_picker_date_to').val(date_today);
    $('#txt_picker_month_date_from').val(month_today);
    $('#txt_picker_month_date_to').val(month_today);
    $('#slc_picker_range').val('DAILY');
    PICKER.load_picker_list();
});

const PICKER = (() =>
{
    let this_picker = {};
    let search_from = '';
    let search_to = '';

    this_picker.onchange_datepicker = () =>
    {
        if ($('#slc_picker_range').val() === 'MONTHLY')
        {
            $('#txt_picker_date_from').prop('hidden', true);
            $('#txt_picker_date_to').prop('hidden', true);
            $('#txt_picker_month_date_from').prop('hidden', false);
            $('#txt_picker_month_date_to').prop('hidden', false);
        }
        else
        {
            $('#txt_picker_date_from').prop('hidden', false);
            $('#txt_picker_date_to').prop('hidden', false);
            $('#txt_picker_month_date_from').prop('hidden', true);
            $('#txt_picker_month_date_to').prop('hidden', true);
        } 
    };

    this_picker.load_picker_list = () =>
    {
        if ($('#slc_picker_range').val() === 'MONTHLY')
        {
            var from = new Date($('#txt_picker_month_date_from').val()); 
            var to = new Date($('#txt_picker_month_date_to').val()); 
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 
            
            search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                            ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

            search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                            ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));    
        }
        else
        {
            search_from = $('#txt_picker_date_from').val();
            search_to = $('#txt_picker_date_to').val();
        }

        if (search_from === '' || search_to === ''|| search_from === 'NaN-0NaN-0NaN' || search_to === 'NaN-0NaN-0NaN')
        {
            toastr.error('Please complete the inputs', 'System Message')
            document.getElementById('notification').play();
        }
        else if (search_from > search_to)
        {
            toastr.error('Invalid date range', 'System Message')
            document.getElementById('notification').play();
        }
        else
        {
            // $('.loader').show();
            instance.get(`load-picker`,
            {
                params: ({
                           date_from    : search_from,
                           date_to      : search_to,
                           area_code    : area_code
                        })
            }).then((response) =>
            {
                var data = response.data.data;

                if(data.length===0)
                {
                    toastr.warning('No data matched in the database. Thank you', 'System Message')  
                    document.getElementById('notification').play();
                }
                else
                {
                    $('#thead_picker').DataTable().destroy();
                    $('#tbody_picker').empty();

                    var count= 0;
                    var tr = '';
                    $.each(data, function () 
                    {   
                        var picker = this.picker_count;
                        var picker_count = "";

                        if(picker == '0')
                        {
                            picker_count = ""
                        }
                        else
                        {
                            picker_count = picker
                        };

                        tr += `<tr>
                                <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.picking_date}</td>
                                <td><input type="text"id="txt_picker_count${count}" style="width:25%; text-align: center;" class="form-control txt_picker_count" placeholder="0" value="${picker_count}" maxlength="7" name="txt_picker_count[]" onkeypress="return onlyNumberKey(event)" autocomplete="off"/>
                                </tr>`;   
                            count++;    
                    });

                    $('#tbody_picker').html(tr);
                    $('#thead_picker').DataTable(
                        {
                            "scrollY": '500px',
                            "paging": false,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": false,
                            "info": true,
                            "autoWidth": true,
                            "fnDrawCallback": function() {
                                $('#tbody_parts_status td').each(function (){
                                    if($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined'){
                                        $(this).text('');				
                                    }
                                  }); 
                              }
                        });
                }
            }).catch((error) => 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator \nThank you', 'System Message')
                console.log(error)
                document.getElementById('notification').play();
            }).finally(() => 
            {
                // $('.loader').hide();
            })
        }   
    };

    this_picker.save_picker = () => 
    {
        var tbl_data = $('#thead_picker').DataTable().rows().data();
        var tbl = $('#thead_picker').DataTable();

        if (tbl_data.length < 1) 
        {
            toastr.warning('Table must not be empty, Thank you!', 'System Message')
            document.getElementById('notification').play();
        }
        else 
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value)
                {
                    // $('.loader').show();
                    let arr_save = [];
                    for (var i = 0; i < tbl_data.length; i++) 
                    {
                        var rows = tbl.rows(i).data();
                        var picker_count=0;
                        if(!($('#txt_picker_count'+i).val() == ""  || $('#txt_picker_count'+i).val() == undefined))
                        {
                            picker_count = $('#txt_picker_count'+i).val();
                        }
                            arr_save.push
                            ({
                                "date"           : rows[0][0],
                                "picker_count"   : picker_count, 
                                "area_code"      : area_code
                            });
                    
                    }
                    instance.post(`save-picker`,
                    {
                        data: arr_save,
                    }).then((response) => 
                    {
                        if (response['statusText'] == 'OK')
                        {
                            toastr.success('Successfully Saved! \nThank you', 'System Message');
                        }
                    }).catch((error) => 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator \nThank you', 'System Message')
                        console.log(error)
                        document.getElementById('notification').play();
                    }).finally(() =>
                    {
                        tbl.clear().draw();
                        // $('.loader').hide();
                        PICKER.load_picker_list();
                    })
                }
            
            })
            
        }
    };

    return this_picker;
})();