window.onload = (()=>
{
    TEMPLATE.display_menu();
    if($("#lbl_employee_number").val() != '000000')
    {
        TEMPLATE.realtime_data();  
    }
    TEMPLATE.guest_load_area_code();
    //console.log(area_code);
});
const TEMPLATE = (() => {
    let this_template = {};

    this_template.realtime_data = () => 
    {
        instance.get(`realtime-data`,
        {
            params: ({
                employee_no: $("#lbl_employee_number").val(),
            })
        }).then((response) => {
         $('#txt_area_code').val(response.data);
         $('#spn_name_area_code').text(response.data);
         $('#spn_nav_area_code').text(response.data);
         localStorage['area_code'] = response.data;
         area_code= localStorage['area_code'];
        }).catch((error) => 
        {
            setTimeout(function(){window.location.reload();}, 1000);
        }).finally(() => 
        {
        })
    }

    this_template.guest_load_area_code = () => 
    {
        localStorage['area_code'] = 'P14'
        instance.get(`area-code-all`).then(function (response) 
        {
             var area_code_guest = ``;
            $.each(response['data'].data, function () 
            {    
                if(this.area_code != 'RECEIVER')
                {                 
                    area_code_guest+= `<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                    <a  href="#" onclick=TEMPLATE.change_area_code("${this.area_code}"); class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-map"></i>
                        <span class="m-menu__link-text" style="font-family:custom-font-body">
                            ${this.area_code}
                        </span>
                    </a></li>`;
                }             
            });
            $("#guest-code-li").empty().append(area_code_guest);
        }).catch(function (error) 
        {
            setTimeout(
                function() 
                {
                    window.location.reload();
                }, 1000);
            console.log(error)
        }).finally(() => {})
    };

    this_template.change_area_code = (code) => 
    {
        local.get(`change-code`,
        {
            params: ({
                area_code: code,
            })
        }).then((response) => {
            localStorage['area_code'] = code;
            if (response['statusText'] == 'OK') 
            {
                // console.log(response);
            // $('.loader').show();
            location.reload(true);
            }
            else 
            {
                setTimeout(
                    function() 
                    {
                        window.location.reload();
                    }, 1000);
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message')
            }
        }).catch((error) => 
        {
            // setTimeout(
            //     function() 
            //     {
            //         window.location.reload();
            //     }, 1000);
            // console.log(error)
        }).finally(() => 
        {
            // $('.loader').hide();
        })
    };

    this_template.display_menu = () => 
    {
    
        instance.get(`user-one`,
        {
            params: ({
                employee_number: $('#lbl_employee_number').val() //session employee no
            })
        }).then((response) => {
            if (response['statusText'] == 'OK') {
                var user_type = '';
                var menu = '';
                var receiver = '';
                var split_menu = '';
                var list_menus = ['dashboard', 'master_data', 'lead_time_data', 'monitoring_report', 'parts_status', 'delivery_data', 'forecast', 'picker','reprint_docu',
                    'create', 'update', 'leadtime_report', 'overall_graph', 'pallet_report',
                    'checking', 'palletizing','parts_for_dr', 'update_delivery','remarks'];

                $.each(response.data[0], function () {
                    if (this.id == user_id) {
                        menu = this.process;
                        user_type = this.user_type;
                        receiver = this.receiver;
                    }
                });
                // alert(user_type);
                if(receiver == 1)
                {
                    document.getElementById('receiving').style.display = 'inline-flex';   
                }
                split_menu = menu.split(",");
                document.getElementById('monitoring').style.display = 'inline-flex';
                document.getElementById('irregularity').style.display = 'inline-flex';
                document.getElementById('reports').style.display = 'inline-flex';
                document.getElementById('transactions').style.display = 'inline-flex';
              
                for (var x = 0; x < list_menus.length; x++) {
                    if (split_menu[x] == 1) {
                       
                        document.getElementById(list_menus[x]).style.display = 'inline-flex';
                    }
                    if (split_menu[1] == 0 && split_menu[2] == 0 && split_menu[3] == 0 && split_menu[4] == 0 && split_menu[5] == 0 && split_menu[6] == 0 && split_menu[7] == 0){
                        document.getElementById('monitoring').style.display = "none";
                    }
                    if (split_menu[8] == 0) {
                        document.getElementById('reprint_docu').style.display = "none";
                    }
                    if (split_menu[9] == 0 && split_menu[10] == 0) {
                        document.getElementById('irregularity').style.display = "none";
                    }
                    if (split_menu[11] == 0 && split_menu[12] == 0 && split_menu[13] == 0) {
                        document.getElementById('reports').style.display = "none";
                    }
                    if (split_menu[14] == 0 && split_menu[15] == 0 && split_menu[16] == 0 && split_menu[17] == 0  && split_menu[18] == 0 )  {
                        document.getElementById('transactions').style.display = "none";
                    }
                    
                    if (user_type === 'Super Admin') {
                        document.getElementById('monitoring').style.display = 'inline-flex';
                        document.getElementById('irregularity').style.display = 'inline-flex';
                        document.getElementById('reports').style.display = 'inline-flex';
                        document.getElementById('transactions').style.display = 'inline-flex';
                        document.getElementById('managements').style.display = 'inline-flex';
                        document.getElementById(list_menus[x]).style.display = 'inline-flex';
                    }
                    else if (user_type === 'Admin') {
                        document.getElementById('managements').style.display = 'inline-flex';
                    }
                }
                // alert('123');
            }
            else {
                toastr.error('There was a problem in loading the data. Please contact the administrator. Thank you', 'System Message');
                // setTimeout(
                //     function() 
                //     {
                //         window.location.reload();
                //     }, 1000);
            }
        }).catch((error) => {
            // setTimeout(
            //     function() 
            //     {
            //         window.location.reload();
            //     }, 1000);
            console.log(error);
        }).finally(() => {
            // $('#thead_area_code').LoadingOverlay('hide');
        })
    };



    return this_template;
})();
