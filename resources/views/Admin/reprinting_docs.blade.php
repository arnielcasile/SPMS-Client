@extends('template')

@section('content-page')

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <div class="card  shadow mb-4">
                <div class="card-header" style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark"  data-toggle="collapse" href="#div_deliv_receipt">
                        <img src="{{ asset('icons/deliv_receipt.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Delivery Receipt</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_deliv_receipt" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Range:</label>
                                    <select class="custom-select" id="slc_deliv_receipt_range" onchange="REPRINT_DOCU.onchange_datepicker();">
                                        <option value="" selected hidden> SELECT RANGE</option>
                                        <option value="DAILY"> DAILY</option>
                                        <option value="MONTHLY"> MONTHLY</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Date From:</label>
                                    <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                    id="txt_deliv_receipt_month_date_from" placeholder="Select date from" readonly hidden>
                                    <input style="background-color:white;" type="text"
                                    class="form-control datepicker_day"
                                    id="txt_deliv_receipt_date_from" placeholder="Select date from" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Date To:</label>
                                    <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                    id="txt_deliv_receipt_month_date_to" placeholder="Select date to" readonly hidden>
                                    <input style="background-color:white;" type="text"
                                    class="form-control datepicker_day" id="txt_deliv_receipt_date_to"
                                    placeholder="Select date to" readonly>
                                </div>
                                <div class="col-md-3">
                                    <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                                    onclick="REPRINT_DOCU.load_delivery_receipt_list()"><i class="flaticon-search"></i> SEARCH</button>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="thead_delivery_receipt" class="table table-bordered table-hover">
                                        <thead class="thead-dark" align="center">
                                            <tr>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Control No.</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_delivery_receipt" align="center"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card  shadow mb-4">
                <div class="card-header" style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark"  data-toggle="collapse" href="#div_irreg_form">
                        <img src="{{ asset('icons/form.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Irregularity Form</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_irreg_form" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Range:</label>
                                    <select class="custom-select" id="slc_irreg_range" onchange="REPRINT_DOCU.onchange_datepicker();">
                                        <option value="" selected hidden> SELECT RANGE</option>
                                        <option value="DAILY"> DAILY</option>
                                        <option value="MONTHLY"> MONTHLY</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Date From:</label>
                                    <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                    id="txt_irreg_month_date_from" placeholder="Select date from" readonly hidden>
                                    <input style="background-color:white;" type="text"
                                    class="form-control datepicker_day"
                                    id="txt_irreg_date_from" placeholder="Select date from" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Date To:</label>
                                    <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                    id="txt_irreg_month_date_to" placeholder="Select date to" readonly hidden>
                                    <input style="background-color:white;" type="text"
                                    class="form-control datepicker_day" id="txt_irreg_date_to"
                                    placeholder="Select date to" readonly>
                                </div>
                                <div class="col-md-3">
                                    <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                                    onclick="REPRINT_DOCU.load_irregularity_list()"><i class="flaticon-search"></i> SEARCH</button>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="thead_irreg_form" class="table table-bordered table-hover">
                                        <thead class="thead-dark" align="center">
                                            <tr>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    <input type="checkbox" style="zoom:2" id='chk_parent_irreg' name='chk_parent_irreg' onclick="REPRINT_DOCU.table_select_all()">
                                                </th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Irregularity Control No.</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_irreg_form" align="center"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4" id="div_add_irregularity">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Prepared By:</label>
                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();"
                                        style="background-color:white;" id="txt_prepared_by_irregularity" placeholder="Input prepared by">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Reviewed By:</label>
                                        <select class="custom-select" id="slc_reviewed_by_irregularity"></select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Approved By:</label>
                                        <select class="custom-select" id="slc_approved_by_irregularity"></select>
                                    </div>
                                    <div class="col-md-3">
                                        <button style="margin-top:8%;" class="btn btn-success btn-xs btn-block" id="btn_submit_irreg"
                                        onclick="REPRINT_DOCU.print_irreg()"><i class="fa fa-print"></i>&nbsp;&nbsp;PRINT</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mod_edit_dr"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_edit_dr_label" aria-hidden="true">
    <div class="modal-dialog modal-lg moda  modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <img src="{{ asset('icons/deliv_receipt.png') }}" style="height:5%; width:5%;" class="rounded">
              <h5 class="modal-title" id="mod_edit_dr_label">
                &nbsp;&nbsp;<b>Delivery Receipt</b>&nbsp;</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <label>DR Control :</label>
                        <input type="text" class="form-control" id="txt_dr_control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label >Approved by :</label>
                        <select id="slc_edit_approved_by" class="custom-select"  required>
                        </select>
                        <div class="invalid-tooltip">
                            Please select a valid name.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Attention to :</label>
                        <input readonly type="text" class="form-control" id="txt_edit_attention_to" ><br><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label style="margin-bottom: 3%; font-weight: bold;">Break Down</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Pallet Qty :</label>
                        <input type="text" class="form-control" id="txt_pallet_qty" onkeypress="return onlyNumberKey(event)" autocomplete="off" maxlength="3">
                    </div>
                    <div class="col-md-3">
                        <label>P-Case No. :</label>
                        <input type="text" class="form-control" id="txt_pcase_no" onkeypress="return onlyNumberKey(event)" autocomplete="off" maxlength="3">
                    </div>
                    <div class="col-md-3">
                        <label>Box :</label>
                        <input type="text" class="form-control" id="txt_box" onkeypress="return onlyNumberKey(event)" autocomplete="off" maxlength="3">
                    </div>
                    <div class="col-md-3">
                        <label>Bag :</label>
                        <input type="text" class="form-control" id="txt_bag" onkeypress="return onlyNumberKey(event)" autocomplete="off" maxlength="3">
                    </div>
                </div>
                <div id="div_save_prompt" hidden>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="col-md-8">
                      
                        </div>
                        <div class="col-md-4">
                            <label>Are you sure to print this value?</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="btn_save_edit_dr_prompt" onclick="REPRINT_DOCU.show_prompt();" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</button>
            <button type="button" id="btn_save_edit_dr"   hidden onclick="REPRINT_DOCU.print_dr();" class="btn btn-primary">Continue</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
@endsection

@section('custom-script')
<script src="{{asset('scripts/Admin/reprinting_docs.js')}}"></script>
@endsection