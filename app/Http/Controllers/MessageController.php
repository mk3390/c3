<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        try {
            $id = auth()->user()->id;
            $message = DB::select("SELECT users.id,users.name,m.content
FROM messages m join users on users.id=m.from_id
WHERE m.to_id = ".$id." AND
      m.id = (SELECT MAX(m2.id)
                      FROM messages m2
                      WHERE m2.to_id = m.to_id AND
                            m2.from_id = m.from_id 
                     )  
ORDER BY `m`.`to_id`  DESC
");
            $success['data'] = $message;
            $success['success'] = true;
            $success['message'] = "Post Created";
            return $this->sendResponse($success);
        } catch (\Exception $e) {
            $success['success'] = false;
            $success['error'] = $e->getMessage();
            return $this->sendResponse($success, 401);
        }
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
        try {
            $message = New Message();
            $message->from_id = $request->from;
            $message->to_id = auth()->user()->id;
            $message->content = $request->message;
            $message->save();
            $success['data'] = $message;
            $success['success'] = true;
            $success['message'] = "Post Created";
            return $this->sendResponse($success);
        } catch (\Exception $e) {
            $success['success'] = false;
            $success['error'] = $e->getMessage();
            return $this->sendResponse($success, 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
          try {
            $uid = auth()->user()->id;
            $message = DB::select("SELECT * FROM `messages` where (from_id=".$uid." and to_id=".$id.") or (from_id=".$id." and to_id=".$uid.")
");
            $success['data'] = $message;
            $success['success'] = true;
            $success['message'] = "Post Created";
            return $this->sendResponse($success);
        } catch (\Exception $e) {
            $success['success'] = false;
            $success['error'] = $e->getMessage();
            return $this->sendResponse($success, 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
