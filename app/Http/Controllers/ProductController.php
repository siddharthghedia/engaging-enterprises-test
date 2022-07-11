<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
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

        return view('product', compact(
            'activeAndVerifiedUsers',
            'activeAndVerifiedUsersWhoHasActiveProducts',
            'activeProducts',
            'activeProductsWhichDontBelongToUser',
            'amountOfAllActiveAttachedProducts',
            'summarizedPrice',
            'summerizedPricePerUsers'
        ));
    }
}
