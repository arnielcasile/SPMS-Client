@extends('template')

@section('content-page')

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <div class="card  shadow mb-4">
                <div class="card-header" style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark"  data-toggle="collapse" href="#div_update_irreg">
                        <img src="{{ asset('icons/refresh.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Parts With Irregularity (Update)</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_update_irreg" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Barcode:</label>
                                <input type="text" class="form-control" 
                                    style="background-color:white;" id="txt_update_barcode" readonly placeholder="Input barcode">
                            </div>
                            <div class="col-md-3">
                                <label>Actual Quantity:</label>
                                <input type="text" class="form-control" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));"
                                    style="background-color:white;" id="txt_update_actual" placeholder="Input actual quantity" 
                                    onkeyup="UPDATE_IRREGULARITY.onchange_actual_quantity();" maxlength="7">
                            </div>
                            <div class="col-md-3">
                                <label>Type of Irregularity:</label>
                                <select class="custom-select" id="slc_update_type_of_irreg" onchange="UPDATE_IRREGULARITY.enable_others()">
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
                                    style="background-color:white;" id="txt_update_others" maxlength="30" readonly>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Remarks:</label>
                                <input type="text" class="form-control" 
                                    style="background-color:white;" id="txt_update_remarks" placeholder="Input remarks" maxlength="30">
                            </div>
                            <div class="col-md-3">
                                <label>Original Quantity:</label>
                                <input type="text" class="form-control" 
                                    style="background-color:white;" id="txt_update_original" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>Part Number:</label>
                                <input type="text" class="form-control" 
                                    style="background-color:white;" id="txt_update_part_no" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>Part Name:</label>
                                <input type="text" class="form-control" 
                                    style="background-color:white;" id="txt_update_part_name" readonly>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Status:</label>
                                <input type="text" class="form-control" 
                                    style="background-color:white;" id="txt_update_status" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>Discrepancy Quantity:</label>
                                <input type="text" class="form-control" 
                                    style="background-color:white;" id="txt_update_discrepancy" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>Order Download No:</label>
                                <input type="text" class="form-control" 
                                    style="background-color:white;" id="txt_update_order_download_no" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>Stock Address:</label>
                                <input type="text" class="form-control" 
                                    style="background-color:white;" id="txt_update_stock_address" readonly>
                            </div>
                        </div><br>
                        <div class="row text-center">
                                <div class="col-md-2">
                                </div>
                            <div class="col-md-4">
                                <button class="btn btn-success btn-xs btn-block" id="btn_add_irreg"
                                    onclick="UPDATE_IRREGULARITY.update_irregularity()"><span class="flaticon-download"></span>&nbsp;   UPDATE IRREGULARITY</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-danger btn-xs btn-block" id="btn_clear_irreg"
                                    onclick="UPDATE_IRREGULARITY.clear_inputs()"><span class="flaticon-delete"></span>&nbsp;   CLEAR ALL FIELDS</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Range:</label>
                                <select class="custom-select" id="slc_irreg_update_range" onchange="UPDATE_IRREGULARITY.onchange_datepicker_for_update();">
                                    <option value="" selected hidden> SELECT RANGE</option>
                                    <option value="DAILY"> DAILY</option>
                                    <option value="MONTHLY"> MONTHLY</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Date From:</label>
                                <input style="background-color:white;" type="text"
                                    class="form-control datepicker_month"
                                    id="txt_irreg_update_month_date_from" placeholder="Select date from" readonly hidden>
                                <input style="background-color:white;" type="text"
                                    class="form-control datepicker_day"
                                    id="txt_irreg_update_date_from" placeholder="Select date from" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>Date To:</label>
                                <input style="background-color:white;" type="text"
                                    class="form-control datepicker_month"
                                    id="txt_irreg_update_month_date_to" placeholder="Select date to" readonly hidden>
                                <input style="background-color:white;" type="text"
                                    class="form-control datepicker_day" id="txt_irreg_update_date_to"
                                    placeholder="Select date to" readonly>
                            </div>
                            <div class="col-md-3">
                                <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                                    onclick="UPDATE_IRREGULARITY.load_update_irregularity_list();"><i class="flaticon-search"></i> SEARCH</button>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="thead_update_irreg" class="table table-bordered table-hover">
                                    <thead class="thead-dark" align="center" style="width: 100%;">
                                        <tr>
                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">No.</th>
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
                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Control No.</th>
                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;" width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_update_irreg" align="center"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card  shadow mb-4">
                <div class="card-header" style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark"  data-toggle="collapse" href="#div_list_of_irreg">
                        <img src="{{ asset('icons/list.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>List of Irregularity</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_list_of_irreg" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Range:</label>
                                    <select class="custom-select" id="slc_list_range" onchange="UPDATE_IRREGULARITY.onchange_datepicker_for_list();">
                                        <option value="" selected hidden> SELECT RANGE</option>
                                        <option value="DAILY"> DAILY</option>
                                        <option value="MONTHLY"> MONTHLY</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Date From:</label>
                                    <input style="background-color:white;" type="text"
                                        class="form-control datepicker_month"
                                        id="txt_list_month_date_from" placeholder="Select date from" readonly hidden>
                                    <input style="background-color:white;" type="text"
                                        class="form-control datepicker_day"
                                        id="txt_list_date_from" placeholder="Select date from" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Date To:</label>
                                    <input style="background-color:white;" type="text"
                                        class="form-control datepicker_month"
                                        id="txt_list_month_date_to" placeholder="Select date to" readonly hidden>
                                    <input style="background-color:white;" type="text"
                                        class="form-control datepicker_day" id="txt_list_date_to"
                                        placeholder="Select date to" readonly>
                                </div>
                                <div class="col-md-3">
                                    <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                                        onclick="UPDATE_IRREGULARITY.load_irregularity_list();"><i class="flaticon-search"></i> SEARCH</button>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="thead_list_of_irreg" class="table table-bordered table-hover">
                                        <thead class="thead-dark" align="center" style="width: 100%;">
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
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Irregularity Control</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">DR Control</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Transporter</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Date Delivered</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_list_of_irreg" align="center"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-script')
<script src="{{asset('scripts/Admin/parts_with_irreg_update.js')}}"></script>
@endsection