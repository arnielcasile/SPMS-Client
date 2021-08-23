@extends('template')

@section('content-page')

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Pallet Report</h4><br>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Range:</label>
                            <select class="custom-select" id="slc_pallet_report_range" onchange="PALLET_REPORT.onchange_datepicker();">
                                <option value="" selected hidden> SELECT RANGE</option>
                                <option value="DAILY"> DAILY</option>
                                <option value="MONTHLY"> MONTHLY</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date From:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_pallet_report_month_date_from" placeholder="Select date from" readonly hidden>
                            <input style="background-color:white;" type="text"
                                class="form-control datepicker_day"
                                id="txt_pallet_report_date_from" placeholder="Select date from" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Date To:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_pallet_report_month_date_to" placeholder="Select date to" readonly hidden>
                            <input style="background-color:white;" type="text"
                                class="form-control datepicker_day" id="txt_pallet_report_date_to"
                                placeholder="Select date to" readonly>
                        </div>
                        <div class="col-md-3">
                            <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                            onclick="PALLET_REPORT.load_pallet_report()"><i class="flaticon-search"></i> SEARCH</button>
                        </div>
                    </div><br>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_pallet_report_data" class="table table-bordered table-hover" width="100%">
                            <thead id="thead_pallet_report_data" class="thead-dark" align="center"></thead>
                            <tbody id="tbody_pallet_report_data" align="center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-script')
<script src="{{asset('scripts/Admin/Reports/pallet_report.js')}}"></script>
@endsection