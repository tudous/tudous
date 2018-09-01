<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        $user->act_token=str_random(30);
    }

    public function updating(User $user)
    {
        //
    }
    
     public function deleted(User $user)
    {
         \DB::table('topics')->where('user_id',$user->id)->delete();
         \DB::table('replies')->where('user_id',$user->id)->delete();
    }

    // 为用户设置默认头像
    public function saving(User $user)
    {
        // 这样写扩展性更高，只有空的时候才指定默认头像
        if (empty($user->avatar)) {
            $user->avatar = 'https://fsdhubcdn.phphub.org/uploads/images/201710/30/1/TrJS40Ey5k.png';
        }
    }
}