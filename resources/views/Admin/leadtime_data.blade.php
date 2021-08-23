@extends('template')

@section('content-page')

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Leadtime Data</h4><br>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Range:</label>
                            <select class="custom-select" id="slc_leadtime_range" onchange="LEADTIME_DATA.onchange_datepicker();">
                                <option value="" selected hidden> SELECT RANGE</option>
                                <option value="DAILY"> DAILY</option>
                                <option value="MONTHLY"> MONTHLY</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date From:</label>
                            <input style="background-color:white;" onchange="LEADTIME_DATA.change_date_to();" class="form-control datepicker_month" type="text"
                                id="txt_leadtime_month_date_from" placeholder="Select date from" readonly hidden>
                            <input style="background-color:white;" onchange="LEADTIME_DATA.change_date_to();" type="text"
                                class="form-control datepicker_day"
                                id="txt_leadtime_date_from" placeholder="Select date from" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Date To:</label>
                            <input style="background-color:white;" onchange="LEADTIME_DATA.change_date_to();"  class="form-control datepicker_month" type="text"
                                id="txt_leadtime_month_date_to" placeholder="Select date to" readonly hidden>
                            <input style="background-color:white;" onchange="LEADTIME_DATA.change_date_to();" type="text"
                                class="form-control datepicker_day" id="txt_leadtime_date_to"
                                placeholder="Select date to" readonly>
                        </div>
                        <div class="col-md-3">
                            <div class="row">  
                                <div class="col-md-6">
                                    <button style="margin-top:13%;" class="btn btn-primary btn-xs btn-block"
                                    onclick="LEADTIME_DATA.search_btn()"><i class="flaticon-search"></i> SEARCH</button>
                                </div>
                                <div class="col-md-6">
                                    <button style="margin-top:13%;" class="btn btn-primary btn-xs btn-block"
                                    onclick="TIMEOUT.show_modal()"><i class="flaticon-clock"></i> TIME LOGS</button>
                                </div>
                            </div>
                        </div>
                    </div><br>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="thead_leadtime_data" class="table table-bordered table-hover">
                            <thead class="thead-dark" align="center">
                                <tr>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">WH_CLASS</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Item No.</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Quantity</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Stock Address</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Manufacturing No.</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Destination Code</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Payee_name</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Due Date</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Ticket No.</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Order Download No.</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Ticket Issue</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Checking</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Palletizing</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">DR Making</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Status
                                        (Normal)</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">DR
                                        Control (Normal)</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                        Delivery (Normal)</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Status
                                        (Irreg)</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">DR
                                        Control (Irreg)</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                        Delivery (Irreg)</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Receive</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Leadtime</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_leadtime_data" align="center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Admin.timeout') 

@endsection

{{-- @section('custom-script')

@endsection --}}