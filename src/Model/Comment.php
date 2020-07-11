<?php


namespace App\Model;


class Comment extends Model
{
    public $timestamps = false;
    protected $attributes = [
        'id' => '',
        'text' => '',
        'post_id' => '',
        'author_id' => '',
        'is_applied' => '',
        'created_at' => ''
    ];
    protected $table = 'comments';

}