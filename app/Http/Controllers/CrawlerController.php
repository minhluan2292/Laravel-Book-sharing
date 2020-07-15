<?php

namespace App\Http\Controllers;

use App\Autorun;
use App\Customer;
use App\Providers\RequestHelper;
use App\Providers\ResponseHelper;
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

    public function get()
    {       
        $accounts = Customer::all();
        return ResponseHelper::successOKResponse($accounts);
    }

    public function addfromChotot()
    {
            $page = Autorun::max('page') + 1;
            $limit=50;
            $start=0;
            
            for($p = $page; $p<=$page+2; $p++)
            {
                $added = 0;
                $start=($p-1)*$limit;
                $urllist = "https://gateway.chotot.com/v1/public/ad-listing?region_v2=13000&cg=1000&limit=$limit&o=$start&st=s,k&page=$p";
                $json = RequestHelper::simpleExecuteURL($urllist);
                if(count($json->ads)>0)
                {
                    for($i=0; $i<count($json->ads); $i++) {
                        $id = $json->ads[$i]->list_id;
                        $url = "https://gateway.chotot.com/v1/public/ad-listing/$id";
                        $customer = RequestHelper::simpleExecuteURL($url);
                        if(!isset($customer->message))
                        {
                            if(Customer::wherePhone($customer->ad->phone)->count() == 0)
                            {
                                $added++;
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
                                    'category' => isset($customer->ad->category) ? $customer->ad->category : null,
                                    'area' => isset($customer->ad->area) ? $customer->ad->area : null,
                                    'area_name' => isset($customer->ad->area_name) ? $customer->ad->area_name : null ,
                                    'region' => isset($customer->ad->region) ? $customer->ad->region : null,
                                    'region_name' => isset($customer->ad->region_name) ? $customer->ad->region_name : null,
                                    'type' => isset($customer->ad->type) ? $customer->ad->type : null,
                                    'price' => isset($customer->ad->price) ? $customer->ad->price : null
                                ]);
                            }
                        }
                    }
                    Autorun::create([
                        'page' => $p,
                        'runned' => true,
                        'added' => $added
                    ]);
                } 
            }
    }
}
