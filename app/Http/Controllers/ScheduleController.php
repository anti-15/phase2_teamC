<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Schedule;
use App\Models\login;
use App\Models\User;
use Auth;
use DateTime;
use App\Models\Member;
use DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        if (DB::table('logins')->where('user_id', $user_id)->exists()) {
            $group_id = login::where('user_id', $user_id)->first();
            $member_id = Member::where('group_id', $group_id->group_id)->pluck('member_id');

            $schedules = Schedule::whereIn('user_id', $member_id)
                ->whereDate('start_at', '>=', $request->start)
                ->whereDate('finish_at', '<=', $request->end)
                ->get(['id', 'title', 'start_at', 'finish_at', 'description', 'color']);
            // start_atをstartに、finish_atをendに変換する処理もしくはScheduleテーブルのスキーマを変更する。
            $converted_schedule = $schedules->map(
                function ($schedule) {
                    return collect([
                        'id' => $schedule->id,
                        'title' => $schedule->title,
                        'start' => $schedule->start_at,
                        'end' => $schedule->finish_at,
                        'description' => $schedule->description,
                        'color' => $schedule->color
                    ]);
                }
            );
        }
        return response()->json($converted_schedule);
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
        $user_color = User::where("id", $user_id)->first();
        // create()は最初から用意されている関数
        // 戻り値は挿入されたレコードの情報
        $result = Schedule::create([
            'user_id' => $user_id, 'color' => $user_color->color, 'start_at' => $request->start_at, 'finish_at' => $request->finish_at,
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
        $schedule = Schedule::find($id);
        $user_name = User::where('id', $schedule->user_id)->first();
        return view('schedule_detail', compact('schedule'), compact(('user_name')));
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
        $schedule = Schedule::where('id', $id)->first();
        $user_id = Auth::id();
        $body = json_decode($request->getContent(), true);
        if ($schedule->user_id == $user_id) {
            $start_at = new DateTime($body['start']);
            $finish_at = new DateTime($body['end']);
            $event = Schedule::find($id)->update([
                'start_at' =>  $start_at->modify('+9 hours'),
                'finish_at'  => $finish_at->modify('+9 hours'),
            ]);
            return response()->json($event);
        } else {
            return;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Schedule::where('id', $id)->first();
        $group_id = login::where('user_id', $user_id->user_id)->first();
        $schedule = Schedule::find($id)->delete();
        return redirect()->route('group.show', $group_id->group_id);
    }

    public function add(Request $request)
    {
        $user_id = Auth::id();
        $user_color=User::where("id",$user_id)->first();
        $body = json_decode($request->getContent(), true);
        $start_at = new DateTime($body['start']);
        $finish_at = new DateTime($body['end']);
        $schedules = Schedule::create([
            'user_id' => $user_id,
            'title' => $body['title'],
            'start_at' =>  $start_at->modify('+9 hours'),
            'finish_at'  => $finish_at->modify('+9 hours'),
            'description' => $body['description'],
            'color'=> $user_color->color
        ]);
        return response()->json($schedules);
    }
}
