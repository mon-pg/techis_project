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
     * 在庫状況取得
     */
    public function stockStatuses(){
        $stockStatuses = [
            1 => '在庫あり',
            3 => '在庫なし',
        ];  
        return $stockStatuses;
    }
    /**
     * 商品一覧（顧客用）
     */
    public function items() {
        $items = Item::paginate(12);
        $types = $this->type();
        $sales = $this->salesStatus();
        $noItem = '商品がありません。';
        if(count(Item::all())>0){
            return view('customer.items',  compact('items', 'types', 'sales'));  
        }else{
            return view('customer.items',  compact('noItem'));
        }
    }
    /**
     * 商品検索機能
     */
    public function search(Request $request){
        $items = Item::query();
        $sales = $this->salesStatus();
        $types = $this->type();
        $stockStatuses = $this->stockStatuses();

        $sKeywords = $request->input('sKeywords');
        $sType = $request->input('type');
        $sSalesStatus = $request->input('sSalesStatus');
        $sStockStatus = $request->input('sStockStatus');
        $start = $request->input('start');
        $end = $request->input('end');

        if(empty($sKeywords)&&empty($sSalesStatus)&&empty($sType)&&empty($start)&&empty($end)&&empty($sStockStatus)){   //検索内容が空の場合
            $searchError = '※検索項目を入力してください。';
            $items = $items->paginate(10);
            return view('customer.items',compact('items', 'sales', 'types', 'searchError'));
        }else{

            if(!empty($sType)){
                $items->where(function($query) use ($sType){
                    $query->orWhereIn('type', $sType);
                });
            }
            if(!empty($sSalesStatus)){
                $items->where('salesStatus', $sSalesStatus);
            }
            if(!empty($start)){
                $items->where('salesDate', '>=', $start);
            }
            if(!empty($end)){
                $items->where('salesDate', '<=', $end);
            }
            if(!empty($sStockStatus)){
                $stockItems = $items->get();
                $num = [];
                foreach ($stockItems as $item){
                    if($item->stock > 0){
                        $num[1][] = $item->id;
                    }elseif($item->stock === 0){
                        $num[3][] = $item->id;
                    }
                }
                if(isset($num[$sStockStatus])){
                    $ids = $num[$sStockStatus];
                }else{
                    $ids = [];
                }
                //dd([$num[1],$num[2],$num[3],$ids]);
                $items->find($ids);
            }
            if(!empty($sKeywords)){
                // 全角の英数字とスペースを半角に変換後、半角で区切った配列に変換
                $keywords = explode(' ', mb_convert_kana($sKeywords, 'as'));
                
                $items->where(function($query) use ($keywords){
                    foreach($keywords as $keyword){
                    $query->orWhere('name', 'LIKE', "%$keyword%")
                            ->orWhere('detail', 'LIKE', "%$keyword%");       
                    }
                });
            }
            
            $check = $items->get();
            $items = $items->paginate(10)->appends($request->query());;            
            if(count($check) === 0){
                $findNoItem = '該当する商品が存在しません。';
                return view('customer.items', compact('items', 'sales', 'types', 'sType','stockStatuses', 'start', 'end', 'findNoItem'));
            }else{
              
                return view('customer.items', compact('items', 'sales', 'types', 'sType','stockStatuses', 'start', 'end'));
            }
        }
    }

    /**
     * 商品詳細画面
     */
    public function detail(Item $item){
        $types = $this->type();
        $sales = $this->salesStatus();

        return view('customer.detail',compact('item', 'types', 'sales'));
    }

}
