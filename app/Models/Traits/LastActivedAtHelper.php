<?php 
namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{
	//缓存
	protected $hash_prefix='Abc_last_active_at_';
	protected $field_prefic='user_';

	public function recordLastActivedAt()
	{
		//获取今天的日期
		$data=Carbon::now()->toDateString();
		//hash表：Abc_last_active_at_2018-08-31
		$hash=$this->hash_prefix.$data;

		//表字段名称
		$field=$this->field_prefic.$this->id;
		//获取今天时间
		$now=Carbon::now()->toDateTimeString();

		Redis::hSet($hash,$field,$now);
	}

	public function syncUserActivedAt()
	{
		//获取今天的日期
		$today_date=Carbon::now()->toDateString();
		$hash=$this->hash_prefix.$today_date;
		$dates=Redis::hGetAll($hash);
		foreach ($dates as $user_id => $actived_at) {
			$user_id=str_replace($this->field_prefic,'',$user_id);
			if($user=$this->find($user_id)){
				$user->last_actived_at=$actived_at;
				$user->save();
			}
		}

		Redis::del($hash);
	}

	public function getLastActivedAtAttribute($value)
    {
        // 获取今天的日期
        $date = Carbon::now()->toDateString();

       
        $hash = $this->hash_prefix . $date;

       
        $field = $this->field_prefix . $this->id;

        // 三元运算符，优先选择 Redis 的数据，否则使用数据库中
        $datetime = Redis::hGet($hash, $field) ? : $value;

        // 如果存在的话，返回时间对应的 Carbon 实体
        if ($datetime) {
            return new Carbon($datetime);
        } else {
        // 否则使用用户注册时间
            return $this->created_at;
        }
    }
}









 ?>