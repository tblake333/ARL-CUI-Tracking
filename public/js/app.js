/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./resources/js/barcode-detect.js":
/*!****************************************!*\
  !*** ./resources/js/barcode-detect.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var BARCODE = {
  PREFIX: ["Shift", "C", "Shift", "U", "Shift", "I"],
  TERMINATOR: "Enter"
};
var currentPrefix = [];
var barcode = ""; // Pre-fill barcode based on standardized prefix

BARCODE.PREFIX.forEach(function (key) {
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

    if (isTerminatorKey(key)) {
      correctCaretPosition(); // Reached barcode terminator key, finished reading barcode

      setBarcodeInputValue(); // Reset barcode and prefix to read a new barcode if necessary

      reset();
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
  var len = location.href.length;

  if (location.href.substring(len - 10).indexOf('check-out') !== -1 || location.href.substring(len - 9).indexOf('check-in') !== -1) {
    document.getElementsByTagName('form')[0].submit();
  }
}

function reset() {
  barcode = barcode.substring(0, BARCODE.PREFIX_LENGTH);
  currentPrefix = [];
}

/***/ }),

/***/ "./resources/js/form-validation.js":
/*!*****************************************!*\
  !*** ./resources/js/form-validation.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function setupListeners() {
  var inputs = document.getElementsByTagName('input');

  for (var i = 0; i < inputs.length; i++) {
    inputs[i].addEventListener('blur', function () {
      validateHelp(this);
    });
    inputs[i].addEventListener('input', function () {
      validateHelp(this);
    });
    inputs[i].addEventListener('otherChange', function () {
      validateHelp(this);
    });
  }
}

function validateHelp(inputElement) {
  var valid = inputElement.checkValidity();

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

setupListeners();

/***/ }),

/***/ "./resources/js/user-detect.js":
/*!*************************************!*\
  !*** ./resources/js/user-detect.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var badge = document.getElementById('badge_number');
var edited = document.getElementById('edited_badge_number');
var checkout = document.getElementById('checkout_badge_number');

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
  var xhr = new XMLHttpRequest();
  var userDetails = document.getElementById('owner-container');

  if (this.value !== '') {
    xhr.onload = function () {
      if (this.status === 200) {
        var user = JSON.parse(this.responseText);
        console.log(user);
        removeChildren(userDetails);
        loadUserDetails(userDetails, user);
      } else {
        if (!userFormExists(userDetails)) {
          removeChildren(userDetails);
          loadUserForm(userDetails);
        }
      }
    };

    xhr.open('GET', '/api/user/' + this.value, true);
    xhr.send();
  }
}

function checkForEdited(e) {
  var xhr = new XMLHttpRequest();
  var userDetails = document.getElementById('edited-container');

  if (this.value !== '') {
    xhr.onload = function () {
      if (this.status === 200) {
        var user = JSON.parse(this.responseText);
        console.log(user);
        removeChildren(userDetails);
        loadUserDetails(userDetails, user);
      } else {
        if (!userFormExists(userDetails)) {
          removeChildren(userDetails);
          loadEditedByForm(userDetails);
        }
      }
    };

    xhr.open('GET', '/api/user/' + this.value, true);
    xhr.send();
  }
}

function checkForCheckOut(e) {
  var xhr = new XMLHttpRequest();
  var userDetails = document.getElementById('checkout-container');

  if (this.value !== '') {
    xhr.onload = function () {
      if (this.status === 200) {
        var user = JSON.parse(this.responseText);
        console.log(user);
        removeChildren(userDetails);
        loadUserDetails(userDetails, user);
      } else {
        if (!userFormExists(userDetails)) {
          removeChildren(userDetails);
          loadCheckOutForm(userDetails);
        }
      }
    };

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
  var userCard = document.createElement('a');
  userCard.href = '/users/' + user.data.badge_number;
  userCard.classList.add('card', 'user-card');
  userCard.innerHTML = "\n    <div class=\"user-name card-section\">\n        <span>".concat(user.data.first_name, " ").concat(user.data.last_name, "</span>\n    </div>\n    <div class=\"badge-info card-section\">\n        <div>\n            <i class=\"fas fa-id-badge\"></i>\n        </div>\n        <span>").concat(user.data.badge_number, "</span>\n    </div>");
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
  var valid = inputElement.checkValidity();

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
  var inputItem = document.createElement('div');
  inputItem.className = "input-item";
  var iconContainer = document.createElement('div');
  iconContainer.className = "i";
  var icon = document.createElement('i');
  icon.classList.add('fas', 'fa-id-card');
  iconContainer.appendChild(icon);
  var inputContainer = document.createElement('div');
  var attributeName = document.createElement('h5');
  attributeName.innerText = human_field_name;
  var input = document.createElement('input');
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
  var firstName = getInput('First Name', 'owner[first_name]');
  var lastName = getInput('Last Name', 'owner[last_name]');
  container.appendChild(firstName);
  container.appendChild(lastName);
}

function loadEditedByForm(container) {
  var firstName = getInput('First Name', 'edited_by[first_name]');
  var lastName = getInput('Last Name', 'edited_by[last_name]');
  container.appendChild(firstName);
  container.appendChild(lastName);
}

function loadCheckOutForm(container) {
  var firstName = getInput('First Name', 'first_name');
  var lastName = getInput('Last Name', 'last_name');
  container.appendChild(firstName);
  container.appendChild(lastName);
}

function userFormExists(container) {
  return container.getElementsByTagName('input').length !== 0;
}

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!**************************************************************************************************************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/js/form-validation.js ./resources/js/user-detect.js ./resources/js/barcode-detect.js ./resources/sass/app.scss ***!
  \**************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Users\student\Documents\cui_tracking\resources\js\app.js */"./resources/js/app.js");
__webpack_require__(/*! C:\Users\student\Documents\cui_tracking\resources\js\form-validation.js */"./resources/js/form-validation.js");
__webpack_require__(/*! C:\Users\student\Documents\cui_tracking\resources\js\user-detect.js */"./resources/js/user-detect.js");
__webpack_require__(/*! C:\Users\student\Documents\cui_tracking\resources\js\barcode-detect.js */"./resources/js/barcode-detect.js");
module.exports = __webpack_require__(/*! C:\Users\student\Documents\cui_tracking\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });