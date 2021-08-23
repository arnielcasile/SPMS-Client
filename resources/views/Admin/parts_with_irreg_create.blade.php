@extends('template')

@section('content-page')

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Parts With Irregularity (Create)</h4><br>
            <div class="card shadow mb-4 form-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Barcode:</label>
                            <input type="text" class="form-control" autocomplete="off" style="background-color:white;" id="txt_barcode" oninput="this.value = this.value.toUpperCase()" placeholder="Input barcode">
                            <input type="hidden"  id="txt_destination">
                            <input type="hidden"  id="txt_warehouse_class">
                        </div>
                        <div class="col-md-3">
                            <label>Actual Quantity:</label>
                            <input type="text" class="form-control" style="background-color:white;" id="txt_actual"  autocomplete="off"
                                onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" 
                                onkeyup="CREATE_IRREGULARITY.onchange_actual_quantity();"
                                placeholder="Input actual quantity" maxlength="7">
                        </div>
                        <div class="col-md-3">
                            <label>Type of Irregularity:</label>
                            <select class="custom-select" id="slc_type_of_irreg" onchange="CREATE_IRREGULARITY.enable_others()">
                                <option value="" selected hidden> SELECT TYPE OF IRREGULARITY</option>
                                <option value="LACKING"> LACKING</option>
                                <option value="NO STOCK"> NO STOCK</option>
                                <option value="EXCESS"> EXCESS</option>
                                <option value="OTHERS"> OTHERS</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Others:</label>
                            <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();"
                                style="background-color:white;" id="txt_others" maxlength="30" readonly> 
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Remarks:</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_remarks" placeholder="Input remarks" maxlength="30">
                        </div>
                        <div class="col-md-3">
                            <label>Original Quantity:</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_original" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Part Number:</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_part_no" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Part Name:</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_part_name" readonly>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Status:</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_status" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Discrepancy Quantity:</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_discrepancy" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Order Download No:</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_order_download_no" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Stock Address:</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_stock_address" readonly>
                        </div>
                    </div><br>
                    <div class="row text-center">
                            <div class="col-md-2">
                            </div>
                        <div class="col-md-4">
                            <button class="btn btn-success btn-xs btn-block" id="btn_add_irreg"
                                onclick="CREATE_IRREGULARITY.add_irregularity()"><span class="flaticon-download"></span>&nbsp;   ADD IRREGULARITY</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-danger btn-xs btn-block" id="btn_clear_irreg"
                                onclick="CREATE_IRREGULARITY.clear_inputs()"><span class="flaticon-delete"></span>&nbsp;   CLEAR ALL FIELDS</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="thead_create_irreg" class="table table-bordered table-hover">
                            <thead class="thead-dark" align="center">
                                <tr>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Barcode</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Order Download No.</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Type of Irregularity</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Status</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Stock Address</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Part No.</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Part Name</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Original Quantity</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Actual Quantity</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Discrepancy Quantity</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Remarks</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_create_irreg" align="center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Prepared By:</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_prepared_by" placeholder="Input prepared by" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Reviewed By:</label>
                            <select class="custom-select" id="slc_reviewed_by"></select>
                        </div>
                        <div class="col-md-3">
                            <label>Approved By:</label>
                            <select class="custom-select" id="slc_approved_by"></select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-xs btn-block" onclick="CREATE_IRREGULARITY.print()" id="btn_upload_irregularity" style="margin-top:8%;"
                                onclick=""><i class="fa fa-print"></i>&nbsp;   PRINT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-script')
<script src="{{asset('scripts/Admin/parts_with_irreg_create.js')}}"></script>
@endsection