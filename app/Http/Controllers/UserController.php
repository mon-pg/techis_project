<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;

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
        $users = User::all();

        $roles = $this->roles();
        $departments = $this->departments();

        return view('user.index',['users' => $users,  'roles' => $roles, 'departments' => $departments]);
    }

    /**
     * 一括編集
     */
    public function someEdit(){
        $users = User::where('id',1)->get();

        $roles = $this->roles();
        $departments = $this->departments();

        return view('user.someEdit', ['users' => $users,  'roles' => $roles, 'departments' => $departments]);
    }

    /**
     * 一件編集
     */
    public function edit(Request $request,User $user){
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'id' => 'required',
                'name' => 'required',
                'role' => 'required',
            ]);

            //$user = User::find($request->id);

            if(!empty($request->department)){
                // ユーザー情報更新
                $user->update([
                    'role' => $request->role,
                    'department' => $request->department,
                ]);
            }else{
                $user->update([
                    'role' => $request->role,
                ]);
            }

            $logs = Log::where('target_type', 'user')->where('target_id',$user->id)->get();
            return redirect('/users');
        }

        $roles = $this->roles();
        $departments = $this->departments();

        return view('user.edit',[ 'user' => $user, 'roles' => $roles, 'departments' => $departments]);
    }

    /**
     * ユーザーの論理削除
     */
    public function delete(User $user){
        if($user->status === 1){
            $user->update([
                'status' => 2,
            ]);
        }
        return redirect('users');
    }
}
