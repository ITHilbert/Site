<?php

namespace ITHilbert\Site\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'vor_site';
    protected $primaryKey = 'ID';
    protected $guarded = ['ID'];
    public $timestamps = true;
}
