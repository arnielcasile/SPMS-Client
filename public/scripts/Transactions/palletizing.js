$(document).ready(() => {
    PALLETIZING.load();
    PALLETIZING.get_ongoing_palletizing();
    PALLETIZING.adjust_ongoing_tab();
});

const PALLETIZING = (() => 
{
    var tbl_normal_palletizing = $('#tbl_normal_palletizing').DataTable(
        {
            "paging"        : false,
            "lengthChange"  : true,
            "searching"     : true,
            "ordering"      : true,
            "info"          : true,
            "autoWidth"     : false,
            'scrollY'       : '80vh',
            'scrollCollapse': true,
        });

    var tbl_irreg_palletizing = $('#tbl_irreg_palletizing').DataTable(
        {
            "paging"        : false,
            "lengthChange"  : true,
            "searching"     : true,
            "ordering"      : true,
            "info"          : true,
            "autoWidth"     : false,
            'scrollY'       : '80vh',
            'scrollCollapse': true,
        });

    let this_palletizing = {};
    let process = {};
    let process_edit = {};
    let irreg_type_normal = [];
    let irreg_type_irreg = [];
    let barcode_list = [];


    this_palletizing.load = () => 
    {
        instance.get(`palletizing-delivery-type`).then(function (response) 
        {
            var delivery_type = "";
            delivery_type = `<option selected disabled value="">Choose...</option>`;

            $.each(response['data'].data, function () 
            {
                delivery_type += `<option class="select-option" value="${this.id}">${this.delivery_type}</option>`;
                $("#slc_delivery_type").html(delivery_type);
                $("#slc_edit_delivery_type").html(delivery_type);

            });
        }).catch(function (error) 
        {
            toastr.error('There was a problem in updating the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() => { })
    };

    this_palletizing.allow_input = () => 
    {
        var delivery_type = $('#slc_delivery_type').val();
        var delivery_number = $('#txt_delivery_number').val();
        if (delivery_type == null || delivery_number == '') 
        {
            $("#txt_barcode").attr("disabled", "disabled");
            $("#txt_ord_no").attr("disabled", "disabled");
            $("#txt_total_item").attr("disabled", "disabled");
            PALLETIZING.clear_inputs();
        }
        else 
        {
            $("#txt_barcode").removeAttr("disabled");
            $("#txt_total_item").removeAttr("disabled");
        }
    };

    this_palletizing.clear_inputs = () => 
    {
        $('#txt_barcode').val('');
        $("#txt_barcode").focus()
    };

    this_palletizing.clear_all_inputs = () => 
    {
        $('#txt_barcode').val('');
        $('#txt_ord_no').val('');
        $('#slc_delivery_type').val('');
        $('#txt_destination_code').val('');
        $('#txt_manufacturing').val('');
        $('#txt_ord_no').val('');
    };

    this_palletizing.barcode = () => 
    {
        var keycode = (event.keyCode ? event.keyCode : event.which);//event on keypress enter
        if (keycode == '13')//event on keypress enter
        {
            var barcode = $('#txt_barcode').val();
            $("#txt_barcode").blur();
            PALLETIZING.barcode_event(barcode);
        }
    };

    this_palletizing.barcode_event = (barcode) => 
    {
        instance.get(`palletizing`,
        {
            params:
                ({
                    ticket_no: barcode
                }),
        }).then((response) => 
        {
            if (response['statusText'] == 'OK') 
            {
                var data = response.data.data[0];
                if (response.data.data.length === 0) 
                {
                    toastr.warning('No data matched in the database. Thank you', 'System Message')
                    document.getElementById('notification').play();
                    PALLETIZING.clear_inputs();
                }
                else 
                {
                    if(data.dest_deleted_at != null)
                    {
                        toastr.warning('Destination Code is disabled. Thank you', 'System Message')
                    }
                    else
                    {
                        if (support_status == 1) 
                        {
                            PALLETIZING.enter_condition(data);
                        }
                        else 
                        {
                            if (data.area_code == area_code) 
                            {
                                PALLETIZING.enter_condition(data);
                            }
                            else 
                            {
                                toastr.warning('Area Code is not same.', 'System Message');
                                document.getElementById('notification').play();
                                PALLETIZING.clear_inputs();
                            }
                        }
                    }
                }
            }
        }).catch((error) => 
        {
            toastr.error('There was a problem in updating the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() => 
        { 

        })
    };

    this_palletizing.enter_condition = (data) => 
    {
        process = data;
        process.ticket_no = $("#txt_barcode").val();
        process.delivery_type = $("#slc_delivery_type option:selected").html();
        process.delivery_type_val = $('#slc_delivery_type').val();
        process.delivery_no = $('#txt_delivery_number').val();
        process.item_no = data.item_no;
        process.delivery_qty = data.delivery_qty;
        process.order_download_no = data.order_download_no;
        process.pdl = data.pdl;
        process.destination_code = data.destination_code;
        process.manufacturing_no = data.manufacturing_no;
        if (data.destination == null)
        {
            toastr.warning('Please register Destination Code in system before proceeding in this process, Thank You', 'System Message')
            document.getElementById('notification').play();
            PALLETIZING.clear_inputs();
        }
        else
        {
            if (data.pdl == 0) 
            {
                if ($("#txt_area_code_hidden").val() == data.area_code || $("#txt_area_code_hidden").val() == "") 
                {
                    $("#txt_ord_no").removeAttr("disabled");
                    $("#txt_destination_code").attr("disabled", "disabled");
                    $("#txt_manufacturing").attr("disabled", "disabled");
                    PALLETIZING.enter_condition_order_download_no(data, process);
                }
                else 
                {
                    toastr.warning('Cannot add diffent area code on the table, Thank you', 'System Message')
                    document.getElementById('notification').play();
                    PALLETIZING.clear_inputs();
                }
            }
            else 
            {
                if ($("#txt_area_code_hidden").val() == data.area_code || $("#txt_area_code_hidden").val() == "") 
                {
                    $("#txt_ord_no").attr("disabled", "disabled");
                    $("#txt_destination_code").removeAttr("disabled");
                    $("#txt_manufacturing").removeAttr("disabled");
                    PALLETIZING.enter_condition_payee_code_manufacturing(data, process);
                }
                else 
                {
                    toastr.warning('Cannot add diffent area_code on the table, Thank you', 'System Message')
                    document.getElementById('notification').play();
                    PALLETIZING.clear_inputs();
                }
            }
        }
    };

    this_palletizing.enter_condition_order_download_no = (data, process) => 
    {
        $("#txt_destination_code").val();
        $("#txt_manufacturing").val();
        if ($('#txt_ord_no').val() === '' && $('#txt_destination_code').val() === '')
        {
            // $('#txt_order_download_no').val(data.order_download_no);
            $('#txt_ord_no').val(data.order_download_no);
            $('#txt_destination_code').val(data.destination_code);
            $('#txt_area_code_hidden').val(data.area_code);

            if ((data.completion != null && data.irreg_status === "FOR PALLETIZING") && (data.normal != null && data.normal_status === "FOR PALLETIZING"))//parehong papasukan
            {
                if (data.irreg_type == 'NO STOCK' || data.irreg_type == 'EXCESS')
                {
                    PALLETIZING.onclick_completion();
                }
                else
                {
                    $('#btn_normal').attr("disabled", false);
                    $('#btn_completion').attr("disabled", false);
                    $('#mod_palletizing').modal('show');
                }
            }
            else if ((data.completion != null && data.irreg_status != "FOR PALLETIZING") && (data.normal != null && data.normal_status === "FOR PALLETIZING"))//enable sa normal
            {
                $('#btn_normal').attr("disabled", false);
                $('#btn_completion').attr("disabled", true);
                $('#mod_palletizing').modal('show');
            }
            else if ((data.completion != null && data.irreg_status === "FOR PALLETIZING") && (data.normal != null && data.normal_status != "FOR PALLETIZING"))//enable sa irregularity
            {
                $('#btn_completion').attr("disabled", false);
                $('#btn_normal').attr("disabled", true);
                $('#mod_palletizing').modal('show');
            }
            else if (data.completion != null && data.irreg_status === "FOR PALLETIZING") 
            {
                $('#mod_palletizing').modal('show');
            }
            else if (data.completion == null && data.normal != null && data.normal_status === "FOR PALLETIZING") 
            {
                process = data;
                process.process = 'NORMAL';
                PALLETIZING.fill_tbl_normal_palletizing(process)
            }
            else 
            {
                var tbl_normal = tbl_normal_palletizing.rows().data();
                var tbl_irreg = tbl_irreg_palletizing.rows().data();

                if (tbl_normal.length < 1 && tbl_irreg.length < 1)
                {
                    toastr.warning('Not for palletizing, Thank you', 'System Message')
                    document.getElementById('notification').play();
                    PALLETIZING.clear_inputs();
                    $('#txt_destination_code').val('');
                    $('#txt_manufacturing').val('');
                    $('#txt_ord_no').val('');
                    $('#txt_area_code_hidden').val('');
                }
                else
                {
                    toastr.warning('Not for palletizing, Thank you', 'System Message')
                    document.getElementById('notification').play();
                    PALLETIZING.clear_inputs();
                }
            }
        }
        else if (($('#txt_ord_no').val() != data.order_download_no) || ($('#txt_destination_code').val() != data.destination_code)) 
        {
            toastr.warning('Please select similar OrderDownload No, Thank you', 'System Message')
            document.getElementById('notification').play();
            PALLETIZING.clear_inputs();
        }
        else if (($('#txt_ord_no').val() == data.order_download_no) && ($('#txt_destination_code').val() == data.destination_code)) 
        {
            // $('#txt_order_download_no').val(data.order_download_no);
            $('#txt_ord_no').val(data.order_download_no);
            $('#txt_destination_code').val(data.destination_code);
            $('#txt_area_code_hidden').val(data.area_code);
            if ((data.completion != null && data.irreg_status === "FOR PALLETIZING") && (data.normal != null && data.normal_status === "FOR PALLETIZING"))//parehong papasukan
            {
                if (data.irreg_type == 'NO STOCK' || data.irreg_type == 'EXCESS')
                {
                    PALLETIZING.onclick_completion();
                }
                else
                {
                    $('#btn_normal').attr("disabled", false);
                    $('#btn_completion').attr("disabled", false);
                    $('#mod_palletizing').modal('show');
                }

            }
            else if ((data.completion != null && data.irreg_status != "FOR PALLETIZING") && (data.normal != null && data.normal_status === "FOR PALLETIZING"))//enable sa normal
            {
                $('#btn_normal').attr("disabled", false);
                $('#btn_completion').attr("disabled", true);
                $('#mod_palletizing').modal('show');
            }
            else if ((data.completion != null && data.irreg_status === "FOR PALLETIZING") && (data.normal != null && data.normal_status != "FOR PALLETIZING"))//enable sa irregularity
            {
                $('#btn_completion').attr("disabled", false);
                $('#btn_normal').attr("disabled", true);
                $('#mod_palletizing').modal('show');
            }
            else if (data.completion != null && data.irreg_status === "FOR PALLETIZING") 
            {
                $('#mod_palletizing').modal('show');
            }
            else if (data.completion == null && data.normal != null && data.normal_status === "FOR PALLETIZING") 
            {
                process = data;
                process.process = 'NORMAL';
                PALLETIZING.fill_tbl_normal_palletizing(process)
            }
            else 
            {
                toastr.warning('Not for palletizing, Thank you', 'System Message')
                document.getElementById('notification').play();
                PALLETIZING.clear_inputs();
            }
        }
    };


    this_palletizing.enter_condition_payee_code_manufacturing = (data, process) => 
    {
        $('#txt_ord_no').val()
        if ($('#txt_destination_code').val() === '' && $("#txt_manufacturing").val() === '') 
        {
            if ((data.completion != null && data.irreg_status === "FOR PALLETIZING") && (data.normal != null && data.normal_status === "FOR PALLETIZING"))//parehong papasukan
            {
                if (data.irreg_type == 'NO STOCK' || data.irreg_type == 'EXCESS')
                {
                    $("#txt_destination_code").val(data.destination_code);
                    $("#txt_ord_no").val(data.order_download_no);
                    $("#txt_manufacturing").val(data.manufacturing_no);
                    $("#txt_area_code_hidden").val(data.area_code);
                    PALLETIZING.onclick_completion();
                }
                else
                {
                    $("#txt_destination_code").val(data.destination_code);
                    $("#txt_ord_no").val(data.order_download_no);
                    $("#txt_manufacturing").val(data.manufacturing_no);
                    $("#txt_area_code_hidden").val(data.area_code);
                    $('#btn_completion').attr("disabled", false);
                    $('#btn_normal').attr("disabled", false);
                    $('#mod_palletizing').modal('show');
                }
            }
            else if ((data.completion != null && data.irreg_status != "FOR PALLETIZING") && (data.normal != null && data.normal_status === "FOR PALLETIZING"))//enable sa normal
            {
                $("#txt_destination_code").val(data.destination_code);
                $("#txt_ord_no").val(data.order_download_no);
                $("#txt_manufacturing").val(data.manufacturing_no);
                $("#txt_area_code_hidden").val(data.area_code);
                $('#btn_completion').attr("disabled", true);
                $('#btn_normal').attr("disabled", false);
                $('#mod_palletizing').modal('show');

            }
            else if ((data.completion != null && data.irreg_status === "FOR PALLETIZING") && (data.normal != null && data.normal_status != "FOR PALLETIZING"))//enable sa irregularity
            {
                $("#txt_destination_code").val(data.destination_code);
                $("#txt_ord_no").val(data.order_download_no);
                $("#txt_manufacturing").val(data.manufacturing_no);
                $("#txt_area_code_hidden").val(data.area_code);
                $('#btn_completion').attr("disabled", false);
                $('#btn_normal').attr("disabled", true);
                $('#mod_palletizing').modal('show');
            }
            else if (data.completion != null && data.irreg_status === "FOR PALLETIZING") 
            {
                $("#txt_destination_code").val(data.destination_code);
                $("#txt_ord_no").val(data.order_download_no);
                $("#txt_manufacturing").val(data.manufacturing_no);
                $("#txt_area_code_hidden").val(data.area_code);
                $('#mod_palletizing').modal('show');
            }
            else if (data.completion == null && data.normal != null && data.normal_status === "FOR PALLETIZING") 
            {
                process = data;
                process.process = 'NORMAL';
                $("#txt_ord_no").val(data.order_download_no);
                $("#txt_destination_code").val(data.destination_code);
                $("#txt_manufacturing").val(data.manufacturing_no);
                $("#txt_area_code_hidden").val(data.area_code);
                PALLETIZING.fill_tbl_normal_palletizing(process)
            }
            else 
            {
                toastr.warning('Not for palletizing, Thank you', 'System Message')
                document.getElementById('notification').play();
                PALLETIZING.clear_inputs();
            }
        }
        else if ($('#txt_destination_code').val() != data.destination_code || $("#txt_manufacturing").val() != data.manufacturing_no) 
        {
            toastr.warning('Please select similar destination code and manufacturing, Thank you', 'System Message')
            document.getElementById('notification').play();
            PALLETIZING.clear_inputs();
        }
        else if ($('#txt_destination_code').val() === data.destination_code && $("#txt_manufacturing").val() === data.manufacturing_no) 
        {
            if ($('#txt_ord_no').val() == data.order_download_no)
            {
                $("#txt_destination_code").val(data.destination_code);
                $("#txt_ord_no").val(data.order_download_no);
                $("#txt_manufacturing").val(data.manufacturing_no);
                $("#txt_area_code_hidden").val(data.area_code);
                if ((data.completion != null && data.irreg_status === "FOR PALLETIZING") && (data.normal != null && data.normal_status === "FOR PALLETIZING"))//parehong papasukan
                {
                    if (data.irreg_type == 'NO STOCK' || data.irreg_type == 'EXCESS')
                    {
                        PALLETIZING.onclick_completion();
                    }
                    else
                    {                    
                        $('#btn_completion').attr("disabled", false);
                        $('#btn_normal').attr("disabled", false);
                        $('#mod_palletizing').modal('show');
                    }
                }
                else if ((data.completion != null && data.irreg_status != "FOR PALLETIZING") && (data.normal != null && data.normal_status === "FOR PALLETIZING"))//enable sa normal
                {
                    $('#btn_normal').attr("disabled", false);
                    $('#btn_completion').attr("disabled", true);
                    $('#mod_palletizing').modal('show');
                }
                else if ((data.completion != null && data.irreg_status === "FOR PALLETIZING") && (data.normal != null && data.normal_status != "FOR PALLETIZING"))//enable sa irregularity
                {
                    $('#btn_completion').attr("disabled", false);
                    $('#btn_normal').attr("disabled", true);
                    $('#mod_palletizing').modal('show');
                }
                else if (data.completion != null && data.irreg_status === "FOR PALLETIZING") 
                {
                    $("#txt_destination_code").val(data.destination_code);
                    $("#txt_ord_no").val(data.order_download_no);
                    $("#txt_manufacturing").val(data.manufacturing_no);
                    $("#txt_area_code_hidden").val(data.area_code);
                    $('#mod_palletizing').modal('show');
                }
                else if (data.completion == null && data.normal != null && data.normal_status === "FOR PALLETIZING") 
                {
                    process = data;
                    process.process = 'NORMAL';
                    $("#txt_destination_code").val(data.destination_code);
                    $("#txt_ord_no").val(data.order_download_no);
                    $("#txt_manufacturing").val(data.manufacturing_no);
                    $("#txt_area_code_hidden").val(data.area_code);
                    PALLETIZING.fill_tbl_normal_palletizing(process)
                }
                else 
                {
                    toastr.warning('Not for palletizing, Thank you', 'System Message')
                    document.getElementById('notification').play();
                    PALLETIZING.clear_inputs();
                }
            }
            else
            {
                toastr.warning('Please select same Order Download No.,Thank You', 'System Message')
                document.getElementById('notification').play();
                PALLETIZING.clear_inputs();
            }
        }
    };

    this_palletizing.onclick_normal = () => 
    {
        PALLETIZING.fill_tbl_normal_palletizing(process)
        PALLETIZING.count_table_length();
        $('#mod_palletizing').modal('hide');
    };

    this_palletizing.onclick_completion = () => 
    {
        process.process = 'COMPLETION';
        PALLETIZING.fill_tbl_irreg_palletizing(process)
        PALLETIZING.count_table_length();
        $('#mod_palletizing').modal('hide');
    };

    this_palletizing.count_table_length = () => 
    {
        var tbl_data_normal = tbl_normal_palletizing.rows().data();
        var tbl_data_irreg = tbl_irreg_palletizing.rows().data();
        var total_items = tbl_data_normal.length + tbl_data_irreg.length;

        $('#nrm_qty').text(tbl_data_normal.length);
        $('#irr_qty').text(tbl_data_irreg.length);
        if (total_items > 0) 
        {
            $('#txt_total_item').val(total_items);
            $('#txt_barcode').val('');
            PALLETIZING.cancel_transaction_modal();
            $("#txt_ord_no").attr("disabled", "disabled");
            
        }
        else if (total_items == 0)
        {
            PALLETIZING.clear_inputs();
        }
    };

    this_palletizing.fill_tbl_normal_palletizing = (normal_data) => 
    {
        var tbl_normal = tbl_normal_palletizing.rows().data();

        var str_irreg = $('#txt_barcode').val().replace(/\s/g, '');
        var dataCount_irreg = tbl_irreg_palletizing.rows(`:contains("${str_irreg}")`).data().length;
        if (dataCount_irreg < 1) 
        {
            var str = $('#txt_barcode').val().replace(/\s/g, '');
            var dataCount = tbl_normal_palletizing.rows(`:contains("${str}")`).data().length;
            if (dataCount < 1) 
            {
                document.getElementById('notification_success').play();
                tbl_normal_palletizing.row.add([
                    normal_data.ticket_no,
                    normal_data.delivery_type,
                    normal_data.delivery_no,
                    normal_data.item_no,
                    normal_data.delivery_qty,
                    normal_data.order_download_no,
                    '<button class="btn btn-danger delete_normal"><i class="fa fa-trash"></i></button>',
                    normal_data.process,
                    normal_data.delivery_type_val
                ]).draw(false);
                process = {};
                PALLETIZING.count_table_length();
                irreg_type_normal.push(normal_data.irreg_type);
            }
            else
            { 
                toastr.warning('Record already exists', 'System Message')
                document.getElementById('notification').play();
                PALLETIZING.clear_inputs();
            }
        }
        else
        {
            toastr.warning('This ticket has complete item. Please cancel irregularity, Thank You!', 'System Message')
            document.getElementById('notification').play();
            PALLETIZING.clear_inputs();
        } 
    };

    this_palletizing.fill_tbl_irreg_palletizing = (irreg_data) => 
    {
        var tbl_irreg = tbl_irreg_palletizing.rows().data();

        var str = $('#txt_barcode').val().replace(/\s/g, '');
        var dataCount = tbl_normal_palletizing.rows(`:contains("${str}")`).data().length;
        if (dataCount < 1) 
        {

            if (process.normal_status == "FOR PALLETIZING" && (process.irreg_type != "NO STOCK" && process.irreg_type != "EXCESS"))
            {
                toastr.warning('Normal Parts still "FOR PALLETIZING". Cancel irregulatity if item was already complete', 'System Message')
                document.getElementById('notification').play();
                setTimeout(function(){
                    PALLETIZING.clear_inputs();
                }, 300);
            }
            else
            {
                var str_irreg = $('#txt_barcode').val().replace(/\s/g, '');
                var dataCount_irreg = tbl_irreg_palletizing.rows(`:contains("${str_irreg}")`).data().length;
                if (dataCount_irreg < 1) 
                {
                    document.getElementById('notification_success').play();
                    tbl_irreg_palletizing.row.add([
                        irreg_data.ticket_no,
                        irreg_data.delivery_type,
                        irreg_data.delivery_no,
                        irreg_data.item_no,
                        irreg_data.delivery_qty,
                        irreg_data.order_download_no,
                        '<button class="btn btn-danger delete_irreg"><i class="fa fa-trash"></i></button>',
                        irreg_data.process,
                        irreg_data.delivery_type_val
                    ]).draw(false);
                    PALLETIZING.count_table_length();
                    process = {};
                    irreg_type_irreg.push(irreg_data.irreg_type);
                }
                else
                {
                    toastr.warning('Record already exists', 'System Message')
                    document.getElementById('notification').play();
                    PALLETIZING.clear_inputs();
                }
            }
        }
        else
        {
            toastr.warning('This ticket has complete item. Please cancel irregularity, Thank You!', 'System Message')
            document.getElementById('notification').play();
            PALLETIZING.clear_inputs();
        } 
    };

    this_palletizing.fill_normal_irregularity = (data) => 
    {
        var tbl_normal = tbl_normal_palletizing.rows().data();
        var tbl_irreg = tbl_irreg_palletizing.rows().data();

        var str_irreg = $('#txt_barcode').val().replace(/\s/g, '');
        var dataCount_irreg = tbl_irreg_palletizing.rows(`:contains("${str_irreg}")`).data().length;
        if (dataCount_irreg < 1) 
        {
            var str = $('#txt_barcode').val().replace(/\s/g, '');
            var dataCount = tbl_normal_palletizing.rows(`:contains("${str}")`).data().length;
            if (dataCount < 1) 
            {
                document.getElementById('notification_success').play();
                tbl_normal_palletizing.row.add([
                    data.ticket_no,
                    data.delivery_type,
                    data.delivery_no,
                    data.item_no,
                    data.delivery_qty,
                    data.order_download_no,
                    '<button class="btn btn-danger delete_normal"><i class="fa fa-trash"></i></button>',
                    'NORMAL',
                    data.delivery_type_val
                ]).draw(false);
            }
            else
            {
                toastr.warning('Record already exists', 'System Message')
                document.getElementById('notification').play();
                PALLETIZING.clear_inputs();
            }
            var dataCount1 = tbl_irreg_palletizing.rows(`:contains("${str}")`).data().length;
            if (dataCount1 < 1) 
            {
                document.getElementById('notification_success').play();
                tbl_irreg_palletizing.row.add([
                    data.ticket_no,
                    data.delivery_type,
                    data.delivery_no,
                    data.item_no,
                    data.delivery_qty,
                    data.order_download_no,
                    '<button class="btn btn-danger delete_irreg"><i class="fa fa-trash"></i></button>',
                    'COMPLETION',
                    data.delivery_type_val
                ]).draw(false);
                PALLETIZING.count_table_length();
                process = {};
            }
            else
            {
                toastr.warning('Record already exists', 'System Message')
                document.getElementById('notification').play();
                PALLETIZING.clear_inputs();
            }
        }
        else
        {
            toastr.warning('This ticket has complete item. Please cancel irregularity, Thank You!', 'System Message')
            document.getElementById('notification').play();
            PALLETIZING.clear_inputs();
        } 
            
    };

    $('#tbl_normal_palletizing tbody').on('click', 'button.delete_normal', function () 
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                tbl_normal_palletizing
                    .row($(this).parents('tr'))
                    .remove()
                    .draw();
                var tbl_normal = tbl_normal_palletizing.rows().data();
                PALLETIZING.count_table_length();
                PALLETIZING.clear_inputs();
                toastr.success('Successfully Deleted', 'System Message')
            }
        })
    });

    $('#tbl_irreg_palletizing tbody').on('click', 'button.delete_irreg', function () 
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                tbl_irreg_palletizing
                    .row($(this).parents('tr'))
                    .remove()
                    .draw();
                var tbl_irreg = tbl_irreg_palletizing.rows().data();
                PALLETIZING.count_table_length();
                toastr.success('Successfully Deleted', 'System Message')
            }
        })
    });

    this_palletizing.data_for_saving = () => 
    {
        var tbl_normal = tbl_normal_palletizing.rows().data();
        var tbl_irreg = tbl_irreg_palletizing.rows().data();

        if (tbl_normal.length < 1 && tbl_irreg.length < 1)
        {
            toastr.warning('Tables must not be empty, Thank you!', 'System Message')
            document.getElementById('notification').play();
            PALLETIZING.clear_inputs();
        }
        else 
        {
            let data = [];
            if (tbl_normal.length > 0) 
            {
                for (var x = 0; x < tbl_normal.length; x++) 
                {
                    var normal_rows = tbl_normal_palletizing.rows(x).data();
                    data.push
                        ({
                            "ticket_no": normal_rows[0][0],
                            "delivery_type": normal_rows[0][8],
                            "delivery_no": normal_rows[0][2],
                            "item_no": normal_rows[0][3],
                            "delivery_qty": normal_rows[0][4],
                            "order_download_no": normal_rows[0][5],
                            "process": 'NORMAL',
                            "users_id": user_id,
                            "irreg_type": irreg_type_normal[x]
                        });
                }
            }
            if (tbl_irreg.length > 0) 
            {
                for (var y = 0; y < tbl_irreg.length; y++) 
                {
                    var irreg_rows = tbl_irreg_palletizing.rows(y).data();
                    data.push
                    ({
                        "ticket_no": irreg_rows[0][0],
                        "delivery_type": irreg_rows[0][8],
                        "delivery_no": irreg_rows[0][2],
                        "item_no": irreg_rows[0][3],
                        "delivery_qty": irreg_rows[0][4],
                        "order_download_no": irreg_rows[0][5],
                        "process": 'COMPLETION',
                        "users_id": user_id,
                        "irreg_type": irreg_type_irreg[y]
                    });
                }
            }
            PALLETIZING.insert_palletizing(data);
        }
    };

    this_palletizing.insert_palletizing = (data) => 
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                $('#btn_for_palletizing_update').prop('disabled', true)
                instance.post(`palletizing`,
                {
                    data: data
                }).then((response) => 
                {
                    Swal.fire('Success!', `Data successfully added!`, 'success')
                    document.getElementById('notification_success').play();
                    tbl_normal_palletizing.clear().draw();
                    tbl_irreg_palletizing.clear().draw();
                    PALLETIZING.clear_all_inputs();
                    PALLETIZING.get_ongoing_palletizing();
                    PALLETIZING.count_table_length();
                    

                    PALLETIZING.clear_inputs();
                    $("#txt_barcode").attr("disabled", "disabled");
                    $("#txt_ord_no").attr("disabled", "disabled");
                    $("#txt_total_item").attr("disabled", "disabled");
                    $("#txt_destination_code").attr("disabled", "disabled");
                    $("#txt_manufacturing").attr("disabled", "disabled");
                    $('#txt_delivery_number').val('');
                    $('#txt_destination_code').val('');
                    $('#slc_delivery_type').val('');
                    $('#txt_manufacturing').val('');
                    $('#txt_ord_no').val('');
                    $('#txt_total_item').val('');
                    $('#txt_area_code_hidden').val('');

                    
                    irreg_type_irreg = [];
                    irreg_type_normal = [];
                }).catch((error) => 
                {
                    toastr.error('There was a problem in adding the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();
                    console.log(error);
                }).finally(() => { 
                    $('#btn_for_palletizing_update').prop('disabled', false)
                })
            }
        });
    };

    this_palletizing.get_ongoing_palletizing = () => //ongoing palletizing panel template
    {
        instance.get(`load-ongoing-palletizing`,
        {
            params:
                ({
                    area_code: area_code
                }),
        }).then((response) => 
        {
            
            if (response['statusText'] == 'OK') 
            {
                var data = response.data.data;
                if (data.length === 0) 
                {
                    $('#tbl_palletizing_masterlist').DataTable().destroy();
                    $('#tbody_tbl_palletizing_masterlist').empty();
                    $("#btn_toggle").click();
                    toastr.warning('No On-going Palletizing data. Thank you', 'System Message')
                    document.getElementById('notification').play();
                }
                else 
                {
                    PALLETIZING.fill_tbl_palletizing_masterlist(data);
                }
            }
        }).catch((error) => 
        {
            toastr.error('There was a problem in adding the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error);
        }).finally(() => { })
    };

    this_palletizing.fill_tbl_palletizing_masterlist = (ongoing_data) =>  //ongoing palletizing panel plotting
    {
        $('#tbl_palletizing_masterlist').DataTable().destroy();
        $('#tbody_tbl_palletizing_masterlist').empty();

        var tr = '';
        let counter = 1;

        $.each(ongoing_data, function () 
        {
            tr += `<tr>
            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.order_download_no}</td> 
            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.dr_control}</td>
            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_type}</td>
            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_no}</td> 
            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.payee_name}</td>
            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.manufacturing_no}</td>
            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.total_items}</td>
            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
            <button class="btn btn-warning btn-sm" onclick="PALLETIZING.fill_tbl_edit_palletizing_masterlist('${this.dr_control}', '${this.order_download_no}')"
                title="Edit palletizing"><i class="fa fa-pencil"></i></button>&nbsp;
            <button class="btn btn-success btn-sm" onclick="PALLETIZING.open_modal_for_finish('${this.dr_control}');" 
                title="Finish palletizing"><i class="fa fa-thumbs-up"></i></button>
        </td>
          
        </tr>`;
        counter++;
        });
        $('#tbody_tbl_palletizing_masterlist').html(tr);
        $('#tbl_palletizing_masterlist').DataTable({
        rowsGroup       : [0, 1, 7, 2, 3,4],
        "paging"        : false,
        "lengthChange"  : false,
        "searching"     : true,
        "ordering"      : false,
        "info"          : true,
        "autoWidth"     : false,
        'scrollCollapse': true,
        }
        );

     
    };

    this_palletizing.finish_palletizing_masterlist = (dr_control_no) => 
    {
        $('#mod_finish_palletizing').modal('show');
        $('#txt_dr_no').val(dr_control_no);
    }

    this_palletizing.finish_palletizing_clear_inputs = () => 
    {
        $('#txt_dr_no').val('0');
        $('#txt_pallet').val('0');
        $('#txt_pcase').val('0');
        $('#txt_box').val('0');
        $('#txt_bag').val('0');
    }

    this_palletizing.fill_tbl_edit_palletizing_masterlist = (dr_control_no, order_download_no) =>  // editing list after clicking edit button in masterlist
    {
        
        var tbl_normal = tbl_normal_palletizing.rows().data();
        var tbl_irreg = tbl_irreg_palletizing.rows().data();

        if (tbl_normal.length < 1 && tbl_irreg.length < 1)
        {   
            PALLETIZING.fill_tbl_edit_palletizing_masterlist_final(dr_control_no, order_download_no);  
        }
        else
        {
            toastr.warning('For palletizing table has data', 'System Message')
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                    PALLETIZING.fill_tbl_edit_palletizing_masterlist_final(dr_control_no, order_download_no);  
                    PALLETIZING.clear_entered_data();   
                }
            });

        }

        
    };

    this_palletizing.fill_tbl_edit_palletizing_masterlist_final = (dr_control_no, order_download_no) =>
    {
        $('#div_ongoing_palletizing').prop('hidden', true);
        $('#div_edit_palletizing').prop('hidden', false);
        $('#div_for_palletizing').prop('hidden', true);
        $('#txt_edit_ord_no').val(order_download_no);

        $('#tbl_edit_palletizing_masterlist').DataTable().destroy();
        $('#tbody_tbl_edit_palletizing_masterlist').empty();
        $('#div_edit_masterlist').css("display", "block");
        $('#txt_edit_dr_control').val(dr_control_no);
        var tr = '';
        instance.get(`palletizing-get-items`,
        {
            params:
                ({
                    dr_control: dr_control_no
                }),
        }).then((response) => 
        {
            if (response['statusText'] == 'OK') 
            {
                var data = response.data.data;
                barcode_list = [];
                if (response.data.data.length === 0) 
                {
                    toastr.warning('No On-going Palletizing data. Thank you', 'System Message')
                    PALLETIZING.cancel_edit_palletizing();
                    document.getElementById('notification').play();
                }
                else 
                {
                    document.getElementById('notification_success').play();
                    $('#tbl_edit_palletizing_masterlist').DataTable().destroy();
                    $('#tbody_tbl_edit_palletizing_masterlist').empty();
                    $('#txt_edit_destination_code').val(data[0].destination_code);
                    $('#txt_edit_manufacturing').val(data[0].manufacturing_no);
                    $('#txt_edit_dr_control_display').val(data[0].dr_control);

                    var count = 0;
                    $.each(data, function () 
                    {
                        barcode_list.push(this.ticket_no)
                        count++;
                        tr += `<tr>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${count}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_no}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_type}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_no}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.item_no}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_qty}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.order_download_no}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                        <button class="btn btn-danger btn-sm" onclick="PALLETIZING.remove_palletizing(${this.id}, '${this.ticket_no}', '${this.dr_control}', '${this.process}','${this.irreg_type}',${count})">
                                        <i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>`;
                    });
                    $('#tbody_tbl_edit_palletizing_masterlist').html(tr);
                    $('#tbl_edit_palletizing_masterlist').DataTable({
                        rowsGroup: [0, 1, 2, 5],
                        "scrollX"       : true,
                        "scrollY"       : '250px',
                        "scrollCollapse": true,
                        "paging"        : false,
                        "lengthChange"  : true,
                        "searching"     : true,
                        "ordering"      : false,
                        "info"          : true,
                        "autoWidth"     : false,
                    });

                    
                    $('#txt_edit_total_item').val(count);
                }
            }
        }).catch((error) => 
        {
            toastr.error('There was a problem in adding the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() => { })
    };

    this_palletizing.allow_edit_input = () => 
    {
        var delivery_type = $('#slc_edit_delivery_type').val();
        var delivery_number = $('#txt_edit_delivery_number').val();
        if (delivery_type == null || delivery_number == '') 
        {
            $("#txt_edit_barcode").attr("disabled", "disabled");
            $("#txt_edit_ord_no").attr("disabled", "disabled");
            $("#txt_edit_total_item").attr("disabled", "disabled");
            PALLETIZING.clear_edit_inputs();
        }
        else
            $("#txt_edit_barcode").removeAttr("disabled");
    };

    this_palletizing.clear_edit_inputs = () => 
    {
        $('#txt_edit_barcode').val('');
        $('#txt_edit_barcode').focus();
    };

    this_palletizing.clear_all_edit_inputs = () => 
    {
        $("#txt_edit_barcode").attr("disabled", "disabled");
        $('#txt_edit_barcode').val('');
        $('#slc_edit_delivery_type').val('');
        $('#txt_edit_delivery_number').val('');
    };

    this_palletizing.barcode_edit = () => 
    {
        var keycode = (event.keyCode ? event.keyCode : event.which);//event on keypress enter
        if (keycode == '13')                                        //event on keypress enter
        {
            var barcode = $('#txt_edit_barcode').val();
            $("#txt_edit_barcode").blur();
            PALLETIZING.barcode_edit_event(barcode);
        }
    };
    
    this_palletizing.adjust_ongoing_tab = () => 
    {
        $($.fn.dataTable.tables(true)).DataTable()
       .columns.adjust(); 
    };
    
    this_palletizing.barcode_edit_event = (barcode) => 
    {
        instance.get(`palletizing`,
        {
            params:
                ({
                    ticket_no: barcode
                }),
        }).then((response) => 
        {
            // console.log(response);
            if (response['statusText'] == 'OK')
            {
                var data = response.data.data[0];
                if (response.data.data.length === 0) 
                {
                    toastr.warning('No data matched in the database. Thank you', 'System Message')
                    document.getElementById('notification').play();
                    PALLETIZING.clear_edit_inputs();
                }
                else 
                {
                    if(data.dest_deleted_at != null)
                    {
                        toastr.warning('Destination Code is disabled. Thank you', 'System Message')
                    }
                    else
                    {
                        if (data.pdl == 0) 
                        { 
                            if (($('#txt_edit_ord_no').val() != data.order_download_no) || ($('#txt_edit_destination_code').val() != data.destination_code)) 
                            {
                                toastr.warning('Please select similar destination code or manufacturing number, Thank you', 'System Message')
                                document.getElementById('notification').play();
                                PALLETIZING.clear_edit_inputs();
                            }
                            else if (($('#txt_edit_ord_no').val() == data.order_download_no) && ($('#txt_edit_destination_code').val() == data.destination_code)) 
                            {
                                
                                if (support_status == 1) 
                                {
                                    PALLETIZING.save_event_condition(data);
                                }
                                else 
                                {
                                    if (data.area_code == area_code) 
                                    {
                                        PALLETIZING.save_event_condition(data);
                                    }
                                    else 
                                    {
                                        toastr.warning('Area Code is not same.', 'System Message');
                                        document.getElementById('notification').play();
                                        PALLETIZING.clear_edit_inputs();
                                    }
                                }
                            }
                        }
                        else 
                        {
                            if (($('#txt_edit_destination_code').val() != data.destination_code) || ($('#txt_edit_manufacturing').val() != data.manufacturing_no)) 
                            {
                                toastr.warning('Please select similar order download number or destination code, Thank you', 'System Message')
                                document.getElementById('notification').play();
                                PALLETIZING.clear_edit_inputs();
                            }
                            else if (($('#txt_edit_destination_code').val() == data.destination_code) && ($('#txt_edit_manufacturing').val() == data.manufacturing_no)) 
                            {
                                if ($('#txt_edit_ord_no').val() == data.order_download_no)
                                {
                                    if (support_status == 1) 
                                    {
                                        PALLETIZING.save_event_condition(data);
                                    }
                                    else 
                                    {
                                        if (data.area_code == area_code) 
                                        {
                                            PALLETIZING.save_event_condition(data);
                                        }
                                        else 
                                        {
                                            toastr.error('Area Code is not same.', 'System Message');
                                            document.getElementById('notification').play();
                                            PALLETIZING.clear_edit_inputs();
                                        }
                                    }
                                }
                                else
                                {
                                    toastr.warning('Please select similar Order Download Number, Thank you', 'System Message')
                                    document.getElementById('notification').play();
                                    PALLETIZING.clear_edit_inputs();
                                }
                                    
                            }
                        }
                    }
                }
            }
        }).catch((error) => 
        {
            toastr.error('There was a problem in adding the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() => { 
            PALLETIZING.clear_inputs();
        });
    };
    this_palletizing.save_event_condition = (data) => 
    {
        var dr_control_no = $("#txt_edit_dr_control").val();
        var process = dr_control_no.split("-");
        if(jQuery.inArray(data.normal, barcode_list) !== -1)
        {
            toastr.warning('Ticket number already exist. Thank you', 'System Message');
            document.getElementById('notification').play();
            PALLETIZING.clear_edit_inputs();
        }
        else
        {
            if (isNaN(process[(process.length) - 1]))//checks if the last value in dr_control_number is numeric if numeric process is normal if not process is completion
            {
                if (data.irreg_type == "NO STOCK" || data.irreg_type == "EXCESS")
                {
                    if (data.irreg_status == "FOR PALLETIZING") 
                    {
                        process_edit = [];
                        process_edit = data;
                        process_edit.ticket_no = $("#txt_edit_barcode").val();
                        process_edit.delivery_type = $("#slc_edit_delivery_type option:selected").html();
                        process_edit.delivery_type_val = $('#slc_edit_delivery_type').val();
                        process_edit.delivery_no = $('#txt_edit_delivery_number').val();
                        process_edit.item_no = data.item_no;
                        process_edit.delivery_qty = data.delivery_qty;
                        process_edit.order_download_no = data.order_download_no;
                        process_edit.process = "COMPLETION";
                        process_edit.dr_control_no = dr_control_no;
                        PALLETIZING.save_event(process_edit)
                    }
                    else
                    {
                        toastr.warning('Parts is not for palletizing, Thank you', 'System Message');
                        document.getElementById('notification').play();
                        PALLETIZING.clear_edit_inputs();
                    }

                }
                else
                {
                    if (data.normal_status == "FOR PALLETIZING") 
                    {
                        process_edit = [];
                        process_edit = data;
                        process_edit.ticket_no = $("#txt_edit_barcode").val();
                        process_edit.delivery_type = $("#slc_edit_delivery_type option:selected").html();
                        process_edit.delivery_type_val = $('#slc_edit_delivery_type').val();
                        process_edit.delivery_no = $('#txt_edit_delivery_number').val();
                        process_edit.item_no = data.item_no;
                        process_edit.delivery_qty = data.delivery_qty;
                        process_edit.order_download_no = data.order_download_no;
                        process_edit.process = "NORMAL";
                        process_edit.dr_control_no = dr_control_no;
                        PALLETIZING.save_event(process_edit)
                    }
                    else
                    {
                        if (data.completion != null)
                        {
                            if (data.irreg_status == "FOR PALLETIZING") 
                            {
                                process_edit = [];
                                process_edit = data;
                                process_edit.ticket_no = $("#txt_edit_barcode").val();
                                process_edit.delivery_type = $("#slc_edit_delivery_type option:selected").html();
                                process_edit.delivery_type_val = $('#slc_edit_delivery_type').val();
                                process_edit.delivery_no = $('#txt_edit_delivery_number').val();
                                process_edit.item_no = data.item_no;
                                process_edit.delivery_qty = data.delivery_qty;
                                process_edit.order_download_no = data.order_download_no;
                                process_edit.process = "COMPLETION";
                                process_edit.dr_control_no = dr_control_no;
                                PALLETIZING.save_event(process_edit)
                            }
                            else
                            {
                                toastr.warning('Parts is not for palletizing, Thank you', 'System Message');
                                document.getElementById('notification').play();
                                PALLETIZING.clear_edit_inputs();
                            }
                        }
                        else
                        {
                            toastr.warning('Parts is not for palletizing, Thank you', 'System Message');
                            document.getElementById('notification').play();
                            PALLETIZING.clear_edit_inputs();
                        }
                    }
                }
            }
            else
            {
                if (data.completion != null)
                {
                    toastr.warning('Can add normal parts only! Thank you!', 'System Message');
                    document.getElementById('notification').play();
                    PALLETIZING.clear_edit_inputs();
                }
                else
                {
                    if (data.normal_status == "FOR PALLETIZING") 
                    {
                        process_edit = [];
                        process_edit = data;
                        process_edit.ticket_no = $("#txt_edit_barcode").val();
                        process_edit.delivery_type = $("#slc_edit_delivery_type option:selected").html();
                        process_edit.delivery_type_val = $('#slc_edit_delivery_type').val();
                        process_edit.delivery_no = $('#txt_edit_delivery_number').val();
                        process_edit.item_no = data.item_no;
                        process_edit.delivery_qty = data.delivery_qty;
                        process_edit.order_download_no = data.order_download_no;
                        process_edit.process = "NORMAL";
                        process_edit.dr_control_no = dr_control_no;
                        PALLETIZING.save_event(process_edit)
                    }
                    else
                    {
                        toastr.warning('Parts is not for palletizing, Thank you', 'System Message');
                        document.getElementById('notification').play();
                        PALLETIZING.clear_edit_inputs();
                    }
                }
            }   
        }
    };

    this_palletizing.save_event = (data) => 
    {
        instance.post(`new-palletizing-item`,
            {
                ticket_no: data.ticket_no,
                users_id: $('#txt_user_id').val(),
                dr_control: data.dr_control_no,
                delivery_type_id: data.delivery_type_val,
                delivery_no: data.delivery_no,
                process: data.process,
                area_code: area_code,
                irreg_type: data.irreg_type

            }).then((response) => 
            {
                PALLETIZING.get_ongoing_palletizing();
                PALLETIZING.count_table_length();
                PALLETIZING.clear_edit_inputs();
                PALLETIZING.fill_tbl_edit_palletizing_masterlist($('#txt_edit_dr_control').val(), $('#txt_edit_ord_no').val())

            }).catch((error) => 
            {
                toastr.error('There was a problem in inserting the data. Please contact the administrator. Thank you', 'System Message')
                document.getElementById('notification').play();
                console.log(error)
            }).finally(() => { })
    };

    this_palletizing.remove_palletizing = (id, ticket_no, dr_control_no, process,irreg_type) => 
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                instance.delete(`/remove-palletizing-item`,
                {
                    params: ({
                        id: id,
                        ticket_no: ticket_no,
                        process: process,
                        irreg_type: irreg_type
                    })
                }).then((response) => 
                {
                    if (result.value)
                    {
                        document.getElementById('notification_success').play();
                        toastr.success('Successfully Deleted', 'System Message')
                    }
                    else
                    {
                        toastr.warning('There was a problem in deleting the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                    }
                }).catch((error) => 
                {
                    toastr.error('There was a problem in deleting the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();
                    console.log(error);
                }).finally(() => 
                {
                    setTimeout(function(){
                        PALLETIZING.clear_edit_inputs();
                    }, 300);
                    PALLETIZING.fill_tbl_edit_palletizing_masterlist($('#txt_edit_dr_control').val(), $('#txt_edit_ord_no').val())
                    PALLETIZING.get_ongoing_palletizing();
                    // $('.loader').hide();
                })
            }
        });
    };

    this_palletizing.cancel_edit_palletizing = () => 
    {
        $('#tbl_edit_palletizing_masterlist').DataTable().destroy();
        $('#tbody_tbl_edit_palletizing_masterlist').empty();
        $('#div_edit_palletizing').prop('hidden', true);
        $('#div_ongoing_palletizing').prop('hidden', false);
        $('#div_for_palletizing').prop('hidden', false);
        PALLETIZING.clear_all_edit_inputs();
        PALLETIZING.clear_entered_data();
        PALLETIZING.get_ongoing_palletizing();
    };

    this_palletizing.open_modal_for_finish = (dr_control) => 
    {
        $('#mod_finish_palletizing').modal('show');
        $('#txt_dr_no').val(dr_control);
    };

    this_palletizing.finish_palletizing = () => 
    {
        if ($('#txt_pallet').val() === '' || $('#txt_pcase').val() === '' || $('#txt_box').val() === '' || $('#txt_bag').val() === '') 
        {
            toastr.warning('Blank value is not allowed. Thank you', 'System Message')
            document.getElementById('notification').play();
        }
        else 
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                    instance.post(`finish-palletizing`,
                    {
                        dr_control: $('#txt_dr_no').val(),
                        pallet: $('#txt_pallet').val(),
                        pcase: $('#txt_pcase').val(),
                        box: $('#txt_box').val(),
                        bag: $('#txt_bag').val(),
                        users_id: user_id
                    }).then((response) => 
                    {
                        Swal.fire('Success!', `Palletizing successfully finished!`, 'success')
                        document.getElementById('notification_success').play();
                        $('#mod_finish_palletizing').modal('hide');
                    }).catch((error) => 
                    {
                        toastr.warning('There was a problem in updating the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                    }).finally(() => 
                    {
                        PALLETIZING.finish_palletizing_clear_inputs();
                        PALLETIZING.get_ongoing_palletizing();
                        PALLETIZING.count_table_length();
                    })
                }
            })
        }
    };

    this_palletizing.clear_tables = () => 
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                tbl_normal_palletizing.clear().draw();
                tbl_irreg_palletizing.clear().draw();
                PALLETIZING.count_table_length();
                PALLETIZING.clear_inputs();
                $("#txt_barcode").attr("disabled", "disabled");
                $("#txt_ord_no").attr("disabled", "disabled");
                $("#txt_total_item").attr("disabled", "disabled");
                $("#txt_destination_code").attr("disabled", "disabled");
                $("#txt_manufacturing").attr("disabled", "disabled");
                $('#txt_delivery_number').val('');
                $('#txt_destination_code').val('');
                $('#slc_delivery_type').val('');
                $('#txt_manufacturing').val('');
                $('#txt_ord_no').val('');
                $('#txt_total_item').val('');
                $('#txt_area_code_hidden').val('');
                irreg_type_irreg = [];
                irreg_type_normal = [];
                document.getElementById('notification_success').play();
            }
        });
    };
    this_palletizing.clear_entered_data = () => 
    {
        tbl_normal_palletizing.clear().draw();
        tbl_irreg_palletizing.clear().draw();
        PALLETIZING.count_table_length();
        PALLETIZING.clear_inputs();
        $("#txt_barcode").attr("disabled", "disabled");
        $("#txt_ord_no").attr("disabled", "disabled");
        $("#txt_total_item").attr("disabled", "disabled");
        $("#txt_destination_code").attr("disabled", "disabled");
        $("#txt_manufacturing").attr("disabled", "disabled");
        $('#txt_delivery_number').val('');
        $('#txt_destination_code').val('');
        $('#slc_delivery_type').val('');
        $('#txt_manufacturing').val('');
        $('#txt_ord_no').val('');
        $('#txt_total_item').val('');
        $('#txt_area_code_hidden').val('');
        document.getElementById('notification_success').play();
    };

    this_palletizing.cancel_transaction_modal = () =>
    {
        setTimeout(function(){
            PALLETIZING.clear_inputs();
        }, 300);
    };


    return this_palletizing;
})(); 
