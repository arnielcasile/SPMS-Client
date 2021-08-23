<html>
    <head>
        <Style>
            .collapse
            {
                border-collapse: collapse;
            }

            .white
            {
                background-color:white;
            }

            .yellow-bold
            {
                font-weight: bold;
                background-color:yellow;
            }
            .light-yellow-bold
            {
                font-weight: bold;
                background-color:#FFFFAA;
            }
            .blue-bold
            {
                font-weight: bold;
                background-color:#101E8E;
                color:white;
                border:1px solid black;
                height:38px;
            }
            .light-blue-bold
            {
                font-weight: bold;
                background-color: #004482;
                color:white;
                border:1px solid black;
                height:23px;
            }
           
            .sky-blue
            {
                background-color:#BFE9F9;
                /* font-weight: bold; */
                color:black;
                border:1px solid black;
                height:23px;
                
            }

            tr.noBorder td 
            {
            border: 0px solid #F3F4F9;
            background-color: #F3F4F9;
            }

            tr.noBorder-last td:last-child {
            border-right :none;
            border-top :none;
            border-bottom :none;
            background-color: #F3F4F9;
            }

            table tr td
            {
                border:1px solid black;
                background-color:white;
            }
            body
            {
                
                color:#231F20; 
                background: url("{{ $message->embed(asset('/icons/pdls_email_bg_copy.png')) }}");
                background-size:contain; 
                background-repeat: no-repeat; 
                font-family:'Segoe UI';
                font-size:13px;
                background-color: #F3F4F9;
            }
            .main-table
            {
                vertical-align:middle; 
                border: 0px;
                position: relative;
                background-color: #F3F4F9;
            }

              /* .main-table-header
            {
                vertical-align:middle; 
                border: 0px;
                background: url("{{ $message->embed(asset('/icons/pdls_email_bg_copy.png')) }}");
            } */

            .font-bold-header
            {
              font-weight: bold;
              font-size: 25px;
              display: inline;
            }
            .small-image
            {
                margin: 0; 
                border: 0; 
                padding: 0; 
                display: block;
            }
            .bg-test
            {
                background: url("{{ $message->embed(asset('/icons/pdls_email_bg_copy.png')) }}");
            }

        </Style>
    </head>
    <body>
        <center>
           
            <table class="collapse main-table" width="100%"> {{--ALIGNMENT TABLE--}}   
            <tr class="main-table-header">
                <td class="main-table" width="60%" style="vertical-align: top;" align="left">
                        &nbsp;&nbsp;&nbsp;<small style="color:#231F20; font-weight:bold; font-size:15px;">{{$data['date']}}</small>
                </td>
                <td class="main-table" width="40%" align="left">
                    <table class="collapse white" border='1px' style="border:1px solid #182835" width="100%">{{--REMARKS TABLE--}}
                        <tr>
                            <td class="light-blue-bold font-bold-header" height="25px;" align='left' colspan='3'><h3 style="display: inline;">&nbsp;&nbsp;Remarks</h3></td>
                          
                        </tr>       

                        <tr>
                            <td align='center' class="sky-blue">AM ISSUANCE</td>
                            <td align='center'>{{$data['remarks_AM'][0]->count}}</td>
                            <td align='center'>ALREADY ISSUE</td>
                        </tr>

                        <tr>
                            <td align='center' class="sky-blue">PM ISSUANCE</td>
                            <td align='center'>{{$data['remarks_PM'][0]->count}}</td>
                            <td align='center'>ALREADY ISSUE</td>
                        </tr>

                        <tr>
                            <td align='center' class="sky-blue">TOTAL</td>
                            <td align='center'>{{$data['remarks_AM'][0]->count + $data['remarks_PM'][0]->count }}</td>
                            <td align='center'>ALREADY ISSUE</td>
                        </tr>
                    </table>
                </td>
            </tr>
                <td class="main-table" align="center" colspan='2'>
                    <br>
                    <br>          
                    <table class="main-table" width="100%">
                        <tr class="main-table">
                            <td class="main-table" width="33.33%">
                            </td>
                            <td class="main-table" width="33.33%" align="center">
                                <span class="font-bold-header">{{$data['area_code']}} SUMMARY</span><br>
                                {{-- <small>Please see link and below data for {{$data['area_code']}} -Parts Delivery Status Monitoring</small> --}}
                            </td>
                            <td class="main-table" width="33.33%" align="center">
                                 
                            </td>
                        </tr>
                    </table>
                    {{-- <br> --}}
                    @if(count($data['forecast'])>1)
                        <table class="collapse white" border='1px' style="text-align:center; border:1px solid black" width="90%">            
                            <tr>
                                <td class="light-blue-bold" height="25px;">SUMMARY OF FORECAST</td>
                                <td colspan={{count($data['forecast'])-1}} class="light-blue-bold">{{$data['month_year']}}</td>{{-- dynamic --}}
                                <td rowspan='2' class="light-blue-bold">GRAND TOTAL</td>
                            </tr>
                            
                            <tr>
                                <td></td>

                                @for($x=0;$x<count($data['forecast'])-1;$x++)
                                <td>{{$data['forecast'][$x]['dates']}}</td>
                                @endfor
                            </tr>

                        
                            <tr>
                                <td height="25px;" class="light-blue-bold">TOTAL</td>
                                @for($x=0;$x<count($data['forecast'])-1;$x++)
                                <td class="sky-blue">{{$data['forecast'][$x]['qty']}}</td>
                                @endfor
                              
                                <td class="light-blue-bold">{{$data['forecast'][count($data['forecast'])-1]['grand_total']}}</td>
                            </tr>
                        </table>
                        @else
                        <table class="collapse white" border='1px' style="text-align:center; border:1px solid black" width="90%">            
                            <tr>
                                <td class="light-blue-bold" height="25px;">SUMMARY OF FORECAST</td>
                            </tr>
                            <tr>
                                <td height="50px;">No summary of forecast for this week.</td>
                            </tr>
                        </table>
                        @endif
                </td>
            </tr>
            {{-- @foreach($data['sum_ticket_count_delivered'] as $ticket_count_delivered_key => $value)
                @foreach($data['sum_ticket_count_delivered'][$ticket_count_delivered_key] as $sub_ticket_count_delivered_key => $sub_value)
                    @php
                    $count_y_dates=count($data['sum_ticket_count_delivered'][$ticket_count_delivered_key])
                    @endphp
                @endforeach
            @endforeach --}}
            @php
            $count_y_dates=[];
            @endphp
            @foreach($data['dates_covered'] as $dates_key => $dates_value)
               
               @php
                   $count_y_dates[]=$dates_value;
               @endphp
            @endforeach

                <tr class="main-table">
                    <td class="main-table" align="center" colspan='2'>
                        <br>  <br>
                        <table class="collapse" border='1px' style="text-align:center; border:1px solid black" width="90%">            
                            <tr>
                                <td colspan='{{count($count_y_dates)+3}}' height="25px;" class="light-blue-bold">TARGET LEADTIME: 1 DAY</td>{{-- dynamic --}}
                            </tr>

                            <tr>
                                <td colspan='2' height="25px;" class="light-blue-bold">SUM OF TICKET COUNT</td>
                                <td colspan='{{count($count_y_dates)}}' class="sky-blue">ISSUE DATE</td>
                                <td rowspan='2' class="light-blue-bold">GRAND TOTAL</td>
                            </tr>

                            <tr>
                                @php
                                    $y_dates=[];
                                @endphp

                                <td height="25px;" class="sky-blue">DATE DELIVERED</td>
                                <td height="25px;" class="sky-blue">STATUS</td>
                                @foreach($data['dates_covered'] as $dates_key => $dates_value)
                                    <td>{{$dates_value->ticket_issue_date}}</td>
                                    @php
                                        $y_dates[]=$dates_value->ticket_issue_date; 
                                    @endphp
                                @endforeach
                                {{-- @foreach($data['sum_ticket_count_delivered'] as $ticket_count_delivered_key => $value)
                                    @if(count($data['sum_ticket_count_delivered'][$ticket_count_delivered_key])>0)
                                        @foreach($data['sum_ticket_count_delivered'][$ticket_count_delivered_key] as $sub_ticket_count_delivered_key => $sub_value)
                                            @if( ($ticket_count_delivered_key === array_key_first($data['sum_ticket_count_delivered'])) )
                                            @php
                                                $y_dates[]=$sub_ticket_count_delivered_key; 
                                            @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach --}}
                               
                             
                            </tr>
                            @php
                            $x_grand_total=0;
                            $y_grand_total=0;
                            $y_loop_count=0;
                            $grand_total=0;
                            @endphp
                            @foreach($data['sum_ticket_count_in_process'] as $ticket_count_in_process_key => $value)
                                <tr>
                                        <td>IN PROCESS</td>
                                        <td>{{$ticket_count_in_process_key}}</td>
                                    @foreach($data['sum_ticket_count_in_process'][$ticket_count_in_process_key] as $sub_ticket_count_in_process_key => $sub_ticket_count_in_process_value)
                                            @php
                                                $x_grand_total+=$sub_ticket_count_in_process_value['0'];
                                                $grand_total+=$sub_ticket_count_in_process_value['0']
                                            @endphp
                                                <td>
                                                    @if($sub_ticket_count_in_process_value['0']>0)
                                                        {{$sub_ticket_count_in_process_value['0']}}
                                                    @endif  
                                                </td>
                                    @endforeach
                                    <td class="sky-blue">{{$x_grand_total}}</td>
                                    @php
                                    
                                    $x_grand_total=0;
                                    @endphp
                                </tr>
                            @endforeach
                            @php
                            $x_grand_total=0;
                            $y_grand_total=0;
                            $y_loop_count=0;
                            @endphp
                            @foreach($data['sum_ticket_count_delivered'] as $ticket_count_delivered_key => $value)
                                @if(count($data['sum_ticket_count_delivered'][$ticket_count_delivered_key])>0)
                                    <tr>
                                            <td>{{$ticket_count_delivered_key}}</td>
                                            <td>DELIVERED</td>
                                        @foreach($data['sum_ticket_count_delivered'][$ticket_count_delivered_key] as $sub_ticket_count_delivered_key => $sub_ticket_count_delivered_value)
                                                @php
                                                    $x_grand_total+=$sub_ticket_count_delivered_value['0'];
                                                    $grand_total+=$sub_ticket_count_delivered_value['0']
                                                @endphp
                                                    <td>
                                                        @if($sub_ticket_count_delivered_value['0']>0)
                                                            {{$sub_ticket_count_delivered_value['0']}}
                                                        @endif  
                                                    </td>
                                        @endforeach
                                        <td class="sky-blue">{{$x_grand_total}}</td>
                                        @php
                                        
                                        $x_grand_total=0;
                                        @endphp
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td height="25px;"  colspan='2' class="light-blue-bold">GRAND TOTAL</td>
                                @for($i=0;$i<count($y_dates);$i++)

                                    @foreach($data['sum_ticket_count_delivered'] as $ticket_count_delivered_key => $value)
                                        @if(count($data['sum_ticket_count_delivered'][$ticket_count_delivered_key])>0)
                                            @php
                                                $y_grand_total+=$data['sum_ticket_count_delivered'][$ticket_count_delivered_key][$y_dates[$i]]['0'];
                                            @endphp
                                        @endif
                                     
                                    @endforeach
                                    @foreach($data['sum_ticket_count_in_process'] as $ticket_count_in_process_key => $value)
                                        @if(count($data['sum_ticket_count_in_process'][$ticket_count_in_process_key])>0)
                                            @php
                                                $y_grand_total+=$data['sum_ticket_count_in_process'][$ticket_count_in_process_key][$y_dates[$i]]['0'];
                                            @endphp
                                        @endif
                                    @endforeach
                                    <td class="sky-blue">{{$y_grand_total}}</td>
                                    @php
                                    $y_grand_total=0;
                                    @endphp

                                @endfor
                                    <td class="light-blue-bold">{{$grand_total}}</td>
                            </tr>
                            <tr class="noBorder">
                                <td style="border-left:0px;"></td>
                                <td></td>
                                @foreach($data['actual_leadtime'] as $actual_leadtime_key => $actual_leadtime_value)
                                    <td width="10%">
                                        <img class="small-image" width="40" height="55" src="{{ $message->embed(asset('/icons/arrow_down.png')) }}"/>
                                    </td>
                                @endforeach
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan='2' height="40px" class="light-blue-bold">ACTUAL LEADTIME</td>
                                <td style="border-top: 0px solid #F3F4F9; background-color: #F3F4F9; border-right: 0px solid white"colspan='{{count($data['actual_leadtime'])}}'></td>
                                <td style="border: 0px solid #F3F4F9; background-color: #F3F4F9;"></td>
                            </tr>
                            <tr>
                                <td colspan='2' height="40px" class="sky-blue">REASON</td>
                            @foreach($data['actual_leadtime'] as $actual_leadtime_key => $actual_leadtime_value)
                                <td class="sky-blue">
                                    {{$actual_leadtime_value['0']->remarks}}
                                </td>
                            @endforeach
                            <td style="border: 0px solid #F3F4F9; background-color: #F3F4F9;"></td>
                            </tr>
                        </table>
                        <br><br>
                        <table class="collapse" border='1px' style="text-align:center; border:1px solid black" width="90%">    
                        @php
                        $count=0;
                        $count_=0;
                        $y_dates=[];
                        @endphp
                        @foreach($data['sum_ticket_count_summary'] as $sum_ticket_count_summary_key => $sum_ticket_count_summary_value)
                            @foreach($data['sum_ticket_count_summary'][$sum_ticket_count_summary_key] as $sub_summary_key => $sub_summary_value)
                                @foreach($data['sum_ticket_count_summary'][$sum_ticket_count_summary_key][$sub_summary_key] as $low_sub_summary_key => $low_sub_summary_value)
                                    @if($count==0)
                                        @php
                                            $y_dates[]=$low_sub_summary_key; 
                                        @endphp
                                    @endif                                     
                                @endforeach
                                @php
                                $count+=1;
                            @endphp
                            @endforeach
                        @endforeach        
                        <tr>
                            <td colspan='2' height='40px' class="light-blue-bold">SUM OF TICKET COUNT</td>
                            <td colspan='{{count($y_dates)}}' class="sky-blue">ISSUE DATE</td>
                            <td rowspan='2' class="light-blue-bold">GRAND TOTAL</td>
                        </tr>
                        <tr>
                            <td height="25px;" class="sky-blue">STATUS</td>
                            <td height="25px;" class="sky-blue">PAYEE NAME</td>
                            @foreach($data['sum_ticket_count_summary'] as $sum_ticket_count_summary_key => $sum_ticket_count_summary_value)
                                @foreach($data['sum_ticket_count_summary'][$sum_ticket_count_summary_key] as $sub_summary_key => $sub_summary_value)
                                    @foreach($data['sum_ticket_count_summary'][$sum_ticket_count_summary_key][$sub_summary_key] as $low_sub_summary_key => $low_sub_summary_value)
                                        @if($count_==0)
                                            <td>{{$low_sub_summary_key}}</td>
                                        @endif                                     
                                    @endforeach
                                    @php
                                        $count_+=1;
                                    @endphp
                                @endforeach
                            @endforeach
                        </tr>
                          @php
                              $x_grand_total=0;
                              $y_grand_total=0;
                              $grand_total=0;
                          @endphp                         
                            @foreach($data['sum_ticket_count_summary'] as $sum_ticket_count_summary_key => $sum_ticket_count_summary_value)
                                @foreach($data['sum_ticket_count_summary'][$sum_ticket_count_summary_key] as $sub_summary_key => $sub_summary_value)
                                <tr>
                                    <td>{{$sum_ticket_count_summary_key}}</td>
                                    <td>{{$sub_summary_key}}</td>
                                    @foreach($data['sum_ticket_count_summary'][$sum_ticket_count_summary_key][$sub_summary_key] as $low_sub_summary_key => $low_sub_summary_value)
                                        <td>
                                            @if($low_sub_summary_value!=0)
                                            {{$low_sub_summary_value}}
                                            @endif
                                        </td>
                                        @php
                                            $grand_total+=$low_sub_summary_value;
                                            $x_grand_total+=$low_sub_summary_value;
                                        @endphp
                                    @endforeach
                                    <td class="sky-blue">{{$x_grand_total}}</td>             
                                    @php
                                        $x_grand_total=0;
                                    @endphp             
                                </tr>
                                @endforeach
                            @endforeach

                           <tr>
                                <td colspan='2' height="40px" class="light-blue-bold">GRAND TOTAL</td>
                                @for($i=0;$i<count($y_dates);$i++)
                                    @foreach($data['sum_ticket_count_summary'] as $sum_ticket_count_summary_key => $sum_ticket_count_summary_value)
                                        @foreach($data['sum_ticket_count_summary'][$sum_ticket_count_summary_key] as $sub_summary_key => $sub_summary_value)
                                            @php     
                                                $y_grand_total+=$data['sum_ticket_count_summary'][$sum_ticket_count_summary_key][$sub_summary_key][$y_dates[$i]]
                                            @endphp    
                                        @endforeach
                                    @endforeach
                                    <td class="sky-blue">{{$y_grand_total}}</td>           
                                    @php
                                    $y_grand_total=0;
                                    @endphp  
                                @endfor
                                <td class="light-blue-bold">{{$grand_total}}</td>
                           </tr>
 
                        </table>
                        <br><br>
                        <table class="collapse" border='1px' style="text-align:center; border:1px solid black" width="90%">   
                             @php
                                $y_dates = [];
                                $x_grand_total=0;
                                $y_grand_total=0;
                                $grand_total=0;
                                $count=0;
                                $count_=0
                            @endphp
                                @foreach($data['sum_ticket_quantity'] as $ticket_quantity_key => $ticket_quantity_value)
                                    @foreach($data['sum_ticket_quantity'][$ticket_quantity_key] as $sub_ticket_quantity_key => $sub_ticket_quantity_value)
                                        @if($count==0)
                                            @php
                                                $y_dates[]=$sub_ticket_quantity_key; 
                                            @endphp
                                        @endif      
                                    @endforeach
                                    @php
                                        $count+=1;
                                     @endphp
                                @endforeach         
                            <tr>
                                <td height="40px" class="light-blue-bold">SUM OF TICKET QTY</td>
                                <td colspan='{{count($y_dates)}}' class="sky-blue">ISSUE DATE</td>
                                <td rowspan='2' class="light-blue-bold">GRAND TOTAL</td>
                            </tr>
                            <tr>
                                <td height="40px" class="sky-blue">PAYEE NAME</td>
                                @foreach($data['sum_ticket_quantity'] as $ticket_quantity_key => $ticket_quantity_value)
                                    @foreach($data['sum_ticket_quantity'][$ticket_quantity_key] as $sub_ticket_quantity_key => $sub_ticket_quantity_value)
                                        @if($count_==0)
                                            <td>{{$sub_ticket_quantity_key}}</td>
                                        @endif      
                                    @endforeach
                                    @php
                                        $count_+=1;
                                    @endphp
                                @endforeach     
                            </tr>
                          
                                @foreach($data['sum_ticket_quantity'] as $ticket_quantity_key => $ticket_quantity_value)
                                    <tr>
                                        <td>{{ $ticket_quantity_key}}</td>
                                        @foreach($data['sum_ticket_quantity'][$ticket_quantity_key] as $sub_ticket_quantity_key => $sub_ticket_quantity_value)
                                            <td>
                                                @if($sub_ticket_quantity_value!=0)
                                                    {{$sub_ticket_quantity_value}}
                                                @endif
                                            </td>  
                                            @php
                                               $x_grand_total+=$sub_ticket_quantity_value;
                                               $grand_total+=$sub_ticket_quantity_value;
                                            @endphp
                                        @endforeach                                    
                                        <td class="sky-blue">{{$x_grand_total}}</td>
                                        @php
                                        $x_grand_total=0;
                                    @endphp
                                    </tr>
                                @endforeach         

                            <tr>

                                <td height="40px" class="light-blue-bold">GRAND TOTAL</td>
                                @for($i=0;$i<count($y_dates);$i++)
                                    @foreach($data['sum_ticket_quantity'] as $ticket_quantity_key => $ticket_quantity_value)
                                        @php
                                            $y_grand_total+=$data['sum_ticket_quantity'][$ticket_quantity_key][$y_dates[$i]];
                                        @endphp
                                    @endforeach
                                    <td class="sky-blue">{{$y_grand_total}}</td>
                                    @php
                                    $y_grand_total=0;
                                    @endphp
                                @endfor
                                <td class="light-blue-bold">{{$grand_total}}</td>

                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
            <br><br>
            <hr>
            <br>       
            <label style="font-size:14px">
                This is a system-generated notice from PDLS. Please do not reply. 
                Replies to this message are routed to an unmonitored mailbox. If you have any questions, please e-mail G07D-FDTP-MIT@ph.fujitsu.com
            </label>
            <br>
            <br>
            <hr>
            <label>
                "Don't do unto others what you don't want others do unto you." 
            </label>
            <br>
            <label>
                Team Brown without Brown
            </label>
            <br><br>
        </center>
      
       
    </body>
</html>