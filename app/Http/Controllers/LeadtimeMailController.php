<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeadtimeMonitoringMail;
use App\LeadtimeMail;
use App\EmailManagement;
use DB;
use Carbon\Carbon;

class LeadtimeMailController extends Controller
{
    //
    //
    protected $no_records = 5;
    public function __construct()
    {
        $this->leadtimemail = new LeadtimeMail();
    }
    public function send_email()
    {
        $area_code=$this->leadtimemail->load_area_code();
        foreach($area_code as $area_code_key => $area_code_value)
        {
            $data=[];
            if($area_code_value->deleted_at == null)
            {
                if(count($this->leadtimemail->get_last_record($this->no_records, $area_code_value->area_code))>0)
                {
                        $now                             = Carbon::now();
                    $data['month_year']                  = Carbon::parse($now)->format('F Y');
                    $data['date']                        = Carbon::parse($now)->format('F d Y');
                    $data['area_code']                   = $area_code_value->area_code;
                    $data['forecast']                    = $this->summary_forecast($area_code_value->area_code);
                    $data['sum_ticket_count_delivered']  = $this->sum_ticket_count('delivered', $area_code_value->area_code);
                    $data['sum_ticket_count_in_process'] = $this->sum_ticket_count('in_process', $area_code_value->area_code);
                    $data['dates_covered']               = $this->leadtimemail->get_last_record($this->no_records, $area_code_value->area_code);
                    $data['actual_leadtime']             = $this->actual_leadtime($area_code_value->area_code);
                    $data['sum_ticket_count_summary']    = $this->sum_ticket_count_summary($area_code_value->area_code);
                    $data['sum_ticket_quantity']         = $this->sum_ticket_quantity($area_code_value->area_code);
                    $data['remarks_AM']                  = $this->remarks('AM',$area_code_value->area_code);
                    $data['remarks_PM']                  = $this->remarks('PM',$area_code_value->area_code);
                    $arr = [];
                    $email_list= $this->leadtimemail->load_recipients(); 
                    
                    foreach($email_list as $email_key => $email_value)
                    {
                        if($email_value->deleted_at == null)
                        {
                         $arr['emails'][]=$email_value->email;
                     
                        }
                    }
                    $arr['area_code'][0]=$area_code_value->area_code;
                   
                    Mail::send('MAIL.leadtime_monitoring',["data"=>$data], function($message) use ($arr)
                    {    
                        $message->from('pdls-v3@fujitsu.com','PDLS V3- '.$arr['area_code'][0]);
                        $message->subject('Leadtime Monitoring'); 
                        $message->to($arr['emails']);
                    
                    });
                    // var_dump( Mail:: failures());
                    // exit;
                
                }
            }
        }
           
       
    }
    public function remarks($time, $area_code)
    { 
        $now= Carbon::now();
        $curr_date = Carbon::parse($now)->format('Y-m-d');
        if($time=='AM')
        {
            $get_record = $this->leadtimemail->remarks_am($curr_date, $area_code);
        }
        else
        {
            $get_record = $this->leadtimemail->remarks_pm($curr_date, $area_code);
        }
        return $get_record;
    }
    public function actual_leadtime($area_code)
    {
        try
        {
            DB:: beginTransaction();
            $result    = [];
            $get_dates = $this->leadtimemail->get_last_record($this->no_records, $area_code);
            foreach($get_dates as $get_dates_key => $value)
            {
                $data=[
                        'issued_date' => $value->ticket_issue_date
                    ];
                    $remarks = $this->leadtimemail->actual_leadtime($data, $area_code);
                    if(count($remarks)!=0)
                    {
                        $result[$value->ticket_issue_date] = $remarks;
                    }
                    else
                    {
                        // $result[$value->ticket_issue_date][]=['remarks'=>'-'];
                        $result[$value->ticket_issue_date][] = (object) array(
                            'remarks' => '',
                        );
                    }
                
            }
            DB:: commit();
        }
        catch (\Throwable $th)
        {
            DB:: rollback();

            return response()
            ->json([
            'status'  => 0,
            'message' => $th->getMessage(),
            'data'    => '',
            ]);
        }
        return $result;
    }

    public function sum_ticket_count($status, $area_code)
    {
        
        try
        {
            DB:: beginTransaction();
            $result                = [];
            $dates                 = [];
            $stat                  = ['FOR CHECKING','FOR PALLETIZING', 'ON GOING PALLETIZING','FOR DELIVERY', 'FOR DR MAKING'];
            $data_array_delivered  = [];
            $data_array_in_process = [];
            $proc_diff             = [];
            $get_dates             = $this->leadtimemail->get_last_record($this->no_records, $area_code);
            foreach($get_dates as $get_dates_key => $value)
            {
                if($status=="delivered")
                {
                    $data=[
                            'ticket_issue_date' => $value->ticket_issue_date
                        ];
  
                        $result[$value->ticket_issue_date] = $delivery_count = $this->leadtimemail->get_delivered($data, $area_code);
                        foreach($delivery_count as $get_count => $sub_value)
                        {
                            $dates[] = $sub_value->created_at;
                        }     
                        $dates = array_unique($dates);
                }        
                else
                {
                    $data=[
                        'ticket_issue_date' => $value->ticket_issue_date
                    ];
                    $result[$value->ticket_issue_date] = $delivery_count = $this->leadtimemail->in_process($data, $area_code);
                    foreach($delivery_count as $get_count => $sub_value)
                    {
                        $proc_diff[] = $sub_value->process;
                    }    
                    $proc_diff = array_unique($proc_diff);
                }
            }
            $stat = array_intersect($stat,$proc_diff);
            foreach ($dates as $key => $part) {//sort from low to high dates
                $sort[$key] = strtotime($part);
           }
           if($status=="delivered")
           {
               if(count($dates)>0)
               {
                    array_multisort($sort, SORT_DESC, $dates);
                    foreach($dates as $dates_keys => $dates_values)//row date
                    {
                        $x_date = $dates_values;
                        foreach($get_dates as $get_dates_key => $value)//column date
                        {
                                                $y_date           = $value->ticket_issue_date;
                            $data_array_delivered[$x_date][$y_date] = [0=>'0'];
                        }
                    }
                    foreach($result as $result_key => $result_value)//column date
                    {
                        foreach($result[$result_key] as $sub_result_key => $sub_result_value)//row date
                        {
                                $data_array_delivered[$sub_result_value->created_at][$result_key] = [$sub_result_value->count_created_at];
                        }
                    }
                    return $data_array_delivered;
                }
            }
            else
            {
                foreach($stat as $stat_keys => $stat_values)//row date
                {
                    $x_stat = $stat_values;
                    foreach($get_dates as $get_dates_key => $value)//column date
                    {
                                               $y_date           = $value->ticket_issue_date;
                        $data_array_in_process[$x_stat][$y_date] = [0=>'0'];
                    }
                }
                foreach($result as $result_key => $result_value)//column date
                {
                    foreach($result[$result_key] as $sub_result_key => $sub_result_value)//row date
                    {
                            $data_array_in_process[$sub_result_value->process][$result_key] = [$sub_result_value->count];
                    }
                }
                return $data_array_in_process; 
            }
           
            DB:: commit();
        }

        catch (\Throwable $th)
        {
            DB:: rollback();

            return response()
            ->json([
            'status'  => 0,
            'message' => $th->getMessage(),
            'data'    => '',
            ]);
        }
        $result = array_combine( array_reverse(array_keys($result)) , $result);
        return $result;
    }

    public function summary_forecast($area_code)
    {
        Carbon::setWeekEndsAt(Carbon::SATURDAY);//set the last week to saturday
        $monday = Carbon::now()->startOfWeek();
        $saturday = Carbon::now()->endOfWeek();

        $monday = Carbon::parse($monday)->format('Y-m-d');
        $saturday = Carbon::parse($saturday)->format('Y-m-d');

        $data = 
            [
                'date_from' => $monday,
                'date_to'   => $saturday,
                'area_code' => $area_code,
            ];     
        try
        {
            DB:: beginTransaction();
            $result      = [];
            $grand_total = 0;
            $forecast    = $this->leadtimemail->search_range_forecast($data, $area_code);
            foreach($forecast as $forecast_key => $value)
            {
                        $grand_total += $value->qty;
                $result[]             = 
                [
                    'dates' => $value->date_forecast,
                    'qty'   => $value->qty,
                ];
            }
            $result[] = 
                [
                    'grand_total' => $grand_total
                ];
            
            DB:: commit();
        }
        catch (\Throwable $th)
        {
            DB:: rollback();

            return response()
            ->json([
            'status'  => 0,
            'message' => $th->getMessage(),
            'data'    => '',
            ]);
        }

        return $result;
    }

    public function sum_ticket_count_summary($area_code)
    {
        $get_dates = $this->leadtimemail->get_last_record($this->no_records, $area_code);
        $data_array = [];
        $date_from;
        $date_to;
        $count=0;
        foreach($get_dates as $get_dates_key => $value)
        {
            if($count==0)
            {
                $date_to=$value->ticket_issue_date;
            }
            if(end($get_dates))
            {
                $date_from=$value->ticket_issue_date;
            }
           
            $count+=1;
        }
        $result= $delivery_count = $this->leadtimemail->sum_ticket_count_summary($date_from, $date_to, $area_code);
        foreach($result as $result_key => $result_values)//row date
        {
            foreach($get_dates as $get_dates_key => $value)
            {
                $data_array[$result_values->process][$result_values->payee_name][$value->ticket_issue_date]='0';
            }
        }
        foreach($result as $result_key => $result_values)//row date
        {
            $data_array[$result_values->process][$result_values->payee_name][$result_values->ticket_issue_date]=$result_values->count;
        }
      
        return $data_array;
    }

    public function sum_ticket_quantity($area_code)
    {
        $get_dates = $this->leadtimemail->get_last_record($this->no_records, $area_code);
        $data_array = [];
        $date_from;
        $date_to;
        $count=0;
        foreach($get_dates as $get_dates_key => $value)
        {
            if($count==0)
            {
                $date_to=$value->ticket_issue_date;
            }
            if(end($get_dates))
            {
                $date_from=$value->ticket_issue_date;
            }
           
            $count+=1;
        }

        $result= $delivery_count = $this->leadtimemail->sum_ticket_quantity($date_to,$date_from,$area_code);
        foreach($result as $result_key => $result_values)//row date
        {
            foreach($get_dates as $get_dates_key => $value)
            {
                $data_array[$result_values->payee_name][$value->ticket_issue_date]='0';
            }
        }
        foreach($result as $result_key => $result_values)//row date
        {

            $data_array[$result_values->payee_name][$result_values->ticket_issue_date]=$result_values->sum;

        }
        return $data_array;
    }
}
