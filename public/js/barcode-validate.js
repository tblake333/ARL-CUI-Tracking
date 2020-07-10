const barcodeInput = document.getElementById('barcode-input');

barcodeInput.addEventListener('otherChange', checkForBarcode);

document.addEventListener('onload', checkForBarcode.call(barcodeInput));

function checkForBarcode(e) {
    let xhr = new XMLHttpRequest();
    let barcodeDetails = document.getElementById('barcode_details');
    if (this.value.length === 10) {
        xhr.onload = function() {
            if (this.status === 200) {
                // TODO: Handle this
                let barcode = JSON.parse(this.responseText);
                let movementType = getMovementType();
                if (barcode.status !== movementType) {
                    document.getElementById('barcode_error').innerText = '';
                } else {
                    document.getElementById('barcode_error').innerText = 'Item is already checked ' + movementType + '.';
                }
                removeChildren(barcodeDetails);
                loadBarcodeDetails(barcodeDetails, barcode);
            } else {
                removeChildren(barcodeDetails);
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

function removeChildren(container) {
    while(container.hasChildNodes()) {
        container.removeChild(container.lastChild);
    }
}

function loadBarcodeDetails(container, barcode) {

    let barcodeDetailsTitle = document.createElement('h6');
    barcodeDetailsTitle.innerText = 'Item Details';

    let titleLabel = document.createElement('label');
    let typeLabel = document.createElement('label');
    let descriptionLabel = document.createElement('label');
    titleLabel.innerText = 'Title:';
    typeLabel.innerText = 'Type:';
    descriptionLabel.innerText = 'Description:';

    let title = document.createElement('p');
    let type = document.createElement('p');
    let description = document.createElement('p');
    title.innerText = barcode.title;
    type.innerText = barcode.type;
    description.innerText = barcode.description;

    let barcodeDetailsContainer = document.createElement('div');
    barcodeDetailsContainer.className = 'container';
    barcodeDetailsContainer.appendChild(titleLabel);
    barcodeDetailsContainer.appendChild(title);
    barcodeDetailsContainer.appendChild(typeLabel);
    barcodeDetailsContainer.appendChild(type);
    barcodeDetailsContainer.appendChild(descriptionLabel);
    barcodeDetailsContainer.appendChild(description);

    container.appendChild(barcodeDetailsTitle);
    container.appendChild(barcodeDetailsContainer);
    
}
