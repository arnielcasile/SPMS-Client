$(document).ready(() => {
    UPDATE_DELIVERY.load_for_dispatch();
    $('#txt_transporter').val($('#txt_username').val());
    $('#txt_control_no').focus();
});

const UPDATE_DELIVERY = (() => 
{
    let this_update_delivery = {};
    let destination = '';
    let banner_data = '';

    var tbl_update_delivery = $('#tbl_update_delivery').DataTable({
        "paging": false,
        "scrollY": '350px',
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "fnDrawCallback": function () {
            $('#tbody_tbl_update_delivery td').each(function () {
                if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') {
                    $(this).text('');
                }
            });
        }
    });

    var tbl_banner = $('#tbl_banner_list').DataTable({
        "paging": false,
        "scrollY": '350px',
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "fnDrawCallback": function () {
            $('#tbl_banner_list_body td').each(function () {
                if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') {
                    $(this).text('');
                }
            });
        }
    });

    $('#txt_control_no').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);//event on keypress enter
        if (keycode == '13')//event on keypress enter
            UPDATE_DELIVERY.load_update_delivery($('#txt_control_no').val());
    });

    this_update_delivery.load_update_delivery = (dr_control) => 
    {
        $("#txt_control_no").blur();
        if (dr_control === '') 
        {
            toastr.warning('Please input a control number. Thank you', 'System Message')
            document.getElementById('notification').play();
            $('#txt_delivery_receipt_control').val('');
            $("#txt_control_no").focus();
        }
        else 
        {
            instance.get('for-delivery-update',
            {
                params: ({
                    dr_control: dr_control,
                })
            }).then(function (response) 
            {
                // $('.loader').show();
                var data = response.data.data
                var tr = '';
                if (response['statusText'] == 'OK') 
                {
                    if (data.length === 0) 
                    {
                        toastr.warning('No data matched in the database. Thank you', 'System Message')
                        document.getElementById('notification').play();
                        $('#txt_delivery_receipt_control').val('');
                    }
                    else 
                    {
                        if (support_status == 1) 
                        {
                            if (data[0].normal_status == 5 || data[0].irreg_status == 5) 
                            {
                                var str = $('#txt_control_no').val().replace(/\s/g, '');
                                var dataCount = tbl_update_delivery.rows(`:contains(${str})`).data().length;
                                if (dataCount < 1) 
                                {
                                    document.getElementById('notification_success').play();
                                    tbl_update_delivery.row.add([
                                        data[0].dr_control,
                                        data[0].normal_process,
                                        data[0].irreg_process,
                                        data[0].item_count
                                    ]).draw(false);
                                }
                                else
                                {
                                    toastr.warning('Control Number already exist. Thank you', 'System Message')
                                    document.getElementById('notification').play();
                                    $('#txt_delivery_receipt_control').val('');
                                }
                            }
                            else if (data[0].normal_status != 2) 
                            {
                                toastr.warning('Not for delivery. Thank you', 'System Message')
                                document.getElementById('notification').play();
                                $('#txt_delivery_receipt_control').val('');
                            }
                            else if (data[0].irreg_status != 2) 
                            {
                                toastr.warning('Not for delivery. Thank you', 'System Message')
                                document.getElementById('notification').play();
                                $('#txt_delivery_receipt_control').val('');
                            }
                            else if (data[0].dr_control == null || data[0].dr_control == '') 
                            {
                                toastr.warning('DR Control not exist. Thank you', 'System Message')
                                document.getElementById('notification').play();
                                $('#txt_delivery_receipt_control').val('');
                            }
                        }
                        else 
                        {
                            if (data[0].area_code == area_code) 
                            {
                                if (data[0].normal_status == 5 || data[0].irreg_status == 5) 
                                {
                                    var str = $('#txt_control_no').val().replace(/\s/g, '');
                                    var dataCount = tbl_update_delivery.rows(`:contains(${str})`).data().length;
                                    if (dataCount < 1) 
                                    {
                                        document.getElementById('notification_success').play();
                                        tbl_update_delivery.row.add([
                                            data[0].dr_control,
                                            data[0].normal_process,
                                            data[0].irreg_process,
                                            data[0].item_count
                                        ]).draw(false);
                                    }
                                    else
                                    {
                                        toastr.warning('Control Number already exist. Thank you', 'System Message')
                                        document.getElementById('notification').play();
                                        $('#txt_delivery_receipt_control').val('');
                                    }
                                }
                                else if (data[0].normal_status != 2) 
                                {
                                    toastr.warning('Not for delivery. Thank you', 'System Message')
                                    document.getElementById('notification').play();
                                    $("#txt_control_no").focus();
                                }
                                else if (data[0].irreg_status != 2) 
                                {
                                    toastr.warning('Not for delivery. Thank you', 'System Message')
                                    document.getElementById('notification').play();
                                    $("#txt_control_no").focus();
                                    $('#txt_delivery_receipt_control').val('');
                                }
                                else if (data[0].dr_control == null || data[0].dr_control == '') 
                                {
                                    toastr.warning('DR Control not exist. Thank you', 'System Message')
                                    document.getElementById('notification').play();
                                    $('#txt_delivery_receipt_control').val('');
                                }
                            }
                            else 
                            {
                                document.getElementById('notification').play();
                                toastr.error('Area Code is not same.', 'System Message');
                                $('#txt_delivery_receipt_control').val('');
                            }
                        }
                    }
                }
                else
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();
                }

            }).catch(function (error) 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                document.getElementById('notification').play();
                console.log(error)
            }).finally(() => 
            {
                // $('.loader').hide();
                $('#txt_control_no').val('');
                $("#txt_control_no").focus();
            });
        }
    };

    this_update_delivery.update_delivery = () => 
    {
        var tbl_data = tbl_update_delivery.rows().data();

        if (tbl_data.length < 1) 
        {
            toastr.warning('Table must not be empty, Thank you!', 'System Message')
            document.getElementById('notification').play();
            $('#txt_control_no').focus();
        }
        else 
        {
            Swal.fire(swal_options).then((result) => 
            {
                if(result.value)
                {
                    $('#btn_update_delivery').prop('disabled', true)
                    // $('.loader').show();
                    let arr_update = [];
                    for (var i = 0; i < tbl_data.length; i++) 
                    {
                        var rows = tbl_update_delivery.rows(i).data();
                        arr_update.push
                            ({
                                "dr_control": rows[0][0],
                                "item_count": rows[0][3],
                                "breakdown": null,
                                "remarks": null,
                                "user_id": $('#txt_user_id').val()
                            });
                    }
                    instance.patch(`for-delivery-update`,
                    {
                        data: arr_update,
                    }).then((response) => 
                    {
                        if (response['statusText'] == 'OK')
                        {
                            toastr.success('Successfully Updated! \nThank you', 'System Message')
                            document.getElementById('notification_success').play();
                            $('#txt_control_no').val('');
                            $("#txt_control_no").focus();
                        }
                    }).catch((error) => 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator \nThank you', 'System Message')
                        document.getElementById('notification').play();
                        console.log(error)
                    }).finally(() => 
                    {
                        UPDATE_DELIVERY.load_for_dispatch();
                        tbl_update_delivery.clear().draw();
                        // $('.loader').hide();
                        $('#btn_update_delivery').prop('disabled', false)
                    })
                }
            })
        }
    };

    this_update_delivery.clear_inputs = () => 
    {
        var tbl_data = tbl_update_delivery.rows().data();
        if (tbl_data.length < 1)
        {
            toastr.warning('Table has no data', 'System Message')
            document.getElementById('notification').play();
            $("#txt_control_no").focus();
        }
        else 
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value)
                {
                    document.getElementById('notification_success').play();
                    tbl_update_delivery.clear().draw();
                    setTimeout(function(){
                        $("#txt_control_no").focus();
                    }, 300);
                }
            })
        }
    };

    //BANNER PRINTING
    $('#txt_delivery_receipt_control').keypress(function (event) 
    {
        var keycode = (event.keyCode ? event.keyCode : event.which);//event on keypress enter
        if (keycode == '13')//event on keypress enter
            UPDATE_DELIVERY.check_barcode($('#txt_delivery_receipt_control').val());
    });

    this_update_delivery.check_barcode = (receipt_control) => 
    {
        if (receipt_control === '') 
        {
            toastr.warning('Please input delivery receipt control. Thank you', 'System Message')
            document.getElementById('notification').play();
        }
        else 
        {
            instance.get('banner-details',
                {
                    params: ({
                        dr_control: receipt_control
                    })
                }).then(function (response) 
                {

                    // $('.loader').show();
                    var data = response.data.data
                    banner_data = data;
                    var tr = '';

                    if (response['statusText'] == 'OK') 
                    {
                        if (data.length === 0) 
                        {
                            toastr.warning('No data matched in the database. Thank you', 'System Message')
                            document.getElementById('notification').play();
                            $('#txt_delivery_receipt_control').val('');
                        }
                        else 
                        {
    
                            if (support_status === 0) 
                            {
                               
                                if (area_code === data[0].warehouse_class)
                                    UPDATE_DELIVERY.load_banner_data(data);
                                else
                                {
                                    toastr.warning('Area code not matched. Thank you', 'System Message')
                                    document.getElementById('notification').play();
                                    $('#txt_delivery_receipt_control').val('');
                                }
                            }
                            else
                            {
                                var tbl_data = tbl_banner.rows().data();

                                if (tbl_data.length < 1) 
                                {
                                    UPDATE_DELIVERY.load_banner_data(data);
                                }
                               else
                               {
                                var first_dr='';
                                $('#tbl_banner_list tr').each(function() {
                                    first_dr= $(this).find("td:first").html();    
                                });
                                    var tbl_content_area_code = first_dr.split("-");
                                    var data_area_code= data[0].dr_control.split("-");
                                    if(tbl_content_area_code[0]==data_area_code[0])
                                    {
                                        UPDATE_DELIVERY.load_banner_data(data);
                                    }
                                    else
                                    {
                                        toastr.warning('Area code not matched. Thank you', 'System Message')
                                    }
                               }

                            }
                        }
                    }
                    else 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                    }
                }).catch(function (error) 
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();
                    console.log(error);
                }).finally(() => 
                {
                    // $('.loader').hide();
                    $('#txt_delivery_receipt_control').val('');
                    $("#txt_delivery_receipt_control").focus();
                });
        }
    };

    this_update_delivery.load_banner_data = (data) => 
    {
        if ((data[0].process_masterlist_id == 5 || data[0].process_masterlists_id == 5) || (data[0].process_masterlist_id == 6 || data[0].process_masterlists_id == 6))
        {
            if (destination == '')
            {
                destination = data[0].destination;
            }

            if (data[0].destination == destination)
            {
                UPDATE_DELIVERY.plot_in_banner_table(data);
            }
            else 
            {
                toastr.warning('Please select similar destination. Thank you', 'System Message')
                document.getElementById('notification').play();
                $('#txt_delivery_receipt_control').val('');
                $("#txt_delivery_receipt_control").focus();
            }
        }
        else if ((data[0].process_masterlist_id != 5 || data[0].process_masterlists_id != 5) || (data[0].process_masterlist_id != 6 || data[0].process_masterlists_id != 6))
        {
            toastr.warning('Not for delivery. Thank you', 'System Message')
            document.getElementById('notification').play();
            $('#txt_delivery_receipt_control').val('');
            $("#txt_delivery_receipt_control").focus();
        }
        else if (data[0].dr_control == null || data[0].dr_control == '') 
        {
            toastr.warning('DR Control not exist. Thank you', 'System Message')
            document.getElementById('notification').play();
            $('#txt_delivery_receipt_control').val('');
            $("#txt_delivery_receipt_control").focus();
        }
    };

    this_update_delivery.plot_in_banner_table = (data) => 
    {
        var dataCount = tbl_banner.rows(`:contains(${data[0].dr_control})`).data().length;
        if (dataCount < 1) 
        {
            document.getElementById('notification_success').play();
            tbl_banner.row.add([
                $('#txt_delivery_receipt_control').val(),
                destination,
                'ATM PARTS',
                data[0].purpose
            ]).draw(false);
            $('#txt_delivery_receipt_control').val('');
        }
        else
        {
            toastr.warning('Control Number already exist. Thank you', 'System Message')
            document.getElementById('notification').play();
            $('#txt_delivery_receipt_control').val('');
            $("#txt_delivery_receipt_control").focus();

        }
    };

    this_update_delivery.submit_banner = () =>
    {
        var tbl_banner_lists = tbl_banner.rows().data();

        if (tbl_banner_lists.length < 1) 
        {
            toastr.warning('Table must not be empty, Thank you!', 'System Message')
            document.getElementById('notification').play();
        }
        else if 
            ($('#txt_pallet_qty').val() == '' || $('#txt_total_pallet').val() == '' || $('#txt_pcase_qty').val() == '' ||
            $('#txt_total_pcase').val() == '' || $('#txt_box_qty').val() == '' || $('#txt_total_box').val() == '') 
        {
            toastr.warning('Please complete all the inputs. Thank you', 'System Message')
            document.getElementById('notification').play();
        }
        else 
        {
            let arr_control = [];
            let arr_banner = [];
            var today = new Date();

            for (var i = 0; i < tbl_banner_lists.length; i++) 
            {
                var rows = tbl_banner.rows(i).data();
                if (i == 0)
                {
                    if ((i + 1) == tbl_banner_lists.length) 
                    {
                        arr_control.push
                            ({
                                "dr_control": rows[0][0]
                            });
                    }
                    else 
                    {
                        arr_control.push
                            ({
                                "dr_control": rows[0][0] + ','
                            });
                    }
                }
                else 
                {
                    if ((i + 1) == tbl_banner_lists.length) 
                    {
                        arr_control.push
                            ({
                                "dr_control": rows[0][0].slice(3)
                            });
                    }
                    else 
                    {
                        arr_control.push
                            ({
                                "dr_control": rows[0][0].slice(3) + ','
                            });
                    }
                }
            }

            var rows = tbl_banner.rows(i).data();
            arr_banner.push
                ({
                    "control_no": arr_control,
                    "date_now": date_today,
                    "time_now": today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds(),
                    "destination": destination,
                    "attention_to": banner_data[0].attention_to,
                    "description": 'ATM PARTS',
                    "purpose": banner_data[0].purpose,
                    "pallet_qty": $('#txt_pallet_qty').val(),
                    "pallet_total": $('#txt_total_pallet').val(),
                    "pcase_qty": $('#txt_pcase_qty').val(),
                    "pcase_total": $('#txt_total_pcase').val(),
                    "box_qty": $('#txt_box_qty').val(),
                    "box_total": $('#txt_total_box').val()
                });
            UPDATE_DELIVERY.generate_pdf(arr_banner);
        }
    };

    this_update_delivery.generate_pdf = (datas) => 
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                local.get(`banner-pdf`,
                {
                    params:
                        ({
                            data: JSON.stringify(datas),
                        }),
                    responseType: 'blob', Accept: 'application/pdf',
                }).then((response) => 
                {
                    const file = new Blob(
                        [response.data],
                        { type: 'application/pdf' });
                    const fileURL = URL.createObjectURL(file);
                    window.open(fileURL);
                }).catch((error) => 
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();
                    console.log(error)
                }).finally(() => 
                {
                    UPDATE_DELIVERY.clear_fields_tbl();
                    tbl_banner.clear().draw();
                })
            }
        })
    };

    this_update_delivery.clear_fields_tbl = () => 
    {
        destination = '';
        $('#txt_delivery_receipt_control').val('');
        $('#txt_pallet_qty').val('');
        $('#txt_total_pallet').val('');
        $('#txt_pcase_qty').val('');
        $('#txt_total_pcase').val('');
        $('#txt_box_qty').val('');
        $('#txt_total_box').val('');
        setTimeout(function(){
            $('#txt_delivery_receipt_control').focus();
        }, 300);

        
    };

    this_update_delivery.clear_banner_tbl = () => 
    {
        var tbl_banner_clear = tbl_banner.rows().data();
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                UPDATE_DELIVERY.clear_fields_tbl();
                if (tbl_banner_clear.length < 1)
                {
                    toastr.warning('Table has no data', 'System Message')
                    document.getElementById('notification').play();
                }
                else
                {
                    tbl_banner.clear().draw();
                    document.getElementById('notification_success').play();
                }
            }
        })
    };

    //FOR DISPATCH
    this_update_delivery.load_for_dispatch = () => 
    {
        if (area_code == 'P14') 
        {
            document.getElementById('div_dispatch_panel').style.display = 'block';
            instance.get('load-for-dispatch').then(function (response) {
                // $('.loader').show();
                var data = response.data.data;
                $("#tbl_dispatch").DataTable().destroy();
                $("#tbody_dispatch").empty();
                var tr = '';
                if (response['statusText'] == 'OK') 
                {
                    if (response.data.data.length === 0) 
                    {
                        toastr.warning('No data matched in the database. Thank you', 'System Message')
                        document.getElementById('notification').play();
                    }
                    else 
                    {
                        $.each(data, function () 
                        {
                            tr += `<tr>
                                        <td><input type="checkbox" id="" style="zoom:2" name='chk_child_dispatch[]' class='chk_child_dispatch' onclick="UPDATE_DELIVERY.table_select();"></td>
                                        <td>${this.dr_control}</td>
                                        <td>${this.ticket_issue_date}</td>
                                        <td>${this.product_no}</td>
                                        <td>${this.delivery_qty}</td>
                                        <td>${this.manufacturing_no}</td>
                                        <td><input type="text" style="width:70%;" class="form-control txt_breakdown" placeholder="Breakdown" value="0" name="txt_breakdown[]"/></td>
                                        <td><input type="text" style="width:70%;" class="form-control txt_remarks" placeholder="Remarks" value="-" name="txt_remarks[]"/></td>
                                    </tr>`;
                        })

                        $("#tbody_dispatch").html(tr);
                        table = $('#tbl_dispatch').DataTable({
                            "scrollX": true,
                            "paging": false,
                            "scrollY": '350px',
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "processing": true,
                            "serverSide": false,
                            "deferRender": true,
                            "fnDrawCallback": function () {
                                $('#tbody_dispatch td').each(function () {
                                    if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') {
                                        $(this).text('');
                                    }
                                });
                            },
                        });
                    }
                }
                else 
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();
                }
            }).catch(function (error) 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                document.getElementById('notification').play();
                console.log(error);
            }).finally(() => 
            {
                // $('.loader').hide();
            });
        }
        else 
        {
            document.getElementById('div_dispatch_panel').style.display = 'none';
        }
    };

    this_update_delivery.table_select_all = () => 
    {
        if ($('#chk_parent_dispatch').is(':checked'))
            table.rows({ filter: 'applied' }).nodes().to$().find('input').prop('checked', true);
        else
            table.rows({ filter: 'applied' }).nodes().to$().find('input').prop('checked', false);
    };

    this_update_delivery.table_select = () => 
    {
        var checked_data = $('#tbl_dispatch').find('tbody input:checkbox:checked').length; // Get count of checkboxes that is checked
        // if all checkboxes are checked, then set property of main checkbox to "true", else set to "false"
        $('#chk_parent_dispatch').prop('checked', (checked_data === $('#tbl_dispatch').find('tbody input:checkbox').length));
    };

    this_update_delivery.dispatch = () => 
    {
        datas = {};
        var data = $(this).parents('tr:eq(0)');
        var length = $("input[name='chk_child_dispatch[]']:checked").length;
        if (length == 0) 
        {
            toastr.warning('Please select a control  number. Thank you', 'System Message')
            document.getElementById('notification').play();
        }
        else 
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                    var dr_control = [];
                    var count = 0;
                    var rowcollection = table.$(".chk_child_dispatch:checked", { "page": "all" });

                    rowcollection.each(function (index, elem) {
                        var tr_data = $(this).parents('tr:eq(0)');
                        var dr_control_no = $(tr_data).find('td:eq(1)').text();
                        var breakdown = $(tr_data).find('input.txt_breakdown').val();
                        var remarks = $(tr_data).find('input.txt_remarks').val();
                        if (breakdown == "" || remarks == "") 
                        {
                            toastr.warning('Please complete the necessary details! \nThank you', 'System Message')
                            document.getElementById('notification').play();
                        }
                        else 
                        {
                            dr_control[count] = 
                            {
                                "dr_control": dr_control_no,
                                "user_id": $('#txt_user_id').val(),
                                "breakdown": breakdown,
                                "remarks": remarks
                            };
                            count++;
                        }
                    });
                    if (dr_control.length > 0) 
                    {
                        instance.patch(`for-delivery-update`,
                        {
                            data: dr_control,
                        }).then((response) =>
                        {
                            if (response['statusText'] == 'OK')
                            {
                                toastr.success('Successfully dispatched! \nThank you', 'System Message')
                                document.getElementById('notification_success').play();
                            }
                        }).catch((error) => 
                        {
                            toastr.error('There was a problem in loading the data. Please contact the administrator \nThank you', 'System Message')
                            document.getElementById('notification').play();
                        }).finally(() => 
                        {
                            // $('.loader').hide();
                            UPDATE_DELIVERY.load_for_dispatch();
                        })
                    }
                }
            })
        }
    };


    return this_update_delivery;
})();