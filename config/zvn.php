<?php

return [
    'url' => [
        'prefix_admin' => 'admin123', 
        'prefix_news' => 'news',
    ], 
    'format' => [
        'long_time' => 'H:m:s d/m/Y',
        'short_time' => 'd/m/Y',
    ], 
    'template' => [
        'status' => [
            'all' => ['name' => 'Tất cả', 'class' => 'btn-success'],
            'active' => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            'inactive' => ['name' => 'Chưa kích hoạt', 'class' => 'btn-info'], 
            'block' => ['name' => 'Bị khoá', 'class' => 'btn-danger'], 
            'default' => ['name' => 'Chưa xác định', 'class' => 'btn-success']
        ], 
        'search' => [
            'all' => ['name' => 'Search by All'],
            'id' => ['name' => 'Search by ID'],
            'name' => ['name' => 'Search by Name'],
            'username' => ['name' => 'Search by Username'],
            'fullname' => ['name' => 'Search by Fullname'],
            'email' => ['name' => 'Search by Email'],
            'description' => ['name' => 'Search by Description'],
            'link' => ['name' => 'Search by Link'],
            'content' => ['name' => 'Search by Content'],
        ], 
        'button' => [
            'edit' => ['class' => 'btn-success', 'title' => 'Edit', 'icon' => 'fa-pencil', 'route-name' =>  '/form'], 
            'delete' => ['class' => 'btn-danger btn-delete', 'title' => 'Delete', 'icon' => 'fa-trash', 'route-name' =>  '/delete'],
            'info' => ['class' => 'btn-info', 'title' => 'View', 'icon' => 'fa-pencil', 'route-name' =>  '/delete'] //dùng để xem chi tiết 1 slider nào đó 
        ]
    ], 
    //thay vì trong template.php ta viết search, ta sẽ viết ở đây luôn, tương tự với btn, ...
    'config' => [
        'search' => [
            'default' => ['all', 'id', 'fullname'],
            'slider' => ['all','id', 'name', 'description', 'link']
        ], 
        'button' => [
            'default' => ['edit', 'delete'], //mặc định phần quản lý sẽ có nút edit và delete 
            'slider' => ['edit', 'delete'],
            'category' => ['edit', 'delete', 'info'],
        ]
    ]

];