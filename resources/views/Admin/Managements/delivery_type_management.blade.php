
<div class="modal fade" id="mod_delivery_type" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_delivery_type_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('icons/delivery.png') }}" style="height:5%; width:5%;" class="rounded">
                <h5 class="modal-title" id="mod_delivery_type_label">&nbsp;Delivery Type Managament</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DELIVERY_TYPE.cancel_transaction();">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Delivery Type</label>
                            <input type="text" class="form-control" id="txt_delivery_type" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
    
                    </div>
                    <br><hr>
                    
                    <div class="row">
                        <div class="col-md-12 text-center">
                        <h5>List of Delivery Type</h5>
                        </div>
                    </div>
                    <br>
                    <input type="hidden" id="txt_delivery_type_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body border" style="padding:10px;">
                                <table id="thead_delivery_type" class="table table-bordered table-striped table-hover border-dark" style="width: 100%;">
                                        <thead style="background-color:#dbdbdb; ">
                                            <tr> 
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">No.</th>														
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Type</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Status</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Action</th>
                                            </tr>                      
                                        </thead>
                                        <tbody id="tbody_delivery_type"></tbody>
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
                            &nbsp;<button type="button" class="btn btn-primary" onclick="DELIVERY_TYPE.insert_delivery_type();" id="btn_save_delivery"><i class="fa fa-save"></i>&nbsp; Save Delivery Type</button>
                            &nbsp;<button type="button" class="btn btn-primary" onclick="DELIVERY_TYPE.update_delivery_type();" id="btn_update_delivery"><i class="fa fa-save"></i>&nbsp; Update Delivery Type</button>
                            &nbsp;<button type="button" class="btn btn-danger"  onclick="DELIVERY_TYPE.cancel_transaction();"   id="btn_cancel_transaction"><i class="fa fa-ban"></i>&nbsp; Reset</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary" onclick="DELIVERY_TYPE.cancel_transaction();" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  