<?php

namespace Models;

use Core\Model;

class ProductsWithSections extends Model
{
    protected $table = 'products_with_sections';

    protected $allowed = [
        'product_id',
        'section_id'
    ];

    protected $timestamp = false;

    public function __construct()
    {
        parent::__construct();
    }
}