<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $activeAndVerifiedUsers = User::where(['is_active' => 1, 'is_verified' => 1])->count();
        $activeAndVerifiedUsersWhoHasActiveProducts = User::where(['is_active' => 1, 'is_verified' => 1])
            ->whereHas('activeProducts')
            ->count();
        $activeProducts = Product::where('is_active', 1)->count();
        $activeProductsWhichDontBelongToUser = Product::where('is_active', 1)
            ->whereDoesntHave('users')
            ->count();
        $amountOfAllActiveAttachedProducts = Product::where('is_active', 1)
            ->whereHas('users')
            ->count();
        $summarizedPriceOfAllActiveProducts = Product::where('is_active', 1)
            ->whereHas('users')
            ->withCount('users')
            ->with('users')
            ->get();

        $summarizedPrice = 0;
        foreach($summarizedPriceOfAllActiveProducts as $summerizedProduct)
        {
            $quantity = 0;
            foreach($summerizedProduct->users as $user)
            {
                $quantity += $user->pivot->quantity;
            }
            $summarizedPrice += $summerizedProduct->price*$quantity;
        }

        $summerizedPricePerUsers = User::whereHas('activeProducts')->with('activeProducts')->get();

        $conversionData = json_decode($this->getExchangeRates(), true);

        return view('product', compact(
            'activeAndVerifiedUsers',
            'activeAndVerifiedUsersWhoHasActiveProducts',
            'activeProducts',
            'activeProductsWhichDontBelongToUser',
            'amountOfAllActiveAttachedProducts',
            'summarizedPrice',
            'summerizedPricePerUsers',
            'conversionData'
        ));
    }

    protected function getExchangeRates()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/latest?symbols=USD,RON&base=EUR",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: xY9GG84mOAMbf1D7IaVkl0hBRhpNmxUh"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
