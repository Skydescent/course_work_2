<?php


namespace App\Controller;

use App\Model;
use App\Helpers\Pagination;
class AdminController extends \App\Controller
{
    public function users($currentPage = 1)
    {
        $total = Model\User::query()->count();
        $perpage = 2;
        $uri = '/admin/users/';
        $pagination = new Pagination($currentPage,$perpage,$total, $uri);
        $start = $pagination->getStart();

        $posts = Model\User::query()
            ->select('login', '', 'text', 'created_at', 'img')
            ->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($perpage)
            ->get();
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