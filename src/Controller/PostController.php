<?php


namespace App\Controller;

use App\Model;

class PostController extends \App\Controller
{
    public  function post($id)
    {
        $post = Model\PostsList::whereId($id)->first();
        $comments = Model\Comments::where('post_id', $id)->get();
        return $this->getView(__METHOD__, ['post'=> $post, 'comments' => $comments]);
    }

}