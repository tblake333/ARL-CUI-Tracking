<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = "items";

    protected $allowedFields = ['barcode', 'title', 'type', 'source', 'source_date', 'location', 'description'];
}