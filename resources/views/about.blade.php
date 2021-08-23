
<div class="modal fade" id="mod_about"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_about_abel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('icons/about.png') }}" style="height:5%; width:5%;" class="rounded">
                <h5 class="modal-title" id="mod_area_code_label">&nbsp;About <span class="position">TEAM BROWN</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-about" style="width: 100%;">
                                <img class="card-img-top" height="215px" src="{{ asset('about/rose.png') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title position" style="color:#388BCD">Project Manager</h5>
                                    <p class="card-text name">Mary Rose Magango</p>
                                    <p class="card-text title"><small class="text-muted">IT Specialist 1</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-about" style="width: 100%;">
                                <img class="card-img-top" height="215px" src="{{ asset('about/brown.png') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title position" style="color:#388BCD">Project Manager</h5>
                                    <p class="card-text name">Jerwyn "POGI" Rabor</p>
                                    <p class="card-text title"><small class="text-muted">IT Staff (Resigned)</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-about" style="width: 100%;">
                                <img class="card-img-top" height="215px" src="{{ asset('about/erika.png') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title position" style="color:#388BCD">Backend</h5>
                                    <p class="card-text name">Erika Reformado</p>
                                    <p class="card-text title"><small class="text-muted">IT Specialist 2</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-about" style="width: 100%;">
                                <img class="card-img-top" height="215px" src="{{ asset('about/cess.jpg') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title position" style="color:#388BCD">Backend</h5>
                                    <p class="card-text name">Princess Mae Bermillo</p>
                                    <p class="card-text title"><small class="text-muted">IT Staff</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-about" style="width: 100%;">
                                <img class="card-img-top" height="215px" src="{{ asset('about/yan.jpg') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title position" style="color:#388BCD">Frontend</h5>
                                    <p class="card-text name">Noreen Arriane Siron</p>
                                    <p class="card-text title"><small class="text-muted">IT Staff (Resigned)</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-about" style="width: 100%;">
                                <img class="card-img-top" height="215px" src="{{ asset('about/mark.png') }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title position" style="color:#388BCD">Frontend</h5>
                                    <p class="card-text name">Mark Sarmiento</p>
                                    <p class="card-text title"><small class="text-muted">IT Staff</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="mod_love"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_about_abel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
       <div class="modal-content" style="border-radius: 15px; border-style: none;">  
        <div class="modal-header">
            <img src="{{ asset('icons/heart_icon.png') }}" style="height:8%; width:8%;" class="rounded">
            <label class="modal-title" id="mod_area_code_label">&nbsp;Nagmahal, Nasaktan, Nagprogram</label>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>	

            <div class="modal-body p-0"> 
                <div class="row"> 
                    <div class="col-md-5"> 
                        <img class="w-100 h-100" src="{{asset('icons/heart_bg.png')}}" style="border-bottom-left-radius: 15px;"> 
                    </div>
                    <div class="col-md-7 mb-2 mt-5 float-left"> 
                        <h5>Dear Mer,</h5>
                        <p>&nbsp;&nbsp;&nbsp;Sana masaya kana. Sana di ka nya saktan.</3</p>
                        <br><br>
                        <small class="float-right">-A true friend of yours.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mod_pic"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_about_abel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width:65%" role="document">
       <div class="modal-content" style="border-radius: 15px; border-style: none;">  
        {{-- <div class="modal-header">
            <img src="{{ asset('icons/heart_icon.png') }}" style="height:8%; width:8%;" class="rounded">
            <label class="modal-title" id="mod_pic_label">&nbsp;Person-In-Charge</label>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>	 --}}

            <div class="modal-body p-0"> 
                <div class="row"> 
                    <div class="col-md-5"> 
                        <img class="w-100 h-100" src="{{asset('icons/pic.jpg')}}" style="border-bottom-left-radius: 15px; border-top-left-radius: 15px;"> 
                    </div>
                    <div class="col-md-7 mb-2 mt-5 float-left"> 
                        <h3 class="text-primary">Person in charge</h3>
                        <i style="color:gray"><p>WHE Contact Details.</p></i>
                        <hr><br>
                        <center>
                            <table border="2px" width="90%" style="border-collapse:collapse; font-size:17px;">
                                <tr>
                                    <th>No.</th>
                                    <th>In-Charge</th>
                                    <th>Area</th>
                                    <th>Local</th>
                                    <th>Section</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Ms. Jeanelyn Tadifa</td>
                                    <td>Common 1</td>
                                    <td style="text-align:center">1592</td>
                                    <td style="text-align:center">BAD-WHE</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Ms. Shyrel De Jesus</td>
                                    <td>Common 2</td>
                                    <td style="text-align:center">1591</td>
                                    <td style="text-align:center">BAD-WHE</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Ms. Marielle Castrillo</td>
                                    <td>Subparts</td>
                                    <td style="text-align:center">1594</td>
                                    <td style="text-align:center">BAD-WHE</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Ms. Lenny Casubuan/<br> Ms. Michelle Loterte</td>
                                    <td>Kanban</td>
                                    <td style="text-align:center">1507</td>
                                    <td style="text-align:center">BAD-WHE</td>
                                </tr>
                            </table>
                            <br><br>
                        
                        </center>
                        <p style="margin-left:10px; margin-right:10px;">&nbsp;   &nbsp;   &nbsp;   This is the list of person-in-charge for Parts Delivery Leadtime System. Please do keep in touch with them if there will be any problems encountered in the system. Thank you.</p>
                        <br>
                        <center>
                            <button class="btn btn-lg" style="border-radius:7px;
                            background: rgb(254,192,17);
                            background: linear-gradient(90deg, rgba(254,192,17,1) 0%, rgba(236,117,104,1) 66%);
                            color:white; border-style: none;
                            "  data-dismiss="modal">
                                <b>&nbsp; &nbsp; Back to PDLS &nbsp; &nbsp; <i class="fa fa-play"></i> &nbsp;</b>
                            </button>
                        </center>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('scripts/about.js')}}" defer></script>
  