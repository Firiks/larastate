<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;

class NotificationController extends Controller
{
    /**
     * Display notifications for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Inertia\ResponseFactory|\Inertia\Response
     */
    public function index(Request $request): Response
    {
        return inertia(
            'Notification/Index',
            [
                'notifications' => $request->user()->notifications()->paginate(10)
            ]
        );
    }
}
