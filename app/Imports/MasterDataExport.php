<?php

namespace App\Imports;

use App\MasterData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MasterDataExport implements ToModel,WithHeadingRow
{
    public $data = [];
    public function model(array $row)
    {
    //     $upload=new MasterData();
    //     $has_entry=false;
    //    if( $upload->check_entry($row) > 0)
    //    {
    //         $has_entry=true;
    //    }
    
    //     if($row['ticketissuetime']!='' || $row['ticketissuetime']!=null)
    //     {
            // $upload=$upload->update_master_data($row,$has_entry);
        // }
        array_push( $this->data,$row);
    }

    public function get_data()
    {
        return $this->data;
    }
  
}
