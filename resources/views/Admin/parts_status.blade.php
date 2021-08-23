@extends('template')

@section('content-page')
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="m-subheader ">
                <h4 class="header-title">Parts Status</h4><br>
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Range:</label>
                            <select class="custom-select" id="slc_parts_status_range"
                                onchange="PARTS_STATUS.onchange_datepicker();">
                                <option value="" selected hidden> SELECT RANGE</option>
                                <option value="DAILY"> DAILY</option>
                                <option value="MONTHLY"> MONTHLY</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date From:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_parts_status_month_date_from" placeholder="Select date from" readonly hidden>
                            <input style="background-color:white;" type="text" class="form-control datepicker_day"
                                id="txt_parts_status_date_from" placeholder="Select date from" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Date To:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_parts_status_month_date_to" placeholder="Select date to" readonly hidden>
                            <input style="background-color:white;" type="text" class="form-control datepicker_day"
                                id="txt_parts_status_date_to" placeholder="Select date to" readonly>
                        </div>
                        <div class="col-md-3">
                            <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                                onclick="PARTS_STATUS.load_parts_status_list()"><i class="flaticon-search"></i>
                                SEARCH</button>
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="thead_parts_status" class="table table-bordered table-hover">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                            WH_CLASS</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Item
                                            No.</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                            Delivery Quantity</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Stock
                                            Address</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                            Manufacturing No.</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                            Destination Code</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                            Payee Name</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                            Delivery Due Date</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Ticket
                                            No.</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Order
                                            Download No.</th>
                                        <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Ticket
                                            Issue</th>
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
                                    </tr>
                                </thead>
                                <tbody id="tbody_parts_status" align="center"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script src="{{ asset('scripts/Admin/parts_status.js') }}"></script>
@endsection
