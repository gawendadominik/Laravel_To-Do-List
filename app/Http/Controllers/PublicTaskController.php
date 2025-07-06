<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PublicTaskLink;


class PublicTaskController extends Controller
{

    public function show($token)
    {
        $publicLink = PublicTaskLink::where('token', $token)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->firstOrFail();

        $task = $publicLink->task; // Assuming relation is set up

        if (!$task) {
            return view('public_task_show', ['error' => 'The task associated with this link is no longer available.']);
        }

        return view('public_task_show', compact('task'));
    }
}
