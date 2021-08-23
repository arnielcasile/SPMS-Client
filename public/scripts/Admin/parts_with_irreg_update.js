$(document).ready(() => 
{
    $('#slc_irreg_update_range').val('DAILY');
    $('#txt_irreg_update_date_from').datepicker('setDate', date_today);
    $('#txt_irreg_update_date_to').datepicker('setDate', date_today);
    $('#txt_irreg_update_month_date_from').datepicker('setDate', date_today);
    $('#txt_irreg_update_month_date_to').datepicker('setDate', date_today);

    $('#slc_list_range').val('DAILY');
    $('#txt_list_date_from').datepicker('setDate', date_today);
    $('#txt_list_date_to').datepicker('setDate', date_today);
    $('#txt_list_month_date_from').datepicker('setDate', date_today);
    $('#txt_list_month_date_to').datepicker('setDate', date_today);

    UPDATE_IRREGULARITY.load_update_irregularity_list();
    UPDATE_IRREGULARITY.load_irregularity_list();
});

const UPDATE_IRREGULARITY = (() => 
{
    let this_update_irregularity = {};
    let update_date_from = '';
    let update_date_to = '';
    let list_date_from = '';
    let list_date_to = '';
    
    this_update_irregularity.onchange_datepicker_for_update = () =>
    {
        if ($('#slc_irreg_update_range').val() === 'MONTHLY')
        {
            $('#txt_irreg_update_date_from').prop('hidden', true);
            $('#txt_irreg_update_date_to').prop('hidden', true);
            $('#txt_irreg_update_month_date_from').prop('hidden', false);
            $('#txt_irreg_update_month_date_to').prop('hidden', false);
        }
        else
        {
            $('#txt_irreg_update_date_from').prop('hidden', false);
            $('#txt_irreg_update_date_to').prop('hidden', false);
            $('#txt_irreg_update_month_date_from').prop('hidden', true);
            $('#txt_irreg_update_month_date_to').prop('hidden', true);
        }
    };

    this_update_irregularity.load_update_irregularity_list = () => 
    {
        if ($('#slc_irreg_update_range').val() === 'MONTHLY')
        {
            var from = new Date($('#txt_irreg_update_month_date_from').val()); 
            var to = new Date($('#txt_irreg_update_month_date_to').val()); 
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 
            
            update_date_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                            ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

            update_date_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                            ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
        }
        else
        {
            update_date_from = $('#txt_irreg_update_date_from').val();
            update_date_to = $('#txt_irreg_update_date_to').val();
        }
        if ($('#slc_irreg_update_range').val() === '' || update_date_from === 'NaN-0NaN-0NaN' || update_date_to === 'NaN-0NaN-0NaN' || update_date_from === '' || update_date_to === '')
        {
            toastr.error('Please complete the inputs', 'System Message')
            document.getElementById('notification').play();
        }
        else if (update_date_from > update_date_to)
        {
            toastr.error('Invalid date range', 'System Message')
            document.getElementById('notification').play();
        }
        else
        {      
            // $('.loader').show();
            instance.get(`irregularity-load`, 
            {
                params: ({   
                            date_from   : update_date_from,
                            date_to     : update_date_to,
                            range       : $('#slc_irreg_update_range').val() ,
                            area_code   : area_code
                        }) 
            }).then((response) => 
            {
                if (response['statusText'] == 'OK') 
                {
                    $('#thead_update_irreg').DataTable().destroy();
                    $('#tbody_update_irreg').empty();

                    var x = 1;
                    var tr = '';

                    $.each(response.data.data, function () 
                    {    
                        var actions =`&nbsp;<button type="button" class="btn btn-danger" title="Delete irregularity" 
                                        onclick="UPDATE_IRREGULARITY.delete_irregularity(${this.id});"><i class="fa fa-trash"></i></button>`;

                        if(this.process_masterlist_id != 1 || this.process_masterlist_id != 2 || this.process_masterlist_id != 3)
                        {
                            actions+=`&nbsp;<button type="button" class="btn btn-warning edit_row" title="Edit irregularity" 
                                        onclick="UPDATE_IRREGULARITY.edit_btn('${this.ticket_no}','${this.order_download_no}','${this.irregularity_type}',
                                        '${this.irreg_status}','${this.stock_address}','${this.item_no}','${this.item_name}',
                                        ${this.delivery_qty},${this.actual_qty},${this.discrepancy},'${this.remarks}');"><i class="fa fa-pencil"></i></button>`;
                        }
                        else
                        {
                            actions+=`&nbsp;<button type="button" disabled class="btn btn-warning" title="Edit irregularity"><i class="fa fa-pencil"></i></button>`;
                        }

                        tr += `<tr>
                                <td>${x}</td>
                                <td>${this.ticket_no}</td>
                                <td>${this.order_download_no}</td>
                                <td>${this.irregularity_type}</td> 
                                <td>${this.irreg_status}</td>
                                <td>${this.stock_address}</td> 
                                <td>${this.item_no}</td>
                                <td>${this.item_name}</td>
                                <td>${this.delivery_qty}</td> 
                                <td>${this.actual_qty}</td>
                                <td>${this.discrepancy}</td> 
                                <td>${this.remarks}</td>
                                <td>${this.control_no}</td>
                                <td>${actions}</td>
                            </tr>`;
                        x++;
                    });

                    $('#tbody_update_irreg').html(tr);
                    $('#thead_update_irreg').DataTable({
                        "scrollX": true,
                        "scrollY": '400px',
                        "paging": true,
                        "lengthChange": true,
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
                            $('#tbody_update_irreg td').each(function (){
                                if($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined'){
                                    $(this).text('');				
                                }
                              }); 
                          }
                    });
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
        }
    };

    this_update_irregularity.edit_btn = (ticket_no, order_download_no, irregularity_type, process_masterlist_id, stock_address, product_no, item_name, delivery_qty, actual_qty, discrepancy, remarks) =>
    {
        var split_irreg_type = irregularity_type.split('-');

        if(split_irreg_type[0] === 'OTHERS')
        {         
            $("#slc_update_type_of_irreg option[value='OTHERS']").prop('selected' , true);  
            $("#txt_update_others").val(split_irreg_type[1]);
            $("#txt_update_others").prop('disabled',false);
            $("#txt_update_others").prop('readonly',false);
            $("#slc_update_type_of_irreg").prop('disabled' , false);  
        }
        else if(irregularity_type =='LACKING' || irregularity_type == 'NO STOCK' || irregularity_type == 'EXCESS')
        {
            $('#slc_update_type_of_irreg').val(irregularity_type);
            $("#txt_update_others").prop('disabled',true);
            $("#txt_update_others").prop('readonly',true);
            $("#txt_update_others").attr('placeholder', '');
            $("#txt_update_others").val('');
            $("#slc_update_type_of_irreg").prop('disabled' , false);  
        }

        $("#txt_update_barcode").val(ticket_no);
        $("#txt_update_order_download_no").val(order_download_no);
        $("#txt_update_status").val(process_masterlist_id);
        $("#txt_update_stock_address").val(stock_address);
        $("#txt_update_part_no").val(product_no);
        $("#txt_update_part_name").val(item_name);
        $("#txt_update_original").val(delivery_qty);
        $("#txt_update_actual").val(actual_qty);
        $("#txt_update_discrepancy").val(discrepancy);
        $("#txt_update_remarks").val(remarks);
    };

    this_update_irregularity.onchange_datepicker_for_list = () =>
    {
        if ($('#slc_list_range').val() === 'MONTHLY')
        {
            $('#txt_list_date_from').prop('hidden', true);
            $('#txt_list_date_to').prop('hidden', true);
            $('#txt_list_month_date_from').prop('hidden', false);
            $('#txt_list_month_date_to').prop('hidden', false);
        }
        else
        {
            $('#txt_list_date_from').prop('hidden', false);
            $('#txt_list_date_to').prop('hidden', false);
            $('#txt_list_month_date_from').prop('hidden', true);
            $('#txt_list_month_date_to').prop('hidden', true);
        }
    };

    this_update_irregularity.load_irregularity_list = () => 
    {
        if ($('#slc_list_range').val() === 'MONTHLY')
        {
            var from = new Date($('#txt_list_month_date_from').val()); 
            var to = new Date($('#txt_list_month_date_to').val()); 
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 
            
            list_date_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                            ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

                            list_date_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                            ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
        }
        else
        {
            list_date_from = $('#txt_list_date_from').val();
            list_date_to = $('#txt_list_date_to').val();
        }

        if ($('#slc_list_range').val() === '' || list_date_from === '' || list_date_to === '' || list_date_from === 'NaN-0NaN-0NaN' || list_date_to === 'NaN-0NaN-0NaN')//empty date
        {
            toastr.error('Please complete the inputs', 'System Message')
            document.getElementById('notification').play();
        }
        else if (list_date_from > list_date_to)
        {
            toastr.error('Invalid date range', 'System Message')
            document.getElementById('notification').play();
        }
        else
        {
            // $('.loader').show();
            instance.get(`/irregularity-list`, 
            {
                params: ({
                            date_from   : list_date_from,
                            date_to     : list_date_to,
                            area_code   : area_code,
                            range       : $('#slc_list_range').val()
                        })
            }).then((response) => 
            {
                if (response['statusText'] == 'OK') 
                {
                    $('#thead_list_of_irreg').DataTable().destroy();
                    $('#tbody_list_of_irreg').empty();

                    var tr = '';
                    var x = 1;
                    $.each(response['data'].data, function () 
                    {    
                        var flag = '';

                        if(this.irreg_status === '' || this.irreg_status === null)
                            flag = `<i class="fa fa-flag fa-3x" style="color: red" title="Update status" onclick="UPDATE_IRREGULARITY.update_status(${this.id},'${this.normal_status}','${this.irregularity_type}')"></i>`;
                        else
                            flag = `<i class="fa fa-flag fa-3x" style="color: green"></i>`;

                        tr += `<tr>
                                <td>${this.ticket_no}</td>
                                <td>${this.order_download_no}</td>
                                <td>${this.irregularity_type}</td> 
                                <td>${this.irreg_status}</td>
                                <td>${this.stock_address}</td> 
                                <td>${this.item_no}</td>
                                <td>${this.item_name}</td>
                                <td>${this.delivery_qty}</td> 
                                <td>${this.actual_qty}</td>
                                <td>${this.discrepancy}</td> 
                                <td>${this.remarks}</td>
                                <td>${this.control_no}</td>
                                <td>${this.dr_control_no}</td>
                                <td>${this.first_name} ${this.last_name}</td>
                                <td>${this.created_at}</td>
                                <td>${flag}</td>
                            </tr>`;
                        x++;
                    });

                    $('#tbody_list_of_irreg').html(tr);
                    $('#thead_list_of_irreg').DataTable({
                        "scrollX": true,
                        "scrollY": true,
                        "paging": false,
                        "lengthChange": true,
                        "scrollY":        '50vh',
                        "scrollCollapse": true,
                        "searching": true,
                        "ordering": false,
                        "info": true,
                        "autoWidth": true,
                        "fnDrawCallback": function() {
                            $('#tbody_list_of_irreg td').each(function (){
                                if($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined' || $.trim($(this).text()) == 'null null'){
                                    $(this).text('');				
                                }
                              }); 
                          }
                    });
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
                UPDATE_IRREGULARITY.load_update_irregularity_list();
                // $('.loader').hide();
            })
        }
    };

    this_update_irregularity.update_status = (id,normal_status,irreg_type) =>
    {
        $('#txt_irreg_update_date_from').datepicker('setDate', date_today);
        $('#txt_irreg_update_date_to').datepicker('setDate', date_today);
        $('#txt_irreg_update_month_date_from').datepicker('setDate', date_today);
        $('#txt_irreg_update_month_date_to').datepicker('setDate', date_today);
    
        $('#txt_list_date_from').datepicker('setDate', date_today);
        $('#txt_list_date_to').datepicker('setDate', date_today);
        $('#txt_list_month_date_from').datepicker('setDate', date_today);
        $('#txt_list_month_date_to').datepicker('setDate', date_today);

        if (irreg_type != 'NO STOCK' && irreg_type != 'EXCESS')
        {
            if(normal_status != "FOR CHECKING")
            {
                Swal.fire(swal_options).then((result) => 
                {
                    if (result.value) 
                    {
                        instance.patch(`/irregularity-status`, 
                        {
                            id  : id
                        }).then((response) => 
                        {
                            if (result.value) 
                            {
                                Swal.fire('Success!', `The status has been updated.`, 'success')
                                document.getElementById('notification_success').play();
                            }
                            else 
                            {
                                toastr.error('There was a problem in updating the status. Please contact the administrator. Thank you', 'System Message')
                                document.getElementById('notification').play();
                            }
                        }).catch((error) => 
                        {
                            toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                            document.getElementById('notification').play();
                            console.log(error)
                        }).finally(() => 
                        {
                            UPDATE_IRREGULARITY.load_irregularity_list();
                            // $('.loader').hide();
                        })
                    }
                })
            }
            else
            {
                toastr.warning('Normal parts still for checking, please cancel irregularity for normal transaction. Thank you', 'System Message')
                document.getElementById('notification').play();
            }
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
                {
                    if (result.value) 
                    {
                        instance.patch(`/irregularity-status`, 
                        {
                            id  : id
                        }).then((response) => 
                        {
                            if (result.value) 
                            {
                                Swal.fire('Success!', `The status has been updated.`, 'success')
                                document.getElementById('notification_success').play();
                            }
                            else 
                            {
                                toastr.error('There was a problem in updating the status. Please contact the administrator. Thank you', 'System Message')
                                document.getElementById('notification').play();
                            }
                        }).catch((error) => 
                        {
                            toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                            document.getElementById('notification').play();
                            console.log(error)
                        }).finally(() => 
                        {
                            UPDATE_IRREGULARITY.load_irregularity_list();
                            // $('.loader').hide();
                        })
                    }
                })
        }
    };

    this_update_irregularity.enable_others = () => 
    {
        if ($('#slc_update_type_of_irreg').val() === 'OTHERS')
        {
            if (parseInt($('#txt_update_original').val()) == parseInt($('#txt_update_actual').val()))
            {
                toastr.error('Please check actual quantity', 'System Message')
                $('#slc_update_type_of_irreg').val('')
                $("#txt_update_others").val('');
                $("#txt_update_others").attr('placeholder', ''); 
                $('#txt_update_others').prop('disabled', 'disabled');
                $("#txt_update_actual").focus();
            }
            else if (parseInt($('#txt_update_original').val()) < parseInt($('#txt_update_actual').val()))
            {
                toastr.error('Item is excess', 'System Message')
                $('#slc_update_type_of_irreg').val('EXCESS')
                $("#txt_update_others").val('');
                $("#txt_update_others").attr('placeholder', ''); 
                $('#txt_update_others').prop('disabled', 'disabled');
                $("#slc_update_type_of_irreg").focus();
            }
            else
            {
                $('#txt_update_others').attr('readonly', false); 
                $('#txt_update_others').prop('disabled', false);
                $('#txt_update_others').val('');
                $("#txt_update_others").attr('placeholder', 'Input type of irregularity'); 
            }
        }
        else if ($('#slc_update_type_of_irreg').val() === 'NO STOCK') 
        {
            $("#txt_update_others").attr('placeholder', '');
            $('#txt_update_others').attr('readonly', true); 
            $('#txt_update_others').prop('disabled', true);
            $('#txt_update_others').val('');
         
            if (parseInt($("#txt_update_actual").val()) != 0)
            {
                toastr.error('Actual quantity is not equal to zero.', 'System Message')
                $('#slc_update_type_of_irreg').val('')
                $("#txt_update_others").val('');
                $("#txt_update_others").attr('placeholder', ''); 
                $('#txt_update_others').prop('disabled', 'disabled');
            }
        }

        else if ($('#slc_update_type_of_irreg').val() === 'EXCESS') 
        {
            $("#txt_update_others").attr('placeholder', '');
            $('#txt_update_others').attr('readonly', true); 
            $('#txt_update_others').prop('disabled', true);
            $('#txt_update_others').val('');
            
         
            if (parseInt($('#txt_update_original').val()) >= parseInt($('#txt_update_actual').val()))
            {
                toastr.error('Please check actual quantity', 'System Message')
                $('#slc_update_type_of_irreg').val('')
                $("#txt_update_others").val('');
                $("#txt_update_others").attr('placeholder', ''); 
                $('#txt_update_others').prop('disabled', 'disabled');
                $("#txt_update_actual").focus();
            }
        }
        else 
        {
         
            $("#txt_update_others").attr('placeholder', '');
            $('#txt_update_others').attr('readonly', true); 
            $('#txt_update_others').prop('disabled', true);
            $('#txt_update_others').val('');
            if (parseInt($('#txt_update_original').val()) == parseInt($('#txt_update_actual').val()))
            {
                toastr.error('Please check actual quantity', 'System Message')
                document.getElementById('notification').play();
                $('#slc_update_type_of_irreg').val('');
                $('#txt_update_actual').val('');
                $("#txt_update_actual").focus();
            }
            else if (parseInt($('#txt_update_actual').val()) > parseInt($('#txt_update_original').val()))
            {
                toastr.error('Please check actual quantity', 'System Message')
                document.getElementById('notification').play();
                $('#slc_update_type_of_irreg').val('');
                // $('#txt_update_actual').val('');
                $("#txt_update_actual").focus();
            }
            else
            {
               
                if (parseInt($('#txt_update_actual').val()) == 0)
                {
                    toastr.error('Please check actual quantity', 'System Message')
                    $('#txt_update_actual').val('');
                    $("#txt_update_actual").focus();
                }
                $('#txt_update_others').attr('readonly', true); 
                $("#txt_update_others").attr('placeholder', ''); 
                $('#txt_update_others').prop('disabled', 'disabled');
                
            }
        }
    };

    this_update_irregularity.onchange_actual_quantity = () => 
    {
        var barcode=$('#txt_update_barcode').val();
        if(barcode != null && barcode != '' && barcode != undefined)
        {
            var original     = $('#txt_update_original').val();
            var actual       = $('#txt_update_actual').val();
            var actual_length=($('#txt_update_actual').val()).length 
            original         =parseInt(original);
            actual           =parseInt(actual);
            var discrep      = original - actual;
        
            if(actual > original)
            {
                // toastr.warning('Please check actual quantity', 'System Message')
                // $('#txt_update_actual').val('');
                // $('#slc_update_type_of_irreg').prop('disabled',false);
                // $('#txt_update_actual').val('');
                // $('#txt_update_discrepancy').val(original);

                $('#slc_update_type_of_irreg').val('EXCESS');
                $('#txt_update_others').val('');
                $('#txt_update_others').prop('disabled',true);
                $('#txt_update_others').prop('readonly',true);
                $("#txt_update_others").attr('placeholder', '');
                $('#slc_update_type_of_irreg').prop('disabled',true);  
                $('#txt_update_discrepancy').val(discrep);
            }
            else
            {
                $('#slc_update_type_of_irreg').val('');
                if(actual == 0)
                {
                    $('#slc_update_type_of_irreg').val('NO STOCK');
                    $('#txt_update_others').val('');
                    $('#txt_update_others').prop('disabled',true);
                    $('#txt_update_others').prop('readonly',true);
                    $("#txt_update_others").attr('placeholder', '');
                    $('#slc_update_type_of_irreg').prop('disabled',true);  
                    $('#txt_update_discrepancy').val(original);
                    if(actual_length > 1)
                    {
                        $('#txt_update_actual').val('');
                        $('#txt_update_discrepancy').val(original);
                        $('#txt_update_others').val('');
                        $('#txt_update_others').prop('disabled',true);
                        $('#txt_update_others').prop('readonly',true);
                    }
                }
                else
                {
                    if($('#txt_update_actual').val().charAt(0)==0)
                    {
                        $('#txt_update_actual').val('');
                        $('#txt_update_discrepancy').val(original);
                        $('#slc_update_type_of_irreg').val('');
                        $('#slc_update_type_of_irreg').prop('disabled',false);
                        $('#slc_update_type_of_irreg').prop('readonly',false);
                    }
                    else
                    {
                        $('#txt_update_others').val('');
                        $('#txt_update_others').prop('disabled',true);
                        $('#txt_update_others').prop('readonly',true);
                        $("#txt_update_others").attr('placeholder', '');
                        $('#slc_update_type_of_irreg').prop('disabled',false);
                        $('#slc_update_type_of_irreg').prop('readonly',false);
                        $('#txt_update_discrepancy').val(discrep);
                    }
                
                }
            }
        }
        else
        {
            $('#txt_update_actual').val('');
            toastr.warning('Please input barcode first.', 'System Message')
        }
    };

    this_update_irregularity.update_irregularity = () => 
    {
        var irreg_type = '';
        var others = $('#txt_update_others').val();

        if ($('#slc_update_type_of_irreg').val() === '' ||  $('#txt_update_actual').val() === '' || $('#txt_update_remarks').val() === '')
        {
            toastr.error('Please complete inputs', 'System Message')
        }
        else if ($('#slc_update_type_of_irreg').val() === 'OTHERS' && $('#txt_update_others').val() === '')
        {
            toastr.error('Please complete inputs', 'System Message')
        }
        else if ($('#txt_update_discrepancy').val() === '')
        {
            toastr.error('Actual quantity must be equal or less than the Original quantity ', 'System Message')
        }
        else
        {
            if ($('#slc_update_type_of_irreg').val() === 'LACKING' || $('#slc_update_type_of_irreg').val() === 'NO STOCK' || $('#slc_update_type_of_irreg').val() === 'EXCESS')
            {
                irreg_type = $('#slc_update_type_of_irreg').val();
            }
            else
            {
                irreg_type = `OTHERS-${others}`;               
            }

            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                    instance.patch(`/irregularity`, 
                    {
                        ticket_no           : $('#txt_update_barcode').val(),
                        irregularity_type   : irreg_type,
                        actual_qty          : $('#txt_update_actual').val(),
                        discrepancy         : $('#txt_update_discrepancy').val(),
                        remarks             : $('#txt_update_remarks').val()
                    }).then((response) => 
                    {
                        if (result.value) 
                        {
                            Swal.fire('Success!', `The data has been updated.`, 'success')
                            document.getElementById('notification_success').play();
                            UPDATE_IRREGULARITY.clear_inputs();
                        }
                        else 
                        {
                            toastr.error('There was a problem in updating the data. Please contact the administrator. Thank you', 'System Message')
                            document.getElementById('notification').play();
                        }
                    }).catch((error) => 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                        console.log(error)
                    }).finally(() => 
                    {
                        UPDATE_IRREGULARITY.load_update_irregularity_list();
                        UPDATE_IRREGULARITY.load_irregularity_list();
                        // $('.loader').hide();
                    })
                }
            })
        }
    };

    this_update_irregularity.delete_irregularity = (id) => 
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                instance.delete(`/irregularity`, 
                {
                    params: ({
                                id : id
                            })
                }).then((response) => 
                {
                    if (result.value) 
                    {
                        Swal.fire('Success!', `The data has been deleted.`, 'success')
                        document.getElementById('notification_success').play();
                    }
                    else 
                    {
                        toastr.error('There was a problem in deleting the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                    }
                }).catch((error) => 
                {
                    toastr.error('There was a problem in deleting the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();
                    console.log(error)
                }).finally(() => 
                {
                    UPDATE_IRREGULARITY.load_update_irregularity_list();
                    UPDATE_IRREGULARITY.load_irregularity_list();
                    // $('.loader').hide();
                })
            }
        });
    };

    this_update_irregularity.clear_inputs = () => 
    {
        $('#txt_update_barcode').val('');
        $('#txt_update_status').val('');
        $('#slc_update_type_of_irreg').val('');
        $('#txt_update_others').val('');
        $('#txt_update_order_download_no').val('');
        $('#txt_update_stock_address').val('');
        $('#txt_update_part_no').val('');
        $('#txt_update_part_name').val('');
        $('#txt_update_original').val('');
        $('#txt_update_actual').val('');
        $('#txt_update_discrepancy').val('');
        $('#txt_update_remarks').val('');
    };

    return this_update_irregularity;
})();
