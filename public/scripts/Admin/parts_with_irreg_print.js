$(document).ready(() => 
{
    PRINT_IRREGULARITY.load_parts_for_dr_list();
    PRINT_IRREGULARITY.display_approvers();
});

const PRINT_IRREGULARITY = (() => 
{
    let this_print_irregularity = {};

    this_print_irregularity.load_parts_for_dr_list = () => 
    {
        var tr = '';
        tr =    `<tr>
                    <td><input type="checkbox" value="1" class="form-control checkbox-sm check_dr"></td>
                    <td>1</td>
                </tr>
                <tr>
                    <td><input type="checkbox" value="2" class="form-control checkbox-sm check_dr"></td>
                    <td>2</td>
                </tr>
                <tr>
                    <td><input type="checkbox" value="3" class="form-control checkbox-sm check_dr"></td>
                    <td>3</td>
                </tr>
                <tr>
                    <td><input type="checkbox" value="4" class="form-control checkbox-sm check_dr"></td>
                    <td>4</td>
                </tr>
                <tr>
                    <td><input type="checkbox" value="5" class="form-control checkbox-sm check_dr"></td>
                    <td>5</td>
                </tr>`;

        $('#tbody_print_dr').html(tr);

        $('#thead_print_dr').DataTable({
            "scrollX": true,
            "scrollY": '320px',
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false
        });
                        
        // instance.get(`get-dr-list`).then((response) => {

        //     if (response['statusText'] == 'OK') {

        //         $('#thead_print_dr').DataTable().destroy();
        //         $('#tbody_print_dr').empty();

        //         var tr = '';
        //         $.each(response['data'], () => {

        //             tr += `<tr>
        //                 <td>
        //                     <button class="btn btn-success btn-sm" onclick="PIC.btn_modal_open_edit_leave(${this.id}, ${this.user_id}, '${this.leave_type_id}', '${this.date_from}','${this.date_to}','${this.leave_reason}')"><i class="ti-thumb-up"></i>
        //                     EDIT</button>
        //                 </td>
        //                 <td>${this.user_first_name} ${this.user_last_name}</td>
        //                 <td>${this.leave_type}</td>
        //                 <td>${this.date_from}</td> 
        //                 <td>${this.date_to}</td>
        //                 <td>${this.leave_reason}</td> 
        //             </tr>`;
        //         });

        //         $('#tbody_print_dr').html(tr);
        //         $('#thead_print_dr').DataTable({
        //             "paging": true,
        //             "lengthChange": true,
        //             "searching": true,
        //             "ordering": false,
        //             "info": true,
        //             "autoWidth": true
        //         });
        //     }
        //     else {
        //         toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
        //     }

        // }).catch((error) => {
        //     console.log(error)
        // }).finally(() => {
            // // $('.loader').show();
        // })
    };

    this_print_irregularity.check_all_dr = () => 
    {
        if ($('#txt_check_all_dr').is(":checked")) 
        {
            $('.check_dr').prop('checked', true);
        }
        else 
        {
            $('.check_dr').prop('checked', false);
        }
    };

    this_print_irregularity.display_approvers = () => 
    {
        instance.get(`/user`).then((response) => 
        {
            if (response['statusText'] == 'OK') 
            {
                var approver ="";
                approver =`<option selected disabled value="">Choose approved by</option>`;

                $.each(response['data'].data, function () 
                {       
                    if (this.approver === 1) 
                    {
                        approver += `<option class="select-option" value="${this.id}">${this.first_name} ${this.last_name}</option>`;
                    }   
                });
                $("#slc_approved_by").html(approver);
            }
            else 
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }
        }).catch((error) => 
        {
            console.log(error)
        }).finally(() => {})
    };

    return this_print_irregularity;
})();
