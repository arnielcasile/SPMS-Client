<?php

namespace App;
use \DB;
use Illuminate\Database\Eloquent\Model;

class LeadtimeMail extends Model
{
    //
    public function load_area_code()
    {
        return DB::table('area')
        ->get();
    }

    public function load_recipients()
    {
        return DB::table('email_managements')
        ->get();
    }

    public function search_range_forecast($where, $area_code)
    {
        return DB:: table('forecast')
                ->wherebetween('date_forecast', [$where['date_from'],$where['date_to']])
                ->where('area_code' , $area_code)
                ->get();
    }

    public function get_last_record($no_records,$wh_class)
    {
        return DB:: table('master_data')
                ->select('ticket_issue_date')
                ->distinct('ticket_issue_date')
                ->where('warehouse_class', $wh_class)
                ->orderby('ticket_issue_date','DESC')
                ->limit($no_records)
                ->get();
    }
    
    public function get_delivered($where, $area_code)
    {
        return DB:: table('master_data as a')
                ->select(DB::Raw('DATE(c.created_at) as created_at'),DB::Raw('count(c.created_at) as count_created_at'))
                ->join('palletizings as b', 'b.ticket_no','a.ticket_no')
                ->join('delivery as c', 'c.dr_control','b.dr_control')
                ->join('process_masterlists as d', 'a.process_masterlist_id','d.id')
                ->where('a.warehouse_class', $area_code)
                ->where('a.ticket_issue_date',$where)
                ->where('a.process_masterlist_id','6')
                ->groupby(DB::Raw('DATE(c.created_at)'))
                ->get();
    }

    public function in_process($where, $area_code)
    { 
        return DB:: table('master_data as a')
                ->select('a.ticket_issue_date','b.process',DB::Raw('count(a.process_masterlist_id)'))
                ->distinct('a.process_masterlist_id')
                ->join('process_masterlists as b', 'a.process_masterlist_id','b.id')
                ->where('a.warehouse_class', $area_code)
                ->where('a.ticket_issue_date',$where)
                ->where('a.process_masterlist_id','<>','6')
                ->groupby('a.ticket_issue_date','b.process')
                ->get();
    }

    public function actual_leadtime($where, $area_code)
    { 
        return DB:: table('remarks')
                ->select('remarks')
                ->where('area_code',$area_code)
                ->where('issued_date',$where)
                ->get();
    }

    public function sum_ticket_count_summary($from, $to, $area_code)
    { 
        return DB:: table('master_data as a')
                ->select('c.payee_name','a.ticket_issue_date','b.process','a.process_masterlist_id',DB::Raw('count(c.payee_name)'))
                ->distinct('c.payee_name')
                ->join('process_masterlists as b', 'a.process_masterlist_id','b.id')
                ->join('destination_masterlist as c', 'a.destination_code','c.payee_cd')
                ->where('a.warehouse_class',$area_code)
                ->wherebetween('a.ticket_issue_date', [$from, $to])
                ->groupby('c.payee_name','b.process','a.ticket_issue_date','a.process_masterlist_id')
                ->orderby('a.process_masterlist_id','asc')  
                ->orderby('a.ticket_issue_date','desc')
                ->get();
    }

    public function sum_ticket_quantity($date_to,$date_from,$area_code)
    { 
        return DB:: table('master_data as a')
                ->select('c.payee_name',DB::Raw('sum(a.delivery_qty)'),'a.ticket_issue_date')
                ->distinct('c.payee_name')
                ->join('destination_masterlist as c', 'a.destination_code','c.payee_cd')
                ->wherebetween('a.ticket_issue_date', [$date_from,$date_to])
                ->groupby('c.payee_name','a.ticket_issue_date')
                ->orderby('a.ticket_issue_date','desc')
                ->where('a.warehouse_class',$area_code)
                ->get();
    }
    public function remarks_am($date, $area_code)
    { 
        return DB:: table('master_data as a')
                ->select(DB::Raw('count(a.*)'))
                ->where('a.warehouse_class',$area_code)
                ->wherebetween('a.ticket_issue_time', ['00:00:00','11:59:59'])
                ->where('a.ticket_issue_date',$date)
                ->get();
    }
    public function remarks_pm($date, $area_code)
    { 
        return DB:: table('master_data as a')
                ->select(DB::Raw('count(a.*)'))
                ->where('a.warehouse_class',$area_code)
                ->wherebetween('a.ticket_issue_time', ['12:00:00','23:59:59'])
                ->where('a.ticket_issue_date',$date)
                ->get();
    }
}
