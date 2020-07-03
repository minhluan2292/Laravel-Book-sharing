<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrawlerController extends Controller
{
    
    function index()
    {
        return view('chotot.bds');
    }
    public function getInfoBDS()
    {
        // $client = new GuzzleHttp\Client();
        // $res = $client->get('https://gateway.chotot.com/v1/public/ad-listing?region_v2=13000&cg=1000&limit=20&st=s,k&f=a&page=1');
        // echo $res->getStatusCode(); // 200
        // dd($res->getBody());
        $json = json_decode(file_get_contents('https://gateway.chotot.com/v1/public/ad-listing?region_v2=13000&cg=1000&limit=20&st=s,k&f=a&page=1'), true);
        $data = $json['ads'][0];
        dd($data);
        return view('chotot.bds', compact('data'));

    }
}
