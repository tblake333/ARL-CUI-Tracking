<?php namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------

	public $item_add = [
        'title' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'A title is required.',
                'max_length' => 'The title must not exceed 30 characters.'
            ]
        ],
        'barcode' => [
            'rules' => 'required|exact_length[10]|is_unique[items.barcode]',
            'errors' => [
                'required' => 'Please scan a barcode.',
                'exact_length' => 'Please scan a valid barcode.',
                // TODO: Handle case where barcode is taken
                'is_unique' => 'This barcode is taken by another item.'
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
        'source_date'=> [
            'rules' => 'permit_empty|valid_date[Y-m-d]',
            'errors' => [
                'valid_date' => 'Enter a valid date.'
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
}
