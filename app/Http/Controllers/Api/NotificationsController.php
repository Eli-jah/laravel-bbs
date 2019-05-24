<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Api\Controller;
use APP\Transformers\NotificationTransformer;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $this->user->notifications()->paginate(20);

        return $this->response->paginator($notifications, new NotificationTransformer());
    }
}
