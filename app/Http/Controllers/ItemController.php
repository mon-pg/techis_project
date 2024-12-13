<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Models\Log;
use Carbon\Carbon;

class ItemController extends Controller
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
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        $items = Item::all();
        $sales = $this->salesStatus();
        $types = $this->type();
        $auth_user = Auth::user();
        return view('item.index', compact('items', 'types', 'sales', 'auth_user'));
    }
    /**
     * ホーム画面
     */
    public function homeIndex()
    {
        // 在庫不足の一覧
        $items = Item::find($this->stockIds());
        $types = $this->type();
        $sales = $this->salesStatus();
        $auth_user = Auth::user();
        $logs = Log::where('target_type', 'item')->get();

        return view('item.home', compact('items', 'types', 'sales', 'auth_user'));
    }
    /**
     * 在庫不足のitemIDの取得
     */
    public function stockIds(){
        $lessStockIds = [] ;
        $items = Item::all();
        foreach ($items as $item){
            $status = $item->stock - $item->sdStock;
            if($status <= 0){   //基準在庫以下
                $lessStockIds[] = $item->id;
            }
        }
        return $lessStockIds;
    }
    /**
     * 商品検索
     */
    /**
     * フリーワード検索結果の表示
     */
    public function search(Request $request)
    {
     $this->index();
    }

    /**
     * 商品登録画面
     */
    public function addView(){
        $auth_user = Auth::user();
        return view('item.add',compact('auth_user'));
    }
    /**
     * 商品登録
     */
    public function add(ItemRequest $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'salesStatus' => $request->salesStatus,
                'salesDate' => $request->salesDate,
                'stock' => $request->stock,
                'sdStock' => $request->sdStock,
                'stockStatus' => $request->stockStatus,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }
    }
    /**
     * 商品編集
     */
    public function edit(ItemRequest $request, Item $item)
    {
            // 商品更新
            $item->update([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'salesStatus' => $request->salesStatus,
                'salesDate' => $request->salesDate,
                'stock' => $request->stock,
                'sdStock' => $request->sdStock,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        
    }
    public function editView(Item $item){
        $auth_user = Auth::user();
        $types = $this->type();
        $sales = $this->salesStatus();
        $logs = Log::where('target_type', 'item')->where('target_id',$item->id)->get();

        return view('item.edit',[
             'item' => $item,
             'auth_user' => $auth_user,
             'types' => $types,  
             'sales' => $sales, 
             'logs' => $logs]);
    }
    /**
     * 商品詳細画面
     */
    public function itemView(Item $item){
        $auth_user = Auth::user();
        $types = $this->type();
        $sales = $this->salesStatus();
        $logs = Log::where('target_type', 'item')->where('target_id',$item->id)->get();

        return view('item.detail',[
             'item' => $item,
             'auth_user' => $auth_user,
             'types' => $types,  
             'sales' => $sales, 
             'logs' => $logs]);
    }

    /**
     * 商品削除
     */
    public function destroy(Request $request,Item $item){
        if($item !== null){
        Item::destroy($item->id);
        }
        if($request !== null){
        Item::destroy($request->id);
        }
        return redirect()->route('items');
    }
    
}
