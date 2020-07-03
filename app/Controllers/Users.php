<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Users extends BaseController {

    /**
     * Name of variable defined in app/Config/Validation.php stating
     * the rules necessary to add or modify a user.
     * 
     * @var string
     */
    const USER_RULE_NAME = 'user';

    public function add() {

        if ($this->formSubmitted()) {

            $isValid = $this->validate(self::USER_RULE_NAME);
            $entries = $this->request->getVar();

            if ($isValid) {
                // Validation success
                $userModel = new UserModel();

                $userModel->insert([
                    'badge_number' => $entries['badge_number'],
                    'first_name' => $entries['first_name'],
                    'last_name' => $entries['last_name']
                ]);

                echo 'success';
            } else {
                // Validation failed
                echo view('add/User', ['validation' => $this->validator, 'entries' => $entries]);
            }
        } else {
            echo view('add/User');
        }
    }

}