
<html lang="en" >
        <head>
            <meta charset="utf-8" />
            <title>PDLS</title>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">
            <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../node_modules/toastr/build/toastr.min.css">
    <style>
        .in-middle{
            justify-content: center;
            align-items: center;
            display: flex;
            height: 100vh;
            }
        .loader{
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('icons/pulse.gif') }}")
                        50% 50% no-repeat rgba(255,255,255, 0.01);;
            }

        .right{
            background-color: :red;
           
        }
        </style>
        </head>
        <body>
       {{-- <div class="containeralign-middle" style="background-color:red">
            <div class="row align-items-center">
                <div class="col-md-6">
                    123
                </div>
                <div class="col-md-6">
                    123
                </div>
            </div>
       </div> --}}
       <div class="jumbotron vertical-center"
       style="
       background-image: url(../node_modules/template/app/media/img/bg/log-bg.png);
       overflow-y:hidden;
       background-size:     cover; 
       background-repeat:   no-repeat;
       background-position: center center; 
       min-height: 100%; 
       min-height: 100vh;
     
       display: flex;
       align-items: center;
      ">
      <div class="container"  style="border-radius:20px; background-color:white">
            <div class="card-header" style="background-color:transparent;">
                PDLS
            </div>
            <div class="card-body" style="height:500px;">
               <div class="row">
                   <div class="col-md-7">
                 123123
                   </div>
                   <div class="col-md-5">
                   <svg viewBox="-50 -50 100 100"><path fill="red" fill-opacity="1" d="M 3.62 -16.45 C 24.68 -6.05, 27.04 10.92, 12.06 23.08"></path></svg>  
                </div>
               </div>
            </div>
            <div class="card-footer" style="background-color:transparent">
              Copyright 2020
            </div>
      </div>

        </div>
        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
		<!-- bootstrap 4 js -->
		<script src="../node_modules/popper.js/dist/popper.min.js"></script>
		<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../node_modules/moment/moment.js"></script>
        <script src="../node_modules/toastr/build/toastr.min.js"></script>
    	<!-- other scripts -->
		<script src="../node_modules/axios/dist/axios.min.js"></script>
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../node_modules/gasparesganga-jquery-loading-overlay/dist/loadingoverlay.min.js"></script>
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
