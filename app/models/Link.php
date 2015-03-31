<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Link extends Model{
	protected $table = 'links';
	protected $fillable = ['name', 'uri', 'status_code'];

	public $timestamps = false;

	public function status() {
        return $this->belongsTo('\App\Models\Lookup', 'status_code', 'code')->where('lookup.type', 'link.status');
    }
}