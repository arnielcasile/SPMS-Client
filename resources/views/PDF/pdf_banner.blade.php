<html>
<head>
    <style>
        @page 
        {
            margin: 15;
        } 
        .header-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10
        }
        .datetime-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13
        }
        .datetime-data-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16;
            font-weight: bold;
        }
        .title-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 28;
            font-weight: bold;
        }
        .origin-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 24;
            font-weight: bold;
        }
        .origins-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12;
        }
        .destination-attention-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 21;
        }
        .destination-data-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 34;
            font-weight: bold;
        }
        .attention-data-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 28;
            font-weight: bold;
        }
        .control-data-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 22;
            font-weight: bold;
        }
        .control-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12;
            font-weight: bold;
        }
        .line-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13;
        }
        .line-box-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14;
        }
        .footer-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16;
        }
        .footer-bold-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16;
            font-weight: bold;
        }
        .footer-data-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 32;
            font-weight: bold;
        }
        .footer-date-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 24;
            font-weight: bold;
        }
        .thead-style {
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
            font-size: 8; 
            text-align:center;
            horizontal-align:middle;
            vertical-align:middle;
        }
        .tbody-style {
            font-family: 'Times New Roman', Times, serif;
            font-size: 8; 
            text-align:center;
            horizontal-align:middle;
            vertical-align:middle;
        }
        table {
            border-collapse: collapse;
        }
        table, td, th {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    {{-- @php
        
        print_r($raw_data);
    @endphp --}}
    <div style="position:absolute;top:0.03in;left:0.15in;width:8in;line-height:0.10in;">
        <span class="header-style">FUJITSU DIE-TECH CORP OF THE PHILS.</span>
    </div>
    <div style="position:absolute;top:0.25in;left:0.15in;width:8in;line-height:0.10in;">
        <span class="header-style">Business Administrative Division</span>
    </div>
    <div style="position:absolute;top:0.46in;left:0.15in;width:8in;line-height:0.10in;">
        <span class="header-style">Warehouse Section</span>
    </div>
    <div style="position:absolute;top:0.10in;left:8.78in;width:8in;line-height:0.10in;">
        <span class="datetime-style">DATE: __________________</span>
    </div>
    <div style="position:absolute;top:0.10in;left:9.60in;width:8in;line-height:0.10in;">
        <span class="datetime-data-style">{{$raw_data[0]->date_now}}</span>
    </div>
    <div style="position:absolute;top:0.46in;left:8.80in;width:8in;line-height:0.10in;">
        <span class="datetime-style">TIME: __________________</span>
    </div>
    <div style="position:absolute;top:0.46in;left:9.70in;width:8in;line-height:0.10in;">
        <span class="datetime-data-style">{{$raw_data[0]->time_now}}</span>
    </div>
    <div style="position:absolute;top:0.62in;left:0.15in;width:8in;line-height:0.10in;">
        <div class="datetime-style" style="border-left: 1px solid black;height: 690px;position: absolute;"></div>
    </div>
    <div style="position:absolute;top:0.62in;left:0.15in;width:11in;line-height:0.10in;">
        <div class="datetime-style" style="border-top: 1px solid black;"></div>
    </div>
    <div style="position:absolute;top:0.62in;left:11.14in;width:8in;line-height:0.10in;">
        <div class="datetime-style" style="border-left: 1px solid black;height: 690px;position: absolute;"></div>
    </div>
    <div style="position:absolute;top:7.80in;left:0.15in;width:11in;line-height:0.10in;">
        <div class="datetime-style" style="border-top: 1px solid black;"></div>
    </div>
    <div style="position:absolute;top:0.40in;left:3.80in;width:11in;line-height:0.10in;">
        <span class="title-style">DELIVERY BANNER</span>
    </div>
    <div style="position:absolute;top:1.15in;left:0.95in;width:11in;line-height:0.10in;">
        <span class="origin-style">Origin:</span>
    </div>
    <div style="position:absolute;top:0.65in;left:2.16in;width:11in;line-height:0.10in;">
        <span><img src="{{ asset('icons/rec.png') }}" style="height:0%; width:7%;"></span>
    </div>
    <div style="position:absolute;top:0.88in;left:3.02in;width:11in;line-height:0.10in;">
        <span class="origins-style">INSPECTION</span>
    </div>
    <div style="position:absolute;top:1.18in;left:2.16in;width:11in;line-height:0.10in;">
        <span><img src="{{ asset('icons/rec.png') }}" style="height:0%; width:7%;"></span>
    </div>
    <div style="position:absolute;top:1.39in;left:3.02in;width:11in;line-height:0.10in;">
        <span class="origins-style">ASSEMBLY</span>
    </div>
    <div style="position:absolute;top:0.65in;left:4.27in;width:11in;line-height:0.10in;">
        <span><img src="{{ asset('icons/rec.png') }}" style="height:0%; width:7%;"></span>
    </div>
    <div style="position:absolute;top:0.88in;left:5.13in;width:11in;line-height:0.10in;">
        <span class="origins-style">PRESS / SMA</span>
    </div>
    <div style="position:absolute;top:1.18in;left:4.27in;width:11in;line-height:0.10in;">
        <span><img src="{{ asset('icons/rec-fill.png') }}" style="height:0%; width:7%;"></span>
    </div>
    <div style="position:absolute;top:1.39in;left:5.13in;width:11in;line-height:0.10in;">
        <span class="origins-style">PC / WHE</span>
    </div>
    <div style="position:absolute;top:0.65in;left:6.42in;width:11in;line-height:0.10in;">
        <span><img src="{{ asset('icons/rec.png') }}" style="height:0%; width:7%;"></span>
    </div>
    <div style="position:absolute;top:0.88in;left:7.28in;width:11in;line-height:0.10in;">
        <span class="origins-style">SUBPARTS</span>
    </div>
    <div style="position:absolute;top:1.18in;left:6.42in;width:11in;line-height:0.10in;">
        <span><img src="{{ asset('icons/rec.png') }}" style="height:0%; width:7%;"></span>
    </div>
    <div style="position:absolute;top:1.39in;left:7.28in;width:11in;line-height:0.10in;">
        <span class="origins-style">KANBAN</span>
    </div>
    <div style="position:absolute;top:0.65in;left:8.46in;width:11in;line-height:0.10in;">
        <span><img src="{{ asset('icons/rec.png') }}" style="height:0%; width:7%;"></span>
    </div>
    <div style="position:absolute;top:0.88in;left:9.32in;width:11in;line-height:0.10in;">
        <span class="origins-style">OTHERS</span>
    </div>
    <div style="position:absolute;top:1.16in;left:8.41in;width:11in;line-height:0.10in;">
        <span class="header-style">please specify:</span>
    </div>
    <div style="position:absolute;top:1.55in;left:8.41in;width:11in;line-height:0.10in;">
        <span class="datetime-style">_________________________</span>
    </div>
    <div style="position:absolute;top:2.10in;left:0.35in;width:11in;line-height:0.10in;">
        <span class="destination-attention-style">Destination:</span>
    </div>
    <div style="position:absolute;top:2.10in;left:2.16in;width:11in;line-height:0.10in;">
        <span class="datetime-style">_______________________________________________________________________________________</span>
    </div>
    <div style="position:absolute;top:2.05in;left:2.30in;width:11in;line-height:0.10in;">
        <span class="destination-data-style">{{$raw_data[0]->destination}}</span>
    </div>
    <div style="position:absolute;top:2.60in;left:0.35in;width:11in;line-height:0.10in;">
        <span class="destination-attention-style">Attention to:</span>
    </div>
    <div style="position:absolute;top:2.60in;left:2.16in;width:11in;line-height:0.10in;">
        <span class="datetime-style">_______________________________________________________________________________________</span>
    </div>
    <div style="position:absolute;top:2.55in;left:2.30in;width:11in;line-height:0.10in;">
        <span class="attention-data-style">{{$raw_data[0]->attention_to}}</span>
    </div>
    <div style="position:absolute;top:3.12in;left:0.35in;width:11in;line-height:0.10in;">
        <span class="control-style">Control No. / NEPDR No.:</span>
    </div>
    <div style="position:absolute;top:3.12in;left:2.45in;width:11in;line-height:0.10in;">
        <span class="datetime-style">____________________________________________________________________________________</span>
    </div>
    <div style="position:absolute;top:3.62in;left:0.80in;width:11in;line-height:0.10in;">
        <span class="datetime-style">____________________________________________________________________________________________________</span>
    </div>
    <div style="position:absolute;top:4.12in;left:0.80in;width:11in;line-height:0.10in;">
        <span class="datetime-style">____________________________________________________________________________________________________</span>
    </div>
    @php
        $count = count($raw_data[0]->control_no);
    @endphp
    @for ($i = 0; $i < $count; $i++)
        @if ($i == 0)
            <div style="position:absolute;top:3.07in;left:2.60in;width:11in;line-height:0.10in;">
                <span class="control-data-style">{{$raw_data[0]->control_no[$i]->dr_control}}</span>
            </div>
        @elseif ($i == 1)
            <div style="position:absolute;top:3.07in;left:5.38in;width:11in;line-height:0.10in;">
                <span class="control-data-style">{{$raw_data[0]->control_no[$i]->dr_control}}</span>
            </div>
        @elseif ($i == 2)
            <div style="position:absolute;top:3.07in;left:7.68in;width:11in;line-height:0.10in;">
                <span class="control-data-style">{{$raw_data[0]->control_no[$i]->dr_control}}</span>
            </div>
        @elseif ($i == 3)
            <div style="position:absolute;top:3.57in;left:1.25in;width:11in;line-height:0.10in;">
                <span class="control-data-style">{{$raw_data[0]->control_no[$i]->dr_control}}</span>
            </div>
        @elseif ($i == 4)
            <div style="position:absolute;top:3.57in;left:3.55in;width:11in;line-height:0.10in;">
                <span class="control-data-style">{{$raw_data[0]->control_no[$i]->dr_control}}</span>
            </div>
        @elseif ($i == 5)
            <div style="position:absolute;top:3.57in;left:5.88in;width:11in;line-height:0.10in;">
                <span class="control-data-style">{{$raw_data[0]->control_no[$i]->dr_control}}</span>
            </div>
        @elseif ($i == 6)
            <div style="position:absolute;top:3.57in;left:8.21in;width:11in;line-height:0.10in;">
                <span class="control-data-style">{{$raw_data[0]->control_no[$i]->dr_control}}</span>
            </div>
        @elseif ($i == 7)
            <div style="position:absolute;top:4.07in;left:1.25in;width:11in;line-height:0.10in;">
                <span class="control-data-style">{{$raw_data[0]->control_no[$i]->dr_control}}</span>
            </div>
        @elseif ($i == 8)
            <div style="position:absolute;top:4.07in;left:3.55in;width:11in;line-height:0.10in;">
                <span class="control-data-style">{{$raw_data[0]->control_no[$i]->dr_control}}</span>
            </div>
        @elseif ($i == 9)
            <div style="position:absolute;top:4.07in;left:5.88in;width:11in;line-height:0.10in;">
                <span class="control-data-style">{{$raw_data[0]->control_no[$i]->dr_control}}</span>
            </div>
        @endif
    @endfor
        
    <div style="position:absolute;top:4.70in;left:0.63in;width:11in;line-height:0.10in;">
        <div style="width: 100px;height: 75px;border: 2px solid black;"></div>
    </div>
    <div style="position:absolute;top:5.41in;left:1.67in;width:13in;line-height:0.10in;">
        <span class="line-box-style" style="transform: rotate(-20deg);">______________________</span>
    </div>
    <div style="position:absolute;top:4.98in;left:0.80in;width:11in;line-height:0.10in;">
        <span class="destination-attention-style">Pallet</span>
    </div>
    <div style="position:absolute;top:5.28in;left:0.90in;width:11in;line-height:0.10in;">
        <span class="destination-attention-style">Qty.</span>
    </div>
    <div style="position:absolute;top:5.10in;left:1.82in;width:11in;line-height:0.10in;">
        <span class="destination-data-style">{{$raw_data[0]->pallet_qty}}</span>
    </div>
    <div style="position:absolute;top:5.30in;left:3.30in;width:11in;line-height:0.10in;">
        <span class="destination-data-style">{{$raw_data[0]->pallet_total}}</span>
    </div>
    <div style="position:absolute;top:4.70in;left:3.93in;width:11in;line-height:0.10in;">
        <div style="width: 100px;height: 75px;border: 2px solid black;"></div>
    </div>
    <div style="position:absolute;top:5.41in;left:4.97in;width:13in;line-height:0.10in;">
        <span class="line-box-style" style="transform: rotate(-20deg);">______________________</span>
    </div>
    <div style="position:absolute;top:4.98in;left:4.07in;width:11in;line-height:0.10in;">
        <span class="destination-attention-style">Boxes</span>
    </div>
    <div style="position:absolute;top:5.28in;left:4.22in;width:11in;line-height:0.10in;">
        <span class="destination-attention-style">Qty.</span>
    </div>
    <div style="position:absolute;top:5.10in;left:5.11in;width:11in;line-height:0.10in;">
        <span class="destination-data-style">{{$raw_data[0]->box_qty}}</span>
    </div>
    <div style="position:absolute;top:5.30in;left:6.60in;width:11in;line-height:0.10in;">
        <span class="destination-data-style">{{$raw_data[0]->box_total}}</span>
    </div>
    <div style="position:absolute;top:4.70in;left:7.23in;width:11in;line-height:0.10in;">
        <div style="width: 100px;height: 75px;border: 2px solid black;"></div>
    </div>
    <div style="position:absolute;top:5.41in;left:8.27in;width:13in;line-height:0.10in;">
        <span class="line-box-style" style="transform: rotate(-20deg);">______________________</span>
    </div>
    <div style="position:absolute;top:4.98in;left:7.37in;width:11in;line-height:0.10in;">
        <span class="destination-attention-style">Pcase</span>
    </div>
    <div style="position:absolute;top:5.28in;left:7.51in;width:11in;line-height:0.10in;">
        <span class="destination-attention-style">Qty.</span>
    </div>
    <div style="position:absolute;top:5.10in;left:8.41in;width:11in;line-height:0.10in;">
        <span class="destination-data-style">{{$raw_data[0]->pcase_qty}}</span>
    </div>
    <div style="position:absolute;top:5.30in;left:9.91in;width:11in;line-height:0.10in;">
        <span class="destination-data-style">{{$raw_data[0]->pcase_total}}</span>
    </div>
    <div style="position:absolute;top:5.55in;left:0.15in;width:11in;line-height:0.10in;">
        <div class="datetime-style" style="border-top: 1px solid black;"></div>
    </div>
    <div style="position:absolute;top:6in;left:0.35in;width:11in;line-height:0.10in;">
        <span class="footer-style">Farm-Out DR No.:</span>
    </div>
    <div style="position:absolute;top:5.97in;left:2.32in;width:11in;line-height:0.10in;">
        <span class="footer-data-style"></span>
    </div>
    <div style="position:absolute;top:6in;left:2.22in;width:11in;line-height:0.10in;">
        <span class="datetime-style">___________________________________________________________</span>
    </div>
    <div style="position:absolute;top:6in;left:8.21in;width:11in;line-height:0.10in;">
        <span class="footer-bold-style">Date:</span>
    </div>
    <div style="position:absolute;top:5.97in;left:8.97in;width:11in;line-height:0.10in;">
        <span class="footer-date-style">{{$raw_data[0]->date_now}}</span>
    </div>
    <div style="position:absolute;top:6in;left:8.85in;width:11in;line-height:0.10in;">
        <span class="datetime-style">____________________</span>
    </div>
    <div style="position:absolute;top:6.54in;left:0.35in;width:11in;line-height:0.10in;">
        <span class="footer-style">Description:</span>
    </div>
    <div style="position:absolute;top:6.51in;left:2.32in;width:11in;line-height:0.10in;">
        <span class="footer-data-style">{{$raw_data[0]->description}}</span>
    </div>
    <div style="position:absolute;top:6.54in;left:2.22in;width:11in;line-height:0.10in;">
        <span class="datetime-style">______________________________________________________________________________________</span>
    </div>
    <div style="position:absolute;top:7.06in;left:0.35in;width:11in;line-height:0.10in;">
        <span class="footer-style">Purpose:</span>
    </div>
    <div style="position:absolute;top:7.03in;left:2.32in;width:11in;line-height:0.10in;">
        <span class="footer-data-style">{{$raw_data[0]->purpose}}</span>
    </div>
    <div style="position:absolute;top:7.06in;left:2.22in;width:11in;line-height:0.10in;">
        <span class="datetime-style">______________________________________________________________________________________</span>
    </div>
    <div style="position:absolute;top:7.58in;left:0.35in;width:11in;line-height:0.10in;">
        <span class="footer-bold-style">Pallet Qty.:</span>
    </div>
    <div style="position:absolute;top:7.55in;left:2.40in;width:11in;line-height:0.10in;">
        <span class="footer-data-style"></span>
    </div>
    <div style="position:absolute;top:7.55in;left:3.50in;width:11in;line-height:0.10in;">
        <span class="footer-data-style"></span>
    </div>
    <div style="position:absolute;top:7.58in;left:2.22in;width:11in;line-height:0.10in;">
        <span class="datetime-style">____________________</span>
    </div>
    <div style="position:absolute;top:7.55in;left:3.05in;width:13in;line-height:0.10in;">
        <span class="line-box-style" style="transform: rotate(-52deg);">___</span>
    </div>
    <div style="position:absolute;top:7.22in;left:5.40in;width:8in;line-height:0.10in;">
        <table width="15%">
            <thead>
                <tr>
                    <td class="thead-style" width="7%">Destination</td>
                    <td class="thead-style" width="5%">Color</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tbody-style" width="7%">SGIC-L</td>
                    <td class="tbody-style" width="5%">Green</td>
                </tr>
                <tr>
                    <td class="tbody-style" width="7%">SGIC-C</td>
                    <td class="tbody-style" width="5%">Blue</td>
                </tr>
                <tr>
                    <td class="tbody-style" width="7%">NEP ORIENT</td>
                    <td class="tbody-style" width="5%">Orange</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="position:absolute;top:7.22in;left:6.63in;width:8in;line-height:0.10in;">
        <table width="15%">
            <thead>
                <tr>
                    <td class="thead-style" width="7%">Destination</td>
                    <td class="thead-style" width="5%">Color</td>
            </thead>
            <tbody>
                <tr>
                    <td class="tbody-style" width="7%">P1</td>
                    <td class="tbody-style" width="5%">White</td>
                </tr>
                <tr>
                    <td class="tbody-style" width="7%">C1 / C2</td>
                    <td class="tbody-style" width="5%">White</td>
                </tr>
                <tr>
                    <td class="tbody-style" width="7%">MA / BR / PP</td>
                    <td class="tbody-style" width="5%">White</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="position:absolute;top:7.22in;left:7.86in;width:8in;line-height:0.10in;">
        <table width="15%">
            <thead>
                <tr>
                    <td class="thead-style" width="7%">Destination</td>
                    <td class="thead-style" width="5%">Color</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tbody-style" width="7%">SINAG</td>
                    <td class="tbody-style" width="5%">Peach</td>
                </tr>
                <tr>
                    <td class="tbody-style" width="7%">HCTI</td>
                    <td class="tbody-style" width="5%">Yellow</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="position:absolute;top:7.27in;left:9.40in;width:8in;line-height:0.10in;">
        <img src="../node_modules/template/app/media/img/bg/logo_pdf.png" style="height:1%; width:20%;">
    </div>
</body>
</html>