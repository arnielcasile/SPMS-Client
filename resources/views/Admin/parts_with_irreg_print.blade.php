@extends('template')

@section('content-page')

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Parts With Irregularity (Print DR)</h4><br>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <label>Approved By:</label>
                        <select class="custom-select" id="slc_approved_by"></select>
                    </div>
                    <div class="col-md-3">
                        <label>Attention To:</label>
                        <input style="background-color:white;" class="form-control" id="txt_print_attention_to" type="text"
                            placeholder="Input attention to" onkeyup="this.value = this.value.toUpperCase();">
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="thead_print_dr" class="table table-bordered table-hover">
                            <thead class="thead-dark" align="center">
                                <tr>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                        <input type="checkbox" id="txt_check_all_dr" class="form-control" 
                                            onclick="PRINT_IRREGULARITY.check_all_dr();">
                                    </th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Control No.</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_print_dr" align="center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <h5 class="header-title">Breakdown</h5>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Pallet No.</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_pallet_no">
                        </div>
                        <div class="col-md-2">
                            <label>P-Case No.</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_pcase_no">
                        </div>
                        <div class="col-md-2">
                            <label>Box</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_box">
                        </div>
                        <div class="col-md-2">
                            <label>Bag</label>
                            <input type="text" class="form-control" 
                                style="background-color:white;" id="txt_bag">
                        </div>
                        <div class="col-md-2">
                            <button style="margin-top:10.5%;" class="btn btn-success btn-xs btn-block" id="btn_print_dr"
                                onclick=""><i class="ti-print"></i>PRINT</button>
                        </div>
                        <div class="col-md-2">
                            <button style="margin-top:10.5%; background-color: #999999" class="btn btn-secondary btn-xs btn-block" id="btn_print_dr"
                                onclick=""><i class="ti-print"></i>CLEAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-script')
<script src="{{asset('scripts/Admin/parts_with_irreg_print.js')}}"></script>
@endsection