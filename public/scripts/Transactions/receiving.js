$(document).ready(() => 
{
    $('#txt_recipient').val($('#txt_username').val());
    RECEIVING.load_for_special();
    $("#txt_control_no").focus();
});

const RECEIVING = (() => 
{
    let this_receiving = {};
    let destination = '';
    let banner_data = '';

    var tbl_receiving = $('#tbl_receiving').DataTable({
        "scrollX": true,
        "paging": false,
        "scrollY": '350px',
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "fnDrawCallback": function () {
            $('#tbody_tbl_receiving td').each(function () {
                if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') {
                    $(this).text('');
                }
            });
        }
    });

    var tbl_banner = $('#tbl_banner_list').DataTable({
        "scrollX": true,
        "paging": false,
        "scrollY": '350px',
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "fnDrawCallback": function () 
        {
            $('#tbl_banner_list_body td').each(function () 
            {
                if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') 
                {
                    $(this).text('');
                }
            });
        }
    });
    $('#txt_control_no').keypress(function (event) 
    {
        var keycode = (event.keyCode ? event.keyCode : event.which);//event on keypress enter
        if (keycode == '13')//event on keypress enter
            RECEIVING.load_receiving($('#txt_control_no').val());
    });

    this_receiving.load_receiving = (dr_control) => 
    {
        $("#txt_control_no").blur();

        if (dr_control === '') 
        {
            toastr.warning('Please input a control number. Thank you', 'System Message')
            document.getElementById('notification').play();
            $("#txt_control_no").focus();
        }
        else 
        {
            instance.get('receiving',
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
                    }
                    else 
                    {
                        if (data[0].updated_at != null)//Ticket is done updating so updated_at has content
                        {
                            toastr.warning('Ticket is already updated. Thank you', 'System Message')
                            document.getElementById('notification').play();
                        }
                        else 
                        {
                            if (data[0].normal_status == 6 || data[0].irreg_status == 6) 
                            {
                                var str = $('#txt_control_no').val().replace(/\s/g, '');
                                var dataCount = tbl_receiving.rows(`:contains("${str}")`).data().length;
                                if (dataCount < 1) 
                                {
                                    tbl_receiving.row.add([
                                        data[0].dr_control,
                                        data[0].warehouse_class,
                                    ]).draw(false);
                                    document.getElementById('notification_success').play();
                                }
                                else
                                {
                                    toastr.warning('Control Number already exist. Thank you', 'System Message')
                                    document.getElementById('notification').play();
                                }
                            }
                            else if (data[0].normal_status != 6) 
                            {
                                toastr.warning('Not for receiving. Thank you', 'System Message')
                                document.getElementById('notification').play();
                            }
                            else if (data[0].irreg_status != 6) 
                            {
                                toastr.warning('Not for receiving. Thank you', 'System Message')
                                document.getElementById('notification').play();
                            }
                            else if (data[0].dr_control == null || data[0].dr_control == '') 
                            {
                                toastr.warning('DR Control not exist. Thank you', 'System Message')
                                document.getElementById('notification').play();
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
                $('#txt_control_no').val('');
                $("#txt_control_no").focus();
            });
        }
    };

    this_receiving.receiving = function()  
    {
        var tbl_data = tbl_receiving.rows().data();

        if (tbl_data.length < 1) 
        {
            toastr.warning('Table must not be empty, Thank you!', 'System Message')
            document.getElementById('notification').play();
            $("#txt_control_no").focus();
        }
        else 
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value)
                {
                    // $('.loader').show();
                    $('#btn_receiving').prop('disabled', true)
                    let arr_update = [];
                    for (var i = 0; i < tbl_data.length; i++) 
                    {
                        var rows = tbl_receiving.rows(i).data();
                        arr_update.push
                        ({
                            "dr_control": rows[0][0],
                            "recipient": $('#txt_user_id').val()
                        });
                    }

                    instance.patch(`receiving`,
                    {
                        data: arr_update,
                    }).then((response) => 
                    {
                        if (response['statusText'] == 'OK')
                        {
                            toastr.success('Successfully Updated! \n Thank you', 'System Message')
                            document.getElementById('notification_success').play();
                        }
                    }).catch((error) => 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator \nThank you', 'System Message')
                        document.getElementById('notification').play();
                        console.log(error)
                    }).finally(() => 
                    {
                        tbl_receiving.clear().draw();
                        // $('.loader').hide();
                        $('#btn_receiving').prop('disabled', false)
                        RECEIVING.load_for_special();
                    })
                }     
            })
        }
    };

    this_receiving.clear_inputs = () => 
    {
        var tbl_data = tbl_receiving.rows().data();
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
                    tbl_receiving.clear().draw();
                    document.getElementById('notification_success').play();
                    setTimeout(function(){
                        $("#txt_control_no").focus();
                    }, 300);
            
                }
            })
        }
    };


    //FOR SPECIAL
    this_receiving.load_for_special = () => 
    {
        document.getElementById('div_special_panel').style.display = 'block';
        instance.get(`load-for-receive`).then((response) => 
        {
            // $('.loader').show();
            var data = response.data.data;
            $("#tbl_special").DataTable().destroy();
            $("#tbody_special").empty();
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
                                    <td>${((this.recipient != null) ? '<input type="checkbox" checked style="zoom:2" name="chk_child_special[]" class="chk_child_special" onclick="RECEIVING.table_select();">' : '<input type="checkbox" style="zoom:2" name="chk_child_special[]" class="chk_child_special" onclick="RECEIVING.table_select();">')}</td>
                                    <td>${this.dr_control}</td>
                                    <td>${this.ticket_issue_date}</td>
                                    <td>${this.product_no}</td>
                                    <td>${this.delivery_qty}</td>
                                    <td>${this.manufacturing_no}</td>
                                    <td>${this.created_at}</td>
                                    <td>${this.remarks}</td>
                                    <td>${this.breakdown}</td>
                                </tr>`;
                    })

                    $("#tbody_special").html(tr);
                    table = $('#tbl_special').DataTable({
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
                            $('#tbody_special td').each(function () 
                            {
                                if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') 
                                {
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
    };

    this_receiving.table_select_all = () => 
    {
        if ($('#chk_parent_special').is(':checked'))
            table.rows({ filter: 'applied' }).nodes().to$().find('input').prop('checked', true);
        else
            table.rows({ filter: 'applied' }).nodes().to$().find('input').prop('checked', false);
    };

    this_receiving.table_select = () => 
    {
        var checked_data = $('#tbl_special').find('tbody input:checkbox:checked').length; // Get count of checkboxes that is checked
        // if all checkboxes are checked, then set property of main checkbox to "true", else set to "false"
        $('#chk_parent_special').prop('checked', (checked_data === $('#tbl_special').find('tbody input:checkbox').length));
    };

    this_receiving.special = () => 
    {
        datas = {};
        var data = $(this).parents('tr:eq(0)');
        var length = $("input[name='chk_child_special[]']:checked").length;
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
                    // $('.loader').show();
                    $('#btn_receiving_special').prop('disabled', true)
                    var dr_control = [];
                    var count = 0;
                    var rowcollection = table.$(".chk_child_special:checked", { "page": "all" });

                    rowcollection.each(function (index, elem) 
                    {
                        var tr_data = $(this).parents('tr:eq(0)');
                        var dr_control_no = $(tr_data).find('td:eq(1)').text();
                        var recipient = $('#txt_user_id').val();

                        dr_control[count] = 
                        {
                            "dr_control": dr_control_no,
                            "recipient": recipient,
                        };
                        count++;
                    });

                    if (dr_control.length > 0) 
                    {
                        instance.patch(`update-receive`,
                        {
                            data: dr_control,
                        }).then((response) => 
                        {
                            if (response['statusText'] == 'OK')
                            {
                                toastr.success('Successfull! \n Thank you', 'System Message')
                                document.getElementById('notification_success').play();
                            }   
                        }).catch((error) => 
                        {
                            toastr.error('There was a problem in loading the data. Please contact the administrator \nThank you', 'System Message')
                            document.getElementById('notification').play();
                            console.log(error)
                        }).finally(() => 
                        {
                            // $('.loader').hide();
                            $('#btn_receiving_special').prop('disabled', false)
                            RECEIVING.load_for_special();
                        })
                    }
                }
            })
        }
    };


    return this_receiving;
})();