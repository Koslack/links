<?php
namespace App\Models;

class Lookup extends BaseModel{
	protected $table = 'lookup';

	public $timestamps = true;
	
	public function Links(){
		$this->hasMany('\App\Models\Link', 'status', 'code')->where('lookup.type', 'link.status');
	}
}