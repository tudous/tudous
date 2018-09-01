<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before($user, $ability)
	{
	    // 如果用户拥有管理内容的权限的话，即授权通过,拥有 manage_contents 权限的用户允许管理站点内所有话题和回复，包括编辑和删除动作；
        if ($user->can('manage_contents')) {
            return true;
        }
	}
}
