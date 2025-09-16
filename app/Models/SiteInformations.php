<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteInformations extends Model
{
    use HasFactory;

    protected $fillable = ['email_01', 'email_02', 'phone_01', 'phone_02', 'text_about', 'link_instagram', 'link_facebook', 'link_twitter', 'link_youtube', 'link_linkedin',
        'text_footer', 'logo'];
}
