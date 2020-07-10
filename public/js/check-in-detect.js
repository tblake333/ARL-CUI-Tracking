const barcodeInput = document.getElementById('barcode-input');

barcodeInput.addEventListener('otherChange', checkForBarcode);

document.addEventListener('onload', checkForBarcode.call(barcodeInput));

function checkForBarcode(e) {
    let xhr = new XMLHttpRequest();
    if (this.value.length === 10) {
        xhr.onload = function() {
            if (this.status === 200) {
                // TODO: Handle this
                let barcode = JSON.parse(this.responseText);
                let movementType = getMovementType();
                if (barcode.status !== movementType) {
                    document.getElementById('form').submit();
                } else {
                    document.getElementById('barcode_error').innerText = 'Item is already checked ' + movementType + '.';
                }
            } else {
                document.getElementById('barcode_error').innerText = 'Item barcode not found.';
            }
        }
        xhr.open('GET', '/api/getItem?barcode=' + this.value, true);
        xhr.send();
    }
}

function getMovementType() {
    // TODO: Clean this
    let title = document.getElementsByTagName('h4')[0].innerText;
    let type = title.split(' ');
    return type[0].split('-')[1];
}