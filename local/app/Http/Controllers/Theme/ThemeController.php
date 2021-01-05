<?php

namespace App\Http\Controllers\Theme;

use App\Models\Forex;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ProductAttachment;
use App\Http\Controllers\Controller;

class ThemeController extends Controller
{
    public function index(Request $request)
    {
        $datas['currency'] = [
            "INR","USD","EUR","GBP","CHF","AUD","CAD","SGD","JPY","CNY","SAR","QAR","THB","AED","MYR","KRW","SEK","DKK","HKD","KWD","BHD","NPR"
        ];

        $date = isset($request->filter_date) ? $request->filter_date : Carbon::today()->format('Y-m-d');
        $today_forex = Forex::where('exchange_date', $date)->get();
        if(count($today_forex) < 1){
            $today = Carbon::parse($date)->day;
            $month = Carbon::parse($date)->month;
            $year = Carbon::parse($date)->year;
            for($i=1; $i<=$today; $i++)
            {
                $new_date = Carbon::createFromDate($year,$month,$i)->format('Y-m-d');
                $check_data = Forex::where('exchange_date', $new_date)->get();
                if(count($check_data) < 1){
                    $this->apiCall($new_date);
                }
            }
        }
        $today_forex = Forex::where('exchange_date', $date)->get();
        $datas['forex'] = $today_forex;
        $datas['date'] = $date;

        $start_month = Carbon::parse($date)->firstOfMonth()->format('Y-m-d');
        $end_month = Carbon::parse($date)->format('Y-m-d');

        $chart_rates = Forex::where('exchange_date', '>=', $start_month)->where('exchange_date', '<=', $end_month)->orderBy('exchange_date','desc')->get()->groupBy(function($date){
                return Carbon::parse($date->exchange_date)->format('Y-m-d');
        });
        foreach($chart_rates as $k=>$cdt){
            $datas["rates_chart"][] = [
                'exchange_date' => $k,
                'item1' => $cdt[0]->buy,
                'item2' => $cdt[1]->buy,
                'item3' => $cdt[2]->buy,
                'item4' => $cdt[3]->buy,
                'item5' => $cdt[4]->buy,
                'item6' => $cdt[5]->buy,
                'item7' => $cdt[6]->buy,
                'item8' => $cdt[7]->buy,
                'item9' => $cdt[8]->buy,
                'item10' => $cdt[9]->buy,
                'item11' => $cdt[10]->buy,
                'item12' => $cdt[11]->buy,
                'item13' => $cdt[12]->buy,
                'item14' => $cdt[13]->buy,
                'item15' => $cdt[14]->buy,
                'item16' => $cdt[15]->buy,
                'item17' => $cdt[16]->buy,
                'item18' => $cdt[17]->buy,
                'item19' => $cdt[18]->buy,
                'item20' => $cdt[19]->buy,
                'item21' => $cdt[20]->buy,
            ];
        }
        $datas['result'] = Forex::where('exchange_date', $date)->where('iso3', 'USD')->first();
        return view('theme.index')->with('datas', $datas);
    }
    public function apiCall($date)
    {
        $args = http_build_query(array(
          'page' => 1,
          'per_page'  => 20,
          'from' => $date,
          'to' => $date,
        ));
        $url = 'https://www.nrb.org.np/api/forex/v1/rates?'.$args;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $result = json_decode($response);
        curl_close($ch); // Close the connection
        // return $response;
        $payload = $result->data->payload[0];
        foreach($payload->rates as $rate){
            $data = [
                'exchange_date' => $payload->date,
                'iso3' => $rate->currency->iso3,
                'unit' => $rate->currency->unit,
                'name' => $rate->currency->name,
                'buy' => $rate->buy,
                'sell' => $rate->sell,
            ];
            Forex::create($data);
        }
    }
    public function convert_currency(Request $request)
    {
        $exchange_date = $request->exchange_date;
        $from_currency = $request->from_currency;
        $to_currency = $request->to_currency;
        $currency = $request->currency;

        $buy = 0;
        $sell = 0;

        if($to_currency == 'NPR' && $from_currency != 'NPR'){
            $forex_data = Forex::where('exchange_date', $exchange_date)->where('iso3', $from_currency)->first();
            if($forex_data->unit == 1){
                $buy = $forex_data->buy * $currency;
                $sell = $forex_data->sell * $currency;
            }else{
                $buy = ($forex_data->buy * $currency) / $forex_data->unit;
                $sell = ($forex_data->sell * $currency) / $forex_data->unit;
            }
        }
        if($to_currency != 'NPR' && $from_currency == 'NPR')
        {
            $forex_data = Forex::where('exchange_date', $exchange_date)->where('iso3', $to_currency)->first();
            if($forex_data->unit == 1){
                $buy = $currency / $forex_data->buy;
                $sell = $currency / $forex_data->sell;
            }else{
                $buy = ($currency / $forex_data->buy) * $forex_data->unit;
                $sell = ($currency / $forex_data->sell) * $forex_data->unit;
            }
        }
        if($to_currency != 'NPR' && $from_currency != 'NPR'){
            $forex_data1 = Forex::where('exchange_date', $exchange_date)->where('iso3', $from_currency)->first();
            if($forex_data1->unit == 1){
                $buy = $forex_data1->buy * $currency;
                $sell = $forex_data1->sell * $currency;
            }else{
                $buy = ($forex_data1->buy * $currency) / $forex_data1->unit;
                $sell = ($forex_data1->sell * $currency) / $forex_data1->unit;
            }

            $forex_data2 = Forex::where('exchange_date', $exchange_date)->where('iso3', $to_currency)->first();
            if($forex_data2->unit == 1){
                $buy = $buy / $forex_data2->buy;
                $sell = $sell / $forex_data2->sell;
            }else{
                $buy = ($buy / $forex_data2->buy) * $forex_data2->unit;
                $sell = ($sell / $forex_data2->sell) * $forex_data2->unit;
            }

        }

        $response = array(
          'buy' => round($buy, 2),
          'sell' => round($sell, 2),
      );
      return response()->json($response); 
    }
}
