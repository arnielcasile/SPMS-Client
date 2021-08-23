<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Irregularity;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use PDF;

class IrregularityController extends Controller
{
    protected $irregularity,$process;

    public function __construct()
    {
        $this->irregularity = New Irregularity();
    }

    public function select_whclass($where)
    {
        $wh_class = $this->irregularity->select_whclass($where);
        return $wh_class;
    }

    public function load_reprint(Request $request)
    {
          $data=$request->data;
            $result = [];             
            try 
            {      
                for($b=0;$b<count($data);$b++)
                {
                    DB::beginTransaction();
                    $where = 
                    [
                        'b.control_no' => $data[$b]
                    ];
                    $load = $this->irregularity->load_reprint($where);
                //  return $load;
                    DB::commit();
                  
                    for($a=0;$a<count($load);$a++)
                    {
                        $result[] = 
                            [
                                'ticket_no'                 => $load[$a]->ticket_no,
                                'order_download_no'         => $load[$a]->order_download_no,
                                'irregularity_type'         => $load[$a]->irregularity_type,
                                'status'                    => '',
                                'stock_address'             => $load[$a]->stock_address,
                                'part_no'                   => $load[$a]->item_no,
                                'part_name'                 => $load[$a]->item_name,
                                'original_qty'              => $load[$a]->delivery_qty,
                                'actual_qty'                => $load[$a]->actual_qty,
                                'discrepancy'               => $load[$a]->discrepancy,
                                'remarks'                   => $load[$a]->remarks,
                                'users_id'                  => $load[$a]->users_id,
                                'user_type_id'              => $load[$a]->user_type_id,
                                'prepared_by'               => $request['prepared_by'],
                                'approved_by'               => $request['approved_by'],
                                'reviewed_by'               => $request['reviewed_by'],
                                'wh_class'                  => $load[$a]->warehouse_class,
                                'control_no'                => $load[$a]->control_no,
                                'normal_status'             => $load[$a]->normal_status,
                                'irreg_status'              => $load[$a]->irregularity_status,
                                'id'                        => $load[$a]->irreg_id,
                                'irregularity_type'         => $load[$a]->irregularity_type,
                                'irreg_create'              => $load[$a]->irreg_create,
                                
                        ];
                            
                    }
                }

                $dr_control_array = [];
                foreach ($result as $arr_1_key => $arr_1_value) {
                    if(!in_array($arr_1_value['control_no'], $dr_control_array))
                    {
                        array_push($dr_control_array, $arr_1_value['control_no']);
                    }
                }
                
                $arr_2 = [];
                foreach ($dr_control_array as $dr_control_array_key => $dr_control_array_value) 
                {
                    $arr_2[$dr_control_array_value] = [];
                    foreach ($result as $arr_1_key => $arr_1_value) 
                    {
                        if($arr_1_value['control_no'] == $dr_control_array_value)
                        {
                            array_push($arr_2[$dr_control_array_value], $arr_1_value);
                        }
                    }
                }

                $pdf = PDF::loadView('PDF.pdf_irregularity',['data' => $arr_2])->setPaper('A5', 'landscape');
                $fileName = 'Irregulairty';
                return $pdf->stream();

            } 
            catch (\Throwable $th) 
            {
                DB::rollback();
    
                return response()
                    ->json([
                        'status'    => 0,
                        'message'   => $th->getMessage(),
                        'data'      => '',
                    ]);
            }   

    }

    public function add_irregularity_item(Request $request)
    {
        
       
        // $where =
        // [
        //     'warehouse_class'   => $request->warehouse_class,
        // ];

        // $control_no = $this->irregularity->generate_control_no($where);
        $wh_class;
        $looping = $request->datas;
        foreach($looping as $loop)
        {
            $wh=$this->irregularity->select_whclass(['ticket_no' =>$loop['ticket_no']]);
            $wh_class=$wh[0]->warehouse_class;
        }
        $control_no = $this->irregularity->generate_control_no(['warehouse_class' =>  $wh_class]);
        $count=0;
        $result=[];
        foreach($looping as $loop)
        {
            // Pushing control number for FE use.
            $loop['control_no'] = $control_no;
            $looping[$count]['control_no']=$control_no;
            $looping[$count]['wh_class']=$wh_class;

            $count++;
            $data = 
            [
                'ticket_no'                 => $loop['ticket_no'],
                'control_no'                => $control_no,
                'users_id'                  => $loop['users_id'],
                'irregularity_type'         => $loop['irregularity_type'],
                'actual_qty'                => $loop['actual_qty'],
                'discrepancy'               => $loop['discrepancy'],
                'remarks'                   => $loop['remarks'],
            ];

            $rule =
            [
                'ticket_no'                 => 'required',
                'control_no'                => 'required',
                'users_id'                  => 'required',
                'irregularity_type'         => 'required',
                'actual_qty'                => 'required',
                'discrepancy'               => 'required',
                'remarks'                   => 'required',
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
                try 
                {
                    DB::beginTransaction();

                    $this->irregularity->add_irregularity_item($data);

                    DB::commit();       
                } 
                catch (\Throwable $th) 
                {
                    DB::rollback();
        
                    return response()
                        ->json([
                            'status'    => 0,
                            'message'   => $th->getMessage(),
                            'data'      => '',
                        ]);
                }                
            } 
        }

        $dr_control_array = [];
        foreach ($looping as $arr_1_key => $arr_1_value) {
            if(!in_array($arr_1_value['control_no'], $dr_control_array))
            {
                array_push($dr_control_array, $arr_1_value['control_no']);
            }
        }
        
        $arr_2 = [];
        foreach ($dr_control_array as $dr_control_array_key => $dr_control_array_value) 
        {
            $arr_2[$dr_control_array_value] = [];
            foreach ($looping as $arr_1_key => $arr_1_value) 
            {
                if($arr_1_value['control_no'] == $dr_control_array_value)
                {
                    array_push($arr_2[$dr_control_array_value], $arr_1_value);
                }
            }
        }

        // return $arr_2;
        $pdf = PDF::loadView('PDF.pdf_irregularity',['data' => $arr_2])->setPaper('A5', 'landscape');
        $fileName = 'Irregulairty';
        return $pdf->stream();

    }
}
