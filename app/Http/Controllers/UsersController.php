<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;                        // 追加
use App\Models\User;                                        // 追加

class UsersController extends Controller
{
    public function index()                                       
    {                                                       
        // ユーザ一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10); 

        // ユーザ一覧ビューでそれを表示
        return view('users.index', [                        
            'users' => $users,                              
        ]);                                                 
    }                                           
    
    public function show($id)                               
    {     
        /// idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        // ユーザーの投稿一覧を作成日時の降順で取得
        $microposts = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);

        // ユーザ詳細ビューでそれを表示
        return view('users.show', [
            'user' => $user,
            'tasklists' => $tasklists,
        ]);
    }                                                       
}