$(document).ready(() => 
{
  
});
$( "#mod_area_code" ).on('shown.bs.modal', function(){
    AREA_CODE.load();
});
const AREA_CODE = (() => 
{
    let counter = 0;
    let modal = {};

    modal.load = () => 
    {
        instance.get(`/area-code-all`).then(function (response) 
        {
            var area_code = "";
            area_code = `<option selected disabled value="">Choose...</option>`;

            $.each(response['data'].data, function () 
            {    
                area_code += `<option class="select-option" value="${this.id}">${this.area_code}</option>`;
                $("#slc_area-code").html(area_code);
            });
        }).catch(function (error) 
        {
            console.log(error)
        }).finally(() => {})
    };

    modal.save = () => 
    {
        var area_code_id=$("#slc_area-code").val();
        var employee_no=$("#txt_employee_no").val();
        var area_code=$( "#slc_area-code option:selected" ).text();
        if(area_code_id === null)
        {
            toastr.warning('Please include area-code', 'System Message');
        }
        else 
        {
            counter++;
            if (counter === 1) 
            {
                $('#btn_save_area_code').text("Proceed...");
                $('#div_save_prompt').css("display", "block");
            }
            else if(counter > 1)
            {
                counter++;
                instance.patch(`/user`, 
                {
                    id      : $('#txt_user_id').val(),
                    area_id : area_code_id,
                }).then((response) => 
                {
                }).catch((error) => 
                {
                    toastr.error('There was a problem in save area code. Please contact the administrator. Thank you', 'System Message')
                }).finally(() => 
                {
                    // window.location.href=`/pdls-v2/client/public/grant-auth/${employee_no}`;
                    window.location.href=`/pdls-v2/client/public/grant-auth/${employee_no}/${area_code}`;
                })
            }
        }
        console.log(counter); 
    };

    return modal;
})();
