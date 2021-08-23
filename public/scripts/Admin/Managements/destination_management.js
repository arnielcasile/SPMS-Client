$("#mod_destination" ).on('shown.bs.modal', function(){
    DESTINATION.load_destination_list();
$('#btn_update_destination').prop('hidden', true);
});

const DESTINATION = (() => 
{
    let this_destination = {};
    let deleted_at_value = "";
    let payee_code_list = [];

    this_destination.load_destination_list = () => 
    {     
       // $('.loader').show();
        var on = '../public/icons/on.png';
        var off ='../public/icons/off.png'; 

        instance.get(`/destination-all`).then((response) => 
        {
            if (response['statusText'] == 'OK') 
            {
                payee_code_list = [];
                $('#thead_destination').DataTable().destroy();
                $('#tbody_destination').empty();

                var tr = '';
                var x = 1;
                $.each(response['data'].data, function () 
                {
                    var status_value = " ";
                    var special_process = " ";
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

                    if (this.pdl == 0)
                    {
                        special_process ="Normal";
                    }
                    else if (this.pdl == 2)
                    {
                        special_process ="Special";
                    }
                    else
                    {
                        special_process ="W/O DR";
                    }

                    tr += `<tr>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${x}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.payee_cd}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.payee_name}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.destination}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.attention_to}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.destination_class}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.purpose}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${special_process}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${status_value}" height="30" width="60" id="chk_dashboard" onclick="DESTINATION.on_off(${this.id},'${this.deleted_at}')">
                            </td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <button type="button" class="btn btn-warning" title="Edit area code" ${edit_button} onclick="DESTINATION.display_destination('${this.payee_cd}','${this.payee_name}','${this.destination}','${this.attention_to}','${this.destination_class}','${this.purpose}', ${this.pdl}, ${this.id}, '${this.deleted_at}')"><i class="fa fa-pencil"></i></button>
                            </td>
                         </tr>`;
                    x++;
                    payee_code_list.push(this.payee_cd);
                });

                $('#tbody_destination').html(tr);
                $('#thead_destination').DataTable({
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
                    "fnDrawCallback": function () {
                        $('#thead_destination td').each(function () {
                            if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') {
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
    };

    this_destination.on_off = (id,deleted_at) =>
    {
        Swal.fire(swal_options).then((result) =>
        {
            if (result.value)
            {
                var status_update = "";
                if (deleted_at == 'null')
                {
                    status_update = "to inactive";
                    DESTINATION.inactive_destination(id);
                }
                else
                {
                    status_update = "to active";
                    DESTINATION.active_destination(id);
                }
            }
        })
    }

    this_destination.inactive_destination = (id) => 
    {
        instance.delete(`destination`,
        {
            params: ({
                        id : id
                    })
        }).then((response) => 
        {
            Swal.fire({
                title : 'Success!', 
                html : `The data has been deactivated.`,
                icon: 'success',
                onclose :  DESTINATION.clear_inputs()
            });
            DESTINATION.cancel_transaction();
            document.getElementById('notification_success').play();
        }).catch((error) => 
        {
            toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() => 
        {
            DESTINATION.load_destination_list();
           // $('.loader').hide();
        })
    };

    this_destination.active_destination = (id) =>
    {
        instance.get('destination-active',
        {
            params: ({
                        id : id
                    })

        }).then((responce) =>
        {
            Swal.fire({
                title : 'Success!', 
                html : `The data has been activated.`,
                icon: 'success',
                onclose :  DESTINATION.clear_inputs()
            });
            DESTINATION.cancel_transaction();
            document.getElementById('notification_success').play();
        }).catch((error) =>
        {
            toastr.error('There was a problem in updating the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() =>
        {
            DESTINATION.load_destination_list();
           // $('.loader').hide();
        })
    }

    this_destination.insert_destination = () => 
    {
        var check_if_exist = payee_code_list.includes($('#txt_payee_cd').val());
        
        if($('#txt_payee_cd').val() === '' || $('#txt_payee_name').val() === '' || $('#txt_destination').val() === '' ||
            $('#txt_destination_attention_to').val() === '' || $('#txt_destination_class').val() === '' || $('#slc_special_process').val() === '' ||
            $('#txt_destination_purpose').val() === '')
        {
            toastr.error('Please complete the inputs', 'System Message')
            document.getElementById('notification').play();
        }
        else if(check_if_exist === true)
        {
            toastr.error('Payee code already exist', 'System Message')
            document.getElementById('notification').play();
            DESTINATION.clear_inputs();
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                   // $('.loader').show();
                    instance.get(`destination-exist`,
                    {
                        params: ({
                                    payee_cd : $('#txt_payee_cd').val()
                                })
                    }).then((response) => 
                    {
                        if (response.data.data == null)
                        {
                            DESTINATION.destination_added();
                        }
                        else
                        {
                            toastr.error('Data already Exist')
                            document.getElementById('notification').play();
                            DESTINATION.clear_inputs();
                           // $('.loader').hide();
                        }
                        
                    }).catch((error) => 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                        console.log(error)
                    }).finally(() => 
                    {
                        DESTINATION.load_destination_list();
                       // $('.loader').hide();
                    })
                }
            })
        }
    };

    this_destination.display_destination = (payee_cd, payee_name, destination, attention_to, destination_class, purpose, pdl, id,deleted_at) => 
    {
        if (deleted_at == 'null' || deleted_at == " " || deleted_at == null)
        {
            deleted_at_value = "active";
        }
        else
        {
            deleted_at_value = "inactive";
        }
        if(payee_cd== null)
        {
            payee_cd= '';
        }
      
        if(payee_name== null)
        {
            payee_name= '';
        }

        if(destination== null)
        {
            destination= '';
        }

        if(attention_to== null)
        {
            attention_to= '';
        }

        if(destination_class== null)
        {
            destination_class= '';
        }

        if(purpose== null)
        {
            purpose= '';
        }

        if(pdl== null)
        {
            pdl= '';
        }

        if(id== null)
        {
            id= '';
        }

        $('#txt_payee_cd').val(payee_cd);
        $('#txt_payee_name').val(payee_name);
        $('#txt_destination').val(destination);
        $('#txt_destination_attention_to').val(attention_to);
        $('#txt_destination_class').val(destination_class);
        $('#txt_destination_purpose').val(purpose);
        $('#slc_special_process').val(pdl);
        $('#txt_destination_id').val(id);
        $('#btn_update_destination').prop('hidden', false);
        $('#btn_save_destination').prop('hidden', true);
        // (payee_cd != 'null' ? $('#txt_payee_cd').val(payee_cd) : $('#txt_payee_cd').val(''))
        // (payee_name != 'null' ? $('#txt_payee_name').val(payee_name) : $('#txt_payee_name').val(''))
        // (destination != 'null' ? $('#txt_destination').val(destination) : $('#txt_destination').val(''))
        // (attention_to != 'null' ? $('#txt_destination_attention_to').val(attention_to) : $('#txt_destination_attention_to').val(''))
        // (destination_class != 'null' ? $('#txt_destination_class').val(destination_class) : $('#txt_destination_class').val(''))
        // (purpose != 'null' ? $('#txt_destination_purpose').val(purpose) : $('#txt_destination_purpose').val(''))
        // (pdl != 'null' ? $('#slc_special_process').val(pdl) : $('#slc_special_process').val(''))
        // (id != 'null' ? $('#txt_destination_id').val(id) : $('#txt_destination_id').val(''))
     

        
        
    }

    this_destination.update_destination = () => 
    {
        if($('#txt_payee_cd').val() === '' || $('#txt_payee_name').val() === '' || $('#txt_destination').val() === ''||
            $('#txt_destination_attention_to').val() === '' || $('#txt_destination_class').val() === '' || $('#slc_special_process').val() === '' ||
            $('#txt_destination_purpose').val() === '')
        {
            toastr.error('Please complete the inputs', 'System Message')
            document.getElementById('notification').play();
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                   // $('.loader').show();
                    instance.patch(`/destination`, 
                    {
                        id                  : $('#txt_destination_id').val(),
                        payee_cd            : $('#txt_payee_cd').val(),
                        payee_name          : $('#txt_payee_name').val(),
                        destination         : $('#txt_destination').val(),
                        attention_to        : $('#txt_destination_attention_to').val(),
                        destination_class   : $('#txt_destination_class').val(),
                        pdl                 : $('#slc_special_process').val(),
                        purpose             : $('#txt_destination_purpose').val()
                    }).then((response) => 
                    {
                        if (result.value) 
                        {
                            Swal.fire({
                                title : 'Success!', 
                                html : `The data has been updated.`,
                                icon: 'success',
                                onclose :  DESTINATION.clear_inputs()
                            });
                            DESTINATION.cancel_transaction();
                            document.getElementById('notification_success').play();
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
                        DESTINATION.load_destination_list();
                       // $('.loader').hide();
                    })
                }
            })
        }
    };

    this_destination.destination_added = () =>
    {
        instance.post(`destination`, 
        {
            payee_cd            : $('#txt_payee_cd').val(),
            payee_name          : $('#txt_payee_name').val(),
            destination         : $('#txt_destination').val(),
            attention_to        : $('#txt_destination_attention_to').val(),
            destination_class   : $('#txt_destination_class').val(),
            purpose             : $('#txt_destination_purpose').val(),
            pdl                 : $('#slc_special_process').val()
        }).then((response) => 
        {
            Swal.fire({
                title : 'Success!', 
                html : `All data has been added.`,
                icon: 'success',
                onclose :  DESTINATION.clear_inputs()
            });
            DESTINATION.cancel_transaction();
            document.getElementById('notification_success').play();
        }).catch((error) => 
        {
            toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            document.getElementById('notification').play();
            console.log(error)
        }).finally(() => 
        {
            DESTINATION.load_destination_list();
           // $('.loader').hide();
        })
    }
    this_destination.cancel_transaction = () =>
    {
        $('#txt_payee_cd').val('');
        $('#txt_payee_name').val('');
        $('#txt_destination').val('');
        $('#txt_destination_attention_to').val('');
        $('#txt_destination_class').val('');
        $('#txt_destination_purpose').val('');
        $('#slc_special_process').val('');
        $('#btn_update_destination').prop('hidden', true);
        $('#btn_save_destination').prop('hidden', false);
        DESTINATION.clear_inputs();
    }

    this_destination.clear_inputs = () =>
    {
        $('#txt_payee_cd').val('');
        $('#txt_payee_name').val('');
        $('#txt_destination').val('');
        $('#txt_destination_attention_to').val('');
        $('#txt_destination_class').val('');
        $('#txt_destination_purpose').val('');
        $('#slc_special_process').val('');
        $('#txt_payee_cd').focus();
    }
    
    return this_destination;
})();
