<?php

namespace App\Admin\Repositories;

use App\Admin\Models\Product as ProductModel;
use Dcat\Admin\Repositories\EloquentRepository;

class Product extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = ProductModel::class;
}
