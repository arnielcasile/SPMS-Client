$("#mod_area_code" ).on('shown.bs.modal', function(){
    window.paceOptions = {
        ajax: false,
        restartOnRequestAfter: false,
    };
    AREA_CODE.load_area_code_list(0);
    $('#btn_update_area_code').prop('hidden', true);
});
const AREA_CODE = (() => 
{
    let this_area_code = {};
    let area_code_lists = [];
    let deleted_at_value = [];

    this_area_code.load_area_code_list = ($page_number) => 
    {                  
       // $('.loader').show();    

        var on = '../public/icons/on.png';
        var off ='../public/icons/off.png';

        instance.get(`/area-code-restore`).then((response) =>
        {
            if (response['statusText'] == 'OK') 
            {
                $('#thead_area_code').DataTable().destroy();
                $('#tbody_area_code').empty();

                var tr = '';
                var x = 1;

                $.each(response['data'].data, function () 
                {    
                    var status_value = " ";
                    let edit_button = '';
                    // if (this.deleted_at == null) 
                    // {
                    //     status_value =on;
                    // }
                    // else
                    // {
                    //     status_value =off;
                    //     edit_button = 'disabled'
                    // }

                    
                    tr += `
                        <tr>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${x}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.area_code}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                            ${(this.deleted_at == null ?  
                                `<img src=${on} height="30" width="60" id="chk_dashboard" onclick="AREA_CODE.on_off(${this.id},'${this.deleted_at}')"></img>`:
                                `<img src=${off} height="30" width="60" id="chk_dashboard" onclick="AREA_CODE.on_off(${this.id},'${this.deleted_at}')"></img>`)}
                               
                            </td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                            ${(this.deleted_at == null ?  
                                `<button type="button" class="btn btn-warning" id="edit_button_${x}" title="Edit area code" onclick="AREA_CODE.display_area_code('${this.area_code}', '${this.deleted_at}',${this.id})" readonly><i class="fa fa-pencil"></i></button>`:
                                `<button type="button" class="btn btn-warning" id="edit_button_${x}" title="Edit area code" disabled onclick="AREA_CODE.display_area_code('${this.area_code}', '${this.deleted_at}',${this.id})" readonly><i class="fa fa-pencil"></i></button>`)}
                            </td>
                        </tr>`;
                    x++;
                    area_code_lists.push(this.area_code);   
                    
                });

                $('#tbody_area_code').html(tr);
                var table=$('#thead_area_code').DataTable(
                {
                    "scrollX": true,
                    "scrollY": true,
                    "paging": false,
                    "lengthChange": true,
                    "scrollY":        '50vh',
                    "scrollCollapse": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": false
                });
                table.page($page_number).draw( 'page' );
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
    this_area_code.on_off = (id,deleted_at) =>
    {
       
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                if (deleted_at == 'null')
                {
                    AREA_CODE.inactive(id);
                }
                else
                {
                    AREA_CODE.active(id);
                }
            }
        })
    }


    this_area_code.insert_area_code = () => 
    {
        var check_if_exist = area_code_lists.includes($('#txt_area_code_mngt').val());

        if($('#txt_area_code_mngt').val() === '')
        {
            toastr.error('Please enter area code', 'System Message')
            document.getElementById('notification').play();
            AREA_CODE.clear_inputs();
        }
        else if(check_if_exist === true)
        {
            toastr.error('Area code already exist', 'System Message')
            document.getElementById('notification').play();
            AREA_CODE.clear_inputs();
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                   // $('.loader').show();
                    instance.post(`/area-code`, 
                    {
                        area_code: $('#txt_area_code_mngt').val()
                    }).then((response) => 
                    {
                        if (response.data.message === '') 
                        {
                            // Swal.fire({
                            //     title : 'Success!', 
                            //     html : `The area code has been added.`,
                            //     icon: 'success',
                            //     onclose :  AREA_CODE.clear_inputs()
                            // });
                            toastr.success('Successfully Inserted. Thank you', 'System Message');     
                            document.getElementById('notification_success').play();
                        }
                        else 
                        {
                            toastr.error(response.data.message)
                            document.getElementById('notification').play();
                        }
                    }).catch((error) => 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                        console.log(error)
                    }).finally(() => 
                    {
                        var table = $("#thead_area_code").DataTable();
                        var info = table.page.info();	
                        AREA_CODE.load_area_code_list(info.page);
                        AREA_CODE.clear_inputs();
                        area_code_lists = [];
                       // $('.loader').hide();
                    })
                }
            })
        }
    };

    this_area_code.display_area_code = (area_code, deleted_at, id) => 
    {

        // $("#edit_button").attr("disabled", false);
        // if ((deleted_at == 'null') || (deleted_at == " ") || (deleted_at == null))
        // {
        //     deleted_at_value = "active";
        // }
        // else
        // {
        //     deleted_at_value = "inactive";
        // }
        $('#txt_area_code_mngt').val(area_code);
        // $('#slc_status').val(status_value_edit);
        $('#txt_area_code_id').val(id);
        $('#btn_update_area_code').prop('hidden', false);
        $('#btn_save_area_code').prop('hidden', true);
        // $('#for_select_status').prop('hidden', false);
    };

    this_area_code.update_area_code = () => 
    { 
        var check_if_exist = area_code_lists.includes($('#txt_area_code_mngt').val());

        if($('#txt_area_code_mngt').val() === '')
        {
            toastr.error('Please enter area code', 'System Message')
            AREA_CODE.clear_inputs();
        }
        else if(check_if_exist === true)
        {
            toastr.error('Area code already exist', 'System Message')
            AREA_CODE.clear_inputs();
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                   // $('.loader').show();
                    instance.patch(`/area-code`, 
                    {
                        id        : $('#txt_area_code_id').val(),
                        area_code : $('#txt_area_code_mngt').val(),
                        // deleted_at: $('#slc_status').val()
                    }).then((response) => 
                    {
                        // Swal.fire({
                        //     title : 'Success!', 
                        //     html : `The area code has been updated.`,
                        //     icon: 'success',
                        //     onclose :  AREA_CODE.clear_inputs()
                        // });
                        toastr.success('Successfully Updated. Thank you', 'System Message');
                        document.getElementById('notification_success').play();
                        $('#btn_update_area_code').prop('hidden', true);
                        $('#btn_save_area_code').prop('hidden', false);
                    }).catch((error) => 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                        console.log(error)
                    }).finally(() => 
                    {
                        var table = $("#thead_area_code").DataTable();
                        var info = table.page.info();	
                        AREA_CODE.load_area_code_list(info.page);
                        AREA_CODE.clear_inputs();
                        area_code_lists = [];
                       // $('.loader').hide();
                    })
                }
            })
        }
    };

    this_area_code.inactive = (id) => 
    {
        status_update ="update to inactive";
       // $('.loader').show();
        instance.delete(`area-code`,
        {
            params: ({
                        id : id
                    })
        }).then((response) => 
        {
            if (response.status) 
            {
                // Swal.fire({
                //     title : 'Success!', 
                //     html : `The area code has been deactivated.`,
                //     icon: 'success',
                //     onclose :  AREA_CODE.clear_inputs()
                // });
                toastr.success('Successfully Changed. Thank you', 'System Message');
                document.getElementById('notification_success').play();
            }
            else 
            {
                toastr.error('There was a problem in deactivating the data. Please contact the administrator. Thank you', 'System Message')
                document.getElementById('notification').play();
            }
        }).catch((error) => 
        {
            toastr.error('There was a problem in deactivating the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() => 
        {
            var table = $("#thead_area_code").DataTable();
            var info = table.page.info();	
            AREA_CODE.load_area_code_list(info.page);
            AREA_CODE.clear_inputs();
           // $('.loader').hide();
        })

    };

    this_area_code.active = (id) =>
    {
        status_update ="update to active";
       // $('.loader').show();
        instance.patch(`/area-active`, 
        {
            id        : id
        }).then((response) => 
        {
            if (response.status) 
            {
                // Swal.fire({
                //     title : 'Success!', 
                //     html : `The area code has been activated.`,
                //     icon: 'success',
                //     onclose :  AREA_CODE.clear_inputs()
                // });
                toastr.success('Successfully Changed. Thank you', 'System Message');
                document.getElementById('notification_success').play();
                $('#btn_update_area_code').prop('hidden', true);
                $('#btn_save_area_code').prop('hidden', false);
            }
            else
            {
                toastr.error(response.message)
                document.getElementById('notification').play();
            }
        }).catch((error) => 
        {
            toastr.error('There was a problem in deactivating the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() => 
        {
            var table = $("#thead_area_code").DataTable();
            var info = table.page.info();	
            AREA_CODE.load_area_code_list(info.page);
            AREA_CODE.clear_inputs();
            area_code_lists = [];
           // $('.loader').hide();
        })
    }

    this_area_code.cancel_transaction = () =>
    {
        $('#txt_area_code_mngt').val("");
        $('#btn_update_area_code').prop('hidden', true);
        $('#btn_save_area_code').prop('hidden', false);
        AREA_CODE.clear_inputs();
    }

    this_area_code.clear_inputs = () =>
    {
        $('#txt_area_code_mngt').val("");
        $('#txt_area_code_mngt').focus();
    }
    return this_area_code;
})();
