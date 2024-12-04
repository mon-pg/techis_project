<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    
    /**
     * 商品一覧（顧客用）
     */
    public function items() {
        $items = Item::all();
        return view('itemsView', compact('items'));
    }
}
