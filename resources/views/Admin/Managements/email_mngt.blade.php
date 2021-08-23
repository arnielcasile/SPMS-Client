
<div class="modal fade" id="mod_email_mngt"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_email_mngt_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('icons/html.png') }}" style="height:3%; width:3%;" class="rounded">
                <h5 class="modal-title" id="mod_email_mngt_label">&nbsp;Email Managament</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="EMAIL.clear_inputs();">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <label>ID Number</label>
                            <input type="text" class="form-control" id="txt_id_number_mngt" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" maxlength="7">
                        </div>    
                    </div>

                    <br><hr>
                    <div class="row">
                        <div class="col-md-12 text-center">
                        <h5>List of Email</h5>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body border" style="padding:20px;">
                                <table id="thead_email_mngt" class="table table-bordered table-striped table-hover border-dark" style="width: 100%;">
                                        <thead style="background-color:#dbdbdb; ">
                                            <tr> 
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">No.</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">ID Number</th>													
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Name</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Email</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Action</th>
                                            </tr>                      
                                        </thead>
                                    <tbody id="tbody_email_mngt"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" onclick="EMAIL.save_email();" id="btn_save_area_code"><i class="fa fa-save"></i>&nbsp; Save Email</button>
                            &nbsp;<button type="button" class="btn btn-danger"  onclick="EMAIL.clear_inputs();" id="btn_cancel_transaction"><i class="fa fa-ban"></i>&nbsp;Reset</button>
                        </div>
                        <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-secondary" onclick="EMAIL.clear_inputs();" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
              
               
            </div>
        </div>
    </div>
</div>
  