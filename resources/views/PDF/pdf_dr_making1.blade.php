<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Receipt</title>
    <style>
        @page {
            margin: 22;
        }
        @font-face {
        font-family: 'sbarc39A';
            src: url({{storage_path('fonts/sbarc39A.ttf')}})  format('truetype');
        }
        @font-face {
        font-family: ' sbarc39v';
            src: url({{storage_path('fonts/sbarc39v.ttf')}})  format('truetype');
        }
        header {
            position: fixed;
        }
        .header-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 17;
            font-weight: bold;
        }
        .header2-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8;
            font-weight: bold;
        }
        .header-barcode-style {
            font-family: 'sbarc39A';
            font-size: 20;
            font-weight: normal;
        }
        .subheader-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12;
            font-weight: bold;
        }
        .line-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13;
        }
        .thead-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 6; 
            text-align:center;
            horizontal-align:middle;
            vertical-align:middle;
            background-color: #e6e6e6;
            border: 1px solid black;
        }
        .tbody-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 6; 
            text-align:center;
            horizontal-align:middle;
            vertical-align:middle;
            border: 1px solid black;
        }
        table {
            border-collapse: collapse;
        }
        footer {
            position: fixed;
        }
        .footer-style {
            font-family: Arial, Helvetica, sans-serif;
            font-style: italic;
            font-size: 8;
        }
        .page-break {
            page-break-after: always;
        }
        .total-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7;
            text-align: center;
            horizontal-align: middle;
            vertical-align: middle;
            background-color: #e6e6e6;
            border: 1px solid black;
        }
        .total-style-sakura {
            font-family: 'sbarc39A';
            font-weight: bold;
            font-size: 7;
            text-align: center;
            horizontal-align: middle;
            vertical-align: middle;
            background-color: #e6e6e6;
            border: 1px solid black;
        }
        .checker-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7;
            text-align: center;
            horizontal-align: middle;
            vertical-align: middle;
            border: 1px solid black;
        }
        .signatories-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7.5;
            text-align: center;
            horizontal-align: middle;
            vertical-align: middle;
        }
        .prepared-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7.5;
            text-align: left;
            horizontal-align: middle;
            vertical-align: middle;
        }
        .approved-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7.5;
            text-align: right;
            horizontal-align: middle;
            vertical-align: middle;
            padding-right: 5px;
        }
        .received-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7.5;
            text-align: right;
            horizontal-align: middle;
            vertical-align: middle;
            padding-right: 5px;
        }
        .tbg {
            background-color: #e6e6e6;
        }
        .total-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7; 
            text-align:center;
            horizontal-align: middle;
            vertical-align:middle;
            background-color: #e6e6e6;
            border: 1px solid black;
        }
      
       

    </style>

</head>

<body>
    <div style="position:absolute;top:1.52in;left:0.16in;width:8in;line-height:0.10in;">
        {{-- START --}}
        @php 
            $pagebreak_count = 1; 
            $count_loop = 0; 
            $outside_loop = 0; 
            $inside_loop = 0; 
            $inner_inside_loop = 0; 
            $delivery_type_loop = 0; 
            $header_loop_main = 0; 
            $header_loop_sub = 0; 
        @endphp

        @foreach($raw_data as $data)
            @if($pagebreak_count > 1) 
                <div class="page-break"></div> 
            @endif

        @php 
            $total = 0;
            $grand_total = 0;
            $outside_loop++;
          
        @endphp

        @foreach($data as $row)
            @php 
            $first_data = true; 
            $inside_loop++;
            @endphp
            @if ($first_data == true)
                <table style="width:92%;">
                    <thead>
                        <tr>
                            <th class="thead-style" width="3%">NO.</th>
                            <th class="thead-style" width="4%">TYPE</th>
                            <th class="thead-style" width="5%">PML_NO</th>
                            <th class="thead-style" width="3%">REV</th>
                            <th class="thead-style" width="9%">PART NO.</th>
                            <th class="thead-style" width="9%">PART NAME</th>
                            <th class="thead-style" width="3%">QTY</th>
                            <th class="thead-style" width="6%">STOCK ADDRESS</th>
                            <th class="thead-style" width="7%">MANUF. NO.</th>
                            <th class="thead-style" width="6%">PAYEE CODE</th>
                            <th class="thead-style" width="6%">TICKET NO.</th>
                            <th class="thead-style" width="7%">PRODUCT NO.</th>
                        </tr>
                    </thead>
                </table>
            @endif
           
            @php 
                $sub_count = 0; 
                $sub_total = 0;
                $unit_count = 1; 
            @endphp
            {{-- <header>
                <div style="position:absolute;top:0.05in;left:2.73in;width:8in;line-height:0.10in;">
                    <span class="header-style" style="font-family:barcode">WAREHOUSE AREA</span>
                </div>
                <div style="position:absolute;top:0.18in;left:3.30in;width:8in;line-height:0.15in;">
                    <span class="header2-style">DELIVERY RECEIPT</span>
                </div>
                <div style="position:absolute;top:0.30in;left:5.70in;width:8in;line-height:0.10in;">
                    <span class="header-barcode-style">*{{$row[$count_loop]['dr_control']}}*</span>
                </div>
                <div style="position:absolute;top:0.80in;left:0.16in;width:8in;line-height:0.10in;">
                    <span class="subheader-style">DESTINATION :</span>
                </div>
                <div style="position:absolute;top:0.80in;left:1.50in;width:8in;line-height:0.10in;">
                    <span class="subheader-data-style">{{$row[$count_loop]['destination']}}</span>
                </div>
                <div style="position:absolute;top:0.80in;left:1.44in;width:8in;line-height:0.10in;">
                    <span class="line-style">_______________</span>
                </div>
                <div style="position:absolute;top:0.80in;left:4.80in;width:8in;line-height:0.10in;">
                    <span class="subheader-style">CONTROL :</span>
                </div>
                <div style="position:absolute;top:0.80in;left:5.85in;width:8in;line-height:0.10in;">
                    <span class="subheader-data-style">{{$row[$count_loop]['dr_control']}}</span>
                </div>
                <div style="position:absolute;top:0.80in;left:5.77in;width:8in;line-height:0.10in;">
                    <span class="line-style">_________________</span>
                </div>
                <div style="position:absolute;top:1.13in;left:0.16in;width:8in;line-height:0.10in;">
                    <span class="subheader-style">ATTENTION TO :</span>
                </div>
                <div style="position:absolute;top:1.13in;left:1.58in;width:8in;line-height:0.10in;">
                    <span class="subheader-data-style">{{$row[$count_loop]['attention_to']}}</span>
                </div>
                <div style="position:absolute;top:1.13in;left:1.54in;width:8in;line-height:0.10in;">
                    <span class="line-style">______________</span>
                </div>
                <div style="position:absolute;top:1.13in;left:4.80in;width:8in;line-height:0.10in;">
                    <span class="subheader-style">DATE :</span>
                </div>
                <div style="position:absolute;top:1.13in;left:5.45in;width:8in;line-height:0.10in;">
                    <span class="subheader-data-style">{{date('m-d-Y', strtotime($row[$count_loop]['created_at']))}}</span>
                </div>
                <div style="position:absolute;top:1.13in;left:5.39in;width:8in;line-height:0.10in;">
                    <span class="line-style">_____________________</span>
                </div>
            </header> --}}
                @foreach($row as $datas)     
                
                    @php 
                        $sub_count++; 
                        $sub_total = intval($sub_total) + intval($datas['delivery_qty']); 
                        $pallet = $datas['pallet'];
                        $pcase = $datas['pcase'];
                        $box = $datas['box'];
                        $bag = $datas['bag'];
                        $checker_name = $datas['checker_name'];
                        $checker_name = $datas['checker_name'];
                        $prepared_name = $datas['checker_name'];
                        $approved_name = $datas['approved_by'];
                        $date_time = date('m-d-Y', strtotime($datas['created_at']));
                        $inner_inside_loop++;
                    @endphp  

                    <footer>
                        <div style="position:absolute;top:10.80in;left:5.98in;width:8in;line-height:0.10in;">
                            <img src="../node_modules/template/app/media/img/bg/logo_pdf.png" style="height:1%; width:20%;">
                            {{-- Generated by: PDLS-Ver. 2  --}}
                        </div>
                    </footer>
                    {{-- || (($unit_count % 59) == 1  && $unit_count != 1) --}}
                    {{-- @if($pagebreak_count == 37 && !(count($row) == $inner_inside_loop && count($data) == $inside_loop)) --}}
                    @if($unit_count >= 37 || (count($row) == $inner_inside_loop && count($data) == $inside_loop) && ($unit_count > 21 &&  $unit_count < 37))
                    @php $header_loop_main++; @endphp  
                        {{-- @if($header_loop_main <= 1) --}}
                            <header>
                                <div style="position:absolute;top:0.05in;left:2.73in;width:8in;line-height:0.10in;">
                                    <span class="header-style" style="font-family:barcode">WAREHOUSE AREA1</span>
                                </div>
                                <div style="position:absolute;top:0.18in;left:3.30in;width:8in;line-height:0.15in;">
                                    <span class="header2-style">DELIVERY RECEIPT</span>
                                </div>
                                <div style="position:absolute;top:0.30in;left:5.70in;width:8in;line-height:0.10in;">
                                    <span class="header-barcode-style">*{{$datas['dr_control']}}*</span>
                                </div>
                                <div style="position:absolute;top:0.80in;left:0.16in;width:8in;line-height:0.10in;">
                                    <span class="subheader-style">DESTINATION :</span>
                                </div>
                                <div style="position:absolute;top:0.80in;left:1.50in;width:8in;line-height:0.10in;">
                                    <span class="subheader-data-style">{{$datas['destination']}}</span>
                                </div>
                                <div style="position:absolute;top:0.80in;left:1.44in;width:8in;line-height:0.10in;">
                                    <span class="line-style">_______________</span>
                                </div>
                                <div style="position:absolute;top:0.80in;left:4.80in;width:8in;line-height:0.10in;">
                                    <span class="subheader-style">CONTROL :</span>
                                </div>
                                <div style="position:absolute;top:0.80in;left:5.85in;width:8in;line-height:0.10in;">
                                    <span class="subheader-data-style">{{$datas['dr_control']}}</span>
                                </div>
                                <div style="position:absolute;top:0.80in;left:5.77in;width:8in;line-height:0.10in;">
                                    <span class="line-style">_________________</span>
                                </div>
                                <div style="position:absolute;top:1.13in;left:0.16in;width:8in;line-height:0.10in;">
                                    <span class="subheader-style">ATTENTION TO :</span>
                                </div>
                                <div style="position:absolute;top:1.13in;left:1.58in;width:8in;line-height:0.10in;">
                                    <span class="subheader-data-style">{{$datas['attention_to']}}</span>
                                </div>
                                <div style="position:absolute;top:1.13in;left:1.54in;width:8in;line-height:0.10in;">
                                    <span class="line-style">______________</span>
                                </div>
                                <div style="position:absolute;top:1.13in;left:4.80in;width:8in;line-height:0.10in;">
                                    <span class="subheader-style">DATE :</span>
                                </div>
                                <div style="position:absolute;top:1.13in;left:5.45in;width:8in;line-height:0.10in;">
                                    <span class="subheader-data-style">{{date('m-d-Y', strtotime($datas['created_at']))}}</span>
                                </div>
                                <div style="position:absolute;top:1.13in;left:5.39in;width:8in;line-height:0.10in;">
                                    <span class="line-style">_____________________</span>
                                </div>
                            </header>
                        {{-- @endif --}}
                        <table style="width:92%;" class="page-break">
                            <tr>
                                <td class="tbody-style" width="3%" height="2%">{{$unit_count++}}</td>
                                <td class="tbody-style" width="4%">{{$datas['delivery_type']}}</td>
                                <td class="tbody-style" width="5%">{{$datas['order_download_no']}}</td>
                                <td class="tbody-style" width="3%">{{$datas['item_rev']}}</td>
                                <td class="tbody-style" width="9%">{{$datas['item_no']}}</td>
                                <td class="tbody-style" width="9%">{{$datas['item_name']}}</td>
                                <td class="tbody-style" width="3%">{{$datas['delivery_qty']}}</td>
                                <td class="tbody-style" width="6%">{{$datas['stock_address']}}</td>
                                <td class="tbody-style" width="7%">{{$datas['manufacturing_no']}}</td>
                                <td class="tbody-style" width="6%">{{$datas['payee_cd']}}</td>
                                <td class="tbody-style" width="6%">{{$datas['ticket_no']}}</td>
                                <td class="tbody-style" width="7%">{{$datas['product_no']}}</td>
                            </tr>
                            @php $pagebreak_count = 1; $first_data = false; @endphp
                        </table>
                    @else
                    @php $header_loop_sub++; @endphp  
                        @if ($unit_count == 1 && $first_data == false)
                            @if($header_loop_sub <= 1)
                                <header>
                                        <div style="position:absolute;top:0.05in;left:2.73in;width:8in;line-height:0.10in;">
                                            <span class="header-style" style="font-family:barcode">WAREHOUSE AREA2</span>
                                        </div>
                                        <div style="position:absolute;top:0.18in;left:3.30in;width:8in;line-height:0.15in;">
                                            <span class="header2-style">DELIVERY RECEIPT</span>
                                        </div>
                                        <div style="position:absolute;top:0.30in;left:5.70in;width:8in;line-height:0.10in;">
                                            <span class="header-barcode-style">*{{$datas['dr_control']}}*</span>
                                        </div>
                                        <div style="position:absolute;top:0.80in;left:0.16in;width:8in;line-height:0.10in;">
                                            <span class="subheader-style">DESTINATION :</span>
                                        </div>
                                        <div style="position:absolute;top:0.80in;left:1.50in;width:8in;line-height:0.10in;">
                                            <span class="subheader-data-style">{{$datas['destination']}}</span>
                                        </div>
                                        <div style="position:absolute;top:0.80in;left:1.44in;width:8in;line-height:0.10in;">
                                            <span class="line-style">_______________</span>
                                        </div>
                                        <div style="position:absolute;top:0.80in;left:4.80in;width:8in;line-height:0.10in;">
                                            <span class="subheader-style">CONTROL :</span>
                                        </div>
                                        <div style="position:absolute;top:0.80in;left:5.85in;width:8in;line-height:0.10in;">
                                            <span class="subheader-data-style">{{$datas['dr_control']}}</span>
                                        </div>
                                        <div style="position:absolute;top:0.80in;left:5.77in;width:8in;line-height:0.10in;">
                                            <span class="line-style">_________________</span>
                                        </div>
                                        <div style="position:absolute;top:1.13in;left:0.16in;width:8in;line-height:0.10in;">
                                            <span class="subheader-style">ATTENTION TO :</span>
                                        </div>
                                        <div style="position:absolute;top:1.13in;left:1.58in;width:8in;line-height:0.10in;">
                                            <span class="subheader-data-style">{{$datas['attention_to']}}</span>
                                        </div>
                                        <div style="position:absolute;top:1.13in;left:1.54in;width:8in;line-height:0.10in;">
                                            <span class="line-style">______________</span>
                                        </div>
                                        <div style="position:absolute;top:1.13in;left:4.80in;width:8in;line-height:0.10in;">
                                            <span class="subheader-style">DATE :</span>
                                        </div>
                                        <div style="position:absolute;top:1.13in;left:5.45in;width:8in;line-height:0.10in;">
                                            <span class="subheader-data-style">{{date('m-d-Y', strtotime($datas['created_at']))}}</span>
                                        </div>
                                        <div style="position:absolute;top:1.13in;left:5.39in;width:8in;line-height:0.10in;">
                                            <span class="line-style">_____________________</span>
                                        </div>
                                    </header>
                                    @php $pagebreak_count = 1;@endphp
                                @endif
                           
                        @endif
                        <table style="width:92%;" class="">
                            <tr>
                                <td class="tbody-style" width="3%" height="2%">{{$unit_count++}}{{$header_loop_sub}}</td>
                                <td class="tbody-style" width="4%">{{$datas['delivery_type']}}</td>
                                <td class="tbody-style" width="5%">{{$datas['order_download_no']}}</td>
                                <td class="tbody-style" width="3%">{{$datas['item_rev']}}</td>
                                <td class="tbody-style" width="9%">{{$datas['item_no']}}</td>
                                <td class="tbody-style" width="9%">{{$datas['item_name']}}</td>
                                <td class="tbody-style" width="3%">{{$datas['delivery_qty']}}</td>
                                <td class="tbody-style" width="6%">{{$datas['stock_address']}}</td>
                                <td class="tbody-style" width="7%">{{$datas['manufacturing_no']}}</td>
                                <td class="tbody-style" width="6%">{{$datas['payee_cd']}}</td>
                                <td class="tbody-style" width="6%">{{$datas['ticket_no']}}</td>
                                <td class="tbody-style" width="7%">{{$datas['product_no']}}</td>
                            </tr>
                        </table>
                        @php $pagebreak_count++ @endphp
                    @endif
                  
                   
                @endforeach
                @if(count($row) == $inner_inside_loop) 
                <header>
                        <div style="position:absolute;top:0.05in;left:2.73in;width:8in;line-height:0.10in;">
                            <span class="header-style" style="font-family:barcode">WAREHOUSE AREA3</span>
                        </div>
                        <div style="position:absolute;top:0.18in;left:3.30in;width:8in;line-height:0.15in;">
                            <span class="header2-style">DELIVERY RECEIPT</span>
                        </div>
                        <div style="position:absolute;top:0.30in;left:5.70in;width:8in;line-height:0.10in;">
                            <span class="header-barcode-style">*{{$datas['dr_control']}}*</span>
                        </div>
                        <div style="position:absolute;top:0.80in;left:0.16in;width:8in;line-height:0.10in;">
                            <span class="subheader-style">DESTINATION :</span>
                        </div>
                        <div style="position:absolute;top:0.80in;left:1.50in;width:8in;line-height:0.10in;">
                            <span class="subheader-data-style">{{$datas['destination']}}</span>
                        </div>
                        <div style="position:absolute;top:0.80in;left:1.44in;width:8in;line-height:0.10in;">
                            <span class="line-style">_______________</span>
                        </div>
                        <div style="position:absolute;top:0.80in;left:4.80in;width:8in;line-height:0.10in;">
                            <span class="subheader-style">CONTROL :</span>
                        </div>
                        <div style="position:absolute;top:0.80in;left:5.85in;width:8in;line-height:0.10in;">
                            <span class="subheader-data-style">{{$datas['dr_control']}}</span>
                        </div>
                        <div style="position:absolute;top:0.80in;left:5.77in;width:8in;line-height:0.10in;">
                            <span class="line-style">_________________</span>
                        </div>
                        <div style="position:absolute;top:1.13in;left:0.16in;width:8in;line-height:0.10in;">
                            <span class="subheader-style">ATTENTION TO :</span>
                        </div>
                        <div style="position:absolute;top:1.13in;left:1.58in;width:8in;line-height:0.10in;">
                            <span class="subheader-data-style">{{$datas['attention_to']}}</span>
                        </div>
                        <div style="position:absolute;top:1.13in;left:1.54in;width:8in;line-height:0.10in;">
                            <span class="line-style">______________</span>
                        </div>
                        <div style="position:absolute;top:1.13in;left:4.80in;width:8in;line-height:0.10in;">
                            <span class="subheader-style">DATE :</span>
                        </div>
                        <div style="position:absolute;top:1.13in;left:5.45in;width:8in;line-height:0.10in;">
                            <span class="subheader-data-style">{{date('m-d-Y', strtotime($datas['created_at']))}}</span>
                        </div>
                        <div style="position:absolute;top:1.13in;left:5.39in;width:8in;line-height:0.10in;">
                            <span class="line-style">_____________________</span>
                        </div>
                    </header>
                    @endif
                    <span class="header-style" style="font-family:barcode">count_row{{count($row)}}</span>
                    <span class="header-style" style="font-family:barcode">inner_inside{{$inner_inside_loop}}</span>
                    <span class="header-style" style="font-family:barcode">count_data{{count($data)}}</span>
                    <span class="header-style" style="font-family:barcode">inside_loop{{$inside_loop}}</span>
                <table style="width:56.82%;" class="">
                    <tr>
                        <td class="total-style" height="2%" width="35.75%">SUB COUNT</td>
                        <td class="total-style" width="21.42%">{{$sub_count}}</td>
                        <td class="total-style" width="21.42%">SUBTOTAL</td>
                        <td class="total-style">{{$sub_total}}</td>
                    </tr>
                </table><br><br>
                
               

                @php 
                    $pb_style = '';
                    $total += intval($sub_count);
                    $grand_total += intval($sub_total);
                    $inner_inside_loop=0;
                    $inside_loop=0;
                @endphp
                
            @endforeach
            @php $header_loop_sub=0; @endphp  
            @php $pb_style = '' @endphp

            @if($unit_count > 25)
                @php $pb_style = 'page-break' @endphp
            @endif

            <table style="margin-top:3%;width:56.82%;" class="{{$pb_style}}">
                <tr>
                    <td class="total-style" height="2%" width="35.75%">TOTAL{{$pagebreak_count}}</td>
                    <td class="total-style" width="21.42%">{{$total}}</td>
                    <td class="total-style" width="21.42%">GRAND TOTAL</td>
                    <td class="total-style">{{$grand_total}}</td>
                    {{-- <td class="total-style">*{{$grand_total}}*</td> --}}
                </tr>
            </table>
            
            <table style="width:60%;margin-top:4%;padding-left: 30%;">
                <tr>
                    <td class="checker-style" width="38%" height="2%">CHECKER NAME</td>
                    <td class="checker-style">{{$checker_name}}</td>
                </tr>
            </table>
            <table style="width:60%;margin-top:1%;padding-left: 30%;">
                <tr>
                    <td class="checker-style" width="38%" height="2%">PALLET</td>
                    <td class="checker-style">{{$pallet}}</td>
                </tr>
            </table>

            <table style="width:60%;margin-top:1%;padding-left: 30%;">
                <tr>
                    <td class="checker-style" colspan="2" width="38%" height="2%">BREAKDOWN</td>
                </tr>
            </table>
            <table style="width:60%;padding-left: 30%;">
                <tr>
                    <td class="checker-style" height="2%" width="38%">PCASE</td>
                    <td class="checker-style" height="2%">{{$pcase}}</td>
                </tr>
                <tr>
                    <td class="checker-style" height="2%" width="38%">BOX</td>
                    <td class="checker-style" height="2%">{{$box}}</td>
                </tr>
                <tr>
                    <td class="checker-style" height="2%" width="38%">BAG</td>
                    <td class="checker-style" height="2%">{{$bag}}</td>
                </tr>
            </table>

            <table style="width:92%;margin-top:3%;">
                <tr>
                    <td class="prepared-style" width="3.5%" height="2%">PREPARED BY:</td>
                    <td class="checker-style" width="10%">{{$prepared_name}}</td>
                    <td class="approved-style" width="6%">APPROVED BY:</td>
                    <td class="checker-style" width="10%">{{$approved_name}}</td>
                </tr>
                <tr>
                    <td class="" ></td>
                    <td class="signatories-style" height="1.75%">WAREHOUSE STAFF</td>
                    <td class="" ></td>
                    <td class="signatories-style">WHE ASST STAFF</td>
                </tr>
            </table>
            <table style="width:66%;margin-top:4%;">
                <tr>
                    <td class="received-style" width="10%" height="2%">RECEIVED BY:</td>
                    <td class="checker-style" width="10%"></td>
                </tr>
                <tr>
                    <td class="" ></td>
                    <td class="signatories-style" height="1.75%">DATE AND TIME</td>
                </tr>
            </table>
            @php
               $count_loop+=1;
            @endphp
        @endforeach
        {{-- END --}}  
    </div>
    
</body>
</html>
