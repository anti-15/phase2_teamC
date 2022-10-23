<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Member;
use Auth;
use Validator;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required',
            'password' => 'required',
        ]);


        // バリデーション:エラー
        if ($validator->fails()) {
            return redirect()
                ->route('group.join')
                ->withInput()
                ->withErrors(array('group_id' => '不正な値です'));
        }
        // create()は最初
        // create()は最初から用意されている関数
        // 戻り値は挿入されたレコードの情報
        
        
        //入力チェック
        //グループがあるかどうかのチェック、グループがあるならtrueを返す。
        $exists = Group::where('group_id', $request->group_id)->exists();

        //グループがありません
        if($exists === false){
            return redirect()
                ->route('group.join')
                ->withInput()
                ->withErrors(array('group_id' => 'グループがありません'));
        }

        //group_idとpasswordが一致するかどうかのチェック、一致するならtureを返す。
        $password = Group::where('group_id', $request->group_id)
                ->where('password',$request->password)
                ->exists();
        
        //パスワードが一致しません
        if($exists === true && $password === false){
            return redirect()
                ->route('group.join')
                ->withInput()
                ->withErrors(array('group_id' => 'パスワードが一致しません'));
        }

        //すでにjoinしているかどうかをチェック、joinしているならtrueを返す。
        $member = Member::where('group_id', $request->group_id)
                ->where('member_id', auth::user()->id)
                ->exists();

                //ddd($member);
        
        //すでにjoinしていたら、何もせずにdashboardに飛ばす
        if($member === true){
          return redirect()->route('dashboard');
        }
        //joinしていなかったら、membersテーブルに情報を書き込んでdashboardに飛ばす。
        else{
            $data = $request->merge(['member_id' => Auth::user()->id])->all();
            $result = Member::create($data);

            return redirect()->route('dashboard');
        }
        
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
