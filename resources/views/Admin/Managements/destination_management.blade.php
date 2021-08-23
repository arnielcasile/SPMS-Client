
<div class="modal fade" id="mod_destination" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_destination_label" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('icons/marker.png') }}" style="height:5%; width:5%;" class="rounded">
                <h5 class="modal-title" id="mod_destination_label">&nbsp;Destination Managament</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DESTINATION.cancel_transaction();">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Payee CD</label>
                            <input type="text" class="form-control" id="txt_payee_cd" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                        <div class="col-md-4">
                            <label>Payee Name</label>
                            <input type="text" class="form-control" id="txt_payee_name" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                        <div class="col-md-4">
                            <label>Destination</label>
                            <input type="text" class="form-control" id="txt_destination" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label>Attention To</label>
                            <input type="text" class="form-control" id="txt_destination_attention_to" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                        <div class="col-md-4">
                            <label>Destination Class</label>
                            <input type="text" class="form-control" id="txt_destination_class" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                        <div class="col-md-4">
                            <label>Purpose</label>
                            <input type="text" class="form-control" id="txt_destination_purpose" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label>Special Process</label>
                            <select class="custom-select" id="slc_special_process">
                                <option value="" selected hidden> SELECT SPECIAL PROCESS</option>
                                <option value="0"> NORMAL</option>
                                <option value="2"> SPECIAL</option>
                                <option value="1"> W/O DR</option>
                                
                            </select>
                        </div>
                    </div>
                    <br><hr><br>
                    <div class="row">
                        <div class="col-md-12 text-center">
                        <h5>List of Destinations</h5>
                        </div>
                    </div>
                    <input type="hidden" id="txt_destination_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="panel-body border table-responsive" style="padding:10px;">
                                    <table id="thead_destination" class="table table-bordered table-striped table-hover border-dark " style="width: 100%;">
                                            <thead style="background-color:#dbdbdb; ">
                                                <tr> 
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">No.</th>														
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Payee CD</th>
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Payee Name</th>
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Destination</th>
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Attention To</th>
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Destination Class</th>
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Purpose</th>
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Special Process</th>
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Status</th>
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Action</th>
                                                </tr>                      
                                            </thead>
                                        <tbody id="tbody_destination"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-8 float-left">
                        <button type="button" class="btn btn-primary" onclick="DESTINATION.insert_destination();" id="btn_save_destination"><i class="fa fa-save"></i>&nbsp; Save Destination</button>
                        <button type="button" class="btn btn-primary" onclick="DESTINATION.update_destination();" id="btn_update_destination"><i class="fa fa-save"></i>&nbsp; Update Destination</button>
                        <button type="button" class="btn btn-danger"  onclick="DESTINATION.cancel_transaction();" id="btn_cancel_transaction"><i class="fa fa-ban"></i>&nbsp;Reset</button>
                      </div>
                    </div>
                </div>
               
                <button type="button" class="btn btn-secondary"onclick="DESTINATION.cancel_transaction();" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Close</button>
            
            </div>
        </div>
    </div>
</div>
  