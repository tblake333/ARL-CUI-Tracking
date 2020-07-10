<?php

namespace App\Controllers;

use App\Models\MovementModel;
use App\Models\UserModel;
use App\Models\ItemModel;
use CodeIgniter\Controller;

class CheckIn extends BaseController {

    const CHECK_IN_RULES_NAME = 'checkin';
    
    public function index() {

        $session = session();

        if ($this->formSubmitted()) {

            $entries = $this->request->getVar();
            
            $isValid = $this->validate(self::CHECK_IN_RULES_NAME);

            if ($isValid) {
                // Validation success
                $session->set($entries);
                return redirect()->to('CheckIn/confirm');

            } else {
                // Validation failure
                echo view('checkin/CheckIn', ['validation' => $this->validator, 'entries' => $entries]);
            }
        } else {
            echo view('checkin/CheckIn');
        }
    }

    public function confirm() {
        
        $session = session();

        // Check if session exists
        $barcode = $session->get('barcode');
        if ($barcode) {

            $movementModel = new MovementModel();

            if ($this->formSubmitted()) {

                // Check if confirmation was cancelled
                $cancelled = $this->request->getPost('cancel') !== null;
                if ($cancelled) {
                    return redirect()->to('/CheckIn');
                }

                $movementModel->checkIn($barcode);
                
                $session->destroy();

                // TODO: Return to menu
                return redirect()->to('/CheckIn');

            } else {

                $badgeNumber = $movementModel->getMostRecentBadgeNumber($barcode);

                $userModel = new UserModel();
                $user = $userModel->find($badgeNumber);

                $itemModel = new ItemModel();
                $item = $itemModel->where('barcode', $barcode)->first();

                echo view('checkin/Confirm', ['user' => $user, 'item' => $item]);
            }

        } else {
            return redirect()->to('/CheckIn');
        }
    }
}