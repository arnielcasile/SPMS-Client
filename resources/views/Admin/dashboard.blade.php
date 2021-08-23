@extends('template')

@section('content-page')
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <table>
                        <tr>
                            <td rowspan='2'>
                                <img src="{{ asset('icons/dashboard/dashboard.png') }}" style="display: block;height: 6%;width: 3em; margin-right: 20px;">
                            </td>
                            <td>
                                <h4 class="header-title" style="display:inline">Dashboard</h4>
                              </td>
                        </tr>
                        <tr>
                         
                            <td>
                                <small><label class="text-muted">Find ticket and see the latest numbers in PDLS.</label></small>
                            </td>
                        </tr>
                    </table>
                   
                   
                </div>
            </div>
            <hr>
        </div>
        <div class="m-content">
            <div class="m-portlet" id="div_main">
                <div class="m-portlet__body  m-portlet__body--no-padding">
                    <div class="row m-row--no-padding m-row--col-separator-xl">                             
                        <div class="col-xl-4" style="border-right: solid #959595 1px">                              
                            <div class="m-widget14">
                                <div class="m-widget14__header m--no-padding">
                                    <span class="m-widget14__title">
                                            <h4 style="color:#575962">
                                                &nbsp;&nbsp;Ticket Tracker
                                            </h4>
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-2">
                                        <input type="text" class="form-control form-control-md" autocomplete="off" placeholder="Ticket Number" id="txt_ticket_no" oninput="this.value = this.value.toUpperCase()"  aria-describedby="basic-addon2">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <button  class="btn btn-primary btn-xs btn-block" onclick="DASHBOARD.track()"><i class="fa fa-search"></i> Search</button>  
                                    </div>
                                </div>
                                <hr>
                                <div id="div_track_default">
                                    <span class="m-widget14__desc">
                                        &nbsp;&nbsp;&nbsp;&nbsp;No results found.
                                    </span>
                                    <center>
                                        <img src="{{ asset('icons/searching.png') }}" width="75%">
                                    </center>
                                </div>
                                <div id="div_track_details" class="fade-in" hidden>
                                    <span class="m-widget14__desc">
                                        <h3 class="m-widget14__desc" style="color:#575962;">
                                            &nbsp;&nbsp;<span id="spn_head"></span>  &nbsp;&nbsp;<a href="#" style="color:#05E177" onclick="DASHBOARD.track_change_type()" id="spn_head_type">Normal</a>
                                        </h3>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="spn_sub_head"></span>
                                    </span>
                                    <div class="m-widget14__header m--no-padding">
                                        <div class="list-group" style="height:167px;" id="div_track_normal_contents" hidden></div>    
                                        <div class="list-group" style="height:167px;" id="div_track_irregularity_contents" hidden></div>      
                                    </div>
                                    <div class='row'>
                                        <div class="col-md-7">

                                        </div>
                                        <div class="col-md-5">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8">
                            <div class="m-portlet m-portlet--full-height m-portlet--skin-light m-portlet--fit  m-portlet--rounded  m--no-padding">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text">
                                                Warehouse 
                                                <small>Status Report</small>
                                                
                                            </h3>
                                            
                                        </div>
                                    </div>
                                    <div class="m-portlet__head-tools">
                                        <ul class="m-portlet__nav">
                                            <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover">
                                                <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                                    Area Code
                                                </a>
                                                <div class="m-dropdown__wrapper">
                                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                    <div class="m-dropdown__inner">
                                                        <div class="m-dropdown__body">
                                                            <div class="m-dropdown__content">
                                                                <ul class="m-nav" id="li_week_status_area_codes">
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="m-portlet__body"  style="padding-bottom:0">
                                    <div class="row">
                                        <div class="col-xl-6">
                                                <div class="m-widget">
                                                    <div class="row">
                                                    <div class="col-md-6">
                                                        <label>&nbsp;Date From:</label>
                                                        <input type="text" class="form-control datepicker_day" type="text"
                                                        style="background-color:white;" id="txt_week_status_from" 
                                                        placeholder="Select date from" readonly>
                                                    </div>
        
                                                    <div class="col-md-6">
                                                        <label>&nbsp;Date To:</label>
                                                        <input type="text" class="form-control datepicker_day" type="text"
                                                        style="background-color:white;" id="txt_week_status_to" 
                                                        placeholder="Select date to" readonly>
                                                    </div>      
                                                    </div>
                                                        <div class="m-widget14" id="div_unprocessed_ticket"  style="width: 100%; padding:0; height: 250px;"> </div>
                                                </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="m-widget">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                            <div class="no-gutters" id="div_ticket_chart" style="height:350px;"></div>
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
            <div class="row">
                <div class="col-xl-12" id="div_chart_status">
                    <div class="m-portlet m-portlet--full-height m-portlet--skin-light m-portlet--fit  m-portlet--rounded">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                            <img src="{{ asset('icons/dashboard/checklist.png') }}" style="height:5%; width:4%;" class="rounded">&nbsp;Delivery Status (Count)
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="m-widget21__chart m-portlet-fit--sides"  id="chart_status" style="height:420px; width:100%;">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="table-responsive" id="table_status" style="overflow:hidden;">
                                        <table id="table_daily_status" class="table table-striped table-bordered table-hover" width="100%">
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
            <div class="row">
                <div class="col-xl-12" id="div_delivery_leadtime">
                    <div class="m-portlet m-portlet--full-height m-portlet--skin-light m-portlet--fit  m-portlet--rounded">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                            <img src="{{ asset('icons/dashboard/analytics.png') }}" style="height:5%; width:4%;" class="rounded">&nbsp;Warehouse Ticket Issuance
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="m-widget21__chart m-portlet-fit--sides"  id="chart_delivery_leadtime" style="height:420px; width:100%;">
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
<script type="text/javascript" src="../node_modules/amcharts/animated.js" ></script>
<script type="text/javascript" src="../node_modules/amcharts/kelly.js" ></script>
<script src="{{asset('scripts/Admin/dashboard.js')}}"></script>
@endsection