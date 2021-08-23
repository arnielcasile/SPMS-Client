
<div class="modal fade" id="mod_remarks" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_remarks_label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <img src="{{ asset('icons/remark.png') }}" style="height:5%; width:5%;" class="rounded">
            <h5 class="modal-title" id="mod_remarks_label">&nbsp;Remarks</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="REMARKS.cancel_transaction();">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mt-2 mb-2">
                        <div class="m-dropdown__body m-dropdown__body--paddingless">
                            <div class="m-dropdown__content">
                                <div class="m-scrollable" data-scrollable="false" data-max-height="380" data-mobile-max-height="200">
                                    <div class="m-nav-grid m-nav-grid--skin-light">
                                        <div class="m-nav-grid__row">
                                            <button class="m-nav-grid__item" onclick="REMARKS.add_remarks();" id="add_remarks" disabled
                                                style="cursor:not-allowed; border-radius: 25px;border: 2px solid #2dad21;padding: 20px; width: 220px;height: 150px; background-color: white">
                                                <i class="m-nav-grid__icon flaticon-add" style="color: #2dad21"></i>
                                                <span class="m-nav-grid__text" style="color: #2dad21">Add Remarks</span>
                                            </button>
                                            <a class="m-nav-grid__item" style="padding: 20px; width: 1px;height: 150px;"></a>
                                            <button class="m-nav-grid__item" onclick="REMARKS.update_remarks();" id="edit_remarks" disabled
                                                style="cursor:not-allowed; border-radius: 25px;border: 2px solid #3287a8;padding: 20px; width: 220px;height: 150px;background-color: white">
                                                <i id="edit_remarks_icon" class="m-nav-grid__icon flaticon-edit" style="color: #3287a8"></i>
                                                <span id="edit_remarks_text" class="m-nav-grid__text" style="color: #3287a8">Update Remarks</span>
                                            </button>
                                            <a class="m-nav-grid__item" style="padding: 20px; width: 1px;height: 150px;"></a>
                                            <button class="m-nav-grid__item" onclick="REMARKS.cancel_remarks();" id="cancel_remarks" disabled
                                                style="cursor:not-allowed; border-radius: 25px;border: 2px solid #a83232;padding: 20px; width: 220px;height: 150px;background-color: white">
                                                <i id="cancel_remarks_icon" class="m-nav-grid__icon flaticon-cancel" style="color: #a83232"></i>
                                                <span id="cancel_remarks_text" class="m-nav-grid__text" style="color: #a83232">Remove Remarks</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><br><hr>
                    </div>
                </div>
                <input type="hidden" id="txt_remarks_id">
                <div class="row">
                    <div class="col-md-6">
                        <label>Issued Date:</label>
                        <input type="text" class="form-control datepicker_day" id="txt_remarks_issued_date" onchange="REMARKS.load_remarks();" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Warehouse Class:</label>
                        <input type="text" class="form-control" id="txt_wclass" readonly>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <label for="exampleTextarea">Remarks:</label>
                        <textarea class="form-control" rows="5" id="txt_remarks" style="resize: none;" placeholder="Input remarks"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="exampleTextarea">Corrective Action:</label>
                        <textarea class="form-control" rows="5" id="txt_corrective_action" style="resize: none;" placeholder="Input corrective action"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <button type="button" class="btn btn-danger"  onclick="REMARKS.cancel_transaction();" id="btn_cancel_transaction_remarks"><i class="fa fa-ban"></i>&nbsp;Cancel</button>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-secondary" onclick="REMARKS.cancel_transaction();" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Close</button>
                    </div>
                </div>
            </div>
           
            
               
        </div>
    </div>
  </div>
</div>

@section('custom-script')
<script src="{{asset('scripts/Transactions/remarks.js')}}"></script>
@endsection
