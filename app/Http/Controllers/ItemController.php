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

    /**
     * 商品一括削除
     */
    public function someDelete(Request $request)
    {
        // eloquentによる複数削除
        Item::destroy($request->id);    //複数データ削除（IDは配列で複数）
        return redirect()->route('items');
    }
    /**
     * 商品一件削除
     */
    public function oneDelete(Request $request){

        $id = $request->input('delete-id');

        $this->delete($id);
        return redirect()->route('items');
    }
    /**
     * 削除機能
     */
    public function delete($id){
/*         return Item::destroy($id); */
    }
}
