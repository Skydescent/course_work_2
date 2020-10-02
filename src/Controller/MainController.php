<?php

namespace App\Controller;

use App\Controller;
use App\Helpers\Sender;
use App\Model;
use App\View\View;

use function helpers\h;
use function helpers\redirect;

class MainController extends Controller
{
    /**
     * Получает и обрабатывает данные для отображения главной страницы.
     * Обрабатывает url c GET параметрами для отписки пользователей.
     *
     * @return View
     */
    public function index()
    {
        $total = Model\PostsList::query()->where('is_active', '<>', '0')->count();

        $pagination = $this->paginate($total, '/');
        $perPage = $pagination->getPerPage();

        $start = $pagination->getStart();
        $posts = Model\PostsList::query()
            ->select('id', 'title', 'text', 'created_at', 'img')
            ->where('is_active', '<>', '0')
            ->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($perPage)
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
                    $_SESSION['form_data']['email'] = $email;
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

        if (!empty($_GET)) {
            if (isset($_GET['email']) && isset($_GET['unsubscribe'])) {

                $email = Sender::decryptEmail(h($_GET['email']));

                $isUnsubscribe = h($_GET['unsubscribe']) == 'yes';
                if (!is_null($email) && $isUnsubscribe) {
                    $user = new Model\User();
                    $user->load(['email'=> $email]);
                    $user->toggleSubs();
                    $_SESSION['success'] = 'Вы отписались от нашей рассылки';
                    if (isset($_SESSION['auth_subsystem'])) {
                        $_SESSION['auth_subsystem']['is_subscribed'] = 'no';
                    }
                    redirect();
                }
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