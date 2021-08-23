@extends('template')
@section('content-page')
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Receiving</h4>
            <small><label class="text-muted">Please double check your data before updating/ saving.</label></small>
            <hr>
            <br>
            <div class="card  shadow mb-4">
                <div class="card-header " style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark" href="#div_delivery_content" data-toggle="collapse">
                        <img src="{{ asset('icons/receive_icon.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>For Receiving</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_delivery_content" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label >Recipient:</label>
                                            <input type="text" readonly class="form-control form-control-lg text-center" id="txt_recipient">
                                        </div>
                                        <div class="col-md-6">
                                                <label >DR Control Number</label>
                                                <input type="text" class="form-control form-control-lg" id="txt_control_no" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                    
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12 text-left">
                                            <h5>Receiving Data</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel-body border border-dark p-3">
                                                <table id="tbl_receiving" class="table table-bordered table-striped table-hover " style="width: 100%;">
                                                    <thead class="thead-dark">
                                                        <tr> 
                                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Control DR Control</th>														
                                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Origin</th>
                                                        </tr>                      
                                                    </thead>
                                                    <tbody id="tbody_tbl_receiving" style="text-align:center;horizontal-align:middle;vertical-align:middle;"></tbody>
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
                                <button type="button" class="btn btn-block btn-primary" onclick="RECEIVING.receiving()"  id ="btn_receiving"><i class="fa fa-save"></i>&nbsp; Receive</button>
                                </div>
                                <div class="col-md-2">
                                <button type="button" class="btn btn-block btn-danger" onclick="RECEIVING.clear_inputs()"><i class="fa fa-trash"></i>&nbsp; Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            <div class="card  shadow mb-4" id="div_special_panel" style="display: none">
                <div class="card-header " style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark" href="#div_special_content" data-toggle="collapse">
                        <img src="{{ asset('icons/webpage.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Special</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_special_content" class="collapse hide" data-parent="#accordion">
                    <div class="card-body">
                        <br><h5>Special Data</h5>
                        <div class="table-responsive">
                            <table id="tbl_special" class="table table-bordered table-hover">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                            <input type="checkbox" style="zoom:2" id='chk_parent_special' name='chk_parent_special' onclick="RECEIVING.table_select_all()">
                                        </th>	
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">DR Control</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Issued Date</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Product No.</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Qty</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Manufacturing</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Date Delivered</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Remarks</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Breakdown</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_special" align="center"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer ">       
                        <div class="container-fluid mb-2">
                            <div class="row">   
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                <button type="button" class="btn btn-block btn-primary" onclick="RECEIVING.special();" id ="btn_receiving_special"><i class="fa fa-save"></i>&nbsp; Save</button>
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
<script src="{{asset('scripts/Transactions/receiving.js')}}"></script>
@endsection