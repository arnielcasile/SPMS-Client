$(document).ready(() => 
{
   
});

$("#mod_parts_for_dr" ).on('shown.bs.modal', function(){
    PARTS_FOR_DR_MAKING.load();
    APPROVER.approver();
 });
 
 const APPROVER = (() => {
    let this_approver = {};

    this_approver.approver = () => 
    {
  
        instance.get(`/user`).then((response) => {
            if (response['statusText'] == 'OK') {
                var approver = "";
                approver = `<option selected disabled value="">Choose approved by</option>`;

                $.each(response['data'].data, function () {
                    if (this.approver === 1) {
                        approver += `<option class="select-option" value="${this.id}">${this.first_name} ${this.last_name}</option>`;
                        
                    }
                });
                $("#slc_transac_approved_by").html(approver);
            }
            else {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message');
                setTimeout(
                    function() 
                    {
                        window.location.reload();
                    }, 1000);
                }
        }).catch((error) => {
            console.log(error);
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
        }).finally(() => { })
    };
    return this_approver;
})();

const PARTS_FOR_DR_MAKING = (() =>
{
    let this_parts_for_dr_making = {};
    let datas = {};
    let table;
    
    this_parts_for_dr_making.load = () =>
    {
        instance.get('load-dr-making',
        {
            params:({
                    user_area_code: $("#txt_area_code").val(),
                    })
        }).then(function (response)
        {
            // $('.loader').show();
            var data=response.data.data
            $("#tbl_parts_for_dr").DataTable().destroy();
            $("#tbody_tbl_parts_for_dr").empty();
            var tr='';
            // console.log(data);
            if (response['statusText'] == 'OK') 
            {
                if (response.data.data.length === 0) 
                {
                    toastr.warning('No data matched in the database. Thank you', 'System Message')
                    $('#txt_barcode').val('');
                }
                else 
                {
                    $.each(data, function ()
                    {
                        tr  +=`<tr>
                                    <td><input type="checkbox" id="${this.dr_id}" style="zoom:2" name='chk_child[]' class='chk_child' onclick="PARTS_FOR_DR_MAKING.table_select()"></td>
                                    <td>${this.dr_control}</td>
                                    <td>${this.ticket_count}</td>
                                    <td>${this.destination}</td>
                                    <input type="hidden" value="${this.attention_to}">                                     
                                </tr>`;  
                                            
                    })
                    $("#tbody_tbl_parts_for_dr").html(tr);     
                    table= $('#tbl_parts_for_dr').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "processing": true,
                        "serverSide": false,
                        "deferRender": true,
                        "fnDrawCallback": function () {
                            $('#tbody_tbl_parts_for_dr td').each(function () {
                                if ($.trim($(this).text()) == 'null' || $.trim($(this).text()) == 'undefined') {
                                    $(this).text('');
                                }
                            });
                        },
                    });
                }
            }
            else
            {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                document.getElementById('notification').play();
            }
        }).catch(function (error)
        {
            document.getElementById('notification').play();
            toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            console.log(error);
        }).finally(()=>
        {
            // $('.loader').hide();
        });
    };
    
    this_parts_for_dr_making.table_select_all = () =>
    {
      
        if($('#chk_parent').is(':checked'))
            table.rows( { filter: 'applied' } ).nodes().to$().find('input').prop('checked',true);
        else
            table.rows( { filter: 'applied' } ).nodes().to$().find('input').prop('checked',false);
    };

    this_parts_for_dr_making.table_select = () =>
    {
        var checked_data = $('#tbl_parts_for_dr').find('tbody input:checkbox:checked').length; // Get count of checkboxes that is checked
        // if all checkboxes are checked, then set property of main checkbox to "true", else set to "false"
        $('#chk_parent').prop('checked', (checked_data === $('#tbl_parts_for_dr').find('tbody input:checkbox').length));
    };

    this_parts_for_dr_making.print_selected = () =>
    {
        datas = {};
        var data            = $(this).parents('tr:eq(0)');
        var length          =$("input[name='chk_child[]']:checked").length;
        var approved_by     =$('#slc_transac_approved_by option:selected').text();
        var approved_by_id  =$('#slc_transac_approved_by').val();

        // var attention_to=$('#txt_dr_attention_to').val();
        if(length==0)
        {
            toastr.warning('Please select a control  number. Thank you', 'System Message')
            document.getElementById('notification').play();
        }
        else if(approved_by === '' || $('#slc_transac_approved_by').val() === null)
        {       
            toastr.warning('Approver or Attention to cannot be blank. Thank you', 'System Message')
            document.getElementById('notification').play();
        }
        else
        {
            let dr_control=[];
            let arr_attention_to=[];
            let count = 0;
            let rowcollection =  table.$(".chk_child:checked", {"page": "all"});
            rowcollection.each(function(index,elem){
                var tr_data       = $(this).parents('tr:eq(0)');
                var dr_control_no = $(tr_data).find('td:eq(1)').text();
                var ticket_no     = $(tr_data).find('td:eq(2)').text();
                var destination   = $(tr_data).find('td:eq(3)').text();
                // if(arr_attention_to.indexOf($(tr_data).find('input[type="hidden"]').val()) === -1)
                // {
                    arr_attention_to.push($(tr_data).find('input[type="hidden"]').val());
                // }
                dr_control [count] = {"dr_control_no":dr_control_no};
                count++;
            });
            // var attention_to=arr_attention_to.toString();
                local.get('print-dr-making',
                {
                    params:
                    ({
                        data:           JSON.stringify( dr_control),
                        approved_by:    approved_by,
                        approved_by_id: approved_by_id,
                        attention_to:   arr_attention_to,
                        user_id:        $('#txt_user_id').val(),
                        pallet_qty:     null,
                        pcase_no:       null,
                        box:            null,
                        bag:            null,
                    }),
                    responseType: 'blob', Accept: 'application/pdf',
                }).then(function (response)
                {
                    const file = new Blob(
                        [response.data],
                        { type: 'application/pdf' });
                    const fileURL = URL.createObjectURL(file);
                    PARTS_FOR_DR_MAKING.load();
                    PARTS_FOR_DR_MAKING.clear_inputs();
                    // $('.loader').hide();
                    window.open(fileURL);  
                }).catch(function (error)
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    document.getElementById('notification').play();
                    console.log(error);
                }).finally(()=>
                {    
                });
        }
    };

    this_parts_for_dr_making.clear_inputs = () =>
    {
        $('#tbl_parts_for_dr input').prop('checked', false);
        $('#slc_transac_approved_by').val('');
        // $('#txt_dr_attention_to').val('');
    };

    this_parts_for_dr_making.cancel_transaction = () =>
    {
        $('#tbl_parts_for_dr input').prop('checked', false);
        $('#slc_transac_approved_by').val('');
        // $('#txt_dr_attention_to').val('');
    };

    return this_parts_for_dr_making;
})();