@extends('template')

@section('content-page')
@include('Admin.master_data-upload')
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Master Data</h4><br>
            <button type="button" class="btn btn-primary btn-sm mb-2"
                                    onclick="MASTER.btn_add_master();"><i class="flaticon-file"></i>
                                    &nbsp; ADD TICKET ISSUE TIME</button>
            <button type="button" class="btn btn-primary btn-sm mb-2"
                                    onclick="MASTER.btn_add_sync();"><i class="flaticon-file"></i>
                                    &nbsp; SYNC</button>
                                    <i><small>&nbsp;Only 1 day is allowed to sync/ upload.</small></i>
            <div class="card shadow mb-4" id="div_add_master" hidden>
                <div class="card-body">
                    {{-- <div class="container"> --}}
                        <div class="row">
                            <div class="col-md-4">
                                <label>Upload File:</label>
                                <input type="file" 
                                    class="form-control" 
                                    style="padding-bottom: 0px; padding-top: 5px; background-color:white; margin-top:0%;"
                                    id="txt_upload_master" 
                                    name="select_file"
                                    readonly
                                    accept=".csv" 
                                    >
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success btn-xs btn-block" style="margin-top:10.5%;" id="btn_upload_master" 
                                    onclick="MASTER.upload_master()"><i id="upload_logo"></i>&nbsp; UPLOAD FILE
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-secondary btn-xs btn-block" style="margin-top:10.5%; background-color: #999999" id="btn_cancel_master"
                                    onclick="MASTER.btn_cancel_master()">CANCEL</button>
                            </div>
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
            <div class="card shadow mb-4" id="div_add_sync" hidden>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Date to sync:</label>
                            <input style="background-color:white;" type="text"
                                class="form-control datepicker_day"
                                id="txt_sync_date_from" placeholder="Select date from" onchange="MASTER.date_change_from_sync()" readonly>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" style="margin-top:10.5%;" class="btn btn-success btn-xs btn-block" id="btn_submit_sync"
                                onclick="MASTER.sync_data()"><i id="sync_logo"></i>&nbsp; SYNC
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-secondary btn-xs btn-block" style="margin-top:10.5%; background-color: #999999" id="btn_cancel_sync"
                                onclick="MASTER.btn_cancel_sync()">CANCEL</button>
                        </div>
                        <div class="col-md-2" style="visibility:hidden">
                            <label>Date To:</label>
                            <input style="background-color:white;" type="text"
                                class="form-control datepicker_day" id="txt_sync_date_to"
                                placeholder="Select date to" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <div class="row">
                  
                    <div class="col-md-3">
                        <label>Date:</label>
                        <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_master_month_date_from" placeholder="Select date from" readonly hidden>
                        <input style="background-color:white;" type="text"
                            class="form-control datepicker_day"
                            id="txt_master_date_from" onchange="MASTER.date_change_from_masterlist()" placeholder="Select date from" readonly>
                    </div>
                    <div class="col-md-3" style="visibility:hidden">
                        <label>Date To:</label>
                        <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_master_month_date_to" placeholder="Select date from" readonly hidden>
                        <input style="background-color:white;" type="text"
                            class="form-control datepicker_day" id="txt_master_date_to"
                            placeholder="Select date to" readonly>
                    </div>
                    <div class="col-md-3" style="visibility:hidden">
                        <label>Range:</label>
                        <select class="custom-select" id="slc_master_range" onchange="MASTER.onchange_datepicker();" disabled>
                            <option value="" selected hidden> SELECT RANGE</option>
                            <option value="DAILY"> DAILY</option>
                            <option value="MONTHLY"> MONTHLY</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                            onclick="MASTER.load_master_list()"><i class="flaticon-search"></i> SEARCH</button>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="thead_master" class="table table-bordered table-hover">
                            <thead class="thead-dark" align="center">
                                <tr>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">WH_CLASS</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Form</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Item No.</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Item Rev</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Quantity</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Stock Address</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Manufacturing No.</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Inst Date</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Destination Code</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Item Name</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Product No.</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">TicketNo</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">TicketIssueDate</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">TicketIssueTime</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Storage Location</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Due Date</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Order Download No.</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_master" align="center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-script')
<script src="{{asset('scripts/Admin/master_data.js')}}"></script>
@endsection