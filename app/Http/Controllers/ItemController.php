<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use DateTime;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Arr;
use JeroenNoten\LaravelAdminLte\View\Components\Form\Input;

use function PHPUnit\Framework\isNull;

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
     * 変更箇所取得
     */
    public function target($target_type){
        if($target_type === 'Item'){
            $targets = [
            'title' => 'タイトル',
            'type' => 'ジャンル',
            'salesStatus' => '販売状況',
            'salesDate' => '発売日',
            'stock' => '在庫数',
            'sdStock' => '基準在庫数',
            'detail' => '商品紹介',
            'image' => '商品画像',     
            ];
        }elseif($target_type === 'User'){
            $targets = [
                'name' => '氏名',
                'role' => '権限',
                'department' => '部署',
                'email' => 'メールアドレス',
            ];
        }

        return $targets;
    }

    /**
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        $items = Item::paginate(10);
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
        $targets = $this->target('Item');
        $auth_user = Auth::user();
        $logs = Log::where('target_type', 'item')->orderBy('id', 'desc')->take(20)->get();
        //dd($logs);
            foreach($logs as $log){
                $decoded_actions = json_decode($log->action);
                $actions = [];
                foreach($decoded_actions as $action){
                    if(isset($targets[$action])){
                        $actions[] = $targets[$action]; //$log->actionをaction名に変更して格納
                    }else{
                        continue;
                    }
                }
                if($actions == null){
                    $actions = ['商品情報'];
                }
                $log->action = $actions;
            }
            //dd([$actions, $log->action]);
        $logUsers = [];
        $logItems = [];
            foreach($logs as $log){
                $user = User::where('id', $log->user_id)->first();
                
                if($user && $user->status === 1){
                    $logUsers[$log->id] =  $user->name;
                }else {
                    $logUsers[$log->id] = 'ユーザー';
                }
                    
                $logItems[$log->id] =  Item::where('id', $log->target_id)->pluck('title', 'id');
            }
                       
        return view('item.home', compact(
            'items',
            'types', 
            'sales', 
            'targets', 
            'auth_user', 
            'logs', 
            'logUsers',
            'logItems'));
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
     * 商品検索機能
     */
    public function search(Request $request){
        $items = Item::query();
        $auth_user = Auth::user();
        $sales = $this->salesStatus();
        $types = $this->type();
        $stockStatuses = [
            1 => '在庫あり〇',
            2 => '在庫不足△',
            3 => '在庫なし✕',
        ];

        $sKeywords = $request->input('sKeywords');
        $sType = $request->input('type');
        $sSalesStatus = $request->input('sSalesStatus');
        $sStockStatus = $request->input('sStockStatus');
        $start = $request->input('start');
        $end = $request->input('end');

        if(empty($sKeywords)&&empty($sSalesStatus)&&empty($sType)&&empty($start)&&empty($end)&&empty($sStockStatus)){   //検索内容が空の場合
            $searchError = '※検索項目を入力してください。';
            $items = $items->paginate(10);
            return view('item.index',compact('items', 'sales', 'types', 'stockStatuses', 'auth_user', 'searchError'));
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
                    if($item->stock >= $item->sdStock){
                        $num[1][] = $item->id;
                    }elseif($item->stock === 0){
                        $num[3][] = $item->id;
                    }else{
                        $num[2][] = $item->id;
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
                    $query->orWhere('title', 'LIKE', "%$keyword%")
                            ->orWhere('detail', 'LIKE', "%$keyword%");       
                    }
                });
            }
            
            $check = $items->get();
            $items = $items->paginate(10)->appends($request->query());;            
            if(count($check) === 0){
                $noItem = '該当する商品が存在しません。';
                return view('item.index', compact('items', 'sales', 'types', 'auth_user', 'sKeywords', 'sSalesStatus', 'stockStatuses', 'sType', 'start', 'end', 'noItem'));
            }else{
                return view('item.index', compact('items', 'sales', 'types', 'auth_user', 'sKeywords', 'sSalesStatus', 'stockStatuses', 'sType', 'start', 'end'));
            }
        }
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
            $storeImage = [];

            if($request->file('images') != null){
                foreach($request->file('images') as $image){
                    $imageResult = cloudinary()->upload($image->getRealPath(), [
                        'folder' => 'Portfolio',
                    ]);
                    $storeImage[] =[
                        'url' => $imageResult->getSecurePath(),
                        'public_id' => $imageResult->getPublicId(),
                    ];
                }
            }

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'type' => $request->type,
                'salesStatus' => $request->salesStatus,
                'salesDate' => $request->salesDate,
                'stock' => $request->stock,
                'sdStock' => $request->sdStock,
                'stockStatus' => $request->stockStatus,
                'detail' => $request->detail,
                'image' => json_encode($storeImage),
            ]);

            return redirect('/items');
        }
    }
    /**
     * 商品編集
     */
    public function edit(ItemRequest $request, Item $item)
    {   
        //バリデーション
            $data = $request->validated();
            $originalItemData  = $item;
        //削除するimageがある場合
        if(isset($request->imageDeleteCheck)){
            $public_ids = $request->imageDeleteCheck;
            $item = $this->imageDestroy($public_ids, $item->id); //画像を削除した配列でitemを再定義
            $data['image'] = $item->image;
        }

        //imageをアップロードする場合、配列に追加
        if($request->hasFile('images')){
            $storeImage = [];
            $oldImage = json_decode($item->image);
            foreach($request->file('images') as $image){
                $imageResult = cloudinary()->upload($image->getRealPath(), [
                    'folder' => 'Portfolio',
                ]);
                $storeImage[] =[
                    'url' => $imageResult->getSecurePath(),
                    'public_id' => $imageResult->getPublicId(),
                ];
            }
            //dd([$oldImage, $storeImage]);
            if($oldImage == null){
                $updateImage = $storeImage;
            }else{
                $updateImage = array_merge($oldImage, $storeImage);
            }
    
            $data['image'] = json_encode($updateImage);
        }
        //ログを作成
            $this->log($data, $originalItemData);            
        //更新
            $item->fill($data)->save();
            if($request->hasFile('images')){
                $item->update([
                    'image' => json_encode($updateImage),
                ]);
            }

        // 古いリファラー情報をクリア
            $request->session()->forget('previous_url');
            
            return redirect('/items');
        
    }
    public function editView(Item $item, Request $request){

        // セッション情報
        // 古いリファラー情報をクリア
        if (!old()) { // バリデーションエラーではない場合のみクリア
            $request->session()->forget('previous_url');
        }
        // 新しいリファラー情報をセッションに保存
        $previousUrl = $request->headers->get('referer'); // 前のURLを取得
        if ($previousUrl && !str_contains($previousUrl, '/items/' . $item->id)) {
            $request->session()->put('previous_url', $previousUrl);
        }

        $auth_user = Auth::user();
        $types = $this->type();
        $sales = $this->salesStatus();
        $targets = $this->target('Item');
        $logs = Log::where('target_type', 'Item')->where('target_id',$item->id)->orderBy('id', 'desc')->take(15)->get();
            foreach($logs as $log){
                $decoded_actions = json_decode($log->action);
                $actions = [];
                foreach($decoded_actions as $action){
                    if(isset($targets[$action])){
                        $actions[] = $targets[$action];
                    }else{
                        continue;
                    }
                }
                if($actions == null){
                    $actions = ['商品情報'];
                }
                $log->action = $actions;
            }
        $logUsers = [];
        foreach($logs as $log){
            $user = User::where('id', $log->user_id)->first();
            if($user && $user->status === 1){
                $logUsers[$log->id] =  $user->name;
            }else {
                $logUsers[$log->id] = 'ユーザー';
            }
        }
  
        return view('item.edit', compact('item', 'auth_user', 'types', 'sales', 'logUsers', 'logs', 'targets'));
    }
    /**
     * 商品詳細画面
     */
    public function itemView(Request $request,Item $item){

        // セッション情報
        // 古いリファラー情報をクリア
        $request->session()->forget('previous_url');

        // 新しいリファラー情報をセッションに保存
        $previousUrl = $request->headers->get('referer'); // 前のURLを取得
        if ($previousUrl && !str_contains($previousUrl, '/items/detail/' . $item->id)) {
            $request->session()->put('previous_url', $previousUrl);
        }

        $auth_user = Auth::user();
        $types = $this->type();
        $sales = $this->salesStatus();
        $targets = $this->target('Item');
        $logs = Log::where('target_type', 'Item')->where('target_id',$item->id)->orderBy('id', 'desc')->get();
        $logUsers = [];
            foreach($logs as $log){
                $decoded_actions = json_decode($log->action);
                $actions = [];
                foreach($decoded_actions as $action){
                    if(isset($targets[$action])){
                        $actions[] = $targets[$action];
                    }else{
                        continue;
                    }
                }
                if($actions == null){
                    $actions = ['商品情報'];
                }
                $log->action = $actions;
            }
            foreach($logs as $log){
                $logUser = User::where('id', $log->user_id)->first();

                if($logUser && $logUser->status === 1){
                    $logUsers[$log->id] =  $logUser->name;
                }else {
                    $logUsers[$log->id] = 'ユーザー';
                }
                
            }
        
            //dd($logUsers);
  
        return view('item.detail', compact('item', 'auth_user', 'types', 'sales', 'logUsers', 'logs', 'targets'));
    }
    /**
     * ログ作成
     */
    public function log($validatedData, Item $item){
        $logs = [];
        $memo = $validatedData['memo'] ?? null;
        unset($validatedData['memo']);
        //dd($validatedData);
        foreach($validatedData as $key => $value){
            if( $key === 'images'){
                // ログのアクションには、imagesではなく、imageを使用するため
                continue;
            }else{
                if( $key === 'salesDate'){
                    // 編集formのsalesDateをDate型からDateTime型に変換
                    $value = new DateTime($value);
                }
                if($item->getOriginal($key) != $value){
                    $actions[] = $key;
                    $before_values[$key] = $item->getOriginal($key);
                    $after_values[$key] = $value; 
                } 
            }
        }
        if(!empty($actions)){
            $logs[] = [
                    'user_id' => Auth::id(),
                    'target_type' => 'Item',
                    'target_id' => $item->id,
                    'action' => json_encode($actions),
                    'before_value' => json_encode($before_values),
                    'after_value' => json_encode($after_values),
                    'memo' => $memo,
                    'created_at' => now(),
                    'updated_at' => now(),               
                ];
                //dd($logs);
        }
        if(!empty($logs)) {
            Log::insert($logs);
        }

        return;
    }
    /**
     * 商品削除
     */
    public function destroy(Item $item){
        $public_ids = [];
        if(isset($item->image)){
        
            for($i=0; $i<count(json_decode($item->image, true)); $i++){
                $public_ids[] = json_decode($item->image, true)[$i]['public_id'];
            }       
            foreach($public_ids as $public_id){
                Cloudinary::destroy($public_id);
            }
        }

        Log::where('target_type', 'Item')->where('target_id', $item->id)->delete();
        Item::destroy($item->id);

         return redirect()->route('items');
    }
    public function someDestroy(Request $request){
        $public_ids = [];
        //複数件削除
        $check_items = Item::whereIn('id', $request->input('id'))->get(); 
        foreach($check_items as $check_item){
            if(isset($check_item->image)){
                for($i=0; $i<count(json_decode($check_item->image, true)); $i++){
                    $public_ids[] = json_decode($check_item->image, true)[$i]['public_id'];
                }  
            }
        }
        Log::where('target_type', 'Item')->whereIn('target_id', $request->input('id'))->delete();   
        Item::destroy($request->id);
        
        if(!empty($public_ids)){
            foreach($public_ids as $public_id){
                Cloudinary::destroy($public_id);
            }
        }

        return redirect()->route('items');
    }
    /**
     * 画像削除
     */
    public function imageDestroy($public_ids, $item_id){
        $item = Item::find($item_id);
        $itemImages = json_decode($item->image, true);
        foreach($itemImages as $key => $value){
            if(array_search($value['public_id'], $public_ids) !== false){
                unset($itemImages[$key]);
            }
        }

        $itemImages = array_values($itemImages); //indexを詰める
        $item->update([
            'image' => json_encode($itemImages), 
        ]);

        foreach($public_ids as $public_id){
            Cloudinary::destroy($public_id);
        }

        $newData = Item::find($item->id);

        return $newData;
    }
    
}
