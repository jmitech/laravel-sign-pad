<?php

namespace Jmitech\LaravelSignPad\Tests\Models;

use Jmitech\LaravelSignPad\Concerns\RequiresSignature;
use Jmitech\LaravelSignPad\Contracts\CanBeSigned;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model implements CanBeSigned
{
    use RequiresSignature;

    protected $guarded = [];
}
