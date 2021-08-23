<?php

namespace App\Http\Controllers;

use Excel;
use App\MasterData;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Imports\MasterDataExport;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->import = new MasterDataExport();
        $this->master = new MasterData();
        ini_set('max_execution_time', '0'); 
    }

    public function import(Request $request)
    {
       $data = 
            [
                "select_file"    => $request->select_file,
            ];

        $rule =
            [
                "select_file"    => 'required',  
            ];
        
        $validator = Validator::make($data, $rule);
        if ($validator->fails())
        {
            return response()
                ->json([
                    'status'    => 0,
                    'message'   => $validator->errors()->all(),
                    'data'      => '',
                ]);
        }
        else
        {
          Excel::import($this->import ,request()->file('select_file'));
          $data =$this->import->get_data();
          $status=0;
          $message;
          if (array_key_exists("ticketissuetime",$data[0]))
          { 
            $has_blanks     = 0;
            $has_characters = 0;
            $count=0;
            foreach($data as $data_key => $data_value)
            {
                if($data_value['ticketissuetime']=== null || $data_value['ticketissuetime']==='')
                {
                    if($this->master->check_entry($data_value['ticketno']) > 0)
                    {
                    $count+=1;
                    }
                    $this->master->update_master_data($data_value);
                }
                else
                {
                    if (DateTime::createFromFormat('H:i:s', $data_value['ticketissuetime']) !== FALSE) 
                    {
                        if($this->master->check_entry($data_value['ticketno']) > 0)
                        {
                        $count+=1;
                        }
                        $this->master->update_master_data($data_value);
                    } 
                    else
                    {
                        $has_characters+=1;
                    }
                }
            }
            if($has_characters>=1)
            {
                $message = "System detected an invalid time in ticket issue time. Please check your csv file and re-upload. Thank you.";
                $status  = 2;
            }
            else
            {
                $message= $count. " ticket number/s are already in the database. Updated successfully";
                $status  = 0;
            }
          
          }
          else
          {
            $message= "File is invalid. Please change your csv file.";  
            $status  = 1;
            
          }
          return response()
          ->json([
              'status'    => $status,
              'message'   => $validator->errors()->all(),
              'data'      =>  $message
          ]);
          
        }
    }
    public function update_rows($data)
    {
      $count=0;
        foreach($data as $data_key => $data_value)
        {
            if($this->master->check_entry($data_value['ticketno']) > 0)
            {
            $count+=1;
            }
            // if( (($data_value['ticketissuetime'])) !=  "null" && 
            // (($data_value['ticketissuetime'])) != null && 
            // (($data_value['ticketissuetime'])) != ''
            // )
            // {
          
            // }
        }

      return $count;
    }
}
