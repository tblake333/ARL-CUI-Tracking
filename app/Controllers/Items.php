<?php

namespace App\Controllers;

use App\Models\ItemModel;
use CodeIgniter\Controller;

// TODO: Add confirmation page for adding item
class Items extends BaseController {

    /**
     * Name of variable defined in app/Config/Validation.php stating
     * the rules necessary to add or modify a CUI item.
     * 
     * @var string
     */
    const ITEM_RULES_NAME = 'item';

    public function add() {

        if ($this->formSubmitted()) {

            $entries = $this->request->getVar();

            $validation = \Config\Services::validation();
            $rules = $validation->getRuleGroup(self::ITEM_RULES_NAME);

            if (isset($entries['owner'])) {
                // Check if owner badge number is new to users database
                $isNew = (new \CodeIgniter\Validation\Rules())->is_unique($entries['owner'], 'users.badge_number', $entries);
                if ($isNew) {
                    // Update validation rules so first and last name are required
                    $rules['first_name']['rules'] = 'required|alpha|max_length[70]';
                    $rules['last_name']['rules'] = 'required|alpha|max_length[70]';
                }
            }

            $isValid = $this->validate($rules);

            if ($isValid) {
                // Validation success
                $itemModel = new ItemModel();
                
                $itemModel->insert([
                    'barcode' => self::getValue($entries['barcode']),
                    'title' => self::getValue($entries['title']),
                    'type' => self::getValue($entries['type']),
                    'owner' => self::getValue($entries['owner']),
                    'source' => self::getValue($entries['source']),
                    'source_date' => self::getValue($entries['source_date']),
                    'location' => self::getValue($entries['location']),
                    'description' => self::getValue($entries['description']),
                    // TODO: sanitize keywords
                    'keywords' => self::getValue($entries['keywords'])
                ]);
                echo 'success';
            } else {
                // Validation failed
                echo view('add/Item', ['validation' => $this->validator, 'entries' => $entries]);
            }
        } else {
            echo view('add/Item');
        }
    }

    /**
     * Function to get value of an input field.
     * 
     * Useful for inserting null values into the database instead of
     * empty strings.
     * 
     * @return mixed value of field if not empty, null otherwise.
     * 
     */
    private static function getValue(string $field) {
        return empty($field) ? null : $field;
    }
}