<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;
use Log;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }

    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $reply->topic->increment('reply_count', 1);
        // 通知作者话题被回复了
       Log::info("话题被回复了");
        $res=$topic->user->notify(new TopicReplied($reply));
      Log::info("调用结束".$res);
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }
}