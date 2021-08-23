$(document).ready(() => 
{
    $('#txt_forecast_date_from').val(date_today);
    $('#txt_forecast_date_to').val(date_today);
    $('#txt_forecast_month_date_from').val(month_today);
    $('#txt_forecast_month_date_to').val(month_today);
    $('#slc_forecast_range').val('DAILY');
    forecast.load_forecast_list();
});

    const forecast = (() => 
    {
        let this_forecast = {};
        let search_from = '';
        let search_to = '';

        this_forecast.onchange_datepicker = () =>
        {
            if ($('#slc_forecast_range').val() === 'MONTHLY')
            {
                $('#txt_forecast_date_from').prop('hidden', true);
                $('#txt_forecast_date_to').prop('hidden', true);
                $('#txt_forecast_month_date_from').prop('hidden', false);
                $('#txt_forecast_month_date_to').prop('hidden', false);
            }
            else
            {
                $('#txt_forecast_date_from').prop('hidden', false);
                $('#txt_forecast_date_to').prop('hidden', false);
                $('#txt_forecast_month_date_from').prop('hidden', true);
                $('#txt_forecast_month_date_to').prop('hidden', true);
            }
        };

        this_forecast.load_forecast_list = () => 
        {

            if ($('#slc_forecast_range').val() === 'MONTHLY')
            {
                var from = new Date($('#txt_forecast_month_date_from').val()); 
                var to = new Date($('#txt_forecast_month_date_to').val()); 
                var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
                var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 

                search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

                search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
            }
            else
            {
                search_from = $('#txt_forecast_date_from').val();
                search_to = $('#txt_forecast_date_to').val();
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
                instance.get(`load-forecast`, 
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
                        if(data.length===0)
                        {
                            toastr.warning('No data matched in the database. Thank you', 'System Message')  
                        }
                        else
                        {
                            $('#thead_forecast').DataTable().destroy();
                            $('#tbody_forecast').empty();
                            var x =0;
                            var tr = '';
                            $.each(data, function () 
                            {   
                                tr += `<tr>
                                <td>${this.date}</td>
                                <td><input type="text" id="txt_forecast_qty${x}" style="width:25%; text-align: center;" class="form-control txt_forecast_qty" placeholder="0" value="${this.qty}" maxlength="10" name="txt_forecast_qty[]" onkeypress="return onlyNumberKey(event)" autocomplete="off"/>
                                </td>
                                </tr>`;
                                x++;
                            });

                            $('#tbody_forecast').html(tr);
                            $('#thead_forecast').DataTable({
                                // "lengthMenu" : [[10,25,50,-1], [10,25,50,"All"]],
                                "scrollX": true,
                                "scrollY": '500px',
                                "paging": false,
                                "lengthChange": false,
                                "searching": true,
                                "ordering": false,
                                "info": true,
                                "autoWidth": true,
                                "fnDrawCallback": function() {
                                    $('#tbody_forecast td').each(function (){
                                        if($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined')
                                        {
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
                        document.getElementById('notification').play();
                    }
                }).catch((error) => 
                {
                    console.log(error)
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();

                }).finally(() => 
                {
                   // $('.loader').hide();
                })

            }
        };

        this_forecast.save_forecast = () => 
        {
            var tbl_data = $('#thead_forecast').DataTable().rows().data();
            var tbl = $('#thead_forecast').DataTable();

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
                            arr_save.push
                            ({
                                "date"      : rows[0][0],
                                "qty"       : $('#txt_forecast_qty'+i).val(),
                                "area_code" : area_code
                            });
                        }
                        instance.post(`save-forecast`,
                        {
                            data: arr_save,
                        }).then((response) => 
                        {
                            if (response['statusText'] == 'OK')
                            {
                                toastr.success('Successfully Saved! \nThank you', 'System Message')
                                document.getElementById('notification_success').play();
                            }
                            else
                            {
                                toastr.error('There was a problem in loading the data. Please contact the administrator \nThank you', 'System Message')
                                document.getElementById('notification').play();
                            }     
                        }).catch((error) => 
                        {
                            toastr.error('There was a problem in loading the data. Please contact the administrator \nThank you', 'System Message')
                            document.getElementById('notification').play();
                            console.log(error)
                        }).finally(() => 
                        {
                            tbl.clear().draw();
                            forecast.load_forecast_list();
                           // $('.loader').hide();
                        })
                    }
                })
            }
        };

        this_forecast.cancel_forecast = () => 
        {
            var tbl_data = $('#thead_forecast').DataTable().rows().data();
            var tbl = $('#thead_forecast').DataTable();
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
                        tbl_data.clear().draw();
                        tbl.clear().draw();
                        toastr.success('Value successfully reset!', 'System Message')
                        document.getElementById('notification_success').play();
                        forecast.load_forecast_list();
                    }
                })
            }
        };

    return this_forecast;
    })();
