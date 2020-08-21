<?php


namespace App\Controller;

use App\Model;
use App\Helpers\Pagination;
use function helpers\h;

class AdminController extends \App\Controller
{
    public function users()
    {
        if (!empty($_POST)) {
            if (isset($_POST['role'])) {
                [$id, $role] = explode('_', h($_POST['role']));
                $user = new \App\Model\User();
                $user->setRole($id, $role);
                redirect();
            }
        }

        $currentPage = $this->getCurrentPage();
        $total = Model\User::query()->count();
        $perpage = 2;
        $uri = '/admin/users/';
        $pagination = new Pagination($currentPage,$perpage,$total, $uri);
        $start = $pagination->getStart();
        $roles = Model\Roles::query()
            ->select('name')
            ->get();

        $users = Model\User::query()
            ->leftJoin('user-role', 'users.id', '=', 'user-role.user_id')
            ->leftJoin('roles', 'user-role.role_id', '=', 'roles.id')
            ->select('users.id','login', 'email', 'img', 'about', 'roles.name as role')
            ->orderBy('id', 'asc')
            ->skip($start)
            ->take($perpage)
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

    public function posts()
    {

    }

    public function signups()
    {

    }

    public function comments()
    {
        
    }
    
    public function pages()
    {
        
    }
}