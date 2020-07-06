const badge = document.getElementById('badge_number');

badge.addEventListener('input', checkForUser);
badge.addEventListener('otherChange', checkForUser);

function checkForUser(e) {
    let xhr = new XMLHttpRequest();
    let userDetails = document.getElementById('user_details');
    if (this.value.length === 6) {
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('badge_number_error').innerText = '';
                // TODO: Handle this
                let user = JSON.parse(this.responseText);
                removeChildren(userDetails);
                loadUserDetails(userDetails, user);
            } else {
                removeChildren(userDetails);
                loadUserForm(userDetails);
                document.getElementById('badge_number_error').innerText = 'User badge number not found.';
            }
        }
        xhr.open('GET', '/api/getUser?badge_number=' + this.value, true);
        xhr.send();
    } else {
        removeChildren(userDetails);
    }
}

function removeChildren(container) {
    while(container.hasChildNodes()) {
        console.log('removing ' + container.lastChild)
        container.removeChild(container.lastChild);
    }
}

function loadUserDetails(container, user) {

    let userDetailsTitle = document.createElement('h6');
    userDetailsTitle.innerText = 'User details:';

    let firstNameLabel = document.createElement('label');
    let lastNameLabel = document.createElement('label');
    firstNameLabel.innerText = 'First Name:';
    lastNameLabel.innerText = 'Last Name';

    let firstName = document.createElement('p');
    let lastName = document.createElement('p');
    firstName.innerText = user.first_name;
    lastName.innerText = user.last_name;

    let userDetailsContainer = document.createElement('div');
    userDetailsContainer.className = 'container';
    userDetailsContainer.appendChild(firstNameLabel);
    userDetailsContainer.appendChild(firstName);
    userDetailsContainer.appendChild(lastNameLabel);
    userDetailsContainer.appendChild(lastName);

    container.appendChild(userDetailsTitle);
    container.appendChild(userDetailsContainer);
}

function loadUserForm(container) {
    let firstNameLabel = document.createElement('label');
    let lastNameLabel = document.createElement('label');
    firstNameLabel.innerText = 'First Name:';
    lastNameLabel.innerText = 'Last Name';

    let firstName = document.createElement('input');
    let lastName = document.createElement('input');
    firstName.type = 'text';
    firstName.name = 'first_name';
    lastName.type = 'text';
    lastName.name = 'last_name';

    container.appendChild(firstNameLabel);
    container.appendChild(firstName);
    container.appendChild(lastNameLabel);
    container.appendChild(lastName);
}

