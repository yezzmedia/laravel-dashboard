<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Illuminate\Foundation\Auth\User;

class TestUser extends User
{
    protected $table = 'users';

    protected $guarded = [];
}
