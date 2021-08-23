<html>
<head>
    <style>
        @page 
        {
            margin: 28;
        } 
        @font-face {
        font-family: 'sbarc39A';
            src: url({{storage_path('fonts/sbarc39A.ttf')}})  format('truetype');
        }
        @font-face {
        font-family: ' sbarc39v';
            src: url({{storage_path('fonts/sbarc39v.ttf')}})  format('truetype');
        }
        .header-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8
        }
        .control-style {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11;
            font-weight: bold;
        }
        .title-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15;
        }
        .warehouse-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10;
            font-weight: bold;
        }
        .date-style {
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
            font-size: 10; 
        }
        .checker-title-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 8; 
        }
        .checker-style {
            font-family:'Times New Roman', Times, serif;
            font-size: 9; 
        }
        .line-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10; 
        }
        .signature-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 5; 
            font-weight: bold;
        }
        .footer-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8; 
            font-style: italic;
        }
        .thead-style {
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
            font-size: 6; 
            text-align:center;
            horizontal-align:middle;
            vertical-align:middle;
        }
        .tbody-style {
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
            font-size: 5; 
            text-align:center;
            horizontal-align:middle;
            vertical-align:middle;
        }
        table {
            border-collapse: collapse;
        }
        table, td, th {
            border: 1px solid black;
            padding-top: 3px;
            padding-left: 5px;
            padding-right: 5px;
        }

        .barcode {
            font-family: 'sbarc39v';
            font-size: 15; 
            font-weight: normal;
            vertical-align: middle;            
        }
        .page-break {
            page-break-after: always;
        }
        .page-break:last-child {
        page-break-after: auto;
}
    </style>
</head>
<body>
        @foreach($data as $row_key=>$row)
        <div class="page-break">
        <div style="position:absolute;top:0.05in;left:0.01in;width:8in;line-height:0.10in;">
                <span class="header-style">FUJITSU DIE-TECH CORPORATION OF THE PHILIPPINES</span>
            </div>
            <div style="position:absolute;top:0.20in;left:0.01in;width:8in;line-height:0.10in;">
                <span class="header-style">BUSINESS ADMINISTRATIVE DIVISION</span>
            </div>
            <div style="position:absolute;top:0.35in;left:0.01in;width:8in;line-height:0.10in;">
                <span class="header-style">WAREHOUSE SECTION</span>
            </div>
            <div style="position:absolute;top:0.35in;left:5.24in;width:8in;line-height:0.10in;">
                <span class="control-style">Control No.:</span>
            </div>
            <div style="position:absolute;top:0.35in;left:6.18in;width:8in;line-height:0.10in;">
                <span class="control-style">
                 {{$row_key}}
                </span>
            </div>
            <div style="position:absolute;top:0.68in;left:2.63in;width:8in;line-height:0.10in;">
                <span class="title-style">IRREGULARITY FORM</span>
            </div>
            <div style="position:absolute;top:0.90in;left0.01in;width:7.5in;height:0.33in;line-height:0.30in;box-sizing: border-box;border: 1px solid black;">
            </div>
            @php 
                $wh_class='';
            @endphp
            @foreach($row as $raw_data)
                @php 
                    $wh_class=$raw_data['wh_class'];
                @endphp
            @endforeach
           
            @if($wh_class=="C1")
                <div style="position:absolute;top:1.04in;left:0.20in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Warehouse :</span>
                </div>
                <div style="position:absolute;top:0.95in;left:1.29in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/fill-square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:1.63in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Common Whe 1</span>
                </div>
                <div style="position:absolute;top:0.95in;left:3.11in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:3.45in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Common Whe 2</span>
                </div>
                <div style="position:absolute;top:0.95in;left:5in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:5.34in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Subparts</span>
                </div>
                <div style="position:absolute;top:0.95in;left:6.47in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:6.81in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Kanban</span>
                </div>
            @elseif($wh_class=="C2")
                <div style="position:absolute;top:1.04in;left:0.20in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Warehouse :</span>
                </div>
                <div style="position:absolute;top:0.95in;left:1.29in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:1.63in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Common Whe 1</span>
                </div>
                <div style="position:absolute;top:0.95in;left:3.11in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/fill-square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:3.45in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Common Whe 2</span>
                </div>
                <div style="position:absolute;top:0.95in;left:5in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:5.34in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Subparts</span>
                </div>
                <div style="position:absolute;top:0.95in;left:6.47in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:6.81in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Kanban</span>
                </div>
            @elseif($wh_class=="P14")
                <div style="position:absolute;top:1.04in;left:0.20in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Warehouse :</span>
                </div>
                <div style="position:absolute;top:0.95in;left:1.29in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:1.63in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Common Whe 1</span>
                </div>
                <div style="position:absolute;top:0.95in;left:3.11in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:3.45in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Common Whe 2</span>
                </div>
                <div style="position:absolute;top:0.95in;left:5in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/fill-square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:5.34in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Subparts</span>
                </div>
                <div style="position:absolute;top:0.95in;left:6.47in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:6.81in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Kanban</span>
                </div>
            @elseif($wh_class=="P15")
                <div style="position:absolute;top:1.04in;left:0.20in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Warehouse :</span>
                </div>
                <div style="position:absolute;top:0.95in;left:1.29in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:1.63in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Common Whe 1</span>
                </div>
                <div style="position:absolute;top:0.95in;left:3.11in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:3.45in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Common Whe 2</span>
                </div>
                <div style="position:absolute;top:0.95in;left:5in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:5.34in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Subparts</span>
                </div>
                <div style="position:absolute;top:0.95in;left:6.47in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/fill-square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:6.81in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Kanban</span>
                </div>
            @else
                <div style="position:absolute;top:1.04in;left:0.20in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Warehouse :</span>
                </div>
                <div style="position:absolute;top:0.95in;left:1.29in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:1.63in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Common Whe 1</span>
                </div>
                <div style="position:absolute;top:0.95in;left:3.11in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:3.45in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Common Whe 2</span>
                </div>
                <div style="position:absolute;top:0.95in;left:5in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:5.34in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Subparts</span>
                </div>
                <div style="position:absolute;top:0.95in;left:6.47in;width:8in;line-height:0.10in;">
                    <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
                </div>
                <div style="position:absolute;top:1.04in;left:6.81in;width:8in;line-height:0.10in;">
                    <span class="warehouse-style">Kanban</span>
                </div>
            @endif
            @foreach($row as $datas)
             @php
                $irreg_create=$datas['irreg_create'];
             @endphp
            @endforeach
            <div style="position:absolute;top:1.40in;left:6.14in;width:8in;line-height:0.10in;">
                <span class="date-style">Date:_______________</span>
            </div>
            <div style="position:absolute;top:1.40in;left:6.70in;width:8in;line-height:0.10in;">
                <span class="date-style">{{date('m-d-Y', strtotime($irreg_create))}}</span>
            </div>
            <div style="position:absolute;top:1.58in;left:0.01in;width:8in;line-height:0.10in;">
                    <table style="width:94%">
                        <thead>
                            <tr>
                                <td class="thead-style" width="3%">No.</td>
                                <td class="thead-style" width="6%">Ord. No.</td>
                                <td class="thead-style" width="9.5%">Stock Address</td>
                                <td class="thead-style" width="15%">Part No.</td>
                                <td class="thead-style" width="15%">Part Name</td>
                                <td class="thead-style" width="8.5%">Ticket No.</td>
                                <td class="thead-style" width="9.5%">Type of Irregularity</td>
                                <td class="thead-style" width="6.5%">Ticket Qty.</td>
                                <td class="thead-style" width="6.5%">Actual Qty.</td>
                                <td class="thead-style" width="6.5%">Dis. Qty.</td>
                                <td class="thead-style" width="15%">Remarks</td>
                                <td class="thead-style" width="16%">Barcode</td>
                            </tr>
                        </thead>
                        <tbody>
                    
                            @php 
                            $a=0;
                            @endphp
                                @foreach($row as $datas)
                                     {{$a++}}
                                    <tr>
                                        <td class="tbody-style" width="3%" height="4.5%">{{$a}}</td>
                                        <td class="tbody-style" width="6%">{{$datas['order_download_no']}} </td>
                                        <td class="tbody-style" width="9.5%">{{$datas['stock_address']}}</td>
                                        <td class="tbody-style" width="15%">{{$datas['part_no']}}</td>
                                        <td class="tbody-style" width="15%">{{$datas['part_name']}}</td>
                                        <td class="tbody-style" width="11%">{{$datas['ticket_no']}}</td>
                                        <td class="tbody-style" width="9.5%">{{$datas['irregularity_type']}}</td>
                                        <td class="tbody-style" width="6.5%">{{$datas['original_qty']}}</td>
                                        <td class="tbody-style" width="6.5%">{{$datas['actual_qty']}}</td>
                                        <td class="tbody-style" width="6.5%">{{$datas['discrepancy']}}</td>
                                        <td class="tbody-style" width="15%">{{$datas['remarks']}}</td>
                                        <td class="tbody-style barcode" width="13.5%">*{{$datas['ticket_no']}}*</td> 
                                    </tr> 
                                   
                                @endforeach
                          
                        </tbody>
                    </table>
                </div>
                <div style="position:absolute;top:4in;left:0.58in;width:8in;line-height:0.10in;">
                    <span class="checker-title-style">Prepared By:</span>
                </div>
                <div style="position:absolute;top:4in;left:2.48in;width:8in;line-height:0.10in;">
                    <span class="checker-title-style">Checked By:</span>
                </div>
                <div style="position:absolute;top:4in;left:4.38in;width:8in;line-height:0.10in;">
                    <span class="checker-title-style">Reviewed By:</span>
                </div>
                <div style="position:absolute;top:4in;left:6.28in;width:8in;line-height:0.10in;">
                    <span class="checker-title-style">Approved By:</span>
                </div>
                <div style="position:absolute;top:4.37in;left:0.13in;width:8in;line-height:0.10in;">
                    <span class="line-style">_____________________</span>
                </div>
                <div style="position:absolute;top:4.35in;left:0.23in;width:8in;line-height:0.10in;">
                     <span class="checker-style">{{$datas['prepared_by']}}</span>
                 </div>
                <div style="position:absolute;top:4.37in;left:2.03in;width:8in;line-height:0.10in;">
                    <span class="line-style">_____________________</span>
                </div>
                <div style="position:absolute;top:4.37in;left:3.93in;width:8in;line-height:0.10in;">
                    <span class="line-style">_____________________</span>
                </div>
                <div style="position:absolute;top:4.35in;left:4.03in;width:8in;line-height:0.10in;">
                    <span class="checker-style">{{$datas['reviewed_by']}}</span>
                </div>
                <div style="position:absolute;top:4.37in;left:5.83in;width:8in;line-height:0.10in;">
                    <span class="line-style">_____________________</span>
                </div>
                <div style="position:absolute;top:4.35in;left:5.93in;width:8in;line-height:0.10in;">
                    <span class="checker-style">{{$datas['approved_by']}}</span>
                </div>
                <div style="position:absolute;top:4.47in;left:0.36in;width:8in;line-height:0.10in;">
                    <span class="signature-style">Signature over printed name / date</span>
                </div>
                <div style="position:absolute;top:4.47in;left:2.26in;width:8in;line-height:0.10in;">
                    <span class="signature-style">Signature over printed name / date</span>
                </div>
                <div style="position:absolute;top:4.47in;left:4.16in;width:8in;line-height:0.10in;">
                    <span class="signature-style">Signature over printed name / date</span>
                </div>
                <div style="position:absolute;top:4.47in;left:6.06in;width:8in;line-height:0.10in;">
                    <span class="signature-style">Signature over printed name / date</span>
                </div>
                <div style="position:absolute;top:4.94in;left:3in;width:8in;line-height:0.10in;">
                        <img src="../node_modules/template/app/media/img/bg/logo_pdf.png" style="height:1%; width:20%;">
                </div>
            </div> 
        @endforeach

</body>
</html>





{{-- 
     

    @php 
    $warehouse_class='';
    @endphp
    @if($warehouse_class=="C1")
        <div style="position:absolute;top:1.04in;left:0.20in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Warehouse :</span>
        </div>
        <div style="position:absolute;top:0.95in;left:1.29in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/fill-square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:1.63in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Common Whe 1</span>
        </div>
        <div style="position:absolute;top:0.95in;left:3.11in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:3.45in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Common Whe 2</span>
        </div>
        <div style="position:absolute;top:0.95in;left:5in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:5.34in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Subparts</span>
        </div>
        <div style="position:absolute;top:0.95in;left:6.47in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:6.81in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Kanban</span>
        </div>
    @elseif($warehouse_class=="C2")
        <div style="position:absolute;top:1.04in;left:0.20in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Warehouse :</span>
        </div>
        <div style="position:absolute;top:0.95in;left:1.29in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:1.63in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Common Whe 1</span>
        </div>
        <div style="position:absolute;top:0.95in;left:3.11in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/fill-square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:3.45in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Common Whe 2</span>
        </div>
        <div style="position:absolute;top:0.95in;left:5in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:5.34in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Subparts</span>
        </div>
        <div style="position:absolute;top:0.95in;left:6.47in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:6.81in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Kanban</span>
        </div>
    @elseif($warehouse_class=="P14")
        <div style="position:absolute;top:1.04in;left:0.20in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Warehouse :</span>
        </div>
        <div style="position:absolute;top:0.95in;left:1.29in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:1.63in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Common Whe 1</span>
        </div>
        <div style="position:absolute;top:0.95in;left:3.11in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:3.45in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Common Whe 2</span>
        </div>
        <div style="position:absolute;top:0.95in;left:5in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/fill-square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:5.34in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Subparts</span>
        </div>
        <div style="position:absolute;top:0.95in;left:6.47in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:6.81in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Kanban</span>
        </div>
    @elseif($warehouse_class=="P15")
        <div style="position:absolute;top:1.04in;left:0.20in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Warehouse :</span>
        </div>
        <div style="position:absolute;top:0.95in;left:1.29in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:1.63in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Common Whe 1</span>
        </div>
        <div style="position:absolute;top:0.95in;left:3.11in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:3.45in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Common Whe 2</span>
        </div>
        <div style="position:absolute;top:0.95in;left:5in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:5.34in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Subparts</span>
        </div>
        <div style="position:absolute;top:0.95in;left:6.47in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/fill-square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:6.81in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Kanban</span>
        </div>
    @else
        <div style="position:absolute;top:1.04in;left:0.20in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Warehouse :</span>
        </div>
        <div style="position:absolute;top:0.95in;left:1.29in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:1.63in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Common Whe 1</span>
        </div>
        <div style="position:absolute;top:0.95in;left:3.11in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:3.45in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Common Whe 2</span>
        </div>
        <div style="position:absolute;top:0.95in;left:5in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:5.34in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Subparts</span>
        </div>
        <div style="position:absolute;top:0.95in;left:6.47in;width:8in;line-height:0.10in;">
            <span><img src="{{ asset('icons/square.png') }}" style="height:3%; width:3%;"></span>
        </div>
        <div style="position:absolute;top:1.04in;left:6.81in;width:8in;line-height:0.10in;">
            <span class="warehouse-style">Kanban</span>
        </div>
    @endif
    <div style="position:absolute;top:1.40in;left:6.14in;width:8in;line-height:0.10in;">
        <span class="date-style">Date:_______________</span>
    </div>
    <div style="position:absolute;top:1.40in;left:6.70in;width:8in;line-height:0.10in;">
        <span class="date-style">{{Carbon\Carbon::now()->format('Y-m-d')}}</span>
    </div>
    <div style="position:absolute;top:1.58in;left:0.01in;width:8in;line-height:0.10in;">
        <table style="width:94%">
            <thead>
                <tr>
                    <td class="thead-style" width="3%">No.</td>
                    <td class="thead-style" width="6%">Ord. No.</td>
                    <td class="thead-style" width="9.5%">Stock Address</td>
                    <td class="thead-style" width="15%">Part No.</td>
                    <td class="thead-style" width="15%">Part Name</td>
                    <td class="thead-style" width="11%">Ticket No.</td>
                    <td class="thead-style" width="9.5%">Status</td>
                    <td class="thead-style" width="6.5%">Ticket Qty.</td>
                    <td class="thead-style" width="6.5%">Actual Qty.</td>
                    <td class="thead-style" width="9%">Discrepancy</td>
                    <td class="thead-style" width="15%">Remarks</td>
                    <td class="thead-style" width="11%">Barcode</td>
                </tr>
            </thead>
            <tbody>
                @php 
                $a=0;
                $prepared_by;
                $reviewed_by;
                $approved_by;
                @endphp
                    @foreach($data as $d)
                    {{$a++}}
                    <tr>
                            <td class="tbody-style" width="3%" height="4.5%">{{$a}}</td>
                            <td class="tbody-style" width="6%"> {{$d->order_download_no}}</td>
                            <td class="tbody-style" width="9.5%">{{$d->stock_address}}</td>
                            <td class="tbody-style" width="15%">{{$d->part_no}} </td>
                            <td class="tbody-style" width="15%">{{$d->part_name}}</td>
                            <td class="tbody-style" width="11%">{{$d->ticket_no}}</td>
                            <td class="tbody-style" width="9.5%">{{$d->status}}</td>
                            <td class="tbody-style" width="6.5%">{{$d->original_qty}}</td>
                            <td class="tbody-style" width="6.5%">{{$d->actual_qty}}</td>
                            <td class="tbody-style" width="9%">{{$d->discrepancy}}</td>
                            <td class="tbody-style" width="15%">{{$d->remarks}}</td>
                            <td class="tbody-style barcode" width="11%">*{{$d->ticket_no}}*</td> 
                        </tr> 
                        {{$prepared_by=$d->prepared_by}}
                        {{$reviewed_by=$d->reviewed_by}}
                        {{$approved_by=$d->approved_by}}
                    @endforeach
              
            </tbody>
        </table>
    </div>
    <div style="position:absolute;top:4in;left:0.58in;width:8in;line-height:0.10in;">
        <span class="checker-title-style">Prepared By:</span>
    </div>
    <div style="position:absolute;top:4in;left:2.48in;width:8in;line-height:0.10in;">
        <span class="checker-title-style">Checked By:</span>
    </div>
    <div style="position:absolute;top:4in;left:4.38in;width:8in;line-height:0.10in;">
        <span class="checker-title-style">Reviewed By:</span>
    </div>
    <div style="position:absolute;top:4in;left:6.28in;width:8in;line-height:0.10in;">
        <span class="checker-title-style">Approved By:</span>
    </div>
    <div style="position:absolute;top:4.37in;left:0.13in;width:8in;line-height:0.10in;">
        <span class="line-style">_____________________</span>
    </div>
    <div style="position:absolute;top:4.35in;left:0.23in;width:8in;line-height:0.10in;">
         <span class="checker-style">{{$prepared_by}}</span>
     </div>
    <div style="position:absolute;top:4.37in;left:2.03in;width:8in;line-height:0.10in;">
        <span class="line-style">_____________________</span>
    </div>
    <div style="position:absolute;top:4.37in;left:3.93in;width:8in;line-height:0.10in;">
        <span class="line-style">_____________________</span>
    </div>
    <div style="position:absolute;top:4.35in;left:4.03in;width:8in;line-height:0.10in;">
        <span class="checker-style">{{$reviewed_by}}</span>
    </div>
    <div style="position:absolute;top:4.37in;left:5.83in;width:8in;line-height:0.10in;">
        <span class="line-style">_____________________</span>
    </div>
    <div style="position:absolute;top:4.35in;left:5.93in;width:8in;line-height:0.10in;">
        <span class="checker-style">{{$approved_by}}</span>
    </div>
    <div style="position:absolute;top:4.47in;left:0.36in;width:8in;line-height:0.10in;">
        <span class="signature-style">Signature over printed name / date</span>
    </div>
    <div style="position:absolute;top:4.47in;left:2.26in;width:8in;line-height:0.10in;">
        <span class="signature-style">Signature over printed name / date</span>
    </div>
    <div style="position:absolute;top:4.47in;left:4.16in;width:8in;line-height:0.10in;">
        <span class="signature-style">Signature over printed name / date</span>
    </div>
    <div style="position:absolute;top:4.47in;left:6.06in;width:8in;line-height:0.10in;">
        <span class="signature-style">Signature over printed name / date</span>
    </div>
    <div style="position:absolute;top:4.94in;left:3in;width:8in;line-height:0.10in;">
        <img src="../node_modules/template/app/media/img/bg/logo_pdf.png" style="height:1%; width:20%;">
    </div> --}}