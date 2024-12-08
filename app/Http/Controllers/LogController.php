<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ホーム画面の全商品の更新ログを取得
     */
    public function allLogs(){
        return Log::where('target_type', 'item')->get();
    }

    /**
     * 特定の商品の更新ログを取得 
     */
    public function itemLogs($target_id){
        return Log::where('target_type', 'item')->where('target_id',$target_id)->get();
    }
    /**
     * 特定のユーザーの更新ログを取得 
     */
    public function userLogs($target_id){
        return Log::where('target_type', 'user')->where('target_id',$target_id)->get();
    }

}
