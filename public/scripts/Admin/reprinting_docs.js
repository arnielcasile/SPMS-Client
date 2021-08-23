$(document).ready(() => 
{
    $('#thead_delivery_receipt').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true
    });
    $('#thead_irreg_form').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true
    });

    $('#txt_deliv_receipt_date_from').val(date_today);
    $('#txt_deliv_receipt_date_to').val(date_today);
    $('#txt_deliv_receipt_month_date_from').val(month_today);
    $('#txt_deliv_receipt_month_date_to').val(month_today);
    $('#txt_irreg_date_from').val(date_today);
    $('#txt_irreg_date_to').val(date_today);
    $('#txt_irreg_month_date_from').val(month_today);
    $('#txt_irreg_month_date_to').val(month_today);
    $('#txt_prepared_by').val(user_name);
    $('#txt_prepared_by_irregularity').val(user_name);

    REPRINT_DOCU.display_approvers();
    $('#chk_parent_irreg').prop('hidden', true);
    $('#slc_deliv_receipt_range').val('DAILY');
    $('#slc_irreg_range').val('DAILY');

    REPRINT_DOCU.load_delivery_receipt_list();
    REPRINT_DOCU.load_irregularity_list();
});

$("#mod_edit_dr" ).on('shown.bs.modal', function(){
    $('#txt_pallet_qty').prop('disabled',false);
    $('#txt_pcase_no').prop('disabled',false);
    $('#txt_box').prop('disabled',false);
    $('#txt_bag').prop('disabled',false);    
    $('#div_save_prompt').prop('hidden', true);
    $('#btn_save_edit_dr_prompt').prop('hidden', false);
    $('#btn_save_edit_dr').prop('hidden', true);
});


    const REPRINT_DOCU = (() => 
    {
        let this_reprint_docu = {};
        let receipt_search_from = '';
        let receipt_search_to = '';
        let irreg_search_from = '';
        let irreg_search_to = '';
        let table_irreg;


        this_reprint_docu.onchange_datepicker = () =>
        {
            if ($('#slc_deliv_receipt_range').val() === 'MONTHLY')
            {
                $('#txt_deliv_receipt_date_from').prop('hidden', true);
                $('#txt_deliv_receipt_date_to').prop('hidden', true);
                $('#txt_deliv_receipt_month_date_from').prop('hidden', false);
                $('#txt_deliv_receipt_month_date_to').prop('hidden', false);
            }
            else
            {
                $('#txt_deliv_receipt_date_from').prop('hidden', false);
                $('#txt_deliv_receipt_date_to').prop('hidden', false);
                $('#txt_deliv_receipt_month_date_from').prop('hidden', true);
                $('#txt_deliv_receipt_month_date_to').prop('hidden', true);
            }

            if ($('#slc_irreg_range').val() === 'MONTHLY')
            {
                $('#txt_irreg_date_from').prop('hidden', true);
                $('#txt_irreg_date_to').prop('hidden', true);
                $('#txt_irreg_month_date_from').prop('hidden', false);
                $('#txt_irreg_month_date_to').prop('hidden', false);
            }
            else
            {
                $('#txt_irreg_date_from').prop('hidden', false);
                $('#txt_irreg_date_to').prop('hidden', false);
                $('#txt_irreg_month_date_from').prop('hidden', true);
                $('#txt_irreg_month_date_to').prop('hidden', true);
            }
        };

        this_reprint_docu.load_delivery_receipt_list = () => 
        {
            if ($('#slc_deliv_receipt_range').val() === 'MONTHLY')
            {
                var from = new Date($('#txt_deliv_receipt_month_date_from').val()); 
                var to = new Date($('#txt_deliv_receipt_month_date_to').val()); 
                var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
                var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 

                receipt_search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

                receipt_search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
            }
            else
            {
                receipt_search_from = $('#txt_deliv_receipt_date_from').val();
                receipt_search_to = $('#txt_deliv_receipt_date_to').val();

            }      
            if ($('#slc_deliv_receipt_range').val() === '' || receipt_search_from === '' || receipt_search_to === '' || receipt_search_from === 'NaN-0NaN-0NaN' || receipt_search_to === 'NaN-0NaN-0NaN')
            {
                toastr.error('Please complete the inputs', 'System Message')
            }
            else if (receipt_search_from > receipt_search_to)
            {
                toastr.error('Invalid date range', 'System Message')
            }
            else
            { 
                instance.get(`load-dr-control`,
                {
                    params: ({   
                        date_from   : receipt_search_from ,
                        date_to     : receipt_search_to,
                        date_range  : $('#slc_deliv_receipt_range').val(),
                        area_code   : area_code
                    }) 
                }).then((response) => 
                {
                    console.log(response);
                    $("#thead_delivery_receipt").DataTable().destroy();
                    $("#tbody_delivery_receipt").empty();
                    var data= response.data.data;
                    // $('.loader').show();
                    if (response['statusText'] == 'OK') 
                    {
                        if(data.length==0)
                        {
                            toastr.warning('No data matched in the database. Thank you', 'System Message')
                        }
                        else
                        {
                            var tr='';
                            var i = 0;
                            $.each(data, () => {
                                tr += `<tr>
                                <td>${data[i].dr_control}</td>
                                <td>
                                <button class="btn btn-success btn-sm" onclick="REPRINT_DOCU.show_modal_edit_dr('${data[i].dr_control}')">
                                <i class="ti-thumb-up"></i>&nbsp;EDIT
                                </button>
                                </td>
                                </tr>`;
                                i++;
                            });
                            $('#tbody_delivery_receipt').html(tr);
                            $('#thead_delivery_receipt').DataTable({
                                "paging": false,
                                "lengthChange": true,
                                "searching": true,
                                "ordering": false,
                                "info": false,
                                "autoWidth": true,
                                'scrollY':        '30vh',
                                'scrollCollapse': true,
                            });
                        }

                    }
                    else
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    }

                }).catch((error) => {
                    console.log(error)
                }).finally(() => {
                    // $('.loader').hide();
                })
            }     

        };

        this_reprint_docu.show_modal_edit_dr = (dr_control) => 
        {
            $('#mod_edit_dr').modal('show');
            $('#txt_dr_control').val(dr_control);

            instance.get(`load-delivery-receipts`,
            {
                params: ({   
                    dr_control   : dr_control
                }) 
            }).then((response) => 
            {
                console.log(response.data.data);
                var data= response.data.data;

                $('#txt_pallet_qty').val(data[0].pallet_qty);
                $('#txt_pcase_no').val(data[0].pcase_no);
                $('#txt_box').val(data[0].box);
                $('#txt_bag').val(data[0].bag);
                $('#txt_edit_attention_to').val(data[0].attention_to);
            }).catch((error) => {
                console.log(error)
            }).finally(() => { })

            instance.get(`/user`).then((response) => 
            {
                console.log(response);
                if (response['statusText'] == 'OK') 
                {
                    var approver = "";
                    approver = `<option selected disabled value="">Choose approved by</option>`;

                    $.each(response['data'].data, function () 
                    {
                        if (this.approver === 1) 
                        {
                            approver += `<option class="select-option" value="${this.id}">${this.first_name} ${this.last_name}</option>`;
                        }
                    });
                    $("#slc_edit_approved_by").html(approver);
                }
                else 
                {
                    toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                }
            }).catch((error) => 
            {
                console.log(error)
            }).finally(() => { })
        };

        this_reprint_docu.load_irregularity_list = () => 
        {
            if ($('#slc_irreg_range').val() === 'MONTHLY')
            {
                var from = new Date($('#txt_irreg_month_date_from').val()); 
                var to = new Date($('#txt_irreg_month_date_to').val()); 
                var first_date = new Date(from.getFullYear(), from.getMonth(), 1); 
                var last_date = new Date(to.getFullYear(), to.getMonth() + 1, 0); 

                irreg_search_from = first_date.getFullYear() + '-' + ((first_date.getMonth() > 8) ? (first_date.getMonth() + 1) : ('0' + (first_date.getMonth() + 1))) + '-' + 
                ((first_date.getDate() > 9) ? first_date.getDate() : ('0' + first_date.getDate()));

                irreg_search_to = last_date.getFullYear() + '-' + ((last_date.getMonth() > 8) ? (last_date.getMonth() + 1) : ('0' + (last_date.getMonth() + 1))) + '-' + 
                ((last_date.getDate() > 9) ? last_date.getDate() : ('0' + last_date.getDate()));
            }
            else
            {
                irreg_search_from = $('#txt_irreg_date_from').val();
                irreg_search_to   = $('#txt_irreg_date_to').val();

            }      
            if ($('#slc_irreg_range').val() === '' || irreg_search_from === '' || irreg_search_to === '' || irreg_search_from === 'NaN-0NaN-0NaN' || irreg_search_to === 'NaN-0NaN-0NaN')
            {
                toastr.error('Please complete the inputs', 'System Message')
            }
            else if (irreg_search_from > irreg_search_to)
            {
                toastr.error('Invalid date range', 'System Message')
            }
            else
            { 

                instance.get(`load-control-no`,
                {
                    params: ({   
                        date_from   : irreg_search_from ,
                        date_to     : irreg_search_to,
                        date_range  : $('#slc_irreg_range').val(),
                        area_code   : area_code
                    }) 
                }).then((response) => 
                {

                    $("#thead_irreg_form").DataTable().destroy();
                    $("#tbody_irreg_form").empty();
                    var data= response.data.data;
                    // $('.loader').show();
                    if (response['statusText'] == 'OK') 
                    {
                        if(data.length==0)
                        {

                            $('#chk_parent_irreg').prop('hidden', true);
                            toastr.warning('No data matched in the database. Thank you', 'System Message')
                        }
                        else
                        {
                            $('#chk_parent_irreg').prop('hidden', false);
                            var tr='';
                            $.each(data, function () 
                            {
                                tr += `<tr>
                                <td><input type="checkbox" style="zoom:2" name="chk_child_reprint_irreg[]" class="chk_child_reprint_irreg" onclick="REPRINT_DOCU.table_select();"></td>
                                <td>${this.control_no}</td>
                                <td>${this.date}</td>
                                </tr>`;
                            });
                            $('#tbody_irreg_form').html(tr);
                            table_irreg=$('#thead_irreg_form').DataTable({
                                "paging": false,
                                "lengthChange": true,
                                "searching": true,
                                "ordering": false,
                                "info": true,
                                "autoWidth": true,
                                'scrollY':        '30vh',
                                'scrollCollapse': true,
                            });
                        }

                    }
                    else
                    {
                        toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
                    }

                }).catch((error) => {
                    console.log(error)
                }).finally(() => {
                    // $('.loader').hide();
                })
            }
        };


        this_reprint_docu.table_select_all = () =>
        {
            if($('#chk_parent_irreg').is(':checked'))
                table_irreg.rows( { filter: 'applied' } ).nodes().to$().find('input').prop('checked',true);
            else
                table_irreg.rows( { filter: 'applied' } ).nodes().to$().find('input').prop('checked',false);
        };

        this_reprint_docu.table_select = () =>
        {
        var checked_data = $('#thead_irreg_form').find('tbody input:checkbox:checked').length; // Get count of checkboxes that is checked
        // if all checkboxes are checked, then set property of main checkbox to "true", else set to "false"
        $('#chk_parent_irreg').prop('checked', (checked_data === $('#thead_irreg_form').find('tbody input:checkbox').length));
    };


    this_reprint_docu.display_approvers = () => 
    {
        instance.get(`/user`).then((response) => 
        {
            if (response['statusText'] == 'OK') 
            {
                var reviewer ="";
                var approver ="";

                reviewer =`<option selected disabled value="">Choose reviewed by</option>`;
                approver =`<option selected disabled value="">Choose approved by</option>`;

                $.each(response['data'].data, function () 
                {          
                    if (this.approver === 1) 
                    {
                        reviewer += `<option class="select-option" value="${this.id} ${this.last_name}">${this.first_name} ${this.last_name}</option>`;
                        approver += `<option class="select-option" value="${this.first_name} ${this.last_name}">${this.first_name} ${this.last_name}</option>`;
                    }   
                });

                $("#slc_reviewed_by").html(reviewer);
                $("#slc_reviewed_by_irregularity").html(approver);
                $("#slc_approved_by_irregularity").html(approver);
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
  
    this_reprint_docu.show_prompt = () => 
    {
        var approved_by   =$('#slc_edit_approved_by option:selected').text();
        var dr_control    =$('#txt_dr_control').val();
        var attention_to  =$('#txt_edit_attention_to').val();
       
        if(approved_by == '' || dr_control == '' || approved_by == null || dr_control == null  ||
        $('#txt_pallet_qty').val()=="" ||   $('#txt_pcase_no').val()=="" || $('#txt_box').val()=="" || $('#txt_bag').val()=="")
        {
            toastr.warning('Please complete all the necessary details.')
        }
        else
        {
            $('#txt_pallet_qty').prop('disabled',true);
            $('#txt_pcase_no').prop('disabled',true);
            $('#txt_box').prop('disabled',true);
            $('#txt_bag').prop('disabled',true);

            $('#div_save_prompt').prop('hidden', false);
            $('#btn_save_edit_dr_prompt').prop('hidden', true);
            $('#btn_save_edit_dr').prop('hidden', false);
        }
    };

    this_reprint_docu.print_irreg = () => 
    {
        var prepared_by = $('#txt_prepared_by_irregularity').val();
        var reviewed_by = $('#slc_reviewed_by_irregularity').val();
        var approved_by = $('#slc_approved_by_irregularity').val();
        if (table_irreg==undefined)
            toastr.warning('Table must not be empty, Thank you!', 'System Message')
        else 
        {
            var tbl_data = table_irreg.rows().data();
            var length   =$("input[name='chk_child_reprint_irreg[]']:checked").length;
        }
        
        if (tbl_data.length < 1)
            toastr.warning('Table must not be empty, Thank you!', 'System Message')
        else 
        {
            if(prepared_by === null || reviewed_by === null || approved_by === null)
            {
                toastr.error('Please complete all the necessary details. Thank you', 'System Message')
            }
            else
            {
                if(length == 0)
                {
                    toastr.error('Please select value in the table. Thank you', 'System Message')
                }
                else
                {
                    Swal.fire(swal_options).then((result) => 
                    {
                        var dr_control=[];
                        var count=0;
                        var rowcollection =  table_irreg.$(".chk_child_reprint_irreg:checked", {"page": "all"});
                        rowcollection.each(function(index,elem)
                        {
                            var tr_data        = $(this).parents('tr:eq(0)');
                            var dr_control_no  = $(tr_data).find('td:eq(1)').text();
                            dr_control[count]=dr_control_no
                            count++;
                        });

                        if (result.value) 
                        {
                            local.get(`print-irregularity`,
                            {
                                params: ({   
                                    data          :dr_control, 
                                    prepared_by   :prepared_by, 
                                    reviewed_by   :reviewed_by, 
                                    approved_by   :approved_by, 
                                }),
                                responseType: 'blob', Accept: 'application/pdf',
                            }).then((response) => 
                            {                         
                            const file = new Blob(
                                [response.data],
                                { type: 'application/pdf' });
                                const fileURL = URL.createObjectURL(file);
                                //Open the URL on new Window
                                window.open(fileURL);
                            }).catch((error) => {
                                console.log(error)
                            }).finally(() => {
                                // $('.loader').hide();
                                table_irreg.clear().draw();
                            })
                        }
                    })
                }
            }
        }


    }
    
    this_reprint_docu.print_dr = () => 
    {
        var dr_control=[];
        var attention_to=[];
        dr_control[0]={"dr_control_no":$('#txt_dr_control').val()};
        attention_to[0]=$('#txt_edit_attention_to').val();
  
        if($('#slc_edit_approved_by').val() === "" || $('#txt_edit_attention_to').val() === "")
        {
            toastr.error('Please complete all the necessary details. Thank you', 'System Message')
        }
        else
        {
            local.get('print-dr-making',
            {
                params:
                ({
                    data:           JSON.stringify(dr_control),
                    approved_by:    $('#slc_edit_approved_by option:selected').text(),
                    attention_to:   attention_to,
                    approved_by_id: $('#slc_edit_approved_by').val(),
                    user_id:        $('#txt_user_id').val(),
                    pallet_qty:     $('#txt_pallet_qty').val(),
                    pcase_no:       $('#txt_pcase_no').val(),
                    box:            $('#txt_box').val(),
                    bag:            $('#txt_bag').val(),
                }),
                responseType: 'blob', Accept: 'application/pdf',
            }).then(function (response)
            {
                // $('.loader').show();
                const file = new Blob(
                    [response.data],
                    { type: 'application/pdf' });
                const fileURL = URL.createObjectURL(file);
                // $('.loader').hide();
                window.open(fileURL)
                ;  
                $('#div_save_prompt').prop('hidden', true);
                $('#btn_save_edit_dr_prompt').prop('hidden', false);
                $('#btn_save_edit_dr').prop('hidden', true);
                $('#txt_edit_attention_to').val('');
                $('#mod_edit_dr').modal('hide');

                $('#txt_pallet_qty').prop('disabled',false);
                $('#txt_pcase_no').prop('disabled',false);
                $('#txt_box').prop('disabled',false);
                $('#txt_bag').prop('disabled',false);

                // console.log(response);
            }).catch(function (error)
            {
                console.log(error);
            }).finally(()=>
            {    
            });    
        }
       

    };

    
    
    return this_reprint_docu;
})();
