$(document).ready(() => 
{
    $( "#mod_email_mngt" ).on('shown.bs.modal', function(){
        EMAIL.load_email();
        // $('#btn_update_area_code').prop('hidden', true);
    });

});

const EMAIL = (() => 
{
    let this_email_mngt = {};

    this_email_mngt.load_email = () =>
    {
       // $('.loader').show();    

        var on = '../public/icons/on.png';
        var off ='../public/icons/off.png';

        instance.get(`/load-email`).then((response) =>
        {
            if (response['statusText'] == 'OK') 
            {

                $('#thead_email_mngt').DataTable().destroy();
                $('#tbody_email_mngt').empty();

                var tr = '';
                var x = 1;

                $.each(response['data'].data, function () 
                {              

                    var status_value = " ";
                    // let edit_button = '';
                    if (this.deleted_at == null) 
                    {
                        status_value =on;
                    }
                    else
                    {
                        status_value =off;
                        // edit_button = 'disabled'
                    }

                    tr += `
                        <tr>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${x}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.id_number}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.fullname}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.email}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${status_value}" height="30" width="60" id="chk_dashboard" onclick="EMAIL.on_off(${this.id},'${this.deleted_at}')">
                            </td>
                        </tr>`;
                    x++;
                });

                $('#tbody_email_mngt').html(tr);
                $('#thead_email_mngt').DataTable(
                {
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": false,
                    'scrollY':        '50vh',
                    'scrollCollapse': true,
                });
                $('.dataTables_scrollBody').scrollLeft(100); 
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

    this_email_mngt.save_email = () =>
    {
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
               // $('.loader').show();
                instance.post(`/save-email`, 
                {
                    id_number: $('#txt_id_number_mngt').val()
                }).then((response) => 
                {
                    if (response.data.status === 1) 
                    {
                        Swal.fire({
                            title : 'Success!', 
                            html : response.data.message,
                            icon: 'success',
                            onclose :  EMAIL.clear_inputs()
                        });

                        document.getElementById('notification_success').play();
                        EMAIL.clear_inputs();
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
                    EMAIL.clear_inputs()
                    EMAIL.load_email();
                   // $('.loader').hide();
                })
            }
        }) 
    };

    this_email_mngt.on_off = (id,deleted_at) =>
    {
       
        Swal.fire(swal_options).then((result) => 
        {
            if (result.value) 
            {
                if (deleted_at == 'null')
                {
                    EMAIL.inactive(id);
                }
                else
                {
                    EMAIL.active(id);
                }
            }
        })
    }


    this_email_mngt.inactive = (id) => 
    {
        status_update ="update to inactive";
       // $('.loader').show();
        instance.delete(`delete-email`,
        {
            params: ({
                id : id
                    })
        }).then((response) => 
        {
            console.log(response)
            if (response.status) 
            {
                Swal.fire({
                    title : 'Success!', 
                    html : `The Email has been deactivated.`,
                    icon: 'success',
                    onclose :  EMAIL.clear_inputs()
                });
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
            EMAIL.load_email();
           // $('.loader').hide();
        })

    };


    this_email_mngt.active = (id) => 
    {
        status_update ="update to active";
       // $('.loader').show();
        instance.delete(`restore-email`,
        {
            params: ({
                id : id
                    })
        }).then((response) => 
        {
            console.log(response)
            if (response.status) 
            {
                Swal.fire({
                    title : 'Success!', 
                    html : `The Email has been activated.`,
                    icon: 'success',
                    onclose :  EMAIL.clear_inputs()
                });
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
            EMAIL.load_email();
           // $('.loader').hide();
        })

    };

    this_email_mngt.clear_inputs = () =>
    {
        $('#txt_id_number_mngt').val("");
        $('#txt_id_number_mngt').focus();
    };

    return this_email_mngt;
})();