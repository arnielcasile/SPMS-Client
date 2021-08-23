<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class DrMaking extends Model
{
    protected $fillable = ['dr_control', 'users_id', 'pcase', 'box', 'bag', 'pallet','updated_at'];
   
    public function add_updated_at($where)
    {
        return DB:: table('dr_makings')
                    ->where($where)
                    ->update(['updated_at'=> date('Y-m-d H:i:s')]);    
    }

    public function select_updated_at($where)
    {
        return DB:: table('dr_makings as c')
                    ->select('c.updated_at as updated_at')
                    ->where($where)
                    ->first();
    }

    public function update_dr_makings($where,$data)
    {
        return DB::table('dr_makings as c')
                ->where($where)
                ->update($data);    
    }

    public function update_process($table,$where,$data)
    {
        return DB::table($table. ' as a')
                ->join('palletizings as b', 'a.ticket_no', 'b.ticket_no')
                ->join('dr_makings as c', 'b.dr_control', 'c.dr_control')
                ->where($where)
                ->update($data);
    }

    public function get_process($where)
    {
        return DB::table('palletizings as a')
                ->where($where)
                ->get();
    }

    public function load_data($where)
    {
        // return DB::table('palletizings as a')
        // ->leftjoin('master_data as b', 'b.ticket_no', 'a.ticket_no')
        // ->leftjoin('dr_makings as c', 'a.dr_control', 'c.dr_control')
        // ->leftjoin('destination_masterlist as d', 'b.destination_code', 'd.payee_cd')
        // ->leftjoin('checkings as e', function($q)
        // {
        //     $q->on("e.ticket_no", "=", "b.ticket_no");
            
        //     $q->on('a.process','=','e.process');
        // })
        // ->leftjoin('delivery_type_masterlists as f', 'f.id', 'a.delivery_type_id')
        // ->leftjoin('users as g', 'e.users_id', 'g.id')
        // ->leftjoin('irregularity as h', 'a.ticket_no' , 'h.ticket_no')
        // ->leftjoin('a.*', 'b.*', 'c.*','d.destination','d.payee_cd', 'e.*', 'f.*','g.*','h.*','h.ticket_no as ticket_no_irreg','b.ticket_no as ticket_no','c.created_at')
        // ->where($where)
        // ->get();

        return DB::table('master_data as a')
        ->leftjoin('irregularity as b', 'a.ticket_no', 'b.ticket_no')
        ->leftjoin('process_masterlists as d', 'b.process_masterlists_id', 'd.id')
        ->leftjoin('destination_masterlist as e', 'a.destination_code', 'e.payee_cd')
        ->leftjoin('palletizings as c', 'a.ticket_no', 'c.ticket_no')
        ->leftjoin('delivery_type_masterlists as g', 'g.id', 'c.delivery_type_id')
        ->leftjoin('checkings as h', function($q)
        {
            $q->on("c.ticket_no", "=", "h.ticket_no");
            
            $q->on('c.process','=','h.process');
        })
        ->leftjoin('dr_makings as j', 'c.dr_control', 'j.dr_control')
        ->join('users as i', 'h.users_id' , 'i.id')
        ->where('c.dr_control',$where)
        ->select(
            'a.order_download_no',
            'a.item_rev',
            'a.item_no',
            'a.item_name',
            'a.delivery_qty',
            'a.stock_address',
            'a.manufacturing_no',
            'a.product_no',
            'a.delivery_qty',
            'a.ticket_no',

            'b.discrepancy',
            'b.actual_qty',
            'b.ticket_no as ticket_no_irreg',
            'b.irregularity_type',

            'c.delivery_no',
            'c.created_at',
            
            'e.payee_cd',
            'e.destination',
            
            'g.delivery_type',
      
            'i.*',       
            
            'j.dr_control',
            'j.pallet',
            'j.pcase',
            'j.box',
            'j.bag',
            'j.delivery_status',
            'j.updated_at'
       
        )
        ->orderby('a.item_no','asc')
        ->distinct()
        ->get();
       
    }

    public function check_no_stock($where)
    {
        return DB::table('palletizings as a')
        ->join('master_data as b', 'b.ticket_no', 'a.ticket_no')
        ->join('dr_makings as c', 'a.dr_control', 'c.dr_control')
        ->leftjoin('irregularity as h', 'a.ticket_no' , 'h.ticket_no')
        ->select('b.ticket_no', 'c.dr_control','h.irregularity_type')
        ->where($where)
        ->get();
    }

    public function load_dr_making($where)
    {
        return DB::table('dr_makings as a')
                ->join('users as b', 'a.users_id', 'b.id')
                ->join('area as c', 'b.area_id', 'c.id')
                ->leftjoin('palletizings as d', 'a.dr_control', 'd.dr_control')
                ->leftjoin('master_data as e', 'd.ticket_no', 'e.ticket_no')
                ->leftjoin('destination_masterlist as f', 'e.destination_code', 'f.payee_cd')
                ->select('a.id', 'a.dr_control', 'f.destination as destination', DB::raw('(count(d.dr_control)) as total_ticket'))
                ->where($where)
                ->where('e.process_masterlist_id', 4)
                ->groupBy('a.id','d.dr_control','f.destination')
                ->get();
    }

    public function get_user($where)
    {
        return DB::table('users')
        ->select($where['position'])
        ->where($where['condition'])
        ->first();
    }
}
