<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

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
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        $items = Item::all();

        return view('item.index', compact('items'));
    }
    /**
     * 在庫不足一覧
     */
    public function stockIndex()
    {
        // 商品一覧取得
        $items = Item::where('id','<=',7)->get();

        return view('item.home', compact('items'));
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
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }

    public function edit(Request $request, Item $item)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

            $item = Item::find($request->id);

            // 商品登録
            $item->update([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }
        return view('item.edit',[ 'item' => $item ]);
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
