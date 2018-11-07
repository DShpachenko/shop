<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Response;
use Models\ {
    Sections,
    Products,
    Manufacturer,
    ProductsWithSections
};

class ShopController extends Controller
{
    private $data;

    private $sections;
    private $products;
    private $manufacturer;
    private $productsWithSections;

    public function __construct()
    {
        parent::__construct();

        $this->data = Request::input();

        $this->sections             = new Sections();
        $this->products             = new Products();
        $this->manufacturer         = new Manufacturer();
        $this->productsWithSections = new ProductsWithSections();
    }

    /*
     * requirement int id
     */
    public function find()
    {
        Response::json($this->products->find($this->data['id']));
    }

    /*
     * requirement string name
     * int from
     */
    public function search()
    {
        $from = $this->data['from'] ?? 0;
        
        Response::json($this->products->searchBy(
            'name',
            $this->data['name'],
            $from
        ));
    }

    /*
     * requirement int array manufacturers
     */
    public function getByManufacturers()
    {
        Response::json($this->products->findWhereIn(
            'manufacturer_id',
            (array) $this->data['manufacturers']
        ));
    }

    /*
     * requirement int section
     */
    public function getBySection()
    {
        $items = $this->productsWithSections->findBy('section_id', $this->data['section']);

        $productIds = [];
        $count = count($items);

        for($i = 0; $i < $count; $i++) {
            $productIds[] = $items[$i]['product_id'];
        }

        Response::json($this->products->findWhereIn('id', $productIds));
    }

    /*
     * requirement int section
     */
    public function getBySections()
    {
        $sectionsIds = $this->sections->nestedSections($this->data['section']);

        $items = $this->productsWithSections->findWhereIn('section_id', $sectionsIds);

        $productIds = [];
        $count = count($items);

        for($i = 0; $i < $count; $i++) {
            $productIds[] = $items[$i]['product_id'];
        }

        Response::json($this->products->findWhereIn('id', $productIds));
    }
}