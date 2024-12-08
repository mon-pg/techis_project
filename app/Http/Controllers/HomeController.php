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
     * ジャンル取得
     */
    public function type(){
        $types = [
            1 => 'RPG',
            2 => '対戦',
            3 => '育成',
            4 => 'パーティ',
            5 => 'その他',
        ];
        return $types;
    }
    /**
     * 販売状況取得
     */
    public function salesStatus(){
        $sales = [
            1 => '販売中',
            2 => '生産終了',
            3 => '発売予定',
            4 => '未定',
        ];
        return $sales;
    }
    /**
     * 商品一覧（顧客用）
     */
    public function items() {
        $items = Item::all();
        $types = $this->type();
        $sales = $this->salesStatus();
        $passwords = $this->password();
        return view('itemsView',  ['items' => $items, 'types' => $types, 'sales' => $sales, 'passwords' => $passwords,]);
    }
    /**
     * パスワードのハッシュ化（ユーザー情報の追加に使用）
     */
    public function password(){
        $beforePasswords = [
            'shioripass',
            'tadashipass',
            'norimitsupass',
            'hanamipass',
            'nahopass',
            'shouheipass',
        ];
        $hashedPasswords = [];
        foreach($beforePasswords as $pass){
            $hashedPasswords[] = bcrypt($pass);
        }
        return $hashedPasswords;
    }
}
