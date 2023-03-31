<?php

namespace App\Http\Controllers\Backend\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Announcements;
use App\Http\Controllers\Controller;
use App\Notifications\CreateAnnouncements;
use Illuminate\Support\Facades\Notification;

class AnnouncementsController extends Controller
{
    //
    public function store(Request $request)
    {
        $announcements = Announcements::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        //sending to user
        $user = User::first();
        $user->notify(new CreateAnnouncements($announcements));

        //sending to email

        Notification::send($announcements, new CreateAnnouncements($announcements));
        

        return response()->json($announcements);
    }
}