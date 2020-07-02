<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Items extends Controller {

    private static $ADD_ITEM_RULES = [
        'title' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'A title is required.',
                'max_length' => 'The title must not exceed 30 characters.'
            ]
        ],
        'barcode' => [
            'rules' => 'required|exact_length[10]',
            'errors' => [
                'required' => 'Please scan a barcode.',
                'exact_length' => 'Please scan a valid barcode.'
            ]
        ],
        'type' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'A type is required.',
                'max_length' => 'The type must not exceed 30 characters.'
            ]
        ],
        'source' => [
            'rules' => 'max_length[30]',
            'errors' => [
                'max_length' => 'The source must not exceed 30 characters.'
            ]
        ],
        'location' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'A location is required.',
                'max_length' => 'The location must not exceed 30 characters.'
            ]
        ],
        'description' => [
            'rules' => 'max_length[250]',
            'errors' => [
                'max_length' => 'The title must not exceed 250 characters.'
            ]
        ]
    ];

    public function add() {
        if ($this->request->getPost('source_date')) {
            self::$ADD_ITEM_RULES['source_date'] = [
                'rules' => 'valid_date[Y-m-d]',
                'errors' => [
                    'valid_date' => 'Enter a valid date.'
                ]
            ];
        }
        if (!$this->validate(self::$ADD_ITEM_RULES)) {
            echo 'please validate';
        } else {
            echo 'success';
        }
        echo view('add/Item', ['validation' => $this->validator]);
    }
}