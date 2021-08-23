@extends('template')

@section('content-page')
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Forecast</h4><br>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <label>Range:</label>
                        <select class="custom-select" id="slc_forecast_range" onchange="forecast.onchange_datepicker();">
                            <option value="" selected hidden> SELECT RANGE</option>
                            <option value="DAILY"> DAILY</option>
                            <option value="MONTHLY"> MONTHLY</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Date From:</label>
                        <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_forecast_month_date_from" placeholder="Select date from" readonly hidden>
                        <input style="background-color:white;" type="text" class="form-control datepicker_day"
                            id="txt_forecast_date_from" placeholder="Select date from" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Date To:</label>
                        <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_forecast_month_date_to" placeholder="Select date to" readonly hidden>
                        <input style="background-color:white;" type="text" class="form-control datepicker_day" id="txt_forecast_date_to"
                            placeholder="Select date to" readonly>
                    </div>
                    <div class="col-md-3">
                        <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                            onclick="forecast.load_forecast_list()"><i class="flaticon-search"></i> SEARCH</button>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="thead_forecast" class="table table-bordered table-hover " style="width: 100%;">
                            <thead class="thead-dark" align="center">
                                <tr>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Date</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Forecast</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_forecast" align="center">
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 pull-right">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-block btn-primary" onclick="forecast.save_forecast()" id="btn_save_forecast"><i class="fa fa-save"></i>&nbsp; Save Forecast</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-block btn-danger"  onclick="forecast.cancel_forecast();"   id="btn_cancel_forecast"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
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
<script src="{{asset('scripts/Admin/forecast.js')}}"></script>
@endsection