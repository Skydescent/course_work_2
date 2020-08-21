<?php


namespace App\Controller;


use App\Model;
use App\Helpers\Pagination;
use function helpers\h;
use function helpers\redirect;

class MainController extends \App\Controller
{
    public function index()
    {
        $currentPage = $this->getCurrentPage();
        $total = Model\PostsList::query()->count();
        $perpage = 2;
        $uri = '/';
        $pagination = new Pagination($currentPage,$perpage,$total, $uri);
        $start = $pagination->getStart();
        $posts = Model\PostsList::query()
            ->select('id', 'title', 'text', 'created_at', 'img')
            ->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($perpage)
            ->get();

        if (!empty($_POST)) {
            $data = h($_POST);
            if (isset($_SESSION['auth_subsystem'])) {
                $email = $_SESSION['auth_subsystem']['email'];
            }
            if (isset($data['email']) && $data['email'] != '') {
                $email = $data['email'];
            }
            if (isset($email)) {
                $user = new Model\User();
                $user->load(['email'=> $email]);
                if (
                !$user->validate(null, ['email'])
                ) {
                    $user->getErrors();
                    redirect();
                }
                if (!$user->subscribe()) {
                    $user->getErrors();
                    redirect();
                }
                $_SESSION['success'] = 'Вы успешно подписаны на рассылку';
                if (isset($_SESSION['auth_subsystem'])) {
                    $_SESSION['auth_subsystem']['is_subscribed'] = 'yes';
                }
                redirect();
            }
        }

        return $this->getView(
            __METHOD__,
            [
                'title' => 'Свежие Посты:',
                'posts' => $posts,
                'pagination' => $pagination
            ]
        );
    }
}