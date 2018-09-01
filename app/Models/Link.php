<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Log;

class Link extends Model
{
    protected  $fillabe=['title','link'];

    public $cache_key='Abc_links';

    protected $cache_expire_in_minute=1440;

    public function getAllCache()
    {
    	return \Cache::remember($this->cache_key,$this->cache_expire_in_minute,function(){
    			return $this->all();
    	});
    }
}
