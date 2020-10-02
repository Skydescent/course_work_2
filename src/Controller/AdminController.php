<?php

namespace App\Controller;

use App\Controller;
use App\Model;

use App\View\View;
use function helpers\h;
use function helpers\redirect;

class AdminController extends Controller
{
    /**
     * Получает и обрабатывает данные для отображения страницы пользователей.
     *
     * @return View
     */
    public function users()
    {
        $model = '\App\Model\User';
        if (!empty($_POST)) {
            if (isset($_POST['active'])) {
                $this->update('active', $model, 'is_active');
            }
            if (isset($_POST['role']) && strpos($_POST['role'], '_') !== false) {
                $this->update('role', $model, 'role_id');
            }
        }

        $pagination = $this->paginate($model, '/admin/users/', true);

        $roles = Model\Role::query()
            ->select('name', 'id')
            ->get();

        $users = Model\User::query()
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id','login', 'email', 'img', 'about', 'roles.name as role', 'roles.id as role_id', 'is_active')
            ->orderBy('id', 'asc')
            ->skip($pagination->getStart())
            ->take($pagination->getPerPage())
            ->get();

        return $this->getView(
            __METHOD__,
            [
                'title' => 'Пользователи',
                'users' => $users,
                'pagination' => $pagination,
                'roles' => $roles
            ]
        );
    }

    /**
     * Получает и обрабатывает данные для отображения страницы статей.
     *
     * @return View
     */
    public function posts()
    {
        $model = '\App\Model\PostsList';
        if (!empty($_POST)) {
            $name = 'active';
            if (isset($_POST[$name])) {
                $this->update($name, $model, 'is_active');
            }
        }

        $pagination = $this->paginate($model, '/admin/posts/', true);

        $comments = Model\Comment::query()
            ->select('id','post_id')
            ->get();
        $commentsCount = [];
        foreach ($comments as $comment) {
            $commentsCount[$comment['post_id']] = Model\Comment::query()
                ->where('post_id', '=', $comment['post_id'] )->count('post_id');
        }
        $posts = Model\PostsList::query()
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->select(
                'posts.id',
                'posts.created_at',
                'posts.img',
                'posts.title',
                'users.login as author',
                'posts.is_active'
            )
            ->orderBy('posts.id', 'asc')
            ->skip($pagination->getStart())
            ->take($pagination->getPerPage())
            ->get();

        return $this->getView(
            __METHOD__,
            [
                'title' => 'Статьи',
                'posts' => $posts,
                'comments' => $commentsCount,
                'pagination' => $pagination
            ]
        );

    }

    /**
     * Получает и обрабатывает данные для отображения страницы подписок.
     *
     * @return View
     */
    public function subscriptions()
    {
        $model = '\App\Model\Subscribed';
        if (!empty($_POST)) {
            $name = 'active';
            if (isset($_POST[$name])) {
                $this->update($name, $model, 'is_active');
            }
        }

        $pagination = $this->paginate($model, '/admin/subscriptions/', true);

        $subscriptions = Model\Subscribed::query()
            ->leftJoin('users', 'subscribed.email', '=', 'users.email')
            ->select('subscribed.id','subscribed.email', 'users.login', 'subscribed.is_active')
            ->orderBy('subscribed.id', 'asc')
            ->skip($pagination->getStart())
            ->take($pagination->getPerPage())
            ->get();

        return $this->getView(
            __METHOD__,
            [
                'title' => 'Подписки',
                'subscriptions' => $subscriptions,
                'pagination' => $pagination
            ]
        );

    }

    /**
     * Получает и обрабатывает данные для отображения страницы с комментариями.
     *
     * @return View
     */
    public function comments()
    {
        $model = '\App\Model\Comment';
        if (!empty($_POST)) {
            $name = 'active';
            if (isset($_POST[$name])) {
                $this->update($name, $model, 'is_applied');
            }
        }

        $pagination = $this->paginate($model, '/admin/comments/', true);


        $comments = Model\Comment::query()
            ->leftJoin('users', 'comments.author_id', '=', 'users.id')
            ->leftJoin('posts', 'comments.post_id', '=', 'posts.id')
            ->select(
                'comments.id',
                'comments.created_at',
                'comments.text',
                'comments.is_applied',
                'posts.title as post_title',
                'posts.id as post_id',
                'users.login as author'
            )
            ->orderBy('comments.id', 'asc')
            ->skip($pagination->getStart())
            ->take($pagination->getPerPage())
            ->get();

        return $this->getView(
            __METHOD__,
            [
                'title' => 'Подписки',
                'comments' => $comments,
                'pagination' => $pagination
            ]
        );
    }

    /**
     * Получает и обрабатывает данные для отображения страницы со статическими страницами.
     *
     * @return View
     */
    public function pages()
    {
        $model = '\App\Model\StaticPages';
        $changeId = $_POST['change'] ?? '';

        if (isset($_POST['submit_change'])) {
                $pageId = h($_POST['submit_change']);
                $page = ($model . '::find')($pageId);
                foreach (['title', 'text', 'alias'] as $field) {
                    $page[$field] = h($_POST[$field]);
                }
                $page->save();
                redirect();
        }

        if (isset($_POST['active'])) {
            $this->update('active', $model, 'is_active');
        }

        if (isset($_POST['new_page'])) {
            $newPage = new $model;
            $data = h($_POST);
            foreach ($data as $field => $value) {
                $data[explode('new_', $field)[1]] = $value;
                unset($data[$field]);
            }
            $newPage->load($data);
            $newPage->is_active = '1';
            unset($newPage->id);
            $newPage->save();
        }

        $pagination = $this->paginate($model, '/admin/pages/', true);



        $pages = Model\StaticPages::query()
            ->select('*')
            ->orderBy('id', 'asc')
            ->skip($pagination->getStart())
            ->take($pagination->getPerPage())
            ->get();

        return $this->getView(__METHOD__,
            [
                'title' => 'Страницы',
                'pages' => $pages,
                'change_id' => $changeId,
                'pagination' => $pagination,
            ]
        );
    }
}