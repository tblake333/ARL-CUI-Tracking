<?php

namespace App\Controllers;

use App\Models\ItemModel;
use CodeIgniter\Controller;

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

            $isValid = $this->validate(self::ITEM_RULES_NAME);
            $entries = $this->request->getVar();

            if ($isValid) {
                // Validation success
                $itemModel = new ItemModel();
                
                $itemModel->insert([
                    'barcode' => self::getValue($entries['barcode']),
                    'title' => self::getValue($entries['title']),
                    'type' => self::getValue($entries['type']),
                    'source' => self::getValue($entries['source']),
                    'source_date' => self::getValue($entries['source_date']),
                    'location' => self::getValue($entries['location']),
                    'description' => self::getValue($entries['description'])
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