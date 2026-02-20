<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = Auth::user();

        if ($user->role_id == 4) {
            // Super Admin — sees notifications they sent
            $notifications = Notification::where('sender_id', $user->id)
                ->where('expiry_date', '>=', now()->toDateString())
                ->where('status', 1)
                ->with('sender')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Get notifications targeted at this role + own sent notifications
            $notifications = Notification::where('expiry_date', '>=', now()->toDateString())
                ->where('status', 1)
                ->where(function ($q) use ($user) {
                    // Notifications within my school
                    $q->where(function ($inner) use ($user) {
                        $inner->where('school_id', $user->school_id);
                        if ($user->role_id == 1) {
                            $inner->where('target_audience', 'admin');
                        } elseif ($user->role_id == 2) {
                            $inner->whereIn('target_audience', ['teacher', 'teacher_and_student']);
                        } elseif ($user->role_id == 3) {
                            $inner->whereIn('target_audience', ['student', 'teacher_and_student']);
                        }
                    });
                    // Super admin notifications sent to all admins (school_id is null)
                    if ($user->role_id == 1) {
                        $q->orWhere(function ($inner) {
                            $inner->whereNull('school_id')->where('target_audience', 'admin');
                        });
                    }
                    // Also include my own sent notifications
                    $q->orWhere('sender_id', $user->id);
                })
                ->with('sender')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $data = $notifications->map(function ($n) {
            return [
                'id' => $n->id,
                'title' => $n->title,
                'message' => $n->message,
                'sender_name' => $n->sender->name ?? 'Unknown',
                'target_audience' => $n->target_audience,
                'expiry_date' => $n->expiry_date->format('M d, Y'),
                'expiry_date_raw' => $n->expiry_date->format('Y-m-d'),
                'created_at' => $n->created_at->format('M d, Y h:i A'),
                'is_mine' => $n->sender_id == Auth::id(),
            ];
        });

        return response()->json([
            'success' => true,
            'notifications' => $data,
        ]);
    }

    public function storeNotification(Request $request)
    {
        $user = Auth::user();

        // Permission check
        $allowedAudiences = [];
        if ($user->role_id == 4) {
            $allowedAudiences = ['admin'];
        } elseif ($user->role_id == 1) {
            $allowedAudiences = ['student', 'teacher', 'teacher_and_student'];
        } elseif ($user->role_id == 2) {
            $allowedAudiences = ['student'];
        } else {
            return response()->json(['success' => false, 'error' => 'You do not have permission to send notifications.']);
        }

        if (!in_array($request->target_audience, $allowedAudiences)) {
            return response()->json(['success' => false, 'error' => 'Invalid target audience.']);
        }

        if (!$request->title || !$request->message || !$request->expiry_date) {
            return response()->json(['success' => false, 'error' => 'Please fill all required fields.']);
        }

        Notification::create([
            'school_id' => $user->school_id,
            'sender_id' => $user->id,
            'title' => $request->title,
            'message' => $request->message,
            'target_audience' => $request->target_audience,
            'expiry_date' => $request->expiry_date,
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'result' => 'Notification sent successfully.',
        ]);
    }

    public function updateNotification(Request $request)
    {
        $user = Auth::user();
        $notification = Notification::find($request->id);

        if (!$notification) {
            return response()->json(['success' => false, 'error' => 'Notification not found.']);
        }

        if ($notification->sender_id != $user->id) {
            return response()->json(['success' => false, 'error' => 'You can only edit your own notifications.']);
        }

        if (!$request->title || !$request->message || !$request->expiry_date) {
            return response()->json(['success' => false, 'error' => 'Please fill all required fields.']);
        }

        $notification->update([
            'title' => $request->title,
            'message' => $request->message,
            'target_audience' => $request->target_audience,
            'expiry_date' => $request->expiry_date,
        ]);

        return response()->json([
            'success' => true,
            'result' => 'Notification updated successfully.',
        ]);
    }

    public function deleteNotification(Request $request)
    {
        $user = Auth::user();
        $notification = Notification::find($request->id);

        if (!$notification) {
            return response()->json(['success' => false, 'error' => 'Notification not found.']);
        }

        // Only sender or admin can delete
        if ($notification->sender_id != $user->id && $user->role_id != 1 && $user->role_id != 4) {
            return response()->json(['success' => false, 'error' => 'You do not have permission to delete this notification.']);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'result' => 'Notification deleted successfully.',
        ]);
    }
}
