$(document).ready(() => 
{
    $('#txt_timeout_date_from').val(date_today);
    $('#txt_timeout_date_to').val(date_today);
    $('#txt_timeout_month_date_from').val(month_today);
    $('#txt_timeout_month_date_to').val(month_today);
    $('#slc_timeout_range').val('DAILY');
   
});

    const TIMEOUT = (() =>
    {
        let this_timeout = {};
        let search_from = '';
        let search_to = '';

        this_timeout.onchange_datepicker = () =>
        {
            if($('#slc_timeout_range').val() === 'MONTHLY')
            {
                $('#txt_timeout_date_from').prop('hidden', true);
                $('#txt_timeout_date_to').prop('hidden', true);
                $('#txt_timeout_month_date_from').prop('hidden', false);
                $('#txt_timeout_month_date_to').prop('hidden', false);
            }
            else
            {
                $('#txt_timeout_date_from').prop('hidden', false);
                $('#txt_timeout_date_to').prop('hidden', false);
                $('#txt_timeout_month_date_from').prop('hidden', true);
                $('#txt_timeout_month_date_to').prop('hidden', true);
            }
        };

        this_timeout.load_timeout_list = () =>
        {
            $('#btn_save_timeout').prop('disabled', false);

            if ($('#slc_timeout_range').val() === 'MONTHLY')
            {
                var from = new Date($('#txt_timeout_month_date_from').val()); 
                var to = new Date($('#txt_timeout_month_date_to').val()); 
                var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
                var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 

                search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

                search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));  
            }
            else
            {
                search_from = $('#txt_timeout_date_from').val();
                search_to = $('#txt_timeout_date_to').val();
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
               $('.loader').show();
                instance.get(`load-timeout`, 
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
                            $('#thead_timeout').DataTable().destroy();
                            $('#tbody_timeout').empty();
                            var x =0;
                            var tr = '';
                            $.each(data, function () 
                            {   
                                tr += `<tr>
                                <td>${this.date}</td>
                                <td>
                                <input id="txt_timein${x}" type="time"  style="width:25%; text-align: center;" class="form-control txt_timein" value="${this.time_in}" maxlength="8" name="txt_timein[]"  autocomplete="off" onkeyup="TIMEOUT.validate_time($('#txt_timein${x}').val(),$('#txt_timeout${x}').val(),${x})"/>
                                </td>
                                <td>
                                <input id="txt_timeout${x}" type="time" style="width:25%; text-align: center;" class="form-control txt_timeout" value="${this.time_out}" maxlength="8" name="txt_timeout[]"  autocomplete="off" onkeyup="TIMEOUT.validate_time($('#txt_timein${x}').val(),$('#txt_timeout${x}').val(),${x})"/>
                                </td>
                                </tr>`;
                                x++;

                            });

                            $('#tbody_timeout').html(tr);
                            $('#thead_timeout').DataTable({
                                "scrollX": '500px',
                                "paging": false,
                                "lengthChange": true,
                                'scrollY'       : '80vh',
                                "scrollCollapse": true,
                                "searching": true,
                                "ordering": false,
                                "info": true,
                                "autoWidth": true,
                                "fnDrawCallback": function() {
                                    $('#tbody_timeout td').each(function (){
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
                   $('.loader').hide();
                })
            
            }
        };

        this_timeout.validate_time = (time_in,time_out,x) => 
        {
 
          
            if ((time_out == "" && time_in != "") || (time_out != "" && time_in == "")) 
            {
                    $('#txt_timein'+x).css('color','red');
                    $('#txt_timeout'+x).css('color','red');
            }
            else if (time_out == "" && time_in == "") 
            {
                $('#txt_timein'+x).css('color','black');
                $('#txt_timeout'+x).css('color','black');
                // $('#btn_save_timeout').prop('disabled', true);	
            }
            else if(time_out != "" && time_in != "")
            {

                if (time_out > time_in)
                {
                    $('#txt_timein'+x).css('color','black');
                    $('#txt_timeout'+x).css('color','black');
                    // $('#btn_save_timeout').prop('disabled', false);	
                }
                else
                {
                    $('#txt_timein'+x).css('color','red');
                    $('#txt_timeout'+x).css('color','red');
                    // $('#btn_save_timeout').prop('disabled', true);	
                }
            }


        }
        this_timeout.check_time_input = (time) => 
        {
            var [h,m] = time.split(":");
            console.log((h%12+12*(h%12==0))+":"+m, h >= 12 ? 'PM' : 'AM');
        }
        this_timeout.save_timeout = () => 
        {
            var tbl_data = $('#thead_timeout').DataTable().rows().data();

            var tbl = $('#thead_timeout').DataTable();

            if (tbl_data.length < 1) 
            {
                toastr.warning('Table must not be empty, Thank you!', 'System Message')
                document.getElementById('notification').play();
            } 
            else 
            {
               
                let blank_counter=0;
                for (var i = 0; i < tbl_data.length; i++) 
                {
                    var time_in =  document.getElementById('txt_timein'+i);
                    var time_out =  document.getElementById('txt_timeout'+i);
                   if(($('#txt_timein'+i).val() == '' && $('#txt_timeout'+i).val() != '') || ($('#txt_timein'+i).val() != '' && $('#txt_timeout'+i).val() == ''))
                   {
                    blank_counter+=1;
                   }
                   if(($('#txt_timein'+i).css("color")==='rgb(255, 0, 0)') || ($('#txt_timeout'+i).css("color")=='rgb(255, 0, 0)'))
                   {
                    blank_counter+=1;
                   }
                   if(time_in.checkValidity()== false || time_out.checkValidity()== false)
                   {
                    blank_counter+=1;
                   }
                }
                if(blank_counter>0)
                {
                    toastr.warning('Blank/wrong entry/entries detected. Please check the input first, Thank you!', 'System Message')
                }
                else
                {
                    Swal.fire(swal_options).then((result) => 
                    {
                        if (result.value)
                        {
                            let arr_save = [];
                            
                            for (var i = 0; i < tbl_data.length; i++) 
                            {
                                
                                var rows = tbl.rows(i).data();
                                arr_save.push
                                ({
                                    "date"      : rows[0][0],
                                    "time_in"   : $('#txt_timein'+i).val(),
                                    "time_out"  : $('#txt_timeout'+i).val(),
                                    "area_code" : area_code
                                });

                            }
                            instance.post(`save-timeout`,
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
                                TIMEOUT.load_timeout_list();
                            })
                        }
                    })
                }
            }
        };

        this_timeout.cancel_timeout = () => 
        {
            // alert('cancel');
            var tbl_data = $('#thead_timeout').DataTable().rows().data();
            var tbl = $('#thead_timeout').DataTable();
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
                        TIMEOUT.load_timeout_list();
                    }
                })
            }
        };

        this_timeout.show_modal = () =>
        {
            $('#mod_timeout').modal('show');
            TIMEOUT.load_timeout_list();
        }


    return this_timeout;    
    })();