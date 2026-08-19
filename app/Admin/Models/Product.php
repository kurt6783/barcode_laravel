<?php

namespace App\Admin\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'product';

    protected $fillable = [];

    protected $guarded = [];

    protected $casts = [];

    public $timestamps = false;

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->init();

        parent::__construct($attributes);
    }

    protected function init()
    {
        $this->setConnection('sqlite');
        $this->setTable($this->table);
    }
}
