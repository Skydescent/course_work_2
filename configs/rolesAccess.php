<?php
return [
    'admin' => 'all',
    'manager' => ['no_access'=>['admin/users', 'admin/settings']],
    'registered' => ['no_access'=>['admin/']],
    'unregistered' => ['no_access'=>['admin/', 'user/profile', 'post/new', 'post/edit']],
];