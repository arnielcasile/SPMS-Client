{{-- @extends('template')

@section('content-page') --}}

{{-- <div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Checking</h4>
            <small><label class="text-muted">Please double check your data before updating/ saving.</label></small>
            <hr>
            <br> --}}
            
<div class="modal fade" id="mod_checking_main" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_checking_main" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 75%;">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('icons/checking.png') }}" style="height:2%; width:2%;" class="rounded">
                <h5 class="modal-title" id="mod_destination_label">&nbsp;Checking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="card  shadow mb-4">
                        <div class="card-header " style="padding: 0px; 0px; 0px; 0px; ">
                            <button class="accordion bg-light text-dark"  data-toggle="collapse">
                                <img src="{{ asset('icons/blue_check.png') }}" style="height:2%; width:2%;" class="rounded">
                                &nbsp;&nbsp;<b><label>Normal Checking</label></b>&nbsp;<i><small class="text-muted"></small></i>
                            </button> 
                        </div>
                        <div class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label >Checker Name:</label>
                                                            <input type="text"
                                                                readonly
                                                                value="{{Auth::user()['first_name']." ".Auth::user()['last_name']}}" 
                                                                class="form-control form-control-lg" 
                                                                id="txt_checking_checker_name"
                                                                style="text-align:center"
                                                                >
                                                        </div>
                                                        <div class="col-md-6">
                                                                <label >Barcode</label>
                                                                <input type="text" class="form-control form-control-lg" autocomplete="off" oninput="this.value = this.value.toUpperCase()" id="txt_checking_barcode">
                                                        </div>
                                                        <input type="hidden" id="txt_checking_user_id" />
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="row">
                                                        <div class="col-md-12 text-left">
                                                        <h5>Barcoded Data</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="panel-body border border-dark" style="padding:10px;">
                                                                    <table id="tbl_checking_normal_checking" class="table table-bordered table-hover">
                                                                        <thead class="thead-dark">
                                                                            <tr> 	
                                                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Barcode</th>														
                                                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Part Number</th>
                                                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Quantity</th>
                                                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Order Download Number</th>
                                                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Process</th>
                                                                            </tr>                      
                                                                        </thead>
                                                                    <tbody id="tbl_checking_order_download_body" style="text-align: center">
                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="card-footer ">       
                                <div class="container-fluid mb-2">
                                    <div class="row">   
                                        <div class="col-md-8">
                                        </div>
                                        <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-primary" id="btn_checking_checking_update" onclick="CHECKING.data_for_update();"><i class="fa fa-save"></i>&nbsp; Update</button>
                                        </div>
                                        <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-danger" onclick="CHECKING.clear_all();"><i class="fa fa-trash" ></i>&nbsp; Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>       
                    </div>
                </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>     
            {{-- </div>
        </div>
    </div>
</div> --}}

{{-- Start of Modal --}}
<div class="modal fade" id="mod_checking" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_checking_label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('icons/barcode.png') }}" style="height:10%; width:10%;" class="rounded">&nbsp;&nbsp;
                <center><h5 class="modal-title" id="mod_checking_label">&nbsp;This Barcode has irregularity. What will you transact?</h5></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn_checking_close_modal_completion" onclick="CHECKING.cancel_transaction_modal();"> 
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-info" style="height: 50px;" id="btn_checking_normal" onclick="CHECKING.onclick_normal();">
                                <img src="{{ asset('icons/normal.png') }}" style="height:70%; width:15%;" class="rounded">&nbsp;&nbsp;<b>NORMAL</b></button>
                            </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success" style="height: 50px;" id="btn_checking_completion" onclick="CHECKING.onclick_completion();">
                                <img src="{{ asset('icons/irreg.png') }}" style="height:70%; width:15%;" class="rounded">&nbsp;&nbsp;<b>COMPLETION</b></button>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
  </div>
{{-- End of Modal --}}
{{-- @endsection

@section('custom-script')
<script src="{{asset('scripts/Transactions/checking.js')}}"></script>
@endsection --}}