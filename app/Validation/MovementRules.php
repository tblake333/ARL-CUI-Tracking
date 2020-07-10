<?php

namespace App\Validation;

use App\Models\MovementModel;

/**
 * Movement Rules.
 * 
 * @author Tristan Blake
 */
class MovementRules {

    /**
     * The item corresponding to the barcode field is currently checked in.
     * 
     * @param string $str value of barcode field
     * 
     * @return boolean
     */
    public function is_checked_in(string $str): bool {

        $movementModel = new MovementModel();

        $status = $movementModel->getItemStatus($str);

        if ($status === 'in') {
            // Item is checked in, so check-out can be done
            return true;
        }

        // Item is currently checked out, reject check-out
        return false;
    }

    /**
     * The item corresponding to the barcode field is currently checked in.
     * 
     * @param string $str value of barcode field
     * 
     * @return boolean
     */
    public function is_checked_out(string $str) {

        $movementModel = new MovementModel();

        $status = $movementModel->getItemStatus($str);

        if ($status === 'out') {
            // Item is checked out, so check-in can be done
            return true;
        }

        // Item is currently checked in, reject check-in
        return false;
    }
}