$(document).ready(() => 
{
    $('#txt_prepared_by').val(user_name);
    CREATE_IRREGULARITY.display_approvers();
});

const CREATE_IRREGULARITY = (() => 
{
    var tbl_irreg = $('#thead_create_irreg').DataTable({
        "scrollX": true,
        "scrollY": '250px',
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });

    let this_create_irregularity = {};

    this_create_irregularity.display_approvers = () => 
    {
        instance.get(`/user`).then((response) => 
        {
            if (response['statusText'] == 'OK') 
            {
                var reviewer = "";
                var approver = "";
                reviewer = `<option selected disabled value="">Choose reviewed by</option>`;
                approver = `<option selected disabled value="">Choose approved by</option>`;

                $.each(response['data'].data, function () 
                {
                    if (this.approver === 1) 
                    {
                        reviewer += `<option class="select-option" value="${this.first_name} ${this.last_name}">${this.first_name} ${this.last_name}</option>`;
                        approver += `<option class="select-option" value="${this.first_name} ${this.last_name}">${this.first_name} ${this.last_name}</option>`;
                    }
                });

                $("#slc_reviewed_by").html(reviewer);
                $("#slc_approved_by").html(approver);
            }
            else 
            {
                document.getElementById('notification').play();
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }
        }).catch((error) => 
        {
            document.getElementById('notification').play();
            toastr.error(error)
            console.log(error)
        }).finally(() => { })
    };

    this_create_irregularity.enable_others = () => 
    {
        // alert ()
        if ($('#slc_type_of_irreg').val() === 'OTHERS') 
        {
            if (parseInt($('#txt_original').val()) == parseInt($('#txt_actual').val()))
            {
                toastr.error('Please check actual quantity', 'System Message')
                $('#slc_type_of_irreg').val('')
                $("#txt_others").val('');
            }
            else
            {
                $('#txt_others').prop('disabled', false);
                $('#txt_others').attr('readonly', false);
                $('#txt_others').val('');
                $("#txt_others").attr('placeholder', 'Input type of irregularity');
            }
        }
        else if ($('#slc_type_of_irreg').val() === 'NO STOCK') 
        {
            $('#txt_others').attr('readonly', true);
            $("#txt_others").attr('placeholder', '');
            $("#txt_others").val('');
            if (parseInt($("#txt_actual").val()) != 0 || parseInt($("#txt_actual").val()) == null || parseInt($("#txt_actual").val())=='')
            {
                toastr.error('Actual quantity is not equal to zero.', 'System Message')
                $('#slc_type_of_irreg').val('')
                $("#txt_others").val('');
            }
        }

        else if ($('#slc_type_of_irreg').val() === 'EXCESS') 
        {
            $('#txt_others').attr('readonly', true);
            $("#txt_others").attr('placeholder', '');
            $("#txt_others").val('');
            if (parseInt($('#txt_original').val()) >= parseInt($('#txt_discrepancy').val()))
            {
                toastr.error('Please check actual quantity', 'System Message')
                $('#slc_type_of_irreg').val('')
                $("#txt_others").val('');
            }
        }
        else 
        {
            $('#txt_others').attr('readonly', true);
            $('#txt_others').prop('disabled', true);
            $("#txt_others").attr('placeholder', '');
            $("#txt_others").val('');
            if (parseInt($('#txt_original').val()) == parseInt($('#txt_actual').val()))
            {
                toastr.error('Please check actual quantity', 'System Message')
                document.getElementById('notification').play();
                $('#slc_type_of_irreg').val('');
                $("#txt_actual").focus();
            }
            else
            {
                if (parseInt($('#txt_actual').val()) == 0)
                {
                    toastr.error('Please check actual quantity', 'System Message')
                    $('#txt_actual').val('');
                    $("#txt_actual").focus();
                }
                $('#txt_others').attr('readonly', true);
                $('#txt_others').prop('disabled', true);
                $("#txt_others").attr('placeholder', '');
                $("#txt_others").val('');
            }
            
        }
    };

    this_create_irregularity.load_data_inputs = (barcode) => 
    {
        $("#txt_barcode").blur();
        instance.get(`irregularity`,
        {
            params: ({
                        ticket_no: barcode,
                    })
        }).then((response) => 
        {
            if (response['statusText'] == 'OK') 
            {
                if (response.data.data.length === 0) 
                {
                    document.getElementById('notification').play();
                    toastr.warning('No data matched in the database. Thank you', 'System Message')
                    $('#txt_barcode').focus();                  
                    $('#txt_barcode').val('');
                }
                else 
                {
                    if(($('#txt_destination').val()!=''|| $('#txt_destination').val()==null) && $('#txt_destination').val() != response.data.data[0].destination_code)
                    {
                        document.getElementById('notification').play();
                        toastr.warning('Destination Code is not same. Thank you', 'System Message')
                        $('#txt_barcode').focus();  
                        CREATE_IRREGULARITY.clear_inputs();
                    }
                    else
                    {
                        if(($('#txt_warehouse_class').val()!=''|| $('#txt_warehouse_class').val()==null) && $('#txt_warehouse_class').val() != response.data.data[0].warehouse_class)
                        {
                            document.getElementById('notification').play();
                            toastr.warning('Cannot input different area code in this control', 'System Message')
                            $('#txt_barcode').focus();  
                            CREATE_IRREGULARITY.clear_inputs();
                        }
                        else
                        {
                            if (support_status == 1)
                            {
                                if (response.data.data[0].irreg_ticket_no == null) 
                                {
                                    if (response.data.data[0].process_masterlist_id == 1) 
                                    {
                                        $('#txt_order_download_no').val(response.data.data[0].order_download_no);
                                        $('#txt_stock_address').val(response.data.data[0].stock_address);
                                        $('#txt_part_no').val(response.data.data[0].item_no);
                                        $('#txt_part_name').val(response.data.data[0].item_name);
                                        $('#txt_original').val(response.data.data[0].delivery_qty);
                                        $('#txt_status').val(response.data.data[0].process);
                                        $('#txt_remarks').val('-'); 
                                        $('#txt_destination').val(response.data.data[0].destination_code); 
                                        $('#txt_warehouse_class').val(response.data.data[0].warehouse_class); 
                                        $('#txt_barcode').attr('readonly', true);
                                    }
                                    else 
                                    {
                                        document.getElementById('notification').play();
                                        toastr.error('Ticket No. is already done in this phase.', 'System Message')
                                        CREATE_IRREGULARITY.clear_inputs();
                                    }
                                }
                                else
                                {
                                    document.getElementById('notification').play();
                                    toastr.error('Irregularity already exist.', 'System Message')
                                    CREATE_IRREGULARITY.clear_inputs();
                                }
                            }
                            else
                            {
                                if (response.data.data[0].warehouse_class == area_code) 
                                {
                                    if (response.data.data[0].irreg_ticket_no == null) 
                                    {
                                        if (response.data.data[0].process_masterlist_id == 1) 
                                        {
                                            $('#txt_order_download_no').val(response.data.data[0].order_download_no);
                                            $('#txt_stock_address').val(response.data.data[0].stock_address);
                                            $('#txt_part_no').val(response.data.data[0].item_no);
                                            $('#txt_part_name').val(response.data.data[0].item_name);
                                            $('#txt_original').val(response.data.data[0].delivery_qty);
                                            $('#txt_status').val(response.data.data[0].process);
                                            $('#txt_remarks').val('-');
                                            $('#txt_barcode').attr('readonly', true);
                                            $('#txt_destination').val(response.data.data[0].destination_code); 
                                            $('#txt_warehouse_class').val(response.data.data[0].warehouse_class); 
                                        }
                                        else 
                                        {
                                            document.getElementById('notification').play();
                                            toastr.error('Ticket No. is already done in this phase.', 'System Message')
                                            CREATE_IRREGULARITY.clear_inputs();
                                        }
                                        
                                    }
                                    else
                                    {
                                        document.getElementById('notification').play();
                                        toastr.error('Irregularity already exist.', 'System Message')
                                        CREATE_IRREGULARITY.clear_inputs();
                                    }
                                }
                                else
                                {
                                    document.getElementById('notification').play();
                                    toastr.error('Area Code is not same.', 'System Message');
                                    CREATE_IRREGULARITY.clear_inputs();
                                }
                            }      
                        } 
                    }
                }
            }
            else 
            {
                document.getElementById('notification').play();
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }
        }).catch((error) => 
        {
            document.getElementById('notification').play();
            toastr.error(error)
            console.log(error)
        }).finally(() => { })
    };

    this_create_irregularity.onchange_actual_quantity = () =>   
    {
        var barcode=$('#txt_barcode').val();
        if(barcode != null && barcode != '' && barcode != undefined)
        {
            var original     = $('#txt_original').val();
            var actual       = $('#txt_actual').val();
            var actual_length=($('#txt_actual').val()).length 
            original         =parseInt(original);
            actual           =parseInt(actual);
            var discrep      = original - actual;
        
            if(actual > original)
            {
                // toastr.warning('Please check actual quantity', 'System Message')
                // $('#txt_actual').val('');
                // $('#slc_type_of_irreg').prop('disabled',false);
                // $('#txt_actual').val('');
                // $('#txt_discrepancy').val(original);

                $('#slc_type_of_irreg').val('EXCESS');
                $('#txt_others').val('');
                $('#txt_others').prop('disabled',true);
                $('#txt_others').prop('readonly',true);
                $("#txt_others").attr('placeholder', '');
                $('#slc_type_of_irreg').prop('disabled',true);  
                $('#txt_discrepancy').val(discrep);
            }
            else
            {
                $('#slc_type_of_irreg').val('');
                if(actual == 0)
                {
                    $('#slc_type_of_irreg').val('NO STOCK');
                    $('#txt_others').val('');
                    $('#txt_others').prop('disabled',true);
                    $('#txt_others').prop('readonly',true);
                    $("#txt_others").attr('placeholder', '');
                    $('#slc_type_of_irreg').prop('disabled',true);  
                    $('#txt_discrepancy').val(original);
                    if(actual_length > 1)
                    {
                        $('#txt_actual').val('');
                        $('#txt_discrepancy').val(original);
                    }

                }
                else
                {
                    if($('#txt_actual').val().charAt(0)==0)
                    {
                        $('#txt_actual').val('');
                        $('#slc_type_of_irreg').val('');
                        $('#txt_discrepancy').val(original);
                        $('#slc_type_of_irreg').prop('disabled',false);
                        $('#slc_type_of_irreg').prop('readonly',false);
                    }
                    else
                    {
                        $('#txt_others').val('');
                        $('#txt_others').prop('disabled',true);
                        $('#txt_others').prop('readonly',true);
                        $("#txt_others").attr('placeholder', '');
                        $('#slc_type_of_irreg').prop('disabled',false);
                        $('#slc_type_of_irreg').prop('readonly',false);
                        $('#txt_discrepancy').val(discrep);
                    }
                
                }
            }
        }
        else
        {
            $('#txt_actual').val('');
            toastr.warning('Please input barcode first.', 'System Message')
            $('#txt_others').val('');
            $('#txt_others').prop('disabled',true);
            $('#txt_others').prop('readonly',true);
            $("#txt_others").attr('placeholder', '');
            $('#slc_type_of_irreg').val('');
        }
    };

    this_create_irregularity.add_irregularity = () => 
    {
        var tbl_data = tbl_irreg.rows().data();
        var irreg_type = '';
        var others = $('#txt_others').val();

        if ($('#slc_type_of_irreg').val() === 'OTHERS') 
            irreg_type = `OTHERS-${others}`;
        else 
            irreg_type = $('#slc_type_of_irreg').val();

        if ($('#txt_barcode').val() === '' || $('#slc_type_of_irreg').val() === '' ||
            $('#txt_actual').val() === '' || $('#txt_remarks').val() === '') 
        {
            toastr.error('Please complete inputs', 'System Message')
        }
        else if ($('#slc_type_of_irreg').val() === 'OTHERS' && $('#txt_others').val() === '') 
        {
            toastr.error('Please complete inputs', 'System Message')
        }
        else if ($('#txt_discrepancy').val() === '') 
        {
            document.getElementById('notification').play();
            toastr.error('Actual quantity must be equal or less than the Original quantity ', 'System Message')
        }
        else 
        {
            if (tbl_data.length < 7) 
            {
                if ($(`#thead_create_irreg tr > td:contains(${$('#txt_barcode').val()})`).length < 1) 
                {
                    tbl_irreg.row.add([
                        $('#txt_barcode').val(),
                        $('#txt_order_download_no').val(),
                        irreg_type,
                        $('#txt_status').val(),
                        $('#txt_stock_address').val(),
                        $('#txt_part_no').val(),
                        $('#txt_part_name').val(),
                        $('#txt_original').val(),
                        $('#txt_actual').val(),
                        $('#txt_discrepancy').val(),
                        $('#txt_remarks').val(),
                        '<button class="btn btn-danger delete_row"><i class="fa fa-trash"></i></button>'
                    ]).draw(false);
                    $('#txt_barcode').attr('readonly', false);
                    CREATE_IRREGULARITY.clear_inputs();
                }
                else 
                {
                    document.getElementById('notification').play();
                    toastr.warning('Record already exists', 'System Message')
                    CREATE_IRREGULARITY.clear_inputs();
                    $('#txt_barcode').attr('readonly', false);
                }
            }
            else 
            {
                document.getElementById('notification').play();
                toastr.error('Input reaches the maximmum allowed entries', 'System Message')
            }
        }
    };

    this_create_irregularity.print = () => 
    {
        var tbl_data = tbl_irreg.rows().data();

        if(tbl_data.length < 1)
        {
            document.getElementById('notification').play();
            toastr.warning('Table must not be empty, Thank you!', 'System Message')
        }
        else if($("#slc_approved_by").val() === null && $("#slc_reviewed_by").val() === null)
        {
            document.getElementById('notification').play();
            toastr.warning('Approvers must not be empty, Thank you!', 'System Message')
        }
        else if($("#slc_approved_by").val() === null)
        {
            document.getElementById('notification').play();
            toastr.warning('Approver must not be empty, Thank you!', 'System Message')
        }
        else if($("#slc_reviewed_by").val() === null)
        {
            document.getElementById('notification').play();
            toastr.warning('Reviewer must not be empty, Thank you!', 'System Message')
        }
        else
        {
            
            $("#btn_upload_irregularity").prop('disabled',true);
            let arr_irregular=[];
        
            for(var i = 0;i < tbl_data.length; i++) 
            {    
                var rows = tbl_irreg.rows(i).data();
                arr_irregular.push
                ({
                    "ticket_no"             : rows[0][0],
                    "order_download_no"     : rows[0][1],
                    "irregularity_type"     : rows[0][2],
                    "status"                : rows[0][3],
                    "stock_address"         : rows[0][4],
                    "part_no"               : rows[0][5],
                    "part_name"             : rows[0][6],
                    "original_qty"          : rows[0][7],
                    "actual_qty"            : rows[0][8],
                    "discrepancy"           : rows[0][9],
                    "remarks"               : rows[0][10],
                    "users_id"              : $("#txt_user_id").val(),
                    // "user_type_id"          : 88,
                    "prepared_by"           : $("#txt_prepared_by").val(),
                    "approved_by"           : $("#slc_approved_by").val(),
                    "reviewed_by"           : $("#slc_reviewed_by").val(),
                    "warehouse_class"       : $("#txt_area_code").val(),
                    "irreg_create"          : date_today,
                });
            }
            CREATE_IRREGULARITY.save_irregularity(arr_irregular);
        }
    };

    this_create_irregularity.save_irregularity = (data) => 
    {
        // $('.loader').show();
        local.post(`irregularity`,
        {
            datas: data,
            // warehouse_class: $("#txt_area_code").val(),
        },
        {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/pdf'
            },
            responseType: "blob"
        }).then((response) => {
            const blob = new Blob([response.data], { type: 'application/pdf' })
            const objectUrl = window.URL.createObjectURL(blob)
            window.open(objectUrl)
        }).catch((error) => 
        {
            document.getElementById('notification').play();
            toastr.error(error)
            console.log(error)
        }).finally(() => 
        {
            CREATE_IRREGULARITY.cancel_inputs();
            $('#txt_destination').val('');
            $('#txt_warehouse_class').val('');
            tbl_irreg.clear().draw();
            $("#btn_upload_irregularity").prop('disabled',false);
            // $('.loader').hide();
         })
    };


    this_create_irregularity.clear_inputs = () => 
    {
        $('#txt_barcode').attr('readonly', false);
        $('#txt_others').attr('readonly', true);
        $('#txt_others').attr('placeholder' ,'');
        $('#txt_barcode').val('');
        $('#txt_status').val('');
        $('#slc_type_of_irreg').val('');
        $('#txt_others').val('');
        $('#txt_order_download_no').val('');
        $('#txt_stock_address').val('');
        $('#txt_part_no').val('');
        $('#txt_part_name').val('');
        $('#txt_original').val('');
        $('#txt_actual').val('');
        $('#txt_discrepancy').val('');
        $('#txt_remarks').val('');
        $('#slc_reviewed_by').val('');
        $('#slc_approved_by').val('');
        $('#slc_type_of_irreg').removeAttr('disabled');
        var tbl_data = tbl_irreg.rows().data();
        if(tbl_data.length < 1)
        {
            $('#txt_destination').val('');
            $('#txt_warehouse_class').val('');
            
        }
        $('#txt_barcode').focus();
    };

    this_create_irregularity.reload_inputs = () => 
    {
        $('#txt_others').attr('readonly', true);
        $('#txt_others').attr('placeholder' ,'');
        $('#txt_status').val('');
        $('#slc_type_of_irreg').val('');
        $('#txt_others').val('');
        $('#txt_order_download_no').val('');
        $('#txt_stock_address').val('');
        $('#txt_part_no').val('');
        $('#txt_part_name').val('');
        $('#txt_original').val('');
        $('#txt_actual').val('');
        $('#txt_discrepancy').val('');
        $('#txt_remarks').val('');
        $('#slc_reviewed_by').val('');
        $('#slc_approved_by').val('');
        $('#slc_type_of_irreg').removeAttr('disabled');
    };



    this_create_irregularity.cancel_inputs = () => 
    {
        $('#txt_barcode').attr('readonly', false);
        $('#txt_others').attr('readonly', true);
        $('#txt_others').attr('placeholder' ,'');
        $('#txt_barcode').val('');
        $('#txt_status').val('');
        $('#slc_type_of_irreg').val('');
        $('#txt_others').val('');
        $('#txt_order_download_no').val('');
        $('#txt_stock_address').val('');
        $('#txt_part_no').val('');
        $('#txt_part_name').val('');
        $('#txt_original').val('');
        $('#txt_actual').val('');
        $('#txt_discrepancy').val('');
        $('#txt_remarks').val('');
        $('#slc_reviewed_by').val('');
        $('#slc_approved_by').val('');
        $('#txt_destination').val('');
        $('#txt_warehouse_class').val('');
        $('#slc_type_of_irreg').removeAttr('disabled');
    };

    
    $('#txt_barcode').keypress(function (event) 
    {
        var keycode = (event.keyCode ? event.keyCode : event.which);//event on keypress enter
        if (keycode == '13')//event on keypress enter
        {
            CREATE_IRREGULARITY.reload_inputs();
            CREATE_IRREGULARITY.load_data_inputs($('#txt_barcode').val());
        }
    });

    $('.form-card :input').focus(function () 
    {
       let id = $(this).attr('id');
       if((id != 'btn_clear_irreg' && id != 'btn_add_irreg' && id != 'txt_barcode') && $('#txt_barcode').val()!='')
       {
          CREATE_IRREGULARITY.load_data_inputs($('#txt_barcode').val());
       }
    });

    $('#thead_create_irreg tbody').on('click', 'button.delete_row', function () 
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                tbl_irreg
                    .row($(this).parents('tr'))
                    .remove()
                    .draw();
                toastr.success('Successfully Deleted', 'System Message')

            }
        })
    });

    return this_create_irregularity;
})();
