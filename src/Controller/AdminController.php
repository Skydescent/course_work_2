<?php

namespace App\Controller;

use App\Controller;
use App\Model\Subscribed;
use App\Model\User;
use App\Model\Role;
use App\Model\Comment;
use App\Model\PostsList;
use App\Model\StaticPages;
use App\Model\Setting;
use App\View\View;

use function helpers\createArrayTree;
use function helpers\arrayGet;
use function helpers\getSettingsId;
use function helpers\htmlSecure;
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
        $model = User::class;
        if (!empty($_POST)) {
            if (isset($_POST['active'])) {
                $this->update('active', $model, 'is_active');
            }
            if (isset($_POST['role']) && strpos($_POST['role'], '_') !== false) {
                $this->update('role', $model, 'role_id');
            }
        }

        $pagination = $this->paginate($model, '/admin/users', true);

        $roles = Role::query()
            ->select('name', 'id')
            ->get();

        $users = User::query()
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id','login', 'email', 'img', 'about', 'roles.name as role', 'roles.id as role_id', 'is_active')
            ->orderBy('id', 'desc')
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
        $model = PostsList::class;
        if (!empty($_POST)) {
            $name = 'active';
            if (isset($_POST[$name])) {
                $this->update($name, $model, 'is_active');
            }
        }

        $pagination = $this->paginate($model, '/admin/posts', true);

        $comments = Comment::query()
            ->select('id','post_id')
            ->get();
        $commentsCount = [];
        foreach ($comments as $comment) {
            $commentsCount[$comment['post_id']] = Comment::query()
                ->where('post_id', '=', $comment['post_id'] )->count('post_id');
        }
        $posts = PostsList::query()
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->select(
                'posts.id',
                'posts.created_at',
                'posts.img',
                'posts.title',
                'users.login as author',
                'posts.is_active'
            )
            ->orderBy('posts.id', 'desc')
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
        $model = Subscribed::class;
        if (!empty($_POST)) {
            $name = 'active';
            if (isset($_POST[$name])) {
                $this->update($name, $model, 'is_active');
            }
        }

        $pagination = $this->paginate($model, '/admin/subscriptions', true);

        $subscriptions = Subscribed::query()
            ->leftJoin('users', 'subscribed.email', '=', 'users.email')
            ->select('subscribed.id','subscribed.email', 'users.login', 'subscribed.is_active')
            ->orderBy('subscribed.id', 'desc')
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
        $model = Comment::class;
        if (!empty($_POST)) {
            $name = 'active';
            if (isset($_POST[$name])) {
                $this->update($name, $model, 'is_applied');
            }
        }

        $pagination = $this->paginate($model, '/admin/comments', true);


        $comments = Comment::query()
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
            ->orderBy('comments.id', 'desc')
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
        $model = StaticPages::class;
        $data =htmlSecure($_POST);
        $changeId = $data['change'] ?? '';

        if (isset($data['submit_change'])) {
                $pageId = $data['submit_change'];
                $page = StaticPages::find($pageId);

                $isAliasUnique = true;

                if ($page->alias !== $data['alias']) {
                    $page->alias = $data['alias'];
                    $isAliasUnique = $page->checkUnique(['alias']);
                }

                if (
                    !$page->validate($data) ||
                    !$isAliasUnique
                ) {
                    $page->getErrors();
                    $_SESSION['form_data'] = $data;
                    $_SESSION['form_data']['update'] = $pageId;
                    redirect();
                }

                foreach (['title', 'text', 'alias'] as $field) {
                    $page[$field] = $data[$field];
                }
                if($page->save()) {
                    $_SESSION['success'] = 'Страница изменена';
                }

                redirect();
        }

        if (isset($_POST['active'])) {
            $this->update('active', $model, 'is_active');
        }

        if (isset($data['new_page'])) {
            $newPage = new $model;
            foreach ($data as $field => $value) {
                $data[explode('new_', $field)[1]] = $value;
                unset($data[$field]);
            }
            $newPage->load($data);

            if (
                !$newPage->validate($data) ||
                !$newPage->checkUnique(['alias'])
            ) {
                $newPage->getErrors();
                $_SESSION['form_data'] = $data;
                $_SESSION['form_data']['new'] = true;
                redirect();
            }

            $newPage->is_active = '1';
            unset($newPage->id);
            if($newPage->save()) {
                $_SESSION['success'] = 'Страница добавлена';
            }
        }

        $pagination = $this->paginate($model, '/admin/pages', true);

        $pages = StaticPages::query()
            ->select('*')
            ->orderBy('id', 'desc')
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

    /**
     * Получает и обрабатывает данные для отображения страницы с дополнительными настройками.
     *
     * @return View
     */
    public function settings()
    {
        $settings = Setting::all()->toArray();
        $defaultFileSizeId = getSettingsId($settings, 'file.maxSize.default');
        $defaultSelectPagination = getSettingsId($settings, 'pagination.selects.default');
        $settings = createArrayTree($settings);
        $maxSize = arrayGet($settings, 'file.maxSize');
        $paginationSelect = arrayGet($settings, 'pagination.selects');

        if (!empty($_POST) && isset($_POST['update_settings'])) {
            $newDefaultFileSize = $_POST['fileSize'];
            $newDefaultSelectPagination = $_POST['select_default'];
            $oldDefaultFileSize = $maxSize['default'];
            $oldSelectPagination = $paginationSelect['default'];

            if ($newDefaultFileSize !== $oldDefaultFileSize) {
                Setting::query()->where('name', '=', $newDefaultFileSize)->update(['name' => $oldDefaultFileSize]);
                Setting::query()->where('parent_id', '=', $defaultFileSizeId)->update(['name' => $newDefaultFileSize]);
                unset($maxSize['default']);
                $maxSize['default'] = $newDefaultFileSize;
                $maxSize[array_search($newDefaultFileSize, $maxSize)] = $oldDefaultFileSize;
                $_SESSION['success'] = 'Настройки изменены';
            }
            if ($newDefaultSelectPagination !== $oldSelectPagination) {
                Setting::query()->where('name', '=', $newDefaultSelectPagination)->update(['name' => $oldSelectPagination]);
                Setting::query()->where('parent_id', '=', $defaultSelectPagination)->update(['name' => $newDefaultSelectPagination]);
                unset($paginationSelect['default']);
                $paginationSelect['default'] = $newDefaultSelectPagination;
                $paginationSelect[array_search($newDefaultSelectPagination, $paginationSelect)] = $oldSelectPagination;
                $_SESSION['success'] = 'Настройки изменены';
            }
        }


        return $this->getView(__METHOD__,
            [
                'title' => 'Дополнительные настройки',
                'maxSize' => $maxSize,
                'paginationSelect' => $paginationSelect
            ]
        );
    }
}