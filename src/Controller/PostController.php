<?php


namespace App\Controller;

use App\Model;
use function helpers\h;
use function helpers\redirect;

class PostController extends \App\Controller
{
    public  function post($id)
    {
        $post = Model\PostsList::whereId($id)->first();

        $comments = Model\Comment::query()
            ->join('users', 'author_id', '=', 'users.id')
            ->get();

        if (!empty($_POST)) {
            if (!isset($_SESSION['auth_subsystem'])) {
                $_SESSION['error']['page'] = 'Комментарий могут оставить только зарегистрированные пользователи, пожалуйста Авторизуйтесь или зарегистрируйтесь!';
                redirect();
            }

            $data = h($_POST);

            if ($data['text'] == '') {
                $_SESSION['error']['page'] = 'Пустой комментарий оставить нельзя!';
                redirect();
            }
            $data['post_id'] = $post->id;
            $data['author_id'] = $_SESSION['auth_subsystem']['id'];
            $data['is_applied'] = '0';
            $data['created_at'] = date('Y-m-d',time());
            $comment = new Model\Comment();
            $comment->load($data);
            unset($comment->id);
            if ($comment->save()) {
                $_SESSION['success'] = 'Комментарий добавлен';
                redirect();
            } else {
                $_SESSION['error']['page'] = 'Ошибка, попробуйте добавить комментарий позже';
                redirect();
            }


        }


        return $this->getView(__METHOD__, ['post'=> $post, 'comments' => $comments]);
    }

}