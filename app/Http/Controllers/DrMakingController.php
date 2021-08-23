<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\DrMaking;
use App\Checking;
use DB;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Collection;

class DrMakingController extends Controller
{
    protected $dr_making, $checking;

    public function __construct()
    {
        ini_set('memory_limit', '3000M');
        $this->dr_making = new DrMaking();
        $this->checking = new Checking();
    }
     /*
    * return @array
    * _method PATCH
    * request data required [dr_control_no,user_id]
    */
    public function load_data(Request $request)
    {
        $where =
        [
            'c.dr_control' => $request['dr_control_no']
        ];  
        $load=$this->dr_making->load_data($where);
        return $load;
    }
    
    public function update_dr_making(Request $request)
    {
        // 'P14-PL-20-1510-A'

        



        // $data[] = 
        // [
        //     'dr_control_no' => 'P14-PL-20-1510-1',//1
        // ];

        // $data[] = 
        // [
        //     'dr_control_no' => 'P14-PL-20-1415-A',//2
        // ];

        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1510-A',//3
        // ];
     
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1405-1',//4
        // ];
        
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1501-1',//5
        // ];
        
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1531-1',//6
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1531-2',//7
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1531-A',//8
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1413-1',//9
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1415-1',//10
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1531-4',//11
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1531-3',//12
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-SWT-20-0005-1',//13
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1531-5',//14
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-757-1',//15
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-756-1',//16
        // ];
        // $data[] =
        // [
        //     'dr_control_no' => 'P14-PL-20-1422-1',//17
        // ];
       
       
        
// $data=[];
// array_push($data,["dr_control_no"=>"P14-PL-20-889-1"]);
// array_push($data,["dr_control_no"=>"P14-SWT-20-0001-1"]);

        // $data       = json_decode($data, true);
        
        // return $data;
        $data       = json_decode($request['data'], true);
        
        // return $data;


        $pallet_qty =$request->pallet_qty;
        $pcase_no   =$request->pcase_no;
        $box        =$request->box;
        $bag        =$request->bag;
        // $pallet_qty =1;
        // $pcase_no   =1;
        // $box        =1;
        // $bag        =1;

     
        $result = [];
        try
        {
            $data_completion = 
            [
                'a.process_masterlists_id' => '5'
            ];
            if($pallet_qty == null && $pcase_no == null && $box == null && $bag == null)
            {
                $data_users_id =
                [
                    'c.users_id'  =>$request->user_id,
                ];
               
            }
            else
            {
                $data_users_id =
                [
                    'c.users_id'  =>$request->user_id,
                    'c.pallet'    =>$pallet_qty,
                    'c.pcase'     =>$pcase_no,
                    'c.box'       =>$box,
                    'c.bag'       =>$bag,
                ];
            }
            
            $data_normal = 
            [
                'a.process_masterlist_id' => '5'
            ];
            // DB::beginTransaction();
           $load=[];
     
            for($a=0;$a<count($data);$a++)
            {
                $where =
                [
                    'c.dr_control' => $data[$a]['dr_control_no']
                ];          
                                     
                $process= $this->dr_making->get_process(['a.dr_control' => $data[$a]['dr_control_no']]);
                // $count = explode('-', $data[$a]['dr_control_no']);
                // $no = $count[4];
 
                $this->dr_making->update_dr_makings($where,$data_users_id);//ok
                $updated_at_count=$this->dr_making->select_updated_at($where);
                if(is_null($updated_at_count->updated_at))
                {
                    $this->dr_making->add_updated_at(['dr_control' => $data[$a]['dr_control_no']]);//ok
                }
                            
                foreach($process as $process_key => $process_value)
                {
                 
             
                    if($process_value->process == 'NORMAL')
                    {
                        $where =
                        [
                            'a.ticket_no' => $process_value->ticket_no
                        ];  
                        $this->dr_making->update_process('master_data', $where, $data_normal);
                    }
                    else
                    {
                        $irreg_type=$this->dr_making->check_no_stock($where);
                        foreach($irreg_type as $irreg_type_key => $type)
                        {
                         
                            if($type->irregularity_type == 'NO STOCK' || $type->irregularity_type == 'EXCESS')
                            {
                                $where =
                                [
                                    'a.ticket_no' => $type->ticket_no
                                ];  
                                $this->dr_making->update_process('master_data', $where, $data_normal);
                                $this->dr_making->update_process('irregularity', $where, $data_completion);
                            }
                            else
                            {
                                $where =
                                [
                                    'a.ticket_no' => $type->ticket_no
                                ];  
                                $this->dr_making->update_process('irregularity', $where, $data_completion);
                            }   
                        }
                    }  
                }
                
                $dt = Carbon::now();
       
                $where_dr_control =
                [
                    'c.dr_control' => $data[$a]['dr_control_no']
                ];      
                 foreach($this->dr_making->load_data($where_dr_control) as $load_key => $load_value)
                 {
                    $load[]=$load_value;
              
                 }
            }

            // foreach($data as $data_key => $data_value)
            // {     
            //     print_r($data_value['dr_control_no']);
            // }
            // for($i=0;$i<count($data);$i++)
            // {
                
            // }
            $load = json_decode(json_encode($load), true);

            foreach($load as $sub_load_key => $sub_load_value)
            {
                $counter_attn=0;
                foreach($data as $data_key => $data_value)
                {           
                 if($data_value['dr_control_no']==$sub_load_value['dr_control'])
                    {
                        // $count = explode('-', $sub_load_value['dr_control']);
                        // $no = $count[4];
                        $process= $this->dr_making->get_process(['a.ticket_no' => $sub_load_value['ticket_no'], 'a.dr_control' => $sub_load_value['dr_control']]);
                        foreach($process as $process_key => $process_value)
                        {
                            if($process_value->process == 'NORMAL')
                            {
                                if($sub_load_value['ticket_no_irreg'] == null)
                                {
                                    $qty= $sub_load_value['delivery_qty'];
                                }
                                else
                                {
                                    $qty= $sub_load_value['actual_qty'];
                                }
                            }
                            else
                            {
                               if ($sub_load_value['irregularity_type'] == 'EXCESS')
                               {
                                    $qty= $sub_load_value['actual_qty'];
                               }
                               else
                               {
                                    $qty= $sub_load_value['discrepancy'];
                               }
                            
                                
                            }
                        }
                    if($pallet_qty == null && $pcase_no == null && $box == null && $bag == null)
                    {
                        // print_r($sub_load_value['dr_control']);
                       array_push($result,
                        [
                            'dr_no'                 => $sub_load_value['dr_control'],
                            'delivery_type'         => $sub_load_value['delivery_type'] . " " .$sub_load_value['delivery_no'],
                            'order_download_no'     => $sub_load_value['order_download_no'],
                            'item_rev'              => $sub_load_value['item_rev'],
                            'item_no'               => $sub_load_value['item_no'],
                            'item_name'             => $sub_load_value['item_name'],
                            'delivery_qty'          => $qty,
                            'stock_address'         => $sub_load_value['stock_address'],
                            'manufacturing_no'      => $sub_load_value['manufacturing_no'],
                            'payee_cd'              => $sub_load_value['payee_cd'],
                            'ticket_no'             => $sub_load_value['ticket_no'],
                            'product_no'            => $sub_load_value['product_no'],
                            'destination'           => $sub_load_value['destination'],
                            'dr_control'            => $sub_load_value['dr_control'],
                            'datetoday'             => $dt->format('D M d Y'),
                            'checker_name'          => $sub_load_value['first_name'] . " " . $sub_load_value['middle_name'] . " " . $sub_load_value['last_name'],
                            'checker_position'      => $this->dr_making->get_user(['position' => 'position','condition' =>['id'=>$sub_load_value['id']]])->position,
                            'pallet'                => $sub_load_value['pallet'],
                            'pcase'                 => $sub_load_value['pcase'],
                            'box'                   => $sub_load_value['box'],
                            'bag'                   => $sub_load_value['bag'],
                            'attention_position'    => $this->dr_making->get_user(['position' => 'position','condition' =>['id'=>$request->approved_by_id]])->position,
                            'attention_to'          => $request->attention_to[$counter_attn],
                            'position'              => $request->approved_by,
                            'approved_by'           => $request->approved_by,
                            'created_at'            => $sub_load_value['updated_at'],
                            'delivery_status'       => $sub_load_value['delivery_status'],
                        ]);
                    }
                    else
                    {
                        array_push($result,
                        [
                            'dr_no'                 => $sub_load_value['dr_control'],
                            'delivery_type'         => $sub_load_value['delivery_type'] . " " .$sub_load_value['delivery_no'],
                            'order_download_no'     => $sub_load_value['order_download_no'],
                            'item_rev'              => $sub_load_value['item_rev'],
                            'item_no'               => $sub_load_value['item_no'],
                            'item_name'             => $sub_load_value['item_name'],
                            'delivery_qty'          => $qty,
                            'stock_address'         => $sub_load_value['stock_address'],
                            'manufacturing_no'      => $sub_load_value['manufacturing_no'],
                            'payee_cd'              => $sub_load_value['payee_cd'],
                            'ticket_no'             => $sub_load_value['ticket_no'],
                            'product_no'            => $sub_load_value['product_no'],
                            'destination'           => $sub_load_value['destination'],
                            'dr_control'            => $sub_load_value['dr_control'],
                            'datetoday'             => $dt->format('D M d Y'),
                            'checker_name'          => $sub_load_value['first_name'] . " " . $sub_load_value['middle_name'] . " " . $sub_load_value['last_name'],
                            'checker_position'      => $this->dr_making->get_user(['position' => 'position','condition' =>['id'=>$sub_load_value['id']]])->position,
                            'pallet'                => $pallet_qty,
                            'pcase'                 => $pcase_no,
                            'box'                   => $box,
                            'bag'                   => $bag,
                            'attention_position'    => $this->dr_making->get_user(['position' => 'position','condition' =>['id'=>$request->approved_by_id]])->position,
                            'attention_to'          => $request->attention_to[$counter_attn],
                            'approved_by'           => $request->approved_by,
                            'created_at'            => $sub_load_value['updated_at'],
                            'delivery_status'       => $sub_load_value['delivery_status'],
                        ]);
                    }
                       
                    }
                    $counter_attn+=1;
                }         
               
            }
            //   return $result;$this->dr_making->get_user(['position' => 'position'],['condition' =>['id'=>$emp_id]]),
                $dr_control_array = [];
                foreach ($result as $arr_1_key => $arr_1_value) {
                    if(!in_array($arr_1_value['dr_control'], $dr_control_array))
                    {
                        array_push($dr_control_array, $arr_1_value['dr_control']);
                    }
                }
                
                $arr_2 = [];
                foreach ($dr_control_array as $dr_control_array_key => $dr_control_array_value) 
                {
                    $arr_2[$dr_control_array_value] = [];
                    foreach ($result as $arr_1_key => $arr_1_value) 
                    {
                        if($arr_1_value['dr_control'] == $dr_control_array_value)
                        {
                            if(!in_array($arr_1_value['delivery_type'], $arr_2[$dr_control_array_value]))
                            {
                                array_push($arr_2[$dr_control_array_value], $arr_1_value['delivery_type']);
                            }
                        }
                    }
                }
                
                $data_print = [];
                foreach ($arr_2 as $arr_2_key => $arr_2_value) 
                {
                    $dr_control = $arr_2_key;
                    $data_print[$dr_control] = [];
                    foreach ($arr_2_value as $delivery_type_key => $delivery_type_value)
                    {
                        $delivery_type = $delivery_type_value;
                        $data_print[$dr_control][$delivery_type] = [];
                        $x=0;
                        foreach ($result as $arr_1_key => $arr_1_value) 
                        {
                            if($arr_1_value['dr_control'] == $dr_control && $arr_1_value['delivery_type'] == $delivery_type)
                            {
                                array_push($data_print[$dr_control][$delivery_type],  $arr_1_value);
                                // $x++;
                            }
                        }
                    }
                } 
        // return $data_print;
        // print_r(json_encode($data_print));
        $pdf = PDF::loadView('PDF.pdf_dr_making',['raw_data' => $data_print])->setPaper('A4', 'portrait');
        return $pdf->output();           
      
        }
        catch(\Throwable $th)
        {
            DB::rollback();
            return response()
                ->json([
                    'status'    => 0,
                    'message'   =>  $th->getMessage(),
                    'data'      => ''
                ]);
        }
}
    public function load_dr_making(Request $request)
    {
        $where = 
        [
            'area_code'    => $request->user_area_code
        ];

        $rule = 
        [
            'area_code'    => 'required'
        ];

        $validator = Validator::make($where,$rule);

        if($validator->fails())
        {
            return response()
                ->json([
                    'status'    => 0,
                    'message'   =>  $validator->errors()->all(),
                    'data'      =>  ''
                ]);
        }
        else
        {
            try
            {   
                DB::beginTransaction();
                $load = $this->dr_making->load_dr_making($where);
                DB::commit();
                $count = count($load);
                $result = [];
                for($a=0;$a<$count;$a++)
                {
                    $result[] =
                    [
                        'dr_id'             => $load[$a]->id,
                        'dr_control'        => $load[$a]->dr_control,
                        'ticket_count'      => $load[$a]->total_ticket,
                        'destination'       => $load[$a]->destination
                    ];
                
                }
            
                return response()
                    ->json([
                        'status'    => 1,
                        'message'   => '',
                        'data'      => $result
                    ]);
            }
            catch(\Throwable $th)
            {
                DB::rollback();
                return response()
                    ->json([
                        'status'    => 0,
                        'message'   =>  $th->getMessage(),
                        'data'      => ''
                    ]);
            }  
        }
    }   
}
