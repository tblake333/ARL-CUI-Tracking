<?php

namespace App\Controllers;

use App\Models\ItemModel;
use CodeIgniter\Controller;

class Items extends Controller {

    const ITEM_ADD_RULES_NAME = 'item_add';

    public function add() {
        if ($this->formSubmitted()) {

            $validation = $this->validate(self::ITEM_ADD_RULES_NAME);
            $entries = $this->getEntries();
            if ($validation) {
                // Validation success
                $model = new ItemModel();
                
                $model->save([
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
     * Determines whether form was submitted, or is being
     * loaded for the first time.
     * 
     * @return boolean
     */
    private function formSubmitted() : bool {
        return (boolean) $this->request->getPost();
    }

    /**
     * Gets entries submitted from a form submission.
     * 
     * Note: This method should only be called AFTER form validation has been run.
     * 
     * @return array with field names as keys and field values as array values
     */
    private function getEntries() : array {
        $entries = array();
        foreach($this->request->getVar() as $field => $value) {
            $entries[$field] = $value;
        }
        return $entries;
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