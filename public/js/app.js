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

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var LABS = ['ATL', 'ESL', 'SISL', 'SGL'];
var PREFIXES = [];
var PREFIX_TERMINATOR = "END";
var TERMINATOR = "Enter";
var CUI_PREFIX = ["Shift", "C", "Shift", "U", "Shift", "I"];
LABS.forEach(function (lab) {
  // Interleave SHIFT keys between each character
  // as that is what the barcode scanner does.
  // Ex. ESL => SHIFT E SHIFT S SHIFT L
  var prefix = [];
  lab.split('').forEach(function (letter) {
    // TODO: Only apply shifts when letter or character is upper case
    prefix.push("Shift");
    prefix.push(letter);
  }); // For prefixes, include
  // 1. The lab abbreviation + CUI
  // 2. Just CUI
  // 1

  prefix = prefix.concat(CUI_PREFIX);
  PREFIXES.push(prefix);
}); // 2

PREFIXES.push(CUI_PREFIX);

var TrieNode = /*#__PURE__*/function () {
  function TrieNode(key) {
    _classCallCheck(this, TrieNode);

    this.key = key;
    this.children = new Map();
  } // Adds a sub trie to the node,
  // Ex. ['H', 'e', 'l', 'l', 'o']
  // Adds 5 nodes, to create the "Hello" string trie


  _createClass(TrieNode, [{
    key: "addChildSubTrie",
    value: function addChildSubTrie(arr) {
      var current = this;

      for (var i = 0; i < arr.length; i++) {
        var key = arr[i];
        var childNode = current.children.get(key);

        if (!childNode) {
          // Child node not found, create one
          childNode = new TrieNode(key);
          current.children.set(key, childNode);
        } // Set child node to current node for next iteration


        current = childNode;
      }

      if (current.key != PREFIX_TERMINATOR) {
        // Add a dummy child to indicate the end of the prefix
        // Maps to 'true' for arbitrary reasons, such as using actual child value as a boolean
        // for checking if child exists rather than using Map.has(child)
        current.children.set(PREFIX_TERMINATOR, true);
      }
    }
  }, {
    key: "containsSubTrie",
    value: function containsSubTrie(arr) {
      var current = this;

      for (var i = 0; i < arr.length; i++) {
        var _char = arr[i];
        var node = current.children.get(_char);

        if (!node) {
          return false;
        }

        current = node;
      }

      return true;
    }
  }, {
    key: "getLastSubTrieNode",
    value: function getLastSubTrieNode(arr) {
      var current = this;

      for (var i = 0; i < arr.length; i++) {
        var _char2 = arr[i];
        var node = current.children.get(_char2);

        if (!node) {
          return null;
        }

        current = node;
      }

      return current;
    }
  }]);

  return TrieNode;
}();

var PREFIX_TRIE_ROOT = new TrieNode('START');
PREFIXES.forEach(function (prefix) {
  PREFIX_TRIE_ROOT.addChildSubTrie(prefix);
});
var currentPrefix = [];
var barcode = "";
var currentTrieRoot = PREFIX_TRIE_ROOT;
document.addEventListener('focusin', reset);
document.addEventListener('keydown', barcodeListener);

function barcodeListener(e) {
  console.log('CURRENT PREFIX: ' + currentPrefix);
  console.log('CURRENT BARCODE: ' + barcode); // Key is pressed

  var key = e.key;

  if (key == "Enter") {
    e.preventDefault();
  } // When a key is read we care about 2 cases:
  // 1. The key is a child of the current sub trie
  // 2. The current sub trie has a prefix terminator child
  // In the second case, there are two subcases which default to the same
  // result:
  // 2a. The key is not a child of the current sub trie: the key is not part of
  //     the prefix, but IS part of the barcode
  // 2b. The key is a child of the current sub trie: this means there exists
  //     an overlapping in the prefixes, such as ABCD and ABC. In this case,
  //     ignore the overlapping and choose the shortest prefix. That is, the
  //     the key is not part of the prefix, but IS part of the barcode.
  //     This case would be automatically handled by case 2a.
  // The other case not mentioned, the case where the key is not a child
  // and there is no prefix terminator child, indicates that the prefix
  // is invalid, and should be truncated to the next potentially valid prefix.
  // Get subtrie root from the current root


  var subTrie = currentTrieRoot.children.get(key);

  if (subTrie) {
    console.log('Found child: ' + key + ' in sub trie root: ' + currentTrieRoot.key); // Key is a child of current sub trie

    currentTrieRoot = subTrie;
    currentPrefix.push(key);
    console.log('New prefix is now: ' + currentPrefix);
    return;
  } else {
    // The subtrie for this key does not exist
    console.log('child: ' + key + ' was NOT found in sub trie root: ' + currentTrieRoot.key); // Key is not a child of the current sub trie

    if (!currentPrefixTrieIsEndOfPrefix()) {
      console.log('Prefix has not been completed yet, truncating...'); // Current prefix is not valid, so truncate until potentially valid

      currentTrieRoot = PREFIX_TRIE_ROOT;
      currentPrefix.push(key);

      while (currentPrefix && currentPrefix.length != 0) {
        console.log("Current prefix: " + currentPrefix); // Remove beginning character

        currentPrefix.shift();
        var tracingNode = currentTrieRoot;
        var passedThrough = true;

        for (var i = 0; i < currentPrefix.length; i++) {
          var _key = currentPrefix[i];

          if (hasTerminatorChildNode(tracingNode)) {
            // Embedded prefix has been found
            // Get rest of barcode
            var barcodeKeys = currentPrefix.splice(i + 1);

            for (var j = 0; j < barcodeKeys.length; j++) {
              var barcodeKey = barcodeKeys[j];

              if (isSingleCharacterKey(barcodeKey)) {
                barcode = barcode.concat(barcodeKey);
              }
            } // Exit the for loop


            passedThrough = false;
            break;
          }

          if (!tracingNode.children.has(_key)) {
            // Child not found, exit for loop
            passedThrough = false;
            break;
          } // Follow through next node


          tracingNode = tracingNode.children.get(_key);
        } // Three cases upon exiting the for loop:
        // 1. We went through all the elements in the prefix buffer
        //         - We have reached a prefix which is a potential valid prefix
        // 2. We found an embedded prefix
        // 3. Child not found
        //         - We have no valid prefix with current truncated buffer
        // Only cases 1 and 2 require breaking out of the for loop


        if (barcode != '' || passedThrough) {
          currentTrieRoot = tracingNode;
          break;
        }

        console.log('Current prefix: ' + currentPrefix + ' is incomplete and therefore not valid');
      }

      console.log('Reverted to prefix: ' + currentPrefix);

      if (hasTerminatorChildNode(currentTrieRoot)) {
        // Full and valid prefix was found by truncating, so begin creating barcode
        var rawPrefix = '';
        currentPrefix.forEach(function (key) {
          if (isSingleCharacterKey(key)) {
            rawPrefix = rawPrefix.concat(key);
          }
        });
        barcode = barcode.concat(rawPrefix);
        return;
      }
    }
  }

  if (currentPrefixTrieIsEndOfPrefix()) {
    // Prefix requirement has been fulfilled, continue reading barcode
    console.log('PREFIX FULFILLED, reading normally');

    if (barcode == '') {
      console.log('Barcode was empty, filled it up');
      currentPrefix.forEach(function (key) {
        if (isSingleCharacterKey(key)) {
          console.log('concatting ' + key + ' to barcode');
          barcode = barcode.concat(key);
        }
      });
    } // Correct currentPrefix length


    if (isTerminatorKey(key)) {
      correctCaretPosition(); // Reached barcode terminator key, finished reading barcode

      setBarcodeInputValue();
      console.log('BARCODE DETECTED: ' + barcode); // Reset barcode and prefix to read a new barcode if necessary

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

function currentPrefixTrieIsEndOfPrefix() {
  return hasTerminatorChildNode(currentTrieRoot);
}

function hasTerminatorChildNode(node) {
  return node.children.has(PREFIX_TERMINATOR);
}

function isTerminatorKey(key) {
  return key === TERMINATOR;
}

function isSingleCharacterKey(key) {
  return key.length === 1;
}

function isNonShiftKey(key) {
  return key != "Shift";
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
  barcode = '';
  currentPrefix = [];
  currentTrieRoot = PREFIX_TRIE_ROOT;
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

__webpack_require__(/*! C:\Users\student\Documents\CUI Server\Apache24\htdocs\resources\js\app.js */"./resources/js/app.js");
__webpack_require__(/*! C:\Users\student\Documents\CUI Server\Apache24\htdocs\resources\js\form-validation.js */"./resources/js/form-validation.js");
__webpack_require__(/*! C:\Users\student\Documents\CUI Server\Apache24\htdocs\resources\js\user-detect.js */"./resources/js/user-detect.js");
__webpack_require__(/*! C:\Users\student\Documents\CUI Server\Apache24\htdocs\resources\js\barcode-detect.js */"./resources/js/barcode-detect.js");
module.exports = __webpack_require__(/*! C:\Users\student\Documents\CUI Server\Apache24\htdocs\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });