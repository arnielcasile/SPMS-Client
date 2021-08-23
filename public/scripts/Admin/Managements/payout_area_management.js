$(document).ready(function () 
{
    //// $('.loader').show();
    // AREA_PAYOUT.load_area_payout_list();
    // $('#btn_update_area_payout').prop('hidden', true);
    
    $( "#mod_payout_area" ).on('shown', function(){
     // AREA_PAYOUT.load_area_payout_list();
    // $('#btn_update_area_payout').prop('hidden', true);
    });
});

const AREA_PAYOUT = (() => 
{
    let this_area_payout = {};
    let area_code_lists = [];

    this_area_payout.load_area_payout_list = () => 
    {
        $('#thead_area_payout').DataTable().destroy();

        var tr = '';
        instance.get(`/area-payout`).then(function (response) 
        {
            if (response['statusText'] == 'OK') 
            {
                $('#thead_area_payout').DataTable().destroy();
                $('#tbody_area_payout').empty();

                var x = 0;
                $.each(response['data'].data, function () 
                {
                    area_code_lists.push(this.area_payout);
                    
                    tr += `<tr>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${x}</td>
                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">${this.area_payout}</td>
                            <td class="text-right" style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                <button type="button" class="btn btn-warning" title="Edit area code" onclick="AREA_PAYOUT.display_area_payout('${this.area_payout}', ${this.id})"><i class="fa fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger" title="Delete area code" onclick="AREA_PAYOUT.delete_area_payout(${this.id});"><i class="fa fa-trash"></i></button>
                            </td>
                         </tr>`;
                         x++;
                });
              
                $('#tbody_area_payout').html(tr);
                $('#thead_area_payout').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            }
            else 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }

        }).catch(function (error) 
        {
            console.log(error)
        }).finally(function () 
        {
           // $('.loader').hide();
        })
    };

    this_area_payout.insert_area_payout = () => 
    {
        var check_if_exist = area_code_lists.includes($('#txt_area_payout').val());

        if($('#txt_area_payout').val() === '')
        {
            toastr.error('Please enter area code', 'System Message')
        }
        else if(check_if_exist === true)
        {
            toastr.error('Area code already exist', 'System Message')
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
            {
               // $('.loader').show();
                if (result.value) 
                {
                    instance.post(`area-payout`, 
                    {
                        area_payout : $('#txt_area_payout').val(),
                    }).then(function (response) 
                    {
                        Swal.fire('Success!', `The area code has been updated.`, 'success')
                    }).catch(function (error) 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    }).finally(function () 
                    {
                        AREA_PAYOUT.load_area_payout_list();
                       // $('.loader').hide();
                    })
                }
            })
        }
    };

    this_area_payout.display_area_payout = (area_payout, id) => 
    {
        $('#txt_area_payout').val(area_payout);
        $('#txt_area_payout_id').val(id);
        $('#btn_update_area_payout').prop('hidden', false);
        $('#btn_save_area_payout').prop('hidden', true);
    };

    this_area_payout.update_area_payout = () => 
    {
        var check_if_exist = area_code_lists.includes($('#txt_area_payout').val());

        if($('#txt_area_payout').val() === '')
        {
            toastr.error('Please enter area code', 'System Message')
        }
        else if(check_if_exist === true)
        {
            toastr.error('Area code already exist', 'System Message')
        }
        else
        {
            Swal.fire(swal_options).then((result) => 
            {
               // $('.loader').show();
                if (result.value) {
                    instance.patch(`area-payout`, 
                    {
                        id          : $('#txt_area_payout_id').val(),
                        area_payout : $('#txt_area_payout').val(),
                    }).then(function (response) 
                    {
                        Swal.fire('Success!', `The area code has been updated.`, 'success')
                    }).catch(function (error) 
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    }).finally(function () 
                    {
                        AREA_PAYOUT.load_area_payout_list();
                       // $('.loader').hide();
                    })
                }
            })
        }
    };

    this_area_payout.delete_area_payout = (id) => 
    {
        Swal.fire(swal_options).then((result) => 
        {
           // $('.loader').show();
            if (result.value) {
                instance.delete(`area-payout`,
                {
                    params: ({
                                id : id, 
                            })
                }).then(function (response)
                {    
                    Swal.fire('Success!', `The area code has been deleted.`, 'success')
                }).catch(function (error) 
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                }).finally(function () 
                {
                    AREA_PAYOUT.load_area_payout_list();
                   // $('.loader').hide();
                })
            }
        })
    };
    
    return this_area_payout;
})();
