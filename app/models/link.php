<?php
namespace App\Models;

use Model;

class Link extends Model{
	public static $_table_use_short_name = true;
	public static $_table = 'links';

	public function lookup() {
        return $this->belongs_to('\App\Models\Lookup', 'status', 'code')->where('lookup.type', 'link.status');
    }
}