@extends('template')

@section('content-page')

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">User Management</h4>
            <small><label class="text-muted">List of users registered in the system.</label></small>
            <hr>
            <div class="card-header" id="div_area_code" hidden>
                <div class="row">
                    <div class="col-md-3">
                        <label >Area Code</label>
                        <select class="custom-select" id="slc_area_code_user"></select>
                    </div>
                    <div class="col-md-3">
                        <button style="margin-top:7.3%;" class="btn btn-success btn-xs btn-block" id="btn_submit_area_code"
                                onclick="USER_MANAGEMENT.btn_update_area_code()"><i class="ti-search"></i>SUBMIT</button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-secondary btn-xs btn-block" style="margin-top:7.3%; background-color: #999999" id="btn_cancel_area_code"
                                onclick="USER_MANAGEMENT.btn_hide_area_code()">CANCEL</button>
                    </div>
                </div>
            </div>
            <input type="hidden" id="txt_user_id" >
            <input type="hidden" id="txt_employee_id" value="{{Auth::user()['id']}}">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive" style="padding:10px;">
                        <table id="thead_user_management" class="table table-bordered table-hover">
                            <thead class="thead-dark" align="center">
                                <tr>
                                    <th rowspan="4" style="text-align:center;horizontal-align:middle;vertical-align:middle;">No.</th>
                                    <th rowspan="4" style="text-align:center;horizontal-align:middle;vertical-align:middle;">ID No.</th>
                                    <th rowspan="4" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Name</th>
                                    <th rowspan="4" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Area Code</th>
                                    <th rowspan="4" style="text-align:center;horizntal-align:middle;vertical-align:middle;">Approver</th>
                                    <th rowspan="4" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Management</th>
                                    <th rowspan="4" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Support</th>
                                    <th rowspan="4" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Receiver</th>
                                    <th rowspan="4" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Status</th>
                                    <th colspan="24" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Process</th>
                                <tr> {{-- Process --}}
                                    <th rowspan="3" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Dashboard</th>
                                    <th colspan="7" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Monitoring</th>
                                    <th rowspan="3" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Reprint Documents</th>
                                    <th colspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Parts with Irregularity</th>
                                    <th colspan="3" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Reports</th>
                                    <th colspan="6" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Transactions</th>
                                </tr>
                                <tr> 
                                    {{-- Monitoring --}}
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Master Data</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Lead Time Data</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Monitoring Report</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Parts Status</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Data</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Forecast</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Picker</th>
                                    {{-- Parts with Irregularity --}}
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Create</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Update</th>
                                    {{-- Reports --}}
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Lead Time Report</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Overall Graph Report</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Pallet Report</th>
                                    {{-- Transactions --}}
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Checking</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Palletizing</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Parts for DR</th>
                                    <th colspan="1" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery</th>
                                    <th rowspan="2" style="text-align:center;horizontal-align:middle;vertical-align:middle;">Remarks</th>
                                </tr>
                                <tr> {{-- Delivery --}}
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Update Delivery</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_user_management"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-script')
<script src="{{asset('scripts/Admin/Managements/user_management.js')}}"></script>
@endsection