@extends('template')

@section('content-page')

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Monitoring Report</h4><br>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 style="display: inline-block;" class="text-primary">Issuance</h5>
                         
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Status:</label>
                            <select class="custom-select" id="slc_mr_status">
                                {{-- <option value="" selected hidden> SELECT STATUS</option> --}}
                                <option value="ALL"> ALL</option>
                                <option value="FOR DISTRIBUTION"> FOR DISTRIBUTION</option>
                                <option value="FOR PICKING"> FOR PICKING </option>
                                <option value="ON PICKING"> ON PICKING </option>
                                <option value="FOR CHECKING"> FOR CHECKING </option>
                                <option value="FOR PALLETIZING"> FOR PALLETIZING</option>
                                <option value="FOR DR MAKING"> FOR DR MAKING </option>
                                <option value="FOR DELIVERY"> FOR DELIVERY </option>
                                <option value="DELIVERED"> DELIVERED </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Range:</label>
                            <select class="custom-select" id="slc_mr_range" onchange="MONITORING_REPORT.onchange_datepicker();">
                                <option selected value="DAILY"> DAILY</option>
                                <option value="MONTHLY"> MONTHLY</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date From:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_mr_range_date_month_from" placeholder="Select date from" readonly hidden>
                            <input style="background-color:white;" type="text"
                                class="form-control datepicker_day" id="txt_mr_range_date_from"
                                placeholder="Select date to" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Date To:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_mr_range_date_month_to" placeholder="Select date to" readonly hidden>
                            <input style="background-color:white;" type="text"
                                class="form-control datepicker_day" id="txt_mr_range_date_to"
                                placeholder="Select date to" readonly>
                        </div>
                    </div><br>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 style="display: inline-block;" class="text-primary">Delivery Due</h5>
                        
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Due Date:</label>
                            <select class="custom-select" id="slc_mr_deliv_due_date" onchange="MONITORING_REPORT.onchange_datepicker();">
                                <option selected value="DAILY"> DAILY</option>
                                <option value="MONTHLY"> MONTHLY</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date From:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_mr_deliv_date_month_from" placeholder="Select date from" readonly hidden>
                            <input type="text" class="form-control datepicker_day"  type="text"
                                style="background-color:white;" id="txt_mr_deliv_date_from" 
                                placeholder="Select date to" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Date To:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_mr_deliv_date_month_to" placeholder="Select date to" readonly hidden>
                            <input type="text" class="form-control datepicker_day" type="text"
                                style="background-color:white;" id="txt_mr_deliv_date_to" 
                                placeholder="Select date to" readonly>
                        </div>
                        <div class="col-md-3">
                            <button style="margin-top:5%;" id="btn_search" class="btn btn-primary btn-xs btn-block"
                            onclick="MONITORING_REPORT.search_btn()"><i class="flaticon-search"></i> SEARCH</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card  shadow mb-4">
                <div class="card-header" style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark"  data-toggle="collapse" id="accordion" href="#div_daily_status">
                        <img src="{{ asset('icons/status.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Delivery Status (Count)</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button>
                </div>
                <br>
                <div id="div_daily_status" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div id="chart_status" class="col-md-12" style="width: 70%; height:500px;"></div>
                                    <div class="col-md-12">
                                        <div class="table-responsive" id="table_status">
                                            <table id="table_daily_status" class="table table-bordered table-hover" width="100%">
                                                <thead id="thead_daily_status" class="thead-dark" align="center">
                                                </thead>
                                                <tbody id="tbody_daily_status" align="center"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card  shadow mb-4">
                <div class="card-header" style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark"  data-toggle="collapse" href="#div_issuance_count">
                        <img src="{{ asset('icons/count.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Issuance Count (Per Payee Name)</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button>
                </div>
                <br>
                <div id="div_issuance_count" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div id="chart_count" class="col-md-12" style="width: 50%; height: 400px;"></div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="table_issuance_count"  class="table table-bordered table-hover" width="100%">
                                                <thead id="thead_issuance_count" class="thead-dark" align="center"></thead>
                                                <tbody id="tbody_issuance_count" align="center"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card  shadow mb-4">
                <div class="card-header" style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark"  data-toggle="collapse" href="#div_issuance_sum">
                        <img src="{{ asset('icons/sum.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Issuance Sum (Per Payee Name)</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button>
                </div>
                <br>
                <div id="div_issuance_sum" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div id="chart_sum" class="col-md-12" style="width: 50%; height: 400px;"></div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="table_issuance_sum"  class="table table-bordered table-hover" width="100%">                     
                                                <thead id="thead_issuance_sum"  class="thead-dark" align="center"></thead>
                                                <tbody id="tbody_issuance_sum" align="center"></tbody>
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
    </div>
</div>
@endsection

@section('custom-script')
<script type="text/javascript" src="../node_modules/amcharts/core.js" ></script>
<script type="text/javascript" src="../node_modules/amcharts/charts.js" ></script>
{{-- <script type="text/javascript" src="../node_modules/amcharts/dataviz.js" ></script> --}}
<script type="text/javascript" src="../node_modules/amcharts/animated.js" ></script>
<script type="text/javascript" src="../node_modules/amcharts/kelly.js" ></script>
<script type="text/javascript" src="../node_modules/amcharts/material.js" ></script>
<!-- <script type="text/javascript" src="../node_modules/amcharts/frozen.js" ></script> -->
<script src="{{asset('scripts/Admin/monitoring_report.js')}}"></script>
@endsection