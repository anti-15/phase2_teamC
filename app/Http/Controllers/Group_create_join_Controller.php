<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Group;
use App\Models\Member;
use App\Models\Schedule;
use App\Models\User;
use App\Models\login;
use Auth;

class Group_create_join_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        return view('group.create_group');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request inde $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => ['required', 'unique:groups,group_id'],
            'password' => 'required',
        ]);


        // バリデーション:エラー
        if ($validator->fails()) {
            return redirect()
                ->route('group.create')
                ->withInput()
                ->withErrors(array('group_id' => 'このグループIDはすでに使われています'));
        }
        // create()は最初から用意されている関数
        // 戻り値は挿入されたレコードの情報


        $result = Group::create($request->all());
        $data = $request->merge(['member_id' => Auth::user()->id])->all();
        $result = Member::create($data);
        // ルーティング「todo.index」にリクエスト送信（一覧ページに移動）
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($group_id)
    {
        $i = 0;
        $user_id = Auth::user()->id;
        if (login::where('user_id', $user_id)->exists()) {
            login::where('user_id', $user_id)->delete();
        }
        $result = login::create([
            'user_id' => $user_id, 'group_id' => $group_id
        ]);
        $members = Member::where('group_id', $group_id)->get();
        foreach ($members as $member) {
            $users[] = User::where('id', $member->member_id)->get();
        }
        foreach ($members as $member) {
            if ($member->member_id == $user_id) {
                $i++;
            }
        }
        if ($i > 0) {
            foreach ($members as $member) {
                $schedules[] = Schedule::where('user_id', $member->member_id)->get();
            }
            return view('index', compact('group_id'), compact('users'));
        } else {
            return \App::abort(404);
        }
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
    public function destroy($user_id)
    {   
        
        //グループ退会処理
        $group = login::where('user_id', $user_id)->first();
        $result = Member::where('group_id', $group->group_id)
            ->where('member_id', Auth::user()->id)
            ->delete();

        return redirect()->route('dashboard');
    }

    public function join()
    {
        return view('group.join_group');
    }
}
