
$('#mod_remarks').on('shown.bs.modal', function (e) 
{
    $('#txt_wclass').val(area_code);
    $('#txt_remarks_issued_date').val(date_today);
    REMARKS.load_remarks();
})

const REMARKS = (() =>
{
    let this_remarks = {};

    this_remarks.load_remarks = () => 
    { 
        if( $('#txt_remarks_issued_date').val() != '')
        {
            REMARKS.clear_inputs();
            instance.get(`load-remarks`,{
                params: ({
                            issued_date  : $('#txt_remarks_issued_date').val(),
                            area_code    : area_code
                        })
            }).then((response) => 
            {
                if (response['statusText'] == 'OK') 
                {
                    $('#btn_cancel_transaction_remarks').prop('disabled', true)
                    if(response['data'].data.length == 0)
                    {
                        $("#add_remarks").css("background-color","#c0f5ba");
                        $("#add_remarks").prop("disabled",false);
                    
                        $("#add_remarks").css("cursor","pointer");
                    
                        $("#edit_remarks").css("cursor","not-allowed");
                        $("#cancel_remarks").css("cursor","not-allowed");
                        $("#cancel_remarks").prop("disabled",true);
                        $("#edit_remarks").prop("disabled",true);
                    }
                    else
                    {
                        $("#edit_remarks").css("background-color","#b0e9ff");
                        $("#edit_remarks").prop("disabled",false);
                        $("#edit_remarks").css("cursor","pointer");

                        $("#cancel_remarks").css("background-color","#fcacac");
                        $("#cancel_remarks").prop("disabled",false);
                        $("#cancel_remarks").css("cursor","pointer");

                        $("#add_remarks").css("cursor","not-allowed");
                        $("#add_remarks").prop("disabled",true);
                        $.each(response['data'].data, function () 
                        {
                            $("#txt_remarks").val(this.remarks);
                            $("#txt_corrective_action").val(this.corrective_action);    
                            $("#txt_remarks_id").val(this.id);    
                        });
                    } 
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
                $('#btn_cancel_transaction_remarks').prop('disabled', false)
            })
        }
        else
        {
            REMARKS.clear_inputs();
        }
    };
    
    this_remarks.add_remarks = () =>
    {
   
            if ((/\S/.test($("#txt_remarks").val())) && (/\S/.test($("#txt_corrective_action").val())))
            {
                // found something other than a space or line break
            if($('#txt_remarks_issued_date').val() === '')
            {
                toastr.error('Please select issued date, Thank you.', 'System Message')
                document.getElementById('notification').play();
            }
            else if($("#txt_remarks").val() === '')
            {
                toastr.error('Please input remarks, Thank you.', 'System Message')
                document.getElementById('notification').play();
            }
            else if($("#txt_corrective_action").val() === '')
            {
                toastr.error('Please input corrective action, Thank you.', 'System Message')
                document.getElementById('notification').play();
            }
            else
            {
                Swal.fire(swal_options).then((result) => 
                {
                    if (result.value) 
                    {
                        // $('.loader').show();
                        instance.post(`/add-remarks`, 
                        {
                            issued_date         : $("#txt_remarks_issued_date").val(),
                            area_code           : $("#txt_wclass").val(),
                            remarks             : $("#txt_remarks").val(),
                            corrective_action   : $("#txt_corrective_action").val()
                        }).then((response) => 
                        {
                        if (response.data.message === '') 
                        {
                            Swal.fire('Success!', `The remarks has been added.`, 'success')
                            document.getElementById('notification_success').play();
                        }
                        else 
                        {
                            toastr.error(response.data.message)
                            document.getElementById('notification').play();
                        }
                        }).catch((error) => 
                        {
                            toastr.error('There was a problem in adding the data. Please contact the administrator. Thank you', 'System Message')
                            document.getElementById('notification').play();
                            console.log(error)
                        }).finally(() => 
                        {
                            // $('.loader').hide();
                            REMARKS.clear_inputs();
                            $('#txt_remarks_issued_date').val(date_today);
                            REMARKS.load_remarks();
                        })
                    }
                })
            }
        }
        else
        {
            toastr.error('No letter or number detected. Thank you', 'System Message')
        }
    };

    this_remarks.update_remarks = () =>
    {
        if($('#txt_remarks_issued_date').val() === '')
        {
            toastr.error('Please select issued date, Thank you.', 'System Message')
            document.getElementById('notification').play();
        }
        else if($("#txt_remarks").val() === '')
        {
            toastr.error('Please input remarks, Thank you.', 'System Message')
            document.getElementById('notification').play();
        }
        else if($("#txt_corrective_action").val() === '')
        {
            toastr.error('Please input corrective action, Thank you.', 'System Message')
            document.getElementById('notification').play();
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                    // $('.loader').show();
                    instance.patch(`/update-remarks`, 
                    {
                        id                  : $("#txt_remarks_id").val(),
                        issued_date         : $("#txt_remarks_issued_date").val(),
                        area_code           : $("#txt_wclass").val(),
                        remarks             : $("#txt_remarks").val(),
                        corrective_action   : $("#txt_corrective_action").val()
                    }).then((response) => 
                    {
                    if (response.data.message === '') 
                    {
                        Swal.fire('Success!', `The remarks has been updated.`, 'success')
                        document.getElementById('notification_success').play();
                    }
                    else 
                    {
                        toastr.error('There was a problem in updating the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                    }
                    }).catch((error) => 
                    {
                        toastr.error('There was a problem in updating the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                        console.log(error)
                    }).finally(() => 
                    {
                        // $('.loader').hide();
                        REMARKS.clear_inputs();
                        $('#txt_remarks_issued_date').val(date_today);
                        REMARKS.load_remarks();
                      
                    })
                }
            })
        }
    };

    this_remarks.cancel_remarks = () =>
    {
        if($('#txt_remarks_issued_date').val() === '')
        {
            toastr.error('Please select issued date, Thank you.', 'System Message')
            document.getElementById('notification').play();
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
            {
                if (result.value) 
                {
                    // $('.loader').show();
                    instance.delete(`/remove-remarks`, 
                    {
                        params: ({
                                    id : $("#txt_remarks_id").val()
                                })
                    }).then((response) => 
                    {
                    if (response.data.message === '') 
                    {
                        Swal.fire('Success!', `The remarks has been removed.`, 'success')
                        document.getElementById('notification_success').play();
                    }  
                    else 
                    {
                        toastr.error('There was a problem in removing the data. Please contact the administrator. Thank you', 'System Message')
                        document.getElementById('notification').play();
                    }
                    }).catch((error) => 
                    {
                        toastr.error('There was a problem in removing the data. Please contact the administrator. Thank you', 'System Message')
                        console.log(error);
                        document.getElementById('notification').play();
                    }).finally(() => 
                    {
                        // $('.loader').hide();
                        REMARKS.clear_inputs();
                        $("#txt_remarks_issued_date").val('');
                    })
                }
            })
        }
    };

    this_remarks.clear_inputs = () =>
    { 
        $("#txt_remarks").val('');
        $("#txt_corrective_action").val('');
        // $("#txt_remarks_issued_date").val('');

        
        $("#add_remarks").prop("disabled",true);
        $("#add_remarks").css("cursor","not-allowed");
        $("#add_remarks").css("background-color","#ffffff");
        
        $("#edit_remarks").prop("disabled",true);
        $("#edit_remarks").css("cursor","not-allowed");
        $("#edit_remarks").css("background-color","#ffffff");

        $("#cancel_remarks").prop("disabled",true);
        $("#cancel_remarks").css("cursor","not-allowed");
        $("#cancel_remarks").css("background-color","#ffffff");


    };

    this_remarks.cancel_transaction = () =>
    { 
        REMARKS.clear_inputs();
    };

    return this_remarks;
})();