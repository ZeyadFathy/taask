<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class OrderController extends Controller
{


  public function search(Request $request)
    {	

    	$data = Http::get("https://run.mocky.io/v3/0d6aab31-bb68-4d89-acc5-bc4148a3cff3");

        $res = collect($data['data']);

        $final = $this->filter($res,$request);
        		
        return response()->json([
            'data' => $final->all(),
            'sucess' => true,
        ], 200);

    }


//filter function filtering accord your intites ----> name or city or min or max and sorting it
// using sortBy 

    public function filter($data,$request){
        	
        	if(isset($request->name)){
        		$data = $data->where('name', $request->name);
        	}
        	if(isset($request->city)){
        		$data = $data->where('city', $request->city);
        	}
        	if(isset($request->min) && isset($request->max)){
        		$data = $data->whereBetween('price', [$request->min, $request->max]);
        	}
        	if(isset($request->sortBy)){
        		if( $request->sortBy == 'name'){
        			$data = $data->sortBy('name');
        		}elseif ($request->sortBy == 'price') {
        			$data = $data->sortBy('price');
        		}
        	}

        	return $data;
    }
}
