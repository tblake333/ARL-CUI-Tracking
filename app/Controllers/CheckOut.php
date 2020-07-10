<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ItemModel;
use App\Models\MovementModel;
use CodeIgniter\Controller;

class CheckOut extends BaseController {

    const CHECK_OUT_RULES_NAME = 'checkout';
    
    public function index() {

        $session = session();
        
        if ($this->formSubmitted()) {

            $entries = $this->request->getVar();

            $validation = \Config\Services::validation();
            $rules = $validation->getRuleGroup(self::CHECK_OUT_RULES_NAME);

            if (isset($entries['badge_number'])) {
                // Check if badge number is new to database
                // TODO: Clean this
                $isNew = (new \CodeIgniter\Validation\Rules())->is_unique($entries['badge_number'], 'users.badge_number', $entries);
                if ($isNew) {
                    // Update validation rules so first and last name are required
                    $rules['first_name']['rules'] = 'required|alpha|max_length[70]';
                    $rules['last_name']['rules'] = 'required|alpha|max_length[70]';
                }
            }

            $isValid = $this->validate($rules);

            if ($isValid) {
                // Validation success
                $session->set($entries);
                return redirect()->to('CheckOut/confirm');
            } else {
                // Validation failure
                echo view('checkout/CheckOut', ['validation' => $this->validator, 'entries' => $entries]);
            }

        } else {

            // Send view with entries as session in the case that user is coming from
            // cancelled confirmation form

            echo view('checkout/CheckOut', ['entries' => $session->get()]);
            $session->destroy();
        }
    }

    public function confirm() {

        $session = session();

        // Check if session exists
        if ($session->get('barcode')) {

            $userModel = new UserModel();

            $badgeNumber = $session->get('badge_number');
            $barcode = $session->get('barcode');
            $user = $userModel->find($badgeNumber);
            
            // Use submit button as only input to check if confirmation page was submitted
            if ($this->formSubmitted()) {

                // Check if confirmation was cancelled
                $cancelled = $this->request->getPost('cancel') !== null;
                if ($cancelled) {
                    return redirect()->to('/CheckOut');
                }

                $movementModel = new MovementModel();

                if ($user) {
                    // User exists
                    $movementModel->checkOut($barcode, $badgeNumber);
                } else {
                    // User does not exist
                    $movementModel->checkOut($barcode, $badgeNumber, $session->get('first_name'), $session->get('last_name'));
                }

                $session->destroy(); 

                // TODO: Return to menu
                return redirect()->to('/CheckOut');

            } else {

                $itemModel = new ItemModel();
                $item = $itemModel->where('barcode', $barcode)->first();

                echo view('checkout/Confirm', ['session' => $session, 'user' => $user, 'item' => $item]);
            }
        } else {
            return redirect()->to('/CheckOut');
        }
    }
}