<?php

namespace App\Controller;

use App\Controller;
use App\Exception\NoRightsException;
use App\Helpers\Sender;
use App\Model;

use App\Model\Comment;
use App\Model\PostsList;
use App\View\View;
use function helpers\htmlSecure;
use function helpers\redirect;

class PostController extends Controller
{
    /**
     * Получает и обрабатывает данные для отображения страницы со статьёй.
     *
     * @param string $id
     * @return View
     */
    public  function post(string $id)
    {
        $post = PostsList::whereId($id)->where('is_active', '<>', '0')->first();
        //var_dump('PostController.post');
        if (is_null($post)) {
            $_SESSION['error']['page'] = 'Доступ к статье закрыт, либо она не существует';
            redirect();
        }
        $comments = Comment::query()
            ->where('post_id', '=', $id)
            ->LeftJoin('users', 'author_id', '=', 'users.id')
            ->get();

        if (!empty($_POST)) {
            if (!isset($_SESSION['auth_subsystem'])) {
                $_SESSION['error']['page'] = 'Комментарий могут оставить только зарегистрированные пользователи, пожалуйста Авторизуйтесь или зарегистрируйтесь!';
                redirect();
            }

            $data =htmlSecure($_POST);

            if ($data['text'] == '') {
                $_SESSION['error']['page'] = 'Пустой комментарий оставить нельзя!';
                redirect();
            }
            $data['post_id'] = $post->id;
            $data['author_id'] = $_SESSION['auth_subsystem']['id'];
            $data['is_applied'] = '0';
            $data['created_at'] = date('Y-m-d',time());
            $comment = new Comment();
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

    /**
     * Получает и обрабатывает данные для отображения формы добавления новой статьи.
     *
     * @return View
     */
    public function new()
    {
        if (!empty($_POST) && isset($_POST['add_post'])) {

            $post = new PostsList();
            $data =htmlSecure($_POST);
            $data['user_id'] = $_SESSION['auth_subsystem']['id'];
            $data['created_at'] = date("Y-m-d");
            $data['is_active'] = 1;

            $this->createPost($data, $post, 'Статья успешно добавлена');

            $this->send($post->title, $post->text,"/post/$post->id");

            redirect('/');


        }
        return $this->getView();
    }

    /**
     * Получает и обрабатывает данные для отображения формы редактирования статьи.
     *
     * @param $id
     * @return View
     */
    public function edit(string $id)
    {
        $post = null;
        if (isset($_SESSION['auth_subsystem'])) {
            if ($_SESSION['auth_subsystem']['role'] == 'admin' || $_SESSION['auth_subsystem']['role'] == 'manager' ) {
                $post = PostsList::whereId($id)->first();
            } else {
                $post = PostsList::whereId($id)->where('user_id', '=', $_SESSION['auth_subsystem']['id'])->first();
            }
        }

        if (is_null($post)) {
            throw new NoRightsException();
        }

        if (!empty($_POST) && isset($_POST['edit_post'])) {
            $data =htmlSecure($_POST);
            $this->createPost($data, $post, 'Статья успешно обновлена');
            redirect("/");
        }

        return $this->getView(__METHOD__, ['post' => $post]);
    }


    /**
     * Валидирует и загружает в модель данные
     *
     * @param $data
     * @param $postModel
     * @param string $successMsg
     */
    private function createPost($data, $postModel, $successMsg = '')
    {
        $file = $this->getFile($postModel);

        if (
            !$postModel->validate($data) ||
            $file === false
        ) {
            $postModel->getErrors();
            $_SESSION['form_data'] =htmlSecure($data);
            redirect();
        }

        if ($file !== null) {
            if ($postModel->img !== '') {
                $postModel->deleteImg();
            }
            $data['img'] = $file;
        }

        $postModel->load($data);
        $postModel->save();
        $_SESSION['success'] = $successMsg;
    }

    /**
     * Отправляет в лог сообщения пользователями о добавлении новой статьи
     *
     * @param $title
     * @param $text
     * @param $postUrl
     */
    private function send ($title, $text, $postUrl)
    {
        $sender = new Sender($title, $text, BASE_URL . $postUrl);
        $sender->send();
    }

}