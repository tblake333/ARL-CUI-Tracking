const badge = document.getElementById('badge_number');
const edited = document.getElementById('edited_badge_number');
const checkout = document.getElementById('checkout_badge_number');

if (badge) {
    
    badge.addEventListener('input', checkForUser);
    badge.addEventListener('otherChange', checkForUser);

    document.addEventListener('onload', checkForUser.call(badge));
}

if (edited) {

    edited.addEventListener('input', checkForEdited);
    edited.addEventListener('otherChange', checkForEdited);
    
    document.addEventListener('onload', checkForEdited.call(edited));
}

if (checkout) {

    checkout.addEventListener('input', checkForCheckOut);
    checkout.addEventListener('otherChange', checkForCheckOut);
    
    document.addEventListener('onload', checkForCheckOut.call(checkout));
}

function checkForUser(e) {
    let xhr = new XMLHttpRequest();
    let userDetails = document.getElementById('owner-container');
    if (this.value !== '') {
        xhr.onload = function () {
            if (this.status === 200) {
                let user = JSON.parse(this.responseText);
                console.log(user);
                removeChildren(userDetails);
                loadUserDetails(userDetails, user);
            } else {
                if (!userFormExists(userDetails)) {
                    removeChildren(userDetails);
                    loadUserForm(userDetails);
                }
            }
        }
        xhr.open('GET', '/api/user/' + this.value, true);
        xhr.send();
    }
}

function checkForEdited(e) {
    let xhr = new XMLHttpRequest();
    let userDetails = document.getElementById('edited-container');
    if (this.value !== '') {
        xhr.onload = function () {
            if (this.status === 200) {
                let user = JSON.parse(this.responseText);
                console.log(user);
                removeChildren(userDetails);
                loadUserDetails(userDetails, user);
            } else {
                if (!userFormExists(userDetails)) {
                    removeChildren(userDetails);
                    loadEditedByForm(userDetails);
                }
            }
        }
        xhr.open('GET', '/api/user/' + this.value, true);
        xhr.send();
    }
}

function checkForCheckOut(e) {
    let xhr = new XMLHttpRequest();
    let userDetails = document.getElementById('checkout-container');
    if (this.value !== '') {
        xhr.onload = function () {
            if (this.status === 200) {
                let user = JSON.parse(this.responseText);
                console.log(user);
                removeChildren(userDetails);
                loadUserDetails(userDetails, user);
            } else {
                if (!userFormExists(userDetails)) {
                    removeChildren(userDetails);
                    loadCheckOutForm(userDetails);
                }
            }
        }
        xhr.open('GET', '/api/user/' + this.value, true);
        xhr.send();
    }
}

function removeChildren(container) {
    while (container.hasChildNodes()) {
        container.removeChild(container.lastChild);
    }
}

/* <a href="#" class="card user-card">
            <div class="user-name card-section">
                <span>Test Card</span>
            </div>
            <div class="badge-info card-section">
                <div>
                    <i class="fas fa-id-badge"></i>
                </div>
                <span>12345</span>
            </div>
        </a> */

function loadUserDetails(container, user) {

    let userCard = document.createElement('a');
    userCard.href = '/users/' + user.data.badge_number;
    userCard.classList.add('card', 'user-card');

    userCard.innerHTML = `
    <div class="user-name card-section">
        <span>${user.data.first_name} ${user.data.last_name}</span>
    </div>
    <div class="badge-info card-section">
        <div>
            <i class="fas fa-id-badge"></i>
        </div>
        <span>${user.data.badge_number}</span>
    </div>`;
    container.appendChild(userCard);
}

/* <div class="input-item">
        <div class="i">
            <i class="fas fa-tag"></i>
        </div>
        <div>
            <h5>Type</h5>
            <input name="type" type="text" maxlength="30" required>
        </div>
    </div> */

function validateHelp(inputElement) {
    let valid = inputElement.checkValidity();

    if (inputElement.name === "source_date") {
        return;
    }

    if (!valid) {
        inputElement.parentNode.parentNode.classList.add('invalid');
    } else {
        inputElement.parentNode.parentNode.classList.remove('invalid');
    }

    if (inputElement.value.length !== 0) {
        inputElement.parentNode.parentNode.classList.add('filled');
    } else {
        inputElement.parentNode.parentNode.classList.remove('filled');
    }
}

function getInput(human_field_name, field_name) {
    let inputItem = document.createElement('div');
    inputItem.className = "input-item";

    let iconContainer = document.createElement('div');
    iconContainer.className = "i";

    let icon = document.createElement('i');
    icon.classList.add('fas', 'fa-id-card');

    iconContainer.appendChild(icon);

    let inputContainer = document.createElement('div');

    let attributeName = document.createElement('h5');
    attributeName.innerText = human_field_name;

    let input = document.createElement('input');
    input.name = field_name;
    input.type = 'text';
    input.maxLength = '30';
    input.setAttribute('required', 'true');
    input.autocomplete = 'off';
    input.addEventListener('blur', function () {
        validateHelp(this);
    });
    input.addEventListener('input', function () {
        validateHelp(this);
    });

    inputContainer.appendChild(attributeName);
    inputContainer.appendChild(input);

    inputItem.appendChild(iconContainer);
    inputItem.appendChild(inputContainer);

    return inputItem;
}

function loadUserForm(container) {
    let firstName = getInput('First Name', 'owner[first_name]');
    let lastName = getInput('Last Name', 'owner[last_name]');

    container.appendChild(firstName);
    container.appendChild(lastName);
}

function loadEditedByForm(container) {
    let firstName = getInput('First Name', 'edited_by[first_name]');
    let lastName = getInput('Last Name', 'edited_by[last_name]');

    container.appendChild(firstName);
    container.appendChild(lastName);
}

function loadCheckOutForm(container) {
    let firstName = getInput('First Name', 'first_name');
    let lastName = getInput('Last Name', 'last_name');

    container.appendChild(firstName);
    container.appendChild(lastName);
}

function userFormExists(container) {
    return container.getElementsByTagName('input').length !== 0;
}
