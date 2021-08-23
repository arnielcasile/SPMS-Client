<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;


class Irregularity extends Model
{
    public $timestamps = true;
  
    protected $table = 'irregularity';
    protected $fillable = ['ticket_no', 'control_no', 'users_id', 'irregularity_type', 'actual_qty', 'discrepancy', 'remarks', 'process_masterlists_id'];

    public function select_barcode($where)
    {
        return DB::table('master_data as a')
                ->join('process_masterlists as b','a.process_masterlist_id','b.id')
                ->leftJoin('irregularity as c', 'c.ticket_no', 'a.ticket_no')
                ->select('a.order_download_no', 'a.stock_address', 'a.item_no', 'a.item_name', 'a.delivery_qty', 'a.process_masterlist_id', 'b.process', 'a.warehouse_class', 'c.ticket_no as irreg_ticket_no')
                ->where('a.ticket_no', $where)
                ->get();
    }

    public function generate_control_no($where)
    {
        // IRREG-C2-2019-0001

        $a = DB::table('irregularity')
            ->select('control_no')
            ->orderBy('id', 'DESC')
            ->get();

        $year = date('Y');
        
        if(count($a))
        {
            $warehouse =  $where['warehouse_class'];

            $query = Irregularity::where(\DB::raw('substr(control_no, 7, 3)'), '=', $warehouse)
                ->orderBy('id', 'DESC')          
                ->get();

            $query2 = Irregularity::where(\DB::raw('substr(control_no, 7, 2)'), '=', $warehouse)
                ->orderBy('id', 'DESC')          
                ->get();

            if(count($query))
            {
                $holder = explode('-', $query[0]->control_no);
                
                if($holder[2] == $year)
                {
                    $counter = $holder[3];

                    ($year === date('Y')) ? $counter++ : $counter = '0001';

                    switch(strlen($counter))
                    {
                        case 1: $counter = '000' . $counter;
                            break;
                        case 2: $counter = '00' . $counter;
                            break;
                        case 3: $counter = '0' . $counter;
                            break;
                        default: $counter = $counter;
                        break;
                    }
        
                    return 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-' . $counter;
                }
                else
                    return 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-0001';
                            
            }
            elseif(count($query2))
            {
                $holder = explode('-', $query2[0]->control_no);

                if($holder[2] == $year)
                {
                    $counter = $holder[3];

                    ($year === date('Y')) ? $counter++ : $counter = '0001';

                    switch(strlen($counter))
                    {
                        case 1: $counter = '000' . $counter;
                            break;
                        case 2: $counter = '00' . $counter;
                            break;
                        case 3: $counter = '0' . $counter;
                            break;
                        default: $counter = $counter;
                        break;
                    }
        
                    return 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-' . $counter;
                }
                else
                    return 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-0001';
            }
            else
             return 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-0001';

            // $holder = explode('-', $a[0]->control_no);
            
            // if($a[0]->control_no != "")
            // {
            //     $counter = $holder[3];

            //     ($year === date('Y')) ? $counter++ : $counter = '0001';

            //     switch(strlen($counter))
            //     {
            //         case 1: $counter = '000' . $counter;
            //             break;
            //         case 2: $counter = '00' . $counter;
            //             break;
            //         case 3: $counter = '0' . $counter;
            //             break;
            //         default: $counter = $counter;
            //         break;
            //     }
            //     // return response()->json(['control_no' => 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-' . $counter]);
            //     return 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-' . $counter;
            // }

            // // return response()->json(['control_no' => 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-0001']);
            // return 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-0001';
        }
        else
            return 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-0001';
            // return response()->json(['control_no' => 'IRREG-' . $where['warehouse_class'] . '-' . $year . '-0001']);
    }

    public function add_irregularity_item($data)
    {
        return Irregularity::create($data);
    }

    public function update_irregularity($data, $where)
    {
        return Irregularity::where($where)
            ->update($data);
    }

    // public function load_irregularity_item()
    // {
    //     return DB::table('irregularity as a')
    //             ->leftjoin('master_data as b', 'a.ticket_no', '=', 'b.ticket_no')
    //             ->select('a.ticket_no', 'a.irregularity_type', 'a.actual_qty', 'a.discrepancy', 'a.remarks', 'a.created_at', 'b.process_masterlist_id', 'b.stock_address', 'b.order_download_no', 'b.item_no', 'b.item_name', 'b.delivery_qty')
    //             ->whereDate('a.created_at', Carbon::now())
    //             ->get();
    // }
    
    public function load_irregularity($where_date, $where)
    {
        // return DB::table('master_data as a')
        // ->leftjoin('irregularity as b', 'b.ticket_no', 'a.ticket_no')
        // ->leftjoin('users as c', 'c.id', '=', 'b.users_id')
        // ->leftjoin('process_masterlists as e', 'a.process_masterlist_id', 'e.id')
        // ->leftjoin('process_masterlists as f', 'b.process_masterlists_id', 'f.id')
        // ->select('a.*','b.*', 'c.*', 'b.id as irreg_id', 'e.process as normal_status', 'f.process as irregularity_status')
        // // ->wherebetween('b.created_at', [$where_date['date_from'].' 00:00:00', $where_date['date_to'].' 23:59:59'])
        // ->wherebetween('a.created_at', [$where_date['date_from'].' 00:00:00', $where_date['date_to'].' 23:59:59'])
        // ->where($where)
        // ->get();   
        
        return DB::table('irregularity as a')
            ->leftJoin('master_data as b', 'b.ticket_no', 'a.ticket_no')
            ->leftjoin('users as c', 'c.id', '=', 'a.users_id')
            ->leftjoin('process_masterlists as e', 'b.process_masterlist_id', 'e.id')
            ->leftjoin('process_masterlists as f', 'a.process_masterlists_id', 'f.id')
            ->select('a.*', 'a.id as irreg_id', 'b.*', 'c.*', 'e.process as normal_status', 'f.process as irregularity_status')
            ->wherebetween('b.created_at', [$where_date['date_from'].' 00:00:00', $where_date['date_to'].' 23:59:59'])
            ->where($where)
            ->get();
    }
   
    public function delete_irregularity($where)
    {
        return Irregularity::where($where)
                        ->delete();
    }

    public function update_irregularity_status($where, $data)
    {
        return Irregularity::where($where)
                    ->update($data);
    }

    public function load_contro_no($where,$from,$to)
    {
        return DB::table('irregularity as a')
                    ->join('master_data as b', 'a.ticket_no', 'b.ticket_no')
                    ->select('a.*')
                    ->whereBetween('b.ticket_issue_date',[$from, $to])
                    ->where($where)
                    ->get();
    }

    public function load_reprint($where)
    {
        return DB::table('master_data as a')
            ->leftjoin('irregularity as b', 'b.ticket_no', 'a.ticket_no')
            ->leftjoin('users as c', 'c.id', '=', 'b.users_id')
            ->leftjoin('process_masterlists as e', 'a.process_masterlist_id', 'e.id')
            ->leftjoin('process_masterlists as f', 'b.process_masterlists_id', 'f.id')
            ->select('a.*','b.*', 'c.*', 'b.id as irreg_id', 'e.process as normal_status', 'f.process as irregularity_status','b.created_at as irreg_create')
            ->where($where)
            ->get();
    }

    public function select_whclass($where)
    {
        return DB::table('master_data')
                    ->select('warehouse_class')
                    ->where($where)
                    ->get();
    }


}
