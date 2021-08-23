$(document).ready(() => 
{
    $("#txt_checking_barcode").focus();
});

const CHECKING = (() => {
    var tbl_checking_normal = $('#tbl_checking_normal_checking').DataTable({
        // "scrollX": true,
        // "scrollY": '250px',
        "paging": false,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });

    let this_checking = {};
    let process = [];
    let process_name = '';
    let irreg_type = [];

    this_checking.barcode_ticket = (barcode) => 
    {
        $("#txt_checking_barcode").blur();
        // $('.loader').show();
        instance.get(`checking`,
        {
            params: ({
                ticket_no: barcode,
            })
        }).then((response) => 
        {
            console.log(response)
            if (response['statusText'] == 'OK') 
            {
                if (response.data.data.length === 0) 
                {
                    toastr.warning('No data matched in the database. Thank you', 'System Message')
                    
                    document.getElementById('notification').play();
                    CHECKING.clear_inputs();
                }
                else 
                {
                    if (response.data.data[0].issue_time != null )
                    {
                        if (response.data.data[0].irregularity_type == 'NO STOCK' || response.data.data[0].irregularity_type == 'EXCESS')
                        {
                            if (response.data.data[0].irreg_status == null)
                            {
                                toastr.warning('Completion not yet arrived.', 'System Message')
                                CHECKING.clear_inputs();
                                document.getElementById('notification').play();
                            }
                            else
                            {
                                process_name = 'Completion';
                                response.data.data[0].process = "Completion";
                                process = response.data.data[0];
                                CHECKING.validate_barcode(response.data.data[0]);
                                // console.log(response.data.data[0])
                            }  
                        }
                        else
                        {
                            if(response.data.data[0].dest_deleted_at != null)//if destination code is disabled
                            {
                                toastr.warning('Destination Code is disabled. Thank you', 'System Message')
                            }
                            else
                            {
                                //disble button if tapos na sa transaction
                                //rosesssss
                                if (response.data.data[0].normal_status!="FOR CHECKING" 
                                && (response.data.data[0].irreg_status!="FOR CHECKING" || response.data.data[0].irreg_status==null))
                                {
                                    $('#btn_checking_completion').attr("disabled", true);	
                                    $('#btn_checking_normal').attr("disabled", true);	
                                }
                                else if(response.data.data[0].normal_status=="FOR CHECKING" 
                                && (response.data.data[0].irreg_status!="FOR CHECKING" || response.data.data[0].irreg_status==null))
                                {
                                    $('#btn_checking_completion').attr("disabled", true);	
                                    $('#btn_checking_normal').attr("disabled", false);
                                }
                                else if(response.data.data[0].normal_status!="FOR CHECKING" && response.data.data[0].irreg_status=="FOR CHECKING")
                                {
                                    $('#btn_checking_completion').attr("disabled", false);	
                                    $('#btn_checking_normal').attr("disabled", true);
                                }
                                else
                                {
                                    $('#btn_checking_completion').attr("disabled", false);	
                                    $('#btn_checking_normal').attr("disabled", false);
                                }

                                if (support_status == 1)
                                {
                                    if (response.data.data[0].completion != null && response.data.data[0].irreg_status == "FOR CHECKING")
                                    {
                                        process_name = 'Completion';
                                        response.data.data[0].process = "Completion";
                                        process = response.data.data[0];
                                        $('#mod_checking').modal('show');
                                    }
                                    else if (response.data.data[0].normal != null && response.data.data[0].normal_status == "FOR CHECKING") 
                                    {
                                        if (response.data.data[0].completion != null )
                                        {
                                            process_name = 'Normal';
                                            response.data.data[0].process = "Normal";
                                            process = response.data.data[0];
                                            $('#mod_checking').modal('show');
                                        }
                                        else
                                        {
                                            process_name = 'Normal';
                                            response.data.data[0].process = "Normal";
                                            process = response.data.data[0];
                                            CHECKING.validate_barcode(response.data.data[0]);
                                        } 
                                    }
                                    else 
                                    {
                                        toastr.error('Not for checking!. Thank you', 'System Message')
                                        document.getElementById('notification').play();
                                        CHECKING.clear_inputs();
                                    }

                                }
                                else 
                                {
                                    if (response.data.data[0].warehouse_class == area_code) 
                                    {
                                        if (response.data.data[0].completion != null && response.data.data[0].irreg_status == "FOR CHECKING")
                                        {
                                                process_name = 'Completion';
                                                response.data.data[0].process = "Completion";
                                                process = response.data.data[0];
                                                $('#mod_checking').modal('show');
                                        }
                                        else if (response.data.data[0].normal != null  && response.data.data[0].normal_status == "FOR CHECKING") 
                                        {
                                            if (response.data.data[0].completion != null )
                                            {
                                                process_name = 'Normal';
                                                response.data.data[0].process = "Normal";
                                                process = response.data.data[0];
                                                $('#mod_checking').modal('show');
                                            }
                                            else
                                            {
                                                process_name = 'Normal';
                                                response.data.data[0].process = "Normal";
                                                process = response.data.data[0];
                                                CHECKING.validate_barcode(response.data.data[0]);
                                            } 
                                        }
                                        else 
                                        {
                                            toastr.error('Not for checking! Thank you', 'System Message')
                                            document.getElementById('notification').play();
                                            CHECKING.clear_inputs();
                                        }
                                    }
                                    else 
                                    {
                                        toastr.error('Area Code is not same.', 'System Message');
                                        document.getElementById('notification').play();
                                        CHECKING.clear_inputs();
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        toastr.warning('Kindly update ticket issue time before doing the transactions', 'System Message');
                        document.getElementById('notification').play();
                        CHECKING.clear_inputs();
                    }
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
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() => 
        {
            // $('.loader').hide();
        })
    };

    this_checking.validate_barcode = (check_barcode) => 
    {
        if (process_name === 'Normal') 
        {
            if (check_barcode.normal == null)
            {
                toastr.error('Not exists in the database!. Thank you', 'System Message')
                $("#txt_checking_barcode").focus();
                document.getElementById('notification').play();
            }
            else if (check_barcode.normal_status == 'FOR CHECKING' || check_barcode.normal_status == null)
            {
                CHECKING.fill_tbl_checking_normal_checking(check_barcode)
            }
            else 
            {
                toastr.error('Not for checking!. Thank you', 'System Message')
                document.getElementById('notification').play();
                CHECKING.clear_inputs();
            }
        }
        else if (process_name === 'Completion') 
        {
            
            if (check_barcode.normal == null)
            {
                toastr.error('Not exists in the database!. Thank you', 'System Message')
                document.getElementById('notification').play();
            }
            else if (check_barcode.irreg_status == 'FOR CHECKING')
            {
                CHECKING.fill_tbl_checking_normal_checking(check_barcode)
            }
            else 
            {
                toastr.error('Not for checking!. Thank you', 'System Message')
                document.getElementById('notification').play();
                CHECKING.clear_inputs();
            }
        }
    };

    this_checking.onclick_normal = () => 
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) {
                process_name = 'Normal';
                process.process = 'Normal';
                $('#mod_checking').modal('hide');
                CHECKING.validate_barcode(process);
            }
        })
    };

    this_checking.onclick_completion = () => 
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                process_name = 'Completion';
                process.process = 'Completion';
                $('#mod_checking').modal('hide');
                CHECKING.validate_barcode(process);
            }
        })
    };

    this_checking.fill_tbl_checking_normal_checking = (check_barcode) => 
    {
        var tbl_checking_data = tbl_checking_normal.rows().data();
        var str = $('#txt_checking_barcode').val().replace(/\s/g, '');
        var dataCount = tbl_checking_normal.rows(`:contains("${str}")`).data().length;
        
        if (dataCount < 1) 
        {
            document.getElementById('notification_success').play();
            tbl_checking_normal.row.add([
                check_barcode.normal,
                check_barcode.item_no,
                check_barcode.delivery_qty,
                check_barcode.order_download_no,
                check_barcode.process
            ]).draw(false);

            irreg_type.push(check_barcode.irregularity_type);
            CHECKING.clear_inputs();
        }
        else 
        {
            toastr.warning('Record already exists', 'System Message')
            document.getElementById('notification').play();
            CHECKING.clear_inputs();
        }
        $("#txt_checking_barcode").focus();
    };

    this_checking.data_for_update = () => 
    {
        var tbl_checking_data = tbl_checking_normal.rows().data();

        if (tbl_checking_data.length < 1)
        {
            toastr.warning('Table must not be empty, Thank you!', 'System Message')
            document.getElementById('notification').play();
            $("#txt_checking_barcode").focus();
        }
        else 
        {
            let arr_update = [];

            for (var i = 0; i < tbl_checking_data.length; i++) 
            {
                var rows = tbl_checking_normal.rows(i).data();
                arr_update.push
                ({
                    "ticket_no": rows[0][0],
                    "item_no": rows[0][1],
                    "delivery_qty": rows[0][2],
                    "order_download_no": rows[0][3],
                    "process": rows[0][4],
                    "users_id": $('#txt_user_id').val(),
                    "irreg_type": irreg_type[i]
                });
            }

            Swal.fire(swal_options).then((result) => 
            {
                if (result.value)
                {
                    $('#btn_checking_checking_update').prop('disabled', true)
                    CHECKING.update_checking(arr_update);
                }
                    
            })
        }
    };

    this_checking.update_checking = (data) => 
    {
        instance.patch(`checking`,
        {
            data: data
        }).then((response) => 
        {
            toastr.success('Successfully Updated!', 'System Message')
            document.getElementById('notification_success').play();
            tbl_checking_normal.clear().draw();
            irreg_type = [];
        }).catch((error) => 
        {
            toastr.error('There was a problem in updating the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() => { 
            $('#btn_checking_checking_update').prop('disabled', false)
            setTimeout(function(){
                CHECKING.clear_inputs();
            }, 300);
        })
    };

    this_checking.clear_inputs = () => 
    {
        $("#txt_checking_barcode").val('');
        $("#txt_checking_barcode").focus();
    };

    this_checking.clear_all = () => 
    {
        var tbl_checking_data = tbl_checking_normal.rows().data();
        if (tbl_checking_data.length < 1) 
        {
            toastr.warning('Table must not be empty, Thank you!', 'System Message')
            document.getElementById('notification').play();
            $("#txt_checking_barcode").focus();
        }
        else 
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                    tbl_checking_normal.clear().draw();  
                    irreg_type = [];
                    document.getElementById('notification_success').play();
                    setTimeout(function(){
                        CHECKING.clear_inputs()
                    }, 300);
                    toastr.success('Table cleared!', 'System Message')
                }
            });       
        }
       
    };

    $('#txt_checking_barcode').keypress(function (event) 
    {
        var keycode = (event.keyCode ? event.keyCode : event.which);//event on keypress enter
        if (keycode == '13')//event on keypress enter
        {
            CHECKING.barcode_ticket($('#txt_checking_barcode').val());
        }
    });

    this_checking.cancel_transaction_modal = () =>
    {
        setTimeout(function(){
            CHECKING.clear_inputs();
        }, 300);

    };

    return this_checking;
})();