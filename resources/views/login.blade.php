<!DOCTYPE html>

<html lang="en" >
	<head>
		<meta charset="utf-8" />
		<title>PDLS</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-control" content="no-cache">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../public/css/montserrat_label.css">
        <link rel="stylesheet" href="../node_modules/toastr/build/toastr.min.css">
        <link rel="stylesheet" href="../node_modules/fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="../node_modules/fontawesome/css/brands.css" rel="stylesheet">
        <link rel="stylesheet" href="../node_modules/fontawesome/css/solid.css" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('icons/logo.png') }}">
<style>
    .vertical-center
    {
        min-height: 100%;
        min-height: 100vh;
        display: :flex;
        align-items:center;
    }
    .loader{
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url("{{ asset('icons/pulse.gif') }}")
					50% 50% no-repeat rgba(255,255,255, 0.01);
		}
        .card-about {
        position: relative;
        top: 0;
        transition: top ease 0.5s;
        }
        .card-about:hover {
        top: -10px;
        }
        .position {
            margin: 0em;
        }
        .name {
            margin: 0em;
        }
        .title {
            margin: 0em;
        }

        .btn-login:hover{
            color: #27B5F5 !important;
            background-color: white !important;
        }

        .btn-guess:hover{
            color: #7F8389 !important;
            background-color: white !important;
        }

        .btn-guess i, .btn-login i {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.2s;
        }

        .btn-guess i:after, .btn-login i:after {
            content: '\00bb';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.2s;
        }

        .btn-guess:hover i, .btn-login:hover i {
            padding-right: 15px;
        }

        .btn-guess:hover i:after, .btn-login:hover i:after {
            opacity: 1;
            right: 0;
        }
        /* Small devices (landscape phones, 544px and up) */
        @media (min-width: 544px) {  

        }

        /* Medium devices (tablets, 768px and up) 
        The navbar toggle appears at this breakpoint */
        @media (min-width: 768px) {  

        }

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) { 

        }

        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {  
            
        }
    </style>
	</head>

    <body style="background-image: url(../node_modules/template/app/media/img/bg/log-bg.png); background-size:cover; overflow-y:hidden ">
    @include('about')
    <div class="loader" style="background-color: #ffffff;opacity: 0.5; filter: alpha(opacity=50);"></div>
        @include('Admin.area_code')
        <div id="preloader">
                <div class="loader"></div>
            </div>
        {{-- <body style="background-color:aliceblue"> --}}
<div class="jumbotron vertical-center" style="background-color:transparent;">
    <center>
        <button class="btn" id="btn_love" style="background-color:transparent">
            &nbsp;     &nbsp;
        </button>
    </center>
    <br>
    <div class="container shadow-lg p-3 mb-5 bg-white h-100" style="border-radius:40px; background-image: url(../node_modules/template/app/media/img/bg/login_bg_.png); background-size:cover;">
        <div class="card border-0" style="background:transparent">
                <div class="row ">
                    <div class="col-md-5 text-center">
                        {{-- <br>
                        <h2 style="color:#388BCD;">PDLS</h2>
                        <h5 style="font-size:15px; color:#388BCD">Parts Delivery Leadtime System</h5> --}}
                    <img src="../node_modules/template/app/media/img/bg/initial_logo_.png" style="height:90%; width:100%;" class="rounded">     
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <br><br><br><br>
                            <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                            <h3 class="text-white" style="font-size:25px; font-weight:bold;"><u>Sign-In</u></h3><br>             
                            <input type="text" id="txt_employee_no" class="form-control form-control-lg border-0 text-center" style="background-color:#104977; color:white" 
                            placeholder="Enter ID Number" onkeypress="">
                            <i><small class="text-white">Use your barcode scanner, touch screen or keyboard.</small><i>
                            <br/> <br/>
                            <button type="button" class="form-control btn btn-lg btn-login" style="background-color:#27B5F5; color:white;" onclick="MAIN.proceed_login();"><i class="fas fa-qrcode">&nbsp;<label style="font-family:custom-font-label;">Login</label></i></button>
                            <br/> <br/>
                            <button type="button" class="form-control btn btn-lg btn-guest" style="background-color:#7F8389; color:white;" onclick="MAIN.guest_login();"><i class="fas fa-question-circle">&nbsp;<label style="font-family:custom-font-label;">Guest</label></i></button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0" style="background-color:transparent">
                    <div class="row">
                        <div class="col-md-6">
                            <small style="cursor: pointer;" onclick="$('#mod_about').modal('show')">&copy;&nbsp;Copyright 2020&nbsp;Parts Delivery Leadtime System version 3.0.0</small>
                        </div>
                        <div class="col-md-6 text-right">
                        <a href="#" onclick="$('#mod_pic').modal('show')" style="color:white">Person-In-Charge</a>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
</div>

		<!-- jquery latest version -->
		<script src="../node_modules/jquery/dist/jquery.min.js"></script>
		<!-- bootstrap 4 js -->
		<script src="../node_modules/popper.js/dist/popper.min.js"></script>
		<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../node_modules/moment/moment.js"></script>
        <script src="../node_modules/toastr/build/toastr.min.js"></script>
    	<!-- other scripts -->
		<script src="../node_modules/axios/dist/axios.min.js"></script>
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../node_modules/gasparesganga-jquery-loading-overlay/dist/loadingoverlay.min.js"></script>
        <script src="../node_modules/fontawesome/js/fontawesome.min.js"></script>
		<script>

			const _TOKEN = $('#csrf-token').attr('content');
	
			const swal_options = {
				title: 'Are you sure?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes',
				cancelButtonText: 'No',
				allowOutsideClick: false
			};
	
			const instance = axios.create({
				baseURL: 'http://10.164.30.173/pdls-v2/server/public/api/',
				headers: {
					'APP-KEY': 'ABCDEFGHIJK'
				}
			});
            $('.loader').hide();
		</script>
        <script src="{{asset('scripts/login.js')}}"></script>
	</body>
</html>
