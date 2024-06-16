<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications(Request $request) {
        $notifications = Notification::where('user_id', $request->user()->id)->where('read', false)->get();

        return $this->successResponse(
            [
                'notification_count' => count($notifications),
                'notifications' => $notifications->toArray()
            ]
        );
    }

    public function readNotifications(Request $request) {
        $notifications = Notification::where('user_id', $request->user()->id);
        $notifications->update(['read' => true]);

        return $this->successResponse([
            'message' => 'Notifications read'
        ]);
    }
}
