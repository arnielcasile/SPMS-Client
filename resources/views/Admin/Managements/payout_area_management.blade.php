
<div class="modal fade" id="mod_payout_area" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_payout_area_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('icons/paper cartoon.png') }}" style="height:5%; width:5%;" class="rounded">
                <h5 class="modal-title" id="mod_payout_area_label">&nbsp;Area Code (Payout) Managament</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Area Code</label>
                            <input type="text" class="form-control" id="txt_area_payout" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
    
                    </div>
                    <br><hr>
                    
                    <div class="row">
                        <div class="col-md-12 text-center">
                        <h5>List of Area Code</h5>
                        </div>
                    </div>
                    <br>
                    <input type="hidden" id="txt_area_payout_id">
                    <input type="hidden" id="txt_checker">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body border" style="padding:10px;">
                                <table id="thead_area_payout" class="table table-bordered table-striped table-hover border-dark" style="width: 100%;">
                                        <thead style="background-color:#dbdbdb; ">
                                            <tr> 
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">No.</th>														
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Area Code</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Action</th>
                                            </tr>                      
                                        </thead>
                                    <tbody id="tbody_area_payout"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancel</button>
                <button type="button" class="btn btn-primary" onclick="AREA_PAYOUT.insert_area_payout();" id="btn_save_area_payout"><i class="fa fa-save"></i>&nbsp; Save Area Code</button>
                <button type="button" class="btn btn-primary" onclick="AREA_PAYOUT.update_area_payout();" id="btn_update_area_payout"><i class="fa fa-save"></i>&nbsp; Update Area Code</button>
            </div>
        </div>
    </div>
</div>
  