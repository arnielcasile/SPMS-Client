$("#mod_delivery_type" ).on('shown.bs.modal', function(){
    DELIVERY_TYPE.load_delivery_type_list(0);
    $('#btn_update_delivery').prop('hidden', true);
});

const DELIVERY_TYPE = (() => 
{
    let this_delivery_type = {};
    let delivery_type_lists = [];
    let deleted_at_value = "";

    this_delivery_type.load_delivery_type_list = ($page_number) =>
    {
       // $('.loader').show();
        $('#thead_delivery_type').DataTable().destroy();

        var on = '../public/icons/on.png';
        var off ='../public/icons/off.png';

        var tr = '';           
        instance.get(`/delivery-type-all_data`).then(function (response) 
        {
            var x = 1;
          
            if (response['statusText'] == 'OK') 
            {
                $('#thead_delivery_type').DataTable().destroy();
                $('#tbody_delivery_type').empty();

                $.each(response['data'].data, function () 
                {
                    var status_value = " ";
                    let edit_button = '';
                    if (this.deleted_at == null) 
                    {
                        status_value =on;
                    }
                    else
                    {
                        status_value =off;
                        edit_button = 'disabled'
                    }
                    tr += `<tr>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${x}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.delivery_type}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                            <img src="${status_value}" height="30" width="60" id="chk_dashboard" onclick="DELIVERY_TYPE.on_off(${this.id},'${this.deleted_at}')">
                            </td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <button type="button" class="btn btn-warning" title="Edit delivery type" ${edit_button} onclick="DELIVERY_TYPE.display_delivery_type('${this.delivery_type}', '${this.deleted_at}',${this.id})"><i class="fa fa-pencil"></i></button>
                            </td>
                         </tr>`;
                    x++;
                    delivery_type_lists.push(this.delivery_type); 
                });

                $('#tbody_delivery_type').html(tr);
                var table=$('#thead_delivery_type').DataTable({
                    "scrollX": true,
                    "scrollY": true,
                    "paging": false,
                    "lengthChange": true,
                    "scrollY":        '50vh',
                    "scrollCollapse": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
                table.page($page_number).draw( 'page' );
            }
            else 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you!', 'System Message')
                document.getElementById('notification_success').play();
            }
        }).catch(function (error) 
        {
            toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you!', 'System Message')
            document.getElementById('notification_success').play();
            console.log(error)
        }).finally(function () 
        {
           // $('.loader').hide();
        })
    };

    this_delivery_type.on_off = (id,deleted_at) =>
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                if (deleted_at == 'null')
                {
                    DELIVERY_TYPE.inactive_delivery_type(id);
                    status_update = "to inactive";
                }
                else
                {

                    DELIVERY_TYPE.active_delivery_type(id);
                    status_update = "to active";
                }
            }
        })
    }


    this_delivery_type.inactive_delivery_type = (id) => 
    {
        instance.delete(`delivery-type`,
        {
            params: ({
                        id : id, 
                        })
        }).then(function (response) 
        {
            if (response.data.status == 1)
            {
                // Swal.fire({
                //     title : 'Success!', 
                //     html : `The delivery type has been deactivated.`,
                //     icon: 'success',
                //     onclose :  DELIVERY_TYPE.clear_inputs()
                // });
                toastr.success('Successfully deactivated. Thank you', 'System Message');     
                DELIVERY_TYPE.clear_inputs();
                document.getElementById('notification_success').play();
            }
            else
            {
                toastr.error(response.data.message)
                document.getElementById('notification').play();
            }
        }).catch(function (error) 
        {
            toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error);
        }).finally(function () 
        {
            var table = $("#thead_delivery_type").DataTable();
            var info = table.page.info();	
            DELIVERY_TYPE.load_delivery_type_list(info.page);
           // $('.loader').hide();
        })
    };

    this_delivery_type.active_delivery_type = (id) =>
    {
        status_update ="update to active";
       // $('.loader').show();
        instance.patch(`/delivery-type-active`, 
        {
            id        : id
        }).then((response) => 
        {
            if (response.data.status == 1) 
            {
                // Swal.fire({
                //     title : 'Success!', 
                //     html : `The delivery type has been activated.`,
                //     icon: 'success',
                //     onclose :  DELIVERY_TYPE.clear_inputs()
                // });
                toastr.success('Successfully activated. Thank you', 'System Message');
                DELIVERY_TYPE.clear_inputs();     
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
            console.log(error);
        }).finally(() => 
        {
            var table = $("#thead_delivery_type").DataTable();
            var info = table.page.info();	
            DELIVERY_TYPE.load_delivery_type_list(info.page);
            DELIVERY_TYPE.cancel_transaction();
            area_code_lists = [];
           // $('.loader').hide();
        })
    }

    this_delivery_type.insert_delivery_type = () => 
    {
        var check_if_exist = delivery_type_lists.includes($('#txt_delivery_type').val());

        if($('#txt_delivery_type').val() === '')
        {
            toastr.error('Please enter delivery type', 'System Message')
            document.getElementById('notification').play();
            DELIVERY_TYPE.clear_inputs();
        }
        else if(check_if_exist === true)
        {
            toastr.error('Delivery type already exist', 'System Message')
            document.getElementById('notification').play();
            DELIVERY_TYPE.clear_inputs();
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                   // $('.loader').show();
                    instance.post(`delivery-type`, 
                    {
                        delivery_type: $('#txt_delivery_type').val()
                    }).then((response) =>
                    {
                        if (response.data.status == 1)
                        {
                            // Swal.fire({
                            //     title : 'Success!', 
                            //     html : `The delivery type has been added.`,
                            //     icon: 'success',
                            //     onclose :  DELIVERY_TYPE.clear_inputs()
                            // });
                            toastr.success('Successfully added. Thank you', 'System Message');   
                            DELIVERY_TYPE.clear_inputs();  
                            DELIVERY_TYPE.cancel_transaction();
                            document.getElementById('notification_success').play();
                        }
                        else
                        {
                            toastr.error(response.data.message)
                            document.getElementById('notification').play();
                        }
                    }).catch(function (error) 
                    {
                        toastr.error('There was a problem in loading the daload_area_code_list ta. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                        console.log(error)
                    }).finally(function () 
                    {
                        var table = $("#thead_delivery_type").DataTable();
                        var info = table.page.info();	
                        DELIVERY_TYPE.load_delivery_type_list(info.page);
                        delivery_type_lists = [];
                       // $('.loader').hide();
                    })
                }
            })
        }
    };

    this_delivery_type.display_delivery_type = (area_code, deleted_at, id) => 
    {
        if (deleted_at == 'null' || deleted_at == " " || deleted_at == null)
        {
            deleted_at_value = "active";
        }
        else
        {
            deleted_at_value = "inactive";
        }
        $('#txt_delivery_type').val(area_code);
        $('#txt_delivery_type_id').val(id);
        $('#btn_update_delivery').prop('hidden', false);
        $('#btn_save_delivery').prop('hidden', true);
    }

    this_delivery_type.update_delivery_type = () => 
    {
        var check_if_exist = delivery_type_lists.includes($('#txt_delivery_type').val());

        if($('#txt_delivery_type').val() === '')
        {
            toastr.error('Please enter delivery type', 'System Message')
            document.getElementById('notification').play();
            DELIVERY_TYPE.clear_inputs();
        }
        else if(check_if_exist === true)
        {
            toastr.error('Delivery type already exist', 'System Message')
            DELIVERY_TYPE.clear_inputs();
            document.getElementById('notification').play();
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                   // $('.loader').show();
                    instance.patch(`delivery-type`, 
                    {
                        id            : $('#txt_delivery_type_id').val(),
                        delivery_type : $('#txt_delivery_type').val()
                    }).then(function (response) 
                    {
                        // Swal.fire({
                        //     title : 'Success!', 
                        //     html : `The delivery type has been updated.`,
                        //     icon: 'success',
                        //     onclose :  DELIVERY_TYPE.clear_inputs()
                        // });
                        toastr.success('Successfully updated. Thank you', 'System Message'); 
                        DELIVERY_TYPE.clear_inputs();    
                        document.getElementById('notification_success').play();
                        DELIVERY_TYPE.cancel_transaction();
                    }).catch(function (error) 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                        console.log(error)
                    }).finally(function () 
                    {
                        var table = $("#thead_delivery_type").DataTable();
                        var info = table.page.info();	
                        DELIVERY_TYPE.load_delivery_type_list(info.page);
                        delivery_type_lists = [];
                       // $('.loader').hide();
                    })
                }
            })
        }
    };

    this_delivery_type.cancel_transaction = () =>
    {
        $('#txt_delivery_type').val('');
        $('#btn_update_delivery').prop('hidden', true);
        $('#btn_save_delivery').prop('hidden', false);
        DELIVERY_TYPE.clear_inputs();
    }

    this_delivery_type.clear_inputs = () =>
    {
        $('#txt_delivery_type').val("");
        $('#txt_delivery_type').focus();
    }
    return this_delivery_type;
})();
