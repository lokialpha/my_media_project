<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use Illuminate\Http\Request;

class ActionLogController extends Controller
{
    //action log
    public function setActionLog(Request $request){
        $data = [
            'user_id' => $request->user_id,
            'post_id' => $request->post_id
        ];
        ActionLog::create($data);

        $data = ActionLog::where('post_id',$request->post_id)->get();

        return response()->json([
            'post' => $data
        ]);
    }
}
