<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{

    public function readNotification($notification_id, $invoice_id)
    {
        foreach (auth()->user()->unreadNotifications as $notification)
            if ($notification->id == $notification_id) {
                $notification->markAsRead();
                break;
            }
        return redirect()->route('invoiceDetails.index', $invoice_id);
    }

    public function readAllNotifications()
    {
        $notifications = auth()->user()->unreadNotifications;
        if ($notifications)
            $notifications->markAsRead();
        return redirect()->route('home');
    }
}
