<?php

namespace App\Listeners;

use App\Events\NewCommentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\UserNotification;

class NewCommentListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\NewCommentEvent  $event
     * @return void
     */
    public function handle(NewCommentEvent $event)
    {
        $comment = $event->comment;
        $userNotification = new UserNotification([
            'link' => route('post.show', ['post' => $comment->post]),
            'seen' => 0,
            'text' => view('components.user_notifications.new_comment', [
                'post' => $comment->post,
                'user' => $comment->user,
                'date' => new \DateTimeImmutable()
            ])->render()
        ]);
        $userNotification->user()->associate($comment->post->user);
        $userNotification->save();
    }
}
