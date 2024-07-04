<?php

namespace Imrancse94\Grocery\app\Services;

class PermissionService
{
    const PERMISSIONS = [
        'manager'=>[
            'preorder.list'
        ],
        'admin'=>['*']
    ];
}
