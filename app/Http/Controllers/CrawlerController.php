<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CrawlerController extends Controller
{
    
    public function index()
    {
        return view('chotot.bds');
    }

    public function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }


    public function addfromChotot(Request $request)
    {
        $dup = 0;
        $add = 0;
        $error = 0;
        $page = $request['page'];
        $topage = $request['topage'];
        for($p=$page;$p<=$topage;$p++)
        {
            $limit=50;
            $start=($p-1)*$limit;

            $json = json_decode(file_get_contents("https://gateway.chotot.com/v1/public/ad-listing?region_v2=13000&cg=1000&limit=$limit&o=$start&st=s,k&page=$p"));
            for($i=0; $i<count($json->ads); $i++) {
                $id = $json->ads[$i]->list_id;
                if($this->get_http_response_code("https://gateway.chotot.com/v1/public/ad-listing/$id") == "200")
                {
                    $customer = json_decode(file_get_contents("https://gateway.chotot.com/v1/public/ad-listing/$id"));
                    if(Customer::wherePhone($customer->ad->phone)->count() == 0)
                    {
                        $add++;          
                        Customer::create([
                            'ad_id' => $customer->ad->ad_id,
                            'list_id' => $customer->ad->list_id,
                            'company_ad' => $customer->ad->company_ad,
                            'phone' => $customer->ad->phone,
                            'list_time' => $customer->ad->list_time,
                            'date' => $customer->ad->date,
                            'account_id' => $customer->ad->account_id,
                            'account_oid' => $customer->ad->account_oid,
                            'account_name' => $customer->ad->account_name,
                            'subject' => $customer->ad->subject,
                            'category' => $customer->ad->category,
                            'area' => $customer->ad->area,
                            'area_name' => $customer->ad->area_name,
                            'region' => $customer->ad->region,
                            'region_name' => $customer->ad->region_name,
                            'type' => $customer->ad->type,
                            'price' => $customer->ad->price
            
                        ]);
                    }
                    else
                    {
                        $dup++;
                    }
                    
                }  
                else
                {
                    $error ++;
                }


            } 
        }
        return view('chotot.bds',compact('add','dup','error'));
    }
}
