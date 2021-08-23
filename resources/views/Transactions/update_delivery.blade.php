@extends('template')
@section('content-page')
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Delivery Update</h4>
            <small><label class="text-muted">Please double check your data before updating/ saving.</label></small>
            <hr>
            <br>
            <div class="card  shadow mb-4">
                <div class="card-header " style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark" href="#div_banner_content" data-toggle="collapse">
                        <img src="{{ asset('icons/webpage.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Banner Printing</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_banner_content" class="collapse hide" data-parent="#accordion">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label >Delivery Receipt Control:</label>
                                            <input type="text" class="form-control form-control-lg" id="txt_delivery_receipt_control" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <h5>Banner List</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel-body border border-dark p-3">
                                                <table id="tbl_banner_list" class="table table-bordered table-striped table-hover " style="width: 100%;">
                                                    <thead class="thead-dark" align="center">
                                                        <tr> 														
                                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Control Number</th>														
                                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Destination</th>														
                                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Description</th>														
                                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Purpose</th>														
                                                        </tr>                      
                                                    </thead>
                                                <tbody id="tbl_banner_list_body" align="center"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <label >Pallet Quantity:</label>
                                            <input type="text" class="form-control form-control-lg" id="txt_pallet_qty"
                                            onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" onpaste="return false" maxlength="3">
                                        </div>
                                        <div class="col-md-6">
                                            <label >TOTAL PALLET:</label>
                                            <input type="text" class="form-control form-control-lg" id="txt_total_pallet"
                                            onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" onpaste="return false" maxlength="3"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <label >P-Case Quantity:</label>
                                            <input type="text" class="form-control form-control-lg" id="txt_pcase_qty"
                                            onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" onpaste="return false" maxlength="3">
                                        </div>
                                        <div class="col-md-6">
                                            <label >TOTAL P-CASE:</label>
                                            <input type="text" class="form-control form-control-lg" id="txt_total_pcase"
                                            
                                            onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" onpaste="return false" maxlength="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <label >Box Quantity:</label>
                                            <input type="text" class="form-control form-control-lg" id="txt_box_qty"
                                            
                                            onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" onpaste="return false" maxlength="3">
                                        </div>
                                        <div class="col-md-6">
                                            <label >TOTAL BOX:</label>
                                            <input type="text" class="form-control form-control-lg" id="txt_total_box" 
                                            onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" onpaste="return false" maxlength="3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">       
                        <div class="container-fluid mb-2">
                            <div class="row">   
                                <div class="col-md-8">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-block btn-primary" onclick="UPDATE_DELIVERY.submit_banner();"><i class="fa fa-save"></i>&nbsp; Submit</button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-block btn-danger" onclick="UPDATE_DELIVERY.clear_banner_tbl();"><i class="fa fa-trash"></i>&nbsp; Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            <div class="card  shadow mb-4">
                <div class="card-header " style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark" href="#div_delivery_content" data-toggle="collapse">
                        <img src="{{ asset('icons/truck.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Delivery Update</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_delivery_content" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label >Transporter:</label>
                                            <input type="text" readonly class="form-control form-control-lg text-center" id="txt_transporter">
                                        </div>
                                        <div class="col-md-6">
                                                <label >DR Control Number</label>
                                                <input type="text"  autocomplete="off" class="form-control form-control-lg" id="txt_control_no" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                    
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12 text-left">
                                            <h5>Delivery Update Data</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel-body border border-dark p-3">
                                                <table id="tbl_update_delivery" class="table table-bordered table-striped table-hover " style="width: 100%;">
                                                    <thead class="thead-dark">
                                                        <tr> 
                                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">DR Control</th>														
                                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Normal Status</th>
                                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Irregularity Status</th>
                                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Item Count</th>
                                                        </tr>                      
                                                    </thead>
                                                    <tbody id="tbody_tbl_update_delivery" style="text-align:center;horizontal-align:middle;vertical-align:middle;"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">       
                        <div class="container-fluid mb-2">
                            <div class="row">   
                                <div class="col-md-8">
                                </div>
                                <div class="col-md-2">
                                <button type="button" class="btn btn-block btn-primary" onclick="UPDATE_DELIVERY.update_delivery()"><i class="fa fa-save" id="btn_update_delivery"></i>&nbsp; Update</button>
                                </div>
                                <div class="col-md-2">
                                <button type="button" class="btn btn-block btn-danger" onclick="UPDATE_DELIVERY.clear_inputs()"><i class="fa fa-trash"></i>&nbsp; Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            <div class="card  shadow mb-4" id="div_dispatch_panel" style="display: none">
                <div class="card-header " style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark" href="#div_dispatch_content" data-toggle="collapse">
                        <img src="{{ asset('icons/webpage.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>For Dispatch</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_dispatch_content" class="collapse hide" data-parent="#accordion">
                    <div class="card-body">
                        <br><h5>For Dispatch Data</h5>
                        <div class="table-responsive">
                            <table id="tbl_dispatch" class="table table-bordered table-hover">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                            <input type="checkbox" style="zoom:2" id='chk_parent_dispatch' name='chk_parent_dispatch' onclick="UPDATE_DELIVERY.table_select_all()">
                                        </th>	
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">DR Control</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Issued Date</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Product No.</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Qty</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Manufacturing</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Breakdown</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_dispatch" align="center"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer ">       
                        <div class="container-fluid mb-2">
                            <div class="row">   
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                <button type="button" class="btn btn-block btn-primary" onclick="UPDATE_DELIVERY.dispatch();"><i class="fa fa-save"></i>&nbsp; Dispatch</button>
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
<script src="{{asset('scripts/Transactions/update_delivery.js')}}"></script>
@endsection