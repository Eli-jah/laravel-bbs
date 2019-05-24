<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\ReplyRequest;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Transformers\ReplyTransformer;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Topic $topic)
    {
        // 关闭 Dingo 的预加载。
        // 有可能使用深层 include 地方都可以暂时这么处理。
        app(\Dingo\Api\Transformer\Factory::class)->disableEagerLoading();

        $replies = $topic->replies()->paginate(20);

        if ($request->include) {
            $replies->load($request->include);
        }

        return $this->response->paginator($replies, new ReplyTransformer());
    }

    /**
     * Display a listing of the topic replies from some user.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function userIndex(Request $request, User $user)
    {
        // 关闭 Dingo 的预加载。
        // 有可能使用深层 include 地方都可以暂时这么处理。
        app(\Dingo\Api\Transformer\Factory::class)->disableEagerLoading();

        $replies = $user->replies()->paginate(20);

        if ($replies->include) {
            $replies->load($request->include);
        }

        return $this->response->paginator($replies, new ReplyTransformer());
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
        if ($reply->topic_id != $topic->id) {
            return $this->response->errorBadRequest();
        }

        $this->authorize('destroy', $reply);
        $reply->delete();

        return $this->response->noContent();
    }
}
