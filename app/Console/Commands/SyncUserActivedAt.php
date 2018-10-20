<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SyncUserActivedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Abc:sync-user-actived-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步用户最近登陆时间';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        $this->info('开始同步');
        $user->syncUserActivedAt();
        $this->info('同步成功');

    }
}
