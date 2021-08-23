<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterData extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'master_data';

    protected $fillable = 
    [
        
    ];
    
    public function get_master_data()
    {
        return MasterData::all();
    }
   
    public function check_entry($where)
    {
        return MasterData::where('ticket_no',$where)
        ->whereNotNull('ticket_issue_time')
        ->count();
    }

    public function update_master_data($data)
    {
        
        $result = MasterData::where('ticket_no',$data['ticketno'])
        ->update(
            [
                'ticket_issue_time'=>$data['ticketissuetime'],
            ]);  
    }
}
