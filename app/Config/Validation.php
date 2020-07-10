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
        \App\Validation\MovementRules::class,
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

    /**
     * Rules for adding or updating a CUI item.
     * 
     * @var array
     */
	public $item = [
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
        'owner' => [
            'rules' => 'required|numeric|max_length[6]',
            'errors' => [
                'required' => 'A badge number is required.',
                'numeric' => 'Badge number must contain only numerical digits.',
                'max_length' => 'Badge number must not exceed 6 digits.'
            ]
        ],
        'first_name' => [
            'rules' => 'permit_empty|alpha|max_length[70]',
            'errors' => [
                'required' => 'First name required.',
                'alpha' => 'First name must contain only alphabetic characters',
                'max_length' => 'First name must not exceed 70 characters'
            ]
        ],
        'last_name' => [
            'rules' => 'permit_empty|alpha|max_length[70]',
            'errors' => [
                'required' => 'Last name required.',
                'alpha' => 'Last name must contain only alphabetic characters',
                'max_length' => 'Last name must not exceed 70 characters'
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
        ],
        'keywords' => [
            'rules' => 'permit_empty|max_length[40]|regex_match[/(\w+[,\s]*)+/]',
            'errors' => [
                'max_length' => 'List of keywords must not exceed 40 characters',
                'regex_match' => 'Keywords must be separated by commas or spaces'
            ]
        ]
    ];

    /**
     * Rules for adding or updating a user
     * 
     * @var array
     */
    public $user = [
        'badge_number' => [
            'rules' => 'required|numeric|max_length[6]|is_unique[users.badge_number]',
            'errors' => [
                'required' => 'A badge number is required.',
                'numeric' => 'Badge number must contain only numerical digits.',
                'max_length' => 'Badge number must not exceed 6 digits.',
                'is_unique' => 'Badge number is taken by another user.'
            ]
        ],
        'first_name' => [
            'rules' => 'required|alpha|max_length[70]',
            'errors' => [
                'required' => 'First name required.',
                'alpha' => 'First name must contain only alphabetic characters',
                'max_length' => 'First name must not exceed 70 characters'
            ]
        ],
        'last_name' => [
            'rules' => 'required|alpha|max_length[70]',
            'errors' => [
                'required' => 'Last name required.',
                'alpha' => 'Last name must contain only alphabetic characters',
                'max_length' => 'Last name must not exceed 70 characters'
            ]
        ],
    ];

    /**
     * Rules for checking out a CUI item
     * 
     * @var array
     */
    public $checkout = [
        'barcode' => [
            'rules' => 'required|exact_length[10]|is_not_unique[items.barcode]|is_checked_in',
            'errors' => [
                'required' => 'Please scan a barcode.',
                'exact_length' => 'Please scan a valid barcode.',
                'is_not_unique' => 'Item barcode not found.',
                'is_checked_in' => 'Item is already checked out.'
            ]
        ],
        'badge_number' => [
            'rules' => 'required|numeric|max_length[6]',
            'errors' => [
                'required' => 'A badge number is required.',
                'numeric' => 'Badge number must contain only numerical digits.',
                'max_length' => 'Badge number must not exceed 6 digits.'
            ]
        ],
        'first_name' => [
            'rules' => 'permit_empty|alpha|max_length[70]',
            'errors' => [
                'required' => 'First name required.',
                'alpha' => 'First name must contain only alphabetic characters',
                'max_length' => 'First name must not exceed 70 characters'
            ]
        ],
        'last_name' => [
            'rules' => 'permit_empty|alpha|max_length[70]',
            'errors' => [
                'required' => 'Last name required.',
                'alpha' => 'Last name must contain only alphabetic characters',
                'max_length' => 'Last name must not exceed 70 characters'
            ]
        ]
    ];

    public $checkin = [
        'barcode' => [
            'rules' => 'required|exact_length[10]|is_not_unique[items.barcode]|is_checked_out',
            'errors' => [
                'required' => 'Please scan a barcode.',
                'exact_length' => 'Please scan a valid barcode.',
                'is_not_unique' => 'Item barcode not found.',
                'is_checked_in' => 'Item is already checked in.'
            ]
        ]
    ];
}
