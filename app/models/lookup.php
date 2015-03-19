<?php
namespace App\Models;

use Model;

class Lookup extends Model{
	public static $_table_use_short_name = true;
	public static $_table = 'lookup';
	
	public function Links(){
		$this->has_many('\App\Models\Links', 'status', 'code')->where('lookup.type', 'link.status');
	}
}