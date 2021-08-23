
<div class="modal fade" id="mod_area_code"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_area_code_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('icons/html.png') }}" style="height:5%; width:5%;" class="rounded">
                <h5 class="modal-title" id="mod_area_code_label">&nbsp;Area Code Managament</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="AREA_CODE.cancel_transaction();">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <label> Area Code</label>
                            <input type="text" class="form-control" id="txt_area_code_mngt" onkeyup=" this.value = this.value.toUpperCase();"  maxlength="30">
                        </div>   
                        
                    </div>
                    <br><hr>
                    
                    <div class="row">
                        <div class="col-md-12 text-center">
                        <h5>List of Area Code</h5>
                        </div>
                    </div>
                    <br>
                    <input type="hidden" id="txt_area_code_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body border" style="padding:10px;">
                                <table id="thead_area_code" class="table table-bordered table-striped table-hover border-dark" style="width: 100%;">
                                        <thead style="background-color:#dbdbdb; ">
                                            <tr> 
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">No.</th>														
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Area Code</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Status</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Action</th>
                                            </tr>                      
                                        </thead>
                                    <tbody id="tbody_area_code"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10">
                            &nbsp;<button type="button" class="btn btn-primary" onclick="AREA_CODE.insert_area_code();" id="btn_save_area_code"><i class="fa fa-save"></i>&nbsp; Save Area Code</button>
                            &nbsp;<button type="button" class="btn btn-primary" onclick="AREA_CODE.update_area_code();" id="btn_update_area_code"><i class="fa fa-save"></i>&nbsp; Update Area Code</button>
                            &nbsp;<button type="button" class="btn btn-danger"  onclick="AREA_CODE.cancel_transaction();" id="btn_cancel_transaction"><i class="fa fa-ban"></i>&nbsp;Reset</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-block btn-secondary" onclick="AREA_CODE.cancel_transaction();" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>
  