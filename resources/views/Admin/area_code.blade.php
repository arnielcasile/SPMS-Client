
<div class="modal fade" id="mod_area_code"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_area_code_label" aria-hidden="true">
        <div class="modal-dialog moda  modal-dialog-centered" role="document">
              <div class="modal-content">
                      <div class="modal-header">
                          <img src="{{ asset('icons/location_green.png') }}" style="height:5%; width:5%;" class="rounded">
                          <h5 class="modal-title" id="mod_area_code_label">&nbsp;Area Code</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="container-fluid">
                              <input type="hidden" id="txt_user_id" />
                                <div class="row">
                                    <div class="col-md-12">
                                       
                                   
                                        <label >Select Area Code</label><br>
                                        <i><small>Please contact system administrator if your area code is missing.</small></i>
                                        <br>
                                        <br>
                                        <select id="slc_area-code" class="custom-select"  required>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please select a valid name.
                                        </div>
                                    </div>
                                </div>
                                <div id="div_save_prompt" style="display:none">
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <small>Are you sure to save this value?</small>
                                    </div>
                                </div>
                                </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                           
                          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancel Login</button> --}}
                          <button type="button" id="btn_save_area_code" onclick="AREA_CODE.save();" class="btn btn-primary">
                           Save Area Code
                          </button>
                      </div>
                      </div>
        </div>
      </div>
      <script src="{{asset('scripts/Admin/area_code.js')}}" defer></script>