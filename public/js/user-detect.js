const badge = document.getElementById('badge_number');

badge.addEventListener('input', checkForUser);
badge.addEventListener('otherChange', checkForUser);

document.addEventListener('onload', checkForUser.call(badge));

function checkForUser(e) {
    let xhr = new XMLHttpRequest();
    let userDetails = document.getElementById('user_details');
    if (this.value !== '') {
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('badge_number_info').innerText = 'User found!';
                // TODO: Handle this
                let user = JSON.parse(this.responseText);
                removeChildren(userDetails);
                loadUserDetails(userDetails, user);
            } else {
                if (!userFormExists(userDetails)) {
                    removeChildren(userDetails);
                    loadUserForm(userDetails);
                }
                document.getElementById('badge_number_info').innerText = 'New badge number detected! Please fill out first and last name.';
            }
        }
        xhr.open('GET', '/api/getUser?badge_number=' + this.value, true);
        xhr.send();
    }
}

function removeChildren(container) {
    while(container.hasChildNodes()) {
        container.removeChild(container.lastChild);
    }
}

function loadUserDetails(container, user) {

    let userDetailsTitle = document.createElement('h6');
    userDetailsTitle.innerText = 'User Details';

    let firstNameLabel = document.createElement('label');
    let lastNameLabel = document.createElement('label');
    firstNameLabel.innerText = 'First Name:';
    lastNameLabel.innerText = 'Last Name:';

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
    let userDetailsTitle = document.createElement('h6');
    userDetailsTitle.innerText = 'User Details';

    let firstNameLabel = document.createElement('label');
    let lastNameLabel = document.createElement('label');
    firstNameLabel.innerText = 'First Name:';
    lastNameLabel.innerText = 'Last Name:';

    let firstName = document.createElement('input');
    let lastName = document.createElement('input');
    firstName.type = 'text';
    firstName.name = 'first_name';
    firstName.setAttribute('autocomplete', 'off');
    lastName.type = 'text';
    lastName.name = 'last_name';
    lastName.setAttribute('autocomplete', 'off');

    let userDetailsContainer = document.createElement('div');
    userDetailsContainer.className = 'container';
    userDetailsContainer.appendChild(firstNameLabel);
    userDetailsContainer.appendChild(firstName);
    userDetailsContainer.appendChild(lastNameLabel);
    userDetailsContainer.appendChild(lastName);

    container.appendChild(userDetailsTitle);
    container.appendChild(userDetailsContainer);
}

function userFormExists(container) {
    return container.getElementsByTagName('input').length !== 0;
}
