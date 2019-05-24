<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\ReplyRequest;
use App\Models\Reply;
use App\Models\Topic;
use App\Transformers\ReplyTransformer;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\Api\ReplyRequest $request
     * @param  \App\Models\Topic $topic
     * @param  \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
        $reply->content = $request->input('content');
        $reply->topic()->associate($topic);
        $reply->user()->associate($this->user());
        $reply->save();

        return $this->response->item($reply, new ReplyTransformer())
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic, Reply $reply)
    {
        if($reply->topic_id != $topic->id){
            return $this->response->errorBadRequest();
        }

        $this->authorize('destroy', $reply);
        $reply->delete();

        return $this->response->noContent();
    }
}
