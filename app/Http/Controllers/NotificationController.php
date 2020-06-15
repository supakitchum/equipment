<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\Notification;
use App\ReservingTool;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read($message_id){
        $notification = Notification::find($message_id);
        if ($notification->user_id == auth()->user()->id){
            $notification->status = 1;
            $notification->save();
            return response()->json([
                'code' => 0,
                'result' => 'success'
            ]);
        }
        return response()->json([
            'code' => 1000,
            'result' => 'คุณไม่ได้เป็นเจ้่าของแจ้งเตือนนี้'
        ]);
    }
    /**
     * Display a listing of t
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('notification')->with([
            'results' => Notification::join('messages','notifications.message_id','=','messages.id')
                ->select('notifications.*','messages.text')
                ->where('user_id',auth()->user()->id)
                ->orderBy('id','desc')
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'code' => 0,
            'result' => [
                'unread' => Notification::where('user_id',auth()->user()->id)->where('status',0)->count(),
                'messages' => Notification::join('messages','notifications.message_id','=','messages.id')
                    ->select('notifications.*','messages.text')
                    ->where('user_id',auth()->user()->id)
                    ->limit(10)
                    ->orderBy('id','desc')
                    ->get()
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function restore($reserving_id)
    {
        $reserving = ReservingTool::find($reserving_id);
        if ($reserving->user_id !== auth()->user()->id || $reserving->reserving_state !== '1'){
            return redirect(route('notifications.index'))->with([
                'status' => [
                    'class' => 'danger',
                    'message' => 'คุณไม่ได้ยืมครุภัณฑ์นี้อยู่'
                ]
            ]);
        }

        $equipment = Equipment::find($reserving->equipment_id);
        return view('user.restore')->with([
            'reserving' => $reserving,
            'equipment' => $equipment
        ]);
    }
}
