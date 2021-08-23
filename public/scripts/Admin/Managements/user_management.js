$(document).ready(() => 
{
   // $('.loader').show();
    USER_MANAGEMENT.load_users_list(0,'');
});

const USER_MANAGEMENT = (() => 
{
    let this_user_management = {};
    let process_list = [];
    let user_id = [];
    let scroll_position=0;
    let scroll_position_top=0;
    this_user_management.load_users_list = ($page_number,search) => 
    {
        process_list=[];//reset the array every load
        user_id=[];//reset the array every load
        
        var tr = '';
        var on = '../public/icons/on.png';
        var off ='../public/icons/off.png';
        instance.get(`user-overall`).then(function (response) 
        {
            if (response['statusText'] == 'OK') 
            {
                $('#thead_user_management').DataTable().destroy();
                $('#tbody_user_management').empty();

                var tr = '';
                var x = 0;
                $.each(response['data'].data, function () 
                {
                    if(this.employee_number !='000000')
                    {
                        if(this.user_type_id !== 1) 
                        {
                            process_list.push(this.process);
                            user_id.push(this.id);
                            x++;
                            tr += `<tr>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${x}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.employee_number}</td>
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.first_name} ${this.last_name}</td> 
                                    <td style="text-align:center;horizontal-align:middle;vertical-align:middle;" onclick="USER_MANAGEMENT.display_area_code(${this.area_id},'${this.area_code}',${this.id})">${(this.area_code == null) ? '' : this.area_code}</td>`;
                        
                            if(this.approver==0)//approver
                            {
                                //Update as Approver
                                tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${off}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('A',${x},1)">
                                </td>`;
                            }
                            else
                            {
                                //Update as Unapprover 
                                tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${on}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('A',${x},0)">
                                </td>`;
                            }
                            if(this.user_type=="User")//user type
                            {
                                //update as Admin
                                tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${off}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('U',${x},2)">
                                </td>`;
                            }
                            else
                            { 
                                if(`${this.employee_number}`== $('#lbl_employee_number').val())
                                {
                                    //update as User
                                    tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                    <img disabled src="${on}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('SU',${x},3)">
                                    </td>`;
                                }
                                else
                                {
                                    tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                    <img src="${on}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('U',${x},3)">
                                    </td>`;
                                }
                            }

                            if(this.support==0)//support
                            {
                                tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${off}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('S',${x},'1')">
                                </td>`;
                            }
                            else
                            {
                                tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${on}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('S',${x},'0')">
                                </td>`;
                            }

                            if(this.receiver==0)//receiving
                            {
                                tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${off}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('R',${x},'1')">
                                </td>`;
                            }
                            else
                            {
                                tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${on}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('R',${x},'0')">
                                </td>`;
                            }

                            if(this.deleted_at!=null)//status
                            {
                                tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${off}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('ST',${x},'${this.deleted_at}')">
                                </td>`;
                            }
                            else
                            {
                                tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <img src="${on}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('ST',${x},'${this.deleted_at}')">
                                </td>`;
                            }

                            var array = this.process.split(",");//process
                            var loop_count = 0;
                            $.each(array,function(i)
                            {
                                if(loop_count == 0)
                                {
                                    tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;cursor:not-allowed;">
                                    <img src="${on}" height="30" width="60" id="chk_dashboard"">
                                    </td>`;
                                }
                                else{
                                    if(array[i]==0)
                                    {
                                        tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                        <img src="${off}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('P',${x},${i+1})">
                                        </td>`;
                                    }
                                    else
                                    {
                                        tr += `<td style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                        <img src="${on}" height="30" width="60" id="chk_dashboard" onclick="USER_MANAGEMENT.on_off('P',${x},${i+1})">
                                        </td>`;
                                    }
                                }
                                loop_count+=1;
                            })
                        }
                    }
                });
                
                $('#tbody_user_management').html(tr);
                var table=$('#thead_user_management').DataTable({
                    "scrollX": true,
                    "scrollY": true,
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    'scrollY':        '80vh',
                    'scrollCollapse': true,
                    fixedColumns:   {
                        leftColumns: 4,
                    }
                });
                table.page($page_number).draw( 'page' );
                table.search(search).draw();
                $('.dataTables_scrollBody').scrollLeft(scroll_position); 
                $('.dataTables_scrollBody').scrollTop(scroll_position_top); 
            }
            else 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                document.getElementById('notification').play();
            }
        }).catch(function (error) 
        {
            console.log(error)
            toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
            document.getElementById('notification').play();
        }).finally(function () 
        {
           // $('.loader').hide();
        })
    };

    this_user_management.on_off = (type,row_number,column_number) => //desiminate to different update api's
    {
        // alert($(".dataTables_scrollBody").scrollTop() + " px");
        scroll_position=$('.dataTables_scrollBody').scrollLeft();
        scroll_position_top=$('.dataTables_scrollBody').scrollTop();
        if(type == "P")
        {
            var array = process_list[row_number-1].split(",");//splits the text output of process
            if(array[column_number-1] == 0) //reverse the value for specific process
            {
                array[column_number-1] = "1";
            }
            else
            {
                array[column_number-1] = "0";
            }
            toastr.info('Please wait. Your request is being processed. Thank you', 'System Message')
            USER_MANAGEMENT.update_process_user(user_id[row_number-1],array.join(","))
        }
        else if(type == "S")
        {
            toastr.info('Please wait. Your request is being processed. Thank you', 'System Message')
            USER_MANAGEMENT.update_support_user(user_id[row_number-1],column_number);
        }
        else if(type == "A")
        {
            toastr.info('Please wait. Your request is being processed. Thank you', 'System Message')
            USER_MANAGEMENT.update_approver_user(user_id[row_number-1],column_number);
        }
        else if(type == "U")
        {
            toastr.info('Please wait. Your request is being processed. Thank you', 'System Message')
            USER_MANAGEMENT.update_management_user(user_id[row_number-1],column_number);
        }
        else if(type == "R")
        {
            toastr.info('Please wait. Your request is being processed. Thank you', 'System Message')
            USER_MANAGEMENT.update_receiver_user(user_id[row_number-1],column_number);
        }

        else if(type == "ST")
        {
           // console.log(user_id[row_number-1])
            if ($('#txt_employee_id').val() == user_id[row_number-1])
            {
                toastr.warning('Cannot deactivate own account. Thank you', 'System Message')
                document.getElementById('notification').play();

            }
            else
            {
                if (column_number == 'null')
                {
                    USER_MANAGEMENT.inactive(user_id[row_number-1],column_number);
                    toastr.info('Please wait. Your request is being processed. Thank you', 'System Message')
                    
                }
                else
                {
                    USER_MANAGEMENT.active(user_id[row_number-1],column_number);
                    toastr.info('Please wait. Your request is being processed. Thank you', 'System Message')
                }
            }
        }

        else if(type == "SU")
        {
            toastr.warning('You are not allowed to update your own account. Thank you', 'System Message')
            document.getElementById('notification').play();
        }
    };

    this_user_management.inactive = (id) => 
    {
        instance.delete(`user`,
        {
            params: ({
                        id : id
                    })
        }).then((response) => 
        {
            if (response.status) 
            {

            }
            else 
            {
                toastr.error(response.message)
                document.getElementById('notification').play();

            }
        }).catch((error) => 
        {
            console.log(error)
            toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
            document.getElementById('notification').play();

        }).finally(() => 
        {
            var table = $("#thead_user_management").DataTable();
            var info = table.page.info();	
            var value = $('.dataTables_filter input').val();
            USER_MANAGEMENT.load_users_list(info.page,value);
            toastr.success('Successfully Deleted. Thank you', 'System Message');
            document.getElementById('notification_success').play();
        })
    };

    this_user_management.active = (id) =>
    {
        status_update ="update to active";
        instance.patch(`user-active`, 
        {
            id        : id
        }).then((response) => 
        {
            if (response.status) 
            {
                $('#txt_area_code_mngt').val('');
            }
            else
            {
                toastr.error(response.message)
            }
        }).catch((error) => 
        {
            console.log(error)
            toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
            document.getElementById('notification').play();
        }).finally(() => 
        {
            var table = $("#thead_user_management").DataTable();
			var info = table.page.info();	
             var value = $('.dataTables_filter input').val();
            USER_MANAGEMENT.load_users_list(info.page,value);
            toastr.success('Successfully Updated. Thank you', 'System Message');
            document.getElementById('notification_success').play();
        })
    }

    this_user_management.update_process_user = (user_id, value) => //update process
    {
        instance.patch(`user-process`,
        {
            id      : user_id,
            process : value
        }).then(function (response) 
        {
            $('#thead_payout').LoadingOverlay('show');
        }).catch(function (error) 
        {
            console.log(error)
            toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
            document.getElementById('notification').play();
        }).finally(function () 
        {
            var table = $("#thead_user_management").DataTable();
			var info = table.page.info();	
             var value = $('.dataTables_filter input').val();
            USER_MANAGEMENT.load_users_list(info.page,value);
            toastr.success('Successfully Updated. Thank you', 'System Message');
            document.getElementById('notification_success').play();
            $('#thead_payout').LoadingOverlay('hide');
        })
    };

    this_user_management.update_support_user = (user_id,value) => //update support
    {
        instance.patch(`edit-support`,
        {
            id       : user_id,
            support  : value
        }).then(function (response) 
        {
            $('#thead_payout').LoadingOverlay('show');
        }).catch(function (error) 
        {
            console.log(error)
            toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
            document.getElementById('notification').play();
        }).finally(function () 
        {
            var table = $("#thead_user_management").DataTable();
			var info = table.page.info();
             var value = $('.dataTables_filter input').val();
            USER_MANAGEMENT.load_users_list(info.page,value);
            toastr.success('Successfully Updated. Thank you', 'System Message');
            document.getElementById('notification_success').play();
            $('#thead_payout').LoadingOverlay('hide');
        })
    };

    this_user_management.update_receiver_user = (user_id,value) => //update recevier
    {
        instance.patch(`edit-receiver`,
        {
            user_id   : user_id,
            receiver  : value
        }).then(function (response) 
        {
            $('#thead_payout').LoadingOverlay('show');
        }).catch(function (error) 
        {
            console.log(error)
            toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
            document.getElementById('notification').play();
        }).finally(function () 
        {
            var table = $("#thead_user_management").DataTable();
			var info = table.page.info();
             var value = $('.dataTables_filter input').val();
            USER_MANAGEMENT.load_users_list(info.page,value);
            toastr.success('Successfully Updated. Thank you', 'System Message');
            $('#thead_payout').LoadingOverlay('hide');
            document.getElementById('notification_success').play();
        })
    };

    this_user_management.update_approver_user = (user_id,value) => //update approver
    {
        instance.patch(`user-approver`,
        {
            id       : user_id,
            approver : value
        }).then(function (response) 
        {
            $('#thead_payout').LoadingOverlay('show');
        }).catch(function (error) 
        {
            console.log(error)
            toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
            document.getElementById('notification').play();
        }).finally(function () 
        {
            var table = $("#thead_user_management").DataTable();
			var info = table.page.info();
             var value = $('.dataTables_filter input').val();
            USER_MANAGEMENT.load_users_list(info.page,value);
            toastr.success('Successfully Updated. Thank you', 'System Message');
            $('#thead_payout').LoadingOverlay('hide');
            document.getElementById('notification_success').play();
        })
    };

    this_user_management.update_management_user = (user_id,value) => //update management
    {
        instance.patch(`user-type`,
        {
            id          : user_id,
            user_type   : value
        }).then(function (response) 
        {
            $('#thead_payout').LoadingOverlay('show');
        }).catch(function (error) 
        {
            console.log(error)
            toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
            document.getElementById('notification').play();
        }).finally(function () 
        {
            var table = $("#thead_user_management").DataTable();
			var info = table.page.info();	
             var value = $('.dataTables_filter input').val();
            USER_MANAGEMENT.load_users_list(info.page,value);
            toastr.success('Successfully Updated. Thank you', 'System Message');
            $('#thead_payout').LoadingOverlay('hide');
            document.getElementById('notification_success').play();
        })
    };

    this_user_management.load_area_code = (area_id, area_code) => 
    {
        instance.get(`area-code-all`).then(function (response) 
        {
            var area_codes ="";
            if (area_code == 'null')
            {
                area_codes =`<option selected disabled value="">SELECT AREA CODE</option>`;
            }
            else 
            {
                area_codes += `<option class="select-option" value="${area_id},${area_code}">${area_code}</option>`;
            }

            $.each(response['data'].data, function () 
            {    
                if (this.id != area_id) 
                {
                    area_codes += `<option class="select-option" value="${this.id},${this.area_code}">${this.area_code}</option>`;
                }
                $("#slc_area_code_user").html(area_codes);
            });
        }).catch(function (error) 
        {
            document.getElementById('notification').play();
            toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
            console.log(error)
        }).finally(() => {})
    };

    this_user_management.display_area_code = (area_id, area_code, id) => 
    {
        USER_MANAGEMENT.load_area_code(area_id, area_code);
        $('#txt_user_id').val(id);
        $('#div_area_code').prop('hidden', false) 
        $('#btn_submit_area_code').prop('hidden', false) 
        $('#btn_cancel_area_code').prop('hidden', false) 
    };

    this_user_management.btn_hide_area_code = () => 
    {
        $('#div_area_code').prop('hidden', true) 
        $('#btn_submit_area_code').prop('hidden', true) 
        $('#btn_cancel_area_code').prop('hidden', true) 
    };

    this_user_management.btn_update_area_code = () => 
    {
        
        var area_code = $('#slc_area_code_user').val();
        var split_code = area_code.split(',');

        if ($('#slc_area_code_user').val() === null) 
        {
            toastr.error('Please select area code', 'System Message')
            document.getElementById('notification').play();
        }
        else 
        {
            Swal.fire(swal_options).then((result) => 
            {
               // $('.loader').show();
                if (result.value) 
                {
                    instance.patch(`/user`, 
                    {
                        id          : $('#txt_user_id').val(),
                        area_id     : split_code[0],
                        area_code   : split_code[1]
                    }).then((response) => 
                    {
                        if (result.value) 
                        {
                            Swal.fire('Success!', `The area code has been updated.`, 'success')
                            document.getElementById('notification_success').play();
                            $('#txt_user_id').val('');
                            $('#slc_area_code_user').val('');
                            $('#div_area_code').prop('hidden', true) 
                            $('#btn_submit_area_code').prop('hidden', true) 
                            $('#btn_cancel_area_code').prop('hidden', true) 
                        }
                        else 
                        {
                            toastr.error('There was a problem in updating the data. Please contact the administrator. Thank you', 'System Message')
                            document.getElementById('notification').play();
                        }
                    }).catch((error) => 
                    {
                        console.log(error)
                        toastr.error(`${error}. Please contact the administrator. Thank you`, 'System Message')
                        setTimeout(
                            function() 
                            {
                                window.location.reload();
                            }, 1000);
                        document.getElementById('notification').play();
                    }).finally(() => 
                    {
                        USER_MANAGEMENT.load_users_list(0);
                       // $('.loader').hide();
                    })
                }
               // $('.loader').hide();
            })
        } 
    };

    return this_user_management;
})();   
