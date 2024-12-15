<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class UserController extends Controller
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
     * 権限名取得
     */
    public function roles(){
        $roles = [
            1 => '管理者',
            2 => '編集者',
            3 => '閲覧者',   
        ];
        return $roles;
    }
     /**
     * 部署名取得
     */
    public function departments(){
        $departments = [
            1 => '商品管理部',
            2 => '営業部',
            3 => '商品開発部',
            4 => 'その他',
        ];
        return $departments;
    }

    /**
     * ユーザー一覧
     */
    public function index() {
        $users = User::paginate(10);
        $auth_user = Auth::user();
        $roles = $this->roles();
        $departments = $this->departments();

        return view('user.index',compact('users', 'roles', 'departments', 'auth_user'));
    }
    /**
     * ユーザー検索機能
     */
    public function search(Request $request){
        $users = User::query();
        $auth_user = Auth::user();
        $roles = $this->roles();
        $departments = $this->departments();

        $sKeywords = $request->input('sKeywords');
        $sRole = $request->input('sRole');
        $sDepartment = $request->input('sDepartment');

        if(empty($sKeywords)&&empty($sRole)&&empty($sDepartment)){   //検索内容が空の場合
            $searchError = '※検索項目を入力してください。';
            $users = $users->get();
            return view('user.index',compact('users', 'roles', 'departments', 'auth_user', 'searchError'));
        }else{

            if(!empty($sRole)){
                $users->where('role', $sRole);
            }
            if(!empty($sDepartment)){
                $users->where('department', $sDepartment);
            }
            if(!empty($sKeywords)){
                // 全角の英数字とスペースを半角に変換後、半角で区切った配列に変換
                $keywords = explode(' ', mb_convert_kana($sKeywords, 'as'));
                
                $users->where(function($query) use ($keywords){
                    foreach($keywords as $keyword){
                    $query->orWhere('name', 'LIKE', "%$keyword%")
                            ->orWhere('email', 'LIKE', "%$keyword%");       
                    }
                });
                
            }
            $checks = $users->get();
            $users = $users->paginate(10)->appends($request->query());            
            if(count($checks) === 0){
                $noUser = '該当するユーザーが存在しません。';
                return view('user.index', compact('users', 'roles', 'departments', 'auth_user', 'noUser'));
            }else{
                return view('user.index', compact('users', 'roles', 'departments', 'auth_user', 'sKeywords', 'sRole', 'sDepartment'));
            }
        }
    }


    /**
     * 一括編集画面
     */
    public function someEdit(Request $request){
        $ids = $request->input('user-check');

        if(empty($ids)){
            $users = User::all();
            $auth_user = Auth::user();
            $roles = $this->roles();
            $departments = $this->departments();
            $selectError = '※選択された項目がありません。';

        return view('user.index',compact('users', 'roles', 'departments', 'auth_user', 'selectError'));

        }else{
        $users = User::whereIn('id', $ids)->get();
        $auth_user = Auth::user();
        $roles = $this->roles();
        $departments = $this->departments();

        return view('user.someEdit',compact('users', 'roles', 'departments', 'auth_user'));
        }
    }
    /**
     * 一括編集保存
     */
    public function someEditSave(Request $request){
        $targetIds = $request->input('target_id');
        $roles = $request->input('role');
        $departments = $request->input('department');
        //dd($targetIds, $roles, $departments);
        foreach($targetIds as $i => $targetId){
            $updateData = [];
            $target = User::find($targetId);

            if($roles[$i] !== $target->role){
                $updateData['role'] =  $roles[$i];
            }
            if(!empty($departments[$i]) && $departments[$i] !== $target->department){
                $updateData['department'] = $departments[$i];
            }
            if(!empty($updateData['role']) || !empty($updateData['department'])){
                $target->update($updateData);
                
            }
        }

        return redirect('/users');
        
    }
    /**
     * 一件編集
     */
    public function edit(Request $request,User $user){
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $request->validate([
                'id' => 'required',
                'name' => 'required',
                'role' => 'required',
                'email' => 'required|email',
            ]);

            if(!empty($request->department)){
                // ユーザー情報更新
                $user->update([
                    'role' => $request->role,
                    'department' => $request->department,
                    'email' => $request->email,
                ]);
            }else{
                $user->update([
                    'role' => $request->role,
                    'email' => $request->email,
                ]);
            }

            $logs = Log::where('target_type', 'user')->where('target_id',$user->id)->get();
            return redirect('/users');
        }

        $auth_user = Auth::user();
        $roles = $this->roles();
        $departments = $this->departments();

        return view('user.edit',compact('user', 'roles', 'departments', 'auth_user'));
    }
    /**
     * ログの作成
     */
    public function log($type, $request){
        
        return true;

    }
    /**
     * ユーザーの論理削除
     */
    public function delete(User $user){
        if($user->status === 1){
            $user->update([
                'status' => 0,
            ]);
        }
        return redirect('users');
    }
}
