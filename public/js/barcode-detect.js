const BARCODE = {
    PREFIX: ["Shift", "C", "Shift", "U", "Shift", "I"],
    // LENGTH does not include terminator key
    // Ex. 'CUI0001234'
    LENGTH: 10,
    TERMINATOR: "Enter"
};

var currentPrefix = [];
var barcode = "";

// Pre-fill barcode based on standardized prefix
BARCODE.PREFIX.forEach(key => {
    if (key != "Shift") {
        barcode = barcode.concat(key);
    }
});

BARCODE.PREFIX_LENGTH = barcode.length;

document.addEventListener('focusin', reset);
document.addEventListener('keydown', barcodeListener);

function barcodeListener(e) {

    // Key is pressed
    var key = e.key;

    if (key == "Enter") {
        e.preventDefault();
    }

    currentPrefix.push(key);

    if (passedPrefixLengthRequirement(currentPrefix) && arraysNotEqual(currentPrefix, BARCODE.PREFIX)) {
        // prefix is invalid, keep reading for prefix match
        currentPrefix.shift();
    } else if (exceededPrefixLengthRequirement(currentPrefix)) {
        // Prefix requirement has been fulfilled, continue reading barcode

        // Correct currentPrefix length
        currentPrefix.pop();
        if (passedBarcodeLengthRequirement(barcode)) {
            // Fulfilled barcode length requirement
            if (isTerminatorKey(key)) {
                correctCaretPosition();
                // Reached barcode terminator key, finished reading barcode
                // alert("Barcode: " + barcode);
                setBarcodeInputValue();
                // Reset barcode and prefix to read a new barcode if necessary
                reset();
            } else {
                // Reached barcode length but was not followed by the terminator key
                // This case should not occur with a barcode scanner. It may occur when trying
                // to emulate a barcode scanner with manual input.
                
                // Reset barcode and prefix
                reset();
            }
        } else if (isSingleCharacterKey(key)) {
            // General case
            barcode = barcode.concat(key);
        } else if (isNonShiftKey(key)) {
            // Found another key while reading barcode
            // Like the case above, this should not occur with a barcode scanner; however, it may
            // occur when trying to emulate a barcode scanner with manual input

            // Reset barcode and prefix
            reset();
        }
    }
}

function passedPrefixLengthRequirement(prefix) {
    return prefix.length === BARCODE.PREFIX.length;
}

function exceededPrefixLengthRequirement(prefix) {
    return prefix.length === BARCODE.PREFIX.length + 1;
}

function passedBarcodeLengthRequirement(code) {
    return code.length === BARCODE.LENGTH;
}

function isTerminatorKey(key) {
    return key === BARCODE.TERMINATOR;
}

function isSingleCharacterKey(key) {
    return key.length === 1;
}

function isNonShiftKey(key) {
    return key != "Shift";
}

function arraysNotEqual(arr1, arr2) {
    if (arr1 === arr2) {
        return false;
    }
    if (arr1 == null || arr2 == null) {
        return true;
    }
    if (arr1.length !== arr2.length) {
        return true;
    }
    for (var i = 0; i < arr1.length; i++) {
        if (arr1[i] !== arr2[i]) {
            return true;
        }
    }
    return false;
}

function correctCaretPosition() {
    var field = document.activeElement;
    if (isTextInputField(field)) {
        // Is in an input field
        var caretPosition = field.selectionStart;
        var text = field.value;
        
        var stringBeforeBarcode = text.substring(0, caretPosition - BARCODE.LENGTH);
        var stringAfterBarcode = text.substring(caretPosition, text.length);
        
        field.value = stringBeforeBarcode + stringAfterBarcode;
        field.selectionStart = caretPosition - BARCODE.LENGTH;
        field.selectionEnd = caretPosition - BARCODE.LENGTH;
        field.dispatchEvent(new CustomEvent('otherChange'));
    } else if (isDateInputField(field)) {
        field.value = '';
        field.focus();
    }
}

function isTextInputField(field) {
    return field.tagName == 'INPUT' && field.getAttribute('type') == 'text' || field.tagName == 'TEXTAREA';
}

function isDateInputField(field) {
    return field.tagName == 'INPUT' && field.getAttribute('type') == 'date';
}

function setBarcodeInputValue() {
    var barcodeInput = document.getElementById('barcode-input');
    barcodeInput.value = barcode;
    barcodeInput.dispatchEvent(new CustomEvent('otherChange'));
}

function reset() {
    barcode = barcode.substring(0, BARCODE.PREFIX_LENGTH);
    currentPrefix = [];
}



