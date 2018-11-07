<?php

namespace Models;

use Core\Model;

class Manufacturer extends Model
{
    protected $table = 'manufacturer';

    protected $allowed = [
        'name'
    ];

    protected $timestamp = false;

    public function __construct()
    {
        parent::__construct();
    }
}