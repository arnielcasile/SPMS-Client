@extends('template')

@section('content-page')
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Overall Graph Report</h4><br>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Range:</label>
                            <select class="custom-select" id="slc_overall_report_range" onchange="OVERALL_GRAPH_REPORT.onchange_datepicker();">
                                <option value="" selected hidden> SELECT RANGE</option>
                                <option value="DAILY"> DAILY</option>
                                <option value="WEEKLY"> WEEKLY</option>
                                <option value="WEEKLY HORENSO"> WEEKLY HORENSO</option>
                                <option value="MONTHLY"> MONTHLY</option>
                                <option value="YEARLY"> YEARLY</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date From:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_overall_report_month_date_from" placeholder="Select date from" readonly hidden>
                            <input style="background-color:white;" class="form-control datepicker_year" type="text"
                                id="txt_overall_report_year_date_from" placeholder="Select date from" readonly hidden>
                            <input style="background-color:white;" type="text"
                                class="form-control datepicker_day"
                                id="txt_overall_report_date_from" placeholder="Select date from" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Date To:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_overall_report_month_date_to" placeholder="Select date to" readonly hidden>
                            <input style="background-color:white;" class="form-control datepicker_year" type="text"
                                id="txt_overall_report_year_date_to" placeholder="Select date to" readonly hidden>
                            <input style="background-color:white;" type="text"
                                class="form-control datepicker_day" id="txt_overall_report_date_to"
                                placeholder="Select date to" readonly>
                        </div>
                        <div class="col-md-3">
                            <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                            onclick="OVERALL_GRAPH_REPORT.load_overall_graph_report()"><i class="flaticon-search"></i> SEARCH</button>
                        </div>
                    </div><br>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <br><h3 style="text-align: center">Delivery LeadTime Trend</h3>
                        </div><hr>
                        <div id="chart_overall_graph" class="col-md-12" style="width: 50%; height: 400px;"></div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="table_overall_report_data" class="table table-bordered table-hover" width="100%">
                                    <thead id="thead_overall_report_data" class="thead-dark" align="center"></thead>
                                    <tbody id="tbody_overall_report_data" align="center"></tbody>
                                </table>
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
<script src="{{asset('scripts/Admin/Reports/overall_graph_report.js')}}"></script>
@endsection