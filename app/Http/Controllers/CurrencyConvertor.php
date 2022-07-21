<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyConvertor extends Controller
{

    // The exchange rates for USD and RON based on Euro  

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {

        if(!$request->ajax())
            throw new \Exception('Not a valid Request!');
        
        // set API Endpoint and API key
        $endpoint = 'latest';
        $access_key = env('CURRENCY_CONVERT_API_KEY','cee212a839adf0ce9f3cafc93f3f8890');

        // Initialize CURL:
        $ch = curl_init(env('CURRENCY_CONVERT_API_URL', 'http://api.exchangeratesapi.io/v1/').$endpoint.'?access_key='.$access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);
        // Access the exchange rate values, e.g. GBP:
        if(!$exchangeRates['success'])
            throw new \Exception('Something going wrong with external API! Pls contact to admin.');
        
        return response()->json([ 'success'=>true,
             'data' => [ 'USD'=>$exchangeRates['rates']['USD'],
             'RON'=>$exchangeRates['rates']['RON']],
             'message'=>'Successfully fetched'    
            ],200) ;
        }//end try
        catch (\Exception $e){
            return response()->json([ 'success'=>false,
                                      'message'=>$e->getMessage()
                                    ],200) ;
       }//end try

    } // end function here

}
