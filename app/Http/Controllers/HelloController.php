<?php

namespace App\Http\Controllers;

use App\Http\Requests\HelloRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HelloController extends Controller{

  //インデックスページの表示
  public function index(Request $request){
    $user = Auth::user();
    $sort = $request->sort;
    $items = DB::table('people')->orderBy($sort,'asc')->simplePaginate(5);
    $param = ['items' => $items, 'sort' => $sort, 'user' => $user];
    return view('hello.index',$param);
  }

  public function post(Request $request){
    $items = DB::select('select * from people');
    return view('hello.index',['items' => $items]);
  }

  //新規作成画面表示
  public function add(Request $request){
    return view('hello.add');
  }

  //新規作成処理の実行
  public function create(Request $request){
    $param = [
      'name' => $request->name,
      'mail' => $request->mail,
      'age' => $request->age,
    ];
    DB::table('people')->insert($param);
    return redirect('/hello');
  }

  //更新画面表示
  public function edit(Request $request){
    $item = DB::table('people')->where('id',$request->id)->get();
    return view('hello.edit',['form' => $item[0] ]);
  }

  //更新処理の実行
  public function update(Request $request){
    $param = [
      'id' => $request->id,
      'name' => $request->name,
      'mail' => $request->mail,
      'age' => $request->age,
    ];
    DB::table('people')
      ->where('id',$request->id)
      ->update($param);
      return redirect('/hello');
  }

  //削除画面表示
  public function del(Request $request){
    $item = DB::table('people')->where('id', $request->id)->get();
    return view('hello.del',['form' => $item[0] ]);
  }

  //削除処理の実行
  public function remove(Request $request){
    DB::table('people')->where('id', $request->id)->delete();
    return redirect('/hello');
  }

  //詳細画面表示
  public function show(Request $request){
    $id = $request->id;
    $item = DB::table('people')->where('id',$id)->first();
    return view('hello.show',['item' => $item]);

  }

  public function rest(Request $request){
    return view('hello.rest');
  }

  //セッション画面表示
  public function ses_get(Request $request){
    $sesdata = $request->session()->get('msg');
    return view('hello.session',['session_data' => $sesdata]);
  }

  //セッションに保管
  public function ses_put(Request $request){
    $msg = $request->input;
    $request->session()->put('msg',$msg);
    return redirect('hello/session');
  }

  public function getAuth(Request $request){
    $param = ['message' => 'ログインしてください。'];
    return view('hello.auth',$param);
  }

  public function postAuth(Request $request){
    $email = $request->email;
    $password = $request->password;
    if (Auth::attempt(['email' => $email,'password' => $password ])){
      $msg = 'ログインしました。('.Auth::user()->name.')';
    } else {
      $msg = 'ログインに失敗しました。';
    }
    return view('hello.auth',['message' => $msg]);
  }

}
