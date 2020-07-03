<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    
    protected $table = 'users';

    protected $allowedFields = ['badge_number', 'first_name', 'last_name'];
}