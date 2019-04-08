<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Http\Requests\ReplyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReplyRequest $request, Reply $reply)
    {
        $reply->topic_id = $request->input('topic_id');
        $reply->content = $request->input('content');
        $reply->user_id = Auth::id();
        $reply->save();

        return redirect()->to($reply->topic->link())->with('success', '评论创建成功！');
    }

    public function destroy(Request $request, Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->to($reply->topic->link())->with('success', '评论删除成功！');
    }
}
