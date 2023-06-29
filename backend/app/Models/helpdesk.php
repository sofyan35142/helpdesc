<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class helpdesk extends Model
{
    use HasFactory;
    protected $table = 'helpdesc';
    protected $fillable = [
        'id_user', 'keluhan', 'link_img', 'deskripsi', 'foto'
    ];
}
