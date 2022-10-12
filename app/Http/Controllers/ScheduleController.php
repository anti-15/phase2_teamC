<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Schedule;
use Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=Schedule::whereDate('start_at','>=',$request->start)
                    ->whereDate('finish_at','<=',$request->end)
                    ->get(['id','title','start_at','finish_at']);
        // TODO: start_atをstartに、finish_atをendに変換する処理もしくはScheduleテーブルのスキーマを変更する。
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedule_create');
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
            'start_at' => 'required',
            'finish_at' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        // バリデーション:エラー
        if ($validator->fails()) {
            return redirect()
                ->route('schedule.create')
                ->withInput()
                ->withErrors($validator);
        }
        $user_id = Auth::id();
        // create()は最初から用意されている関数
        // 戻り値は挿入されたレコードの情報
        $result = Schedule::create([
            'user_id' => $user_id, 'start_at' => $request->start_at, 'finish_at' => $request->finish_at,
            'title' => $request->title, 'description' => $request->description
        ]);
        // ルーティング「todo.index」にリクエスト送信（一覧ページに移動）
        return redirect()->route('dashboard');
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
