
const MAIN = (() => {
    let this_login = {};

    this_login.proceed_login = () => {
        // $('.loader').show();
        instance.get(`/login`,
            {
                params: ({
                    employee_number: $('#txt_employee_no').val() //session employee no
                })
            }).then((response) => {
                if (response.data.status == "0") {
                    var message = "";
                    var data = response.data.message;

                    if (Array.isArray(data)) {
                        for ($i = 0; $i <= data.length - 1; $i++) {
                            message = `${message} ${data[$i]}`;
                            Swal.fire('Error!', message, 'error');
                        }
                    }
                    else {
                        message = data;
                        Swal.fire('Error!', message, 'error');
                    }
                }
                else {
                    var data_success = response.data.data[0];

                    if (data_success.area_id === null) {
                        $('#txt_user_id').val(data_success.id);
                        $('#mod_area_code').modal('show');
                    }
                    else {
                        console.log(data_success.area_code);
                        console.log(data_success);
                        window.location.href = `/pdls-v2/client/public/grant-auth/${data_success.employee_number}/${data_success.area_code}`;
                    }
                }
            }).catch((error) => {
                console.log(error)
            }).finally(() => {
                // $('.loader').hide();
            })
    };

    this_login.guest_login = () => {
        window.location.href = `/pdls-v2/client/public/grant-auth-guest/000000`;
    };

    $('#txt_employee_no').keypress(function (event) 
    {
        var keycode = (event.keyCode ? event.keyCode : event.which);//event on keypress enter
        if (keycode == '13')//event on keypress enter
        {
            MAIN.proceed_login();
        }

    });
    return this_login;
})();
