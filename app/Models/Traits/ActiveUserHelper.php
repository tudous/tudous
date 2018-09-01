<?php 
namespace App\Models\Traits;

use App\Models\Topic;
use App\Models\Reply;
use Carbon\Carbon;
use DB;
use Cache;
use Log;

trait ActiveUserHelper
{
	//存放数据
	protected $users=[];
	//配置
	protected $topic_weight=4;
	protected $reply_weight=1;
	protected $pass_days=7;
	protected $user_number=6;
	//缓存配置
	protected $cache_key='abc_active_users';
	protected $cache_expire_in_minutes=65;

	public function getActiveUsers()
	{
		return Cache::remember($this->cache_key,$this->cache_expire_in_minutes,function(){
			return $this->calculateActiveUsers();
		});
	}

	public function calculateAndCacheActiveUsers()
	{
		$active_users=$this->calculateActiveUsers();
		$this->cacheActiveUsers($active_users);
		
	}

	public function calculateActiveUsers()
	{
		$this->calculateTopicScore();
		$this->calculateReplyScore();

		
		// 数组按照得分排序
        $users = array_sort($this->users, function ($user) {
            return $user['score'];
        });

        // 我们需要的是倒序，高分靠前，第二个参数为保持数组的 KEY 不变
        $users = array_reverse($users, true);

        // 只获取我们想要的数量
        $users = array_slice($users, 0, $this->user_number, true);

        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $user) {
            // 找寻下是否可以找到用户
            $user = $this->find($user_id);

            // 如果数据库里有该用户的话
            if ($user) {

                // 将此用户实体放入集合的末尾
                $active_users->push($user);
            }
        }

        // 返回数据
        return $active_users;
	}

	private function calculateTopicScore()
	{
		$topic_users=Topic::query()->select(DB::raw('user_id,count(*) as topic_count'))
					->where('created_at','>=',Carbon::now()->subDays($this->pass_days))
					->groupBy('user_id')
					->get();
		
		//根据话题数量计算得分
		foreach ($topic_users as $value) {
			$this->users[$value->user_id]['score']=$value->topic_count*$this->topic_weight;
		}
	}

	private function calculateReplyScore()
	{
		$reply_users=Reply::query()->select(DB::raw('user_id,count(*) as reply_count'))
					->where('created_at','>=',Carbon::now()->subDays($this->pass_days))
					->groupBy('user_id')
					->get();

		foreach ($reply_users as $value) {
			 $reply_score=$value->reply_count*$this->reply_weight;
			 if(isset($this->users[$value->user_id])){
			 	$this->users[$value->user_id]['score'] +=$reply_score;
			 }else{
			 	$this->users[$value->user_id]['score'] =$reply_score;
			 }
		}
	}

	private function cacheActiveUsers($active_users)
    {
        // 将数据放入缓存中
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_minutes);
    }



}











 ?>