$(document).ready(() => {
    $('#slc_master_range').val('DAILY');
    $('#txt_sync_date_from').val(date_today);
    $('#txt_sync_date_to').val(date_today);
    $('#txt_master_date_from').val(date_today);
    $('#txt_master_date_to').val(date_today);
    $('#txt_master_month_date_from').val(month_today);
    $('#txt_master_month_date_to').val(month_today);

    MASTER.load_master_list();
});

const MASTER = (() => {
    let this_master = {};
    let date_from = '';
    let date_to = '';

    this_master.date_change_from_masterlist = () => {
        $('#txt_master_date_to').val($('#txt_master_date_from').val());
    };

    this_master.date_change_from_sync = () => {
        $('#txt_sync_date_to').val($('#txt_sync_date_from').val());
    };

    this_master.btn_add_master = () => {
        $('#div_add_master').prop('hidden', false)
        $('#btn_upload_master').prop('hidden', false)
    };

    this_master.btn_cancel_master = () => {
        $("#txt_upload_master").val('');
        $('#div_add_master').prop('hidden', true)
    };

    this_master.btn_add_sync = () => {
        $('#div_add_sync').prop('hidden', false)
        $('#btn_submit_sync').prop('hidden', false)
    };

    this_master.btn_cancel_sync = () => {
        $('#div_add_sync').prop('hidden', true)
    };

    this_master.onchange_datepicker = () => {
        if ($('#slc_master_range').val() === 'MONTHLY') {
            $('#txt_master_date_from').prop('hidden', true);
            $('#txt_master_date_to').prop('hidden', true);
            $('#txt_master_month_date_from').prop('hidden', false);
            $('#txt_master_month_date_to').prop('hidden', false);
        }
        else {
            $('#txt_master_date_from').prop('hidden', false);
            $('#txt_master_date_to').prop('hidden', false);
            $('#txt_master_month_date_from').prop('hidden', true);
            $('#txt_master_month_date_to').prop('hidden', true);
        }
    };

    this_master.load_master_list = () => {
        if ($('#slc_master_range').val() === 'MONTHLY') {
            var from = new Date($('#txt_master_month_date_from').val());
            var to = new Date($('#txt_master_month_date_to').val());
            var first_date = new Date(from.getFullYear(), from.getMonth(), 1);
            var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0);

            date_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' +
                ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

            date_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' +
                ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
        }
        else {
            date_from = $('#txt_master_date_from').val();
            date_to = $('#txt_master_date_to').val();
        }

        if ($('#slc_master_range').val() === '' || date_from === '' || date_to === '' || date_from === 'NaN-0NaN-0NaN' || date_to === 'NaN-0NaN-0NaN') {
            toastr.error('Please complete the inputs', 'System Message')
        }
        else if (date_from > date_to) {
            toastr.error('Invalid date range', 'System Message')
        }
        else {
           // $('.loader').show();
            instance.get(`master-data`,
                {
                    params: ({
                        from: date_from,
                        to: date_to,
                        area_code: area_code
                    })
                }).then((response) => {
                    var data = response.data.data;
                    if (response['statusText'] == 'OK') {
                        if (data.length === 0) {
                            $('#thead_master').DataTable().destroy();
                            $('#tbody_master').empty();
                            toastr.warning('No data matched in the database. Thank you', 'System Message')
                            
                        }
                        else {
                            $('#thead_master').DataTable().destroy();
                            $('#tbody_master').empty();

                            var tr = '';

                            $.each(data, function () {
                                tr += `<tr>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.warehouse_class}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_form}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.item_no}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.item_rev}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_qty}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.stock_address}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.manufacturing_no}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_inst_date}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.destination_code}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.item_name}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.product_no}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_no}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_issue_date}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_issue_time}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.storage_location}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_due_date}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.order_download_no}</td>
                                    </tr>`;
                            });

                            $('#tbody_master').html(tr);
                            $('#thead_master').DataTable({
                                "scrollX": true,
                                "scrollY": true,
                                "paging": false,
                                "lengthChange": true,
                                "scrollY":        '80vh',
                                "scrollCollapse": true,
                                "searching": true,
                                "ordering": false,
                                "info": true,
                                "autoWidth": true,
                                "fnDrawCallback": function () {
                                    $('#tbody_master td').each(function () {
                                        if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') {
                                            $(this).text('');
                                        }
                                    });
                                },
                                dom: 'Blfrtip',
                                buttons: [
                                    {
                                        extend: 'csv',
                                        text: 'EXPORT CSV FILE'
                                    }
                                ]
                            });
                        }
                    }
                    else {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    }
                }).catch((error) => {
                    console.log(error)
                }).finally(() => {
                   // $('.loader').hide();
                })
        }
    };
    this_master.sync_data = () => {
        if ($('#txt_sync_date_from').val() === '' || $('#txt_sync_date_to').val() === '') {
            toastr.error('Please select a date', 'System Message')
        }
        else if ($('#txt_sync_date_from').val() > $('#txt_sync_date_to').val()) {
            toastr.error('Invalid date range', 'System Message')
        }
        else {
            $("#sync_logo").addClass("fa fa-refresh fa-spin");
            $("#btn_submit_sync").prop('disabled',true);
            instance.get(`/sync`,
                {
                    params: ({
                        from: $('#txt_sync_date_from').val().split("-").join("/"),
                        to: $('#txt_sync_date_to').val().split("-").join("/"),
                        area_code: area_code
                    })
                }).then((response) => {

                    if (response['statusText'] == 'OK') {
                        $("#sync_logo").removeClass("fa fa-refresh fa-spin");
                        $('#txt_sync_date_from').val('');
                        $('#txt_sync_date_to').val('');
                        $('#thead_master').DataTable().destroy();
                        $('#tbody_master').empty();

                        var tr = '';

                        $.each(response['data'], function () {
                            tr += `<tr>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.warehouse_class}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_form}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.item_no}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.item_rev}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_qty}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.stock_address}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.manufacturing_no}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_inst_date}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.destination_code}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.item_name}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.product_no}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_no}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_issue_date}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.ticket_issue_time}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.storage_location}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_due_date}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.order_download_no}</td>
                             </tr>`;
                        });

                        $('#tbody_master').html(tr);
                        $('#thead_master').DataTable({
                            "scrollX": true,
                            "scrollY": '500px',
                            "paging": true,
                            "lengthChange": false,
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
                            ]
                        });
                        $("#sync_logo").prop('disabled',false);
                    }
                    else {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    }
                }).catch((error) => {
                    console.log(error)
                }).finally(() => {
                    $('#thead_area_code').LoadingOverlay('hide');
                    $("#btn_submit_sync").prop('disabled',false);
                })
        }
    };

    this_master.upload_master = () => {
        var dataForm = new FormData();
        var file = $("#txt_upload_master").val();
        dataForm.append('select_file', $('#txt_upload_master')[0].files[0]);
        var sCurExtension = ".csv";
        var blnValid = false;
        if (file.substr(file.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) 
        {
            blnValid = true;
        }
        if (file.length < 4)//default 4 https://stackoverflow.com/questions/46219/how-to-determine-if-user-selected-a-file-for-file-upload
        {
            toastr.warning('Please insert a file. Thank you', 'System Message')
        }
        else 
        {
            if (!blnValid) {
                toastr.warning('Invalid file type. Please select a csv file. Thank you', 'System Message')
            }
            else
            {
                $("#upload_logo").addClass("fa fa-spinner fa-pulse");
                $("#btn_upload_master").prop('disabled',true);
                instance.post('http://10.164.30.173/pdls-v2/client/public/import_excel', dataForm,
                    {
                        headers:
                        {
                            'Content-Type': 'multipart/form-data'
                        },
                    }).then(function (response) {
                        // MASTER.load_master_list();
                        // console.log(response);
                        if(response.data.status == 1)
                        {
                            toastr.error(response.data.data);
                            $("#txt_upload_master").val('');
                        }
                        else if(response.data.status == 2)
                        {
                            toastr.warning(response.data.data);
                            $("#txt_upload_master").val('');
                           
                        }
                        else
                        {
                            toastr.success(response.data.data);
                            $("#txt_upload_master").val('');
                            MASTER.load_master_list();
                        }
                        $("#upload_logo").prop('disabled',false);
                    })
                    
                    .catch((error) => {
                        console.log(error);
                        toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
                        // setTimeout(
                        //     function() 
                        //     {
                        //         window.location.reload();
                        //     }, 1000);
                    }).finally(() => {
                        $("#upload_logo").removeClass("fa fa-spinner fa-pulse");
                        $("#btn_upload_master").prop('disabled',false);
                    })
            }
        }
    };

    return this_master;
})();
