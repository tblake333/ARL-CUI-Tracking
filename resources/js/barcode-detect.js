// TODO: Test this with unit tests
const LABS = ['ATL', 'ESL', 'SISL', 'SGL'];

const PREFIXES = [];
const PREFIX_TERMINATOR = "END";
const TERMINATOR = "Enter";
const CUI_PREFIX = ["Shift", "C", "Shift", "U", "Shift", "I"];

LABS.forEach(lab => {
    // Interleave SHIFT keys between each character
    // as that is what the barcode scanner does.

    // Ex. ESL => SHIFT E SHIFT S SHIFT L
    let prefix = [];
    lab.split('').forEach(letter => {
        // TODO: Only apply shifts when letter or character is upper case
        prefix.push("Shift");
        prefix.push(letter);
    });

    // For prefixes, include
    // 1. The lab abbreviation + CUI
    // 2. Just CUI

    // 1
    prefix = prefix.concat(CUI_PREFIX);
    PREFIXES.push(prefix);
});

// 2
PREFIXES.push(CUI_PREFIX);

class TrieNode {

    constructor(key) {
        this.key = key;
        this.children = new Map();
    }

    // Adds a sub trie to the node,
    // Ex. ['H', 'e', 'l', 'l', 'o']
    // Adds 5 nodes, to create the "Hello" string trie
    addChildSubTrie(arr) {
        let current = this;
        for (var i = 0; i < arr.length; i++) {

            let key = arr[i];
            let childNode = current.children.get(key);

            if (!childNode) {
                // Child node not found, create one
                childNode = new TrieNode(key);
                current.children.set(key, childNode);
            }
            // Set child node to current node for next iteration
            current = childNode;
        }

        if (current.key != PREFIX_TERMINATOR) {
            // Add a dummy child to indicate the end of the prefix
            // Maps to 'true' for arbitrary reasons, such as using actual child value as a boolean
            // for checking if child exists rather than using Map.has(child)
            current.children.set(PREFIX_TERMINATOR, true);
        }
    }

    containsSubTrie(arr) {
        let current = this;
        for (var i = 0; i < arr.length; i++) {
            let char = arr[i];
            let node = current.children.get(char);
            if (!node) {
                return false;
            }
            current = node;
        }
        return true;
    }

    getLastSubTrieNode(arr) {
        let current = this;
        for (var i = 0; i < arr.length; i++) {
            let char = arr[i];
            let node = current.children.get(char);
            if (!node) {
                return null;
            }
            current = node;
        }
        return current;
    }
}

const PREFIX_TRIE_ROOT = new TrieNode('START');

PREFIXES.forEach(prefix => {
    PREFIX_TRIE_ROOT.addChildSubTrie(prefix);
});

var currentPrefix = [];
var barcode = "";
let currentTrieRoot = PREFIX_TRIE_ROOT;


document.addEventListener('focusin', reset);
document.addEventListener('keydown', barcodeListener);

function barcodeListener(e) {

    
    

    // Key is pressed
    let key = e.key;

    if (key == "Enter") {
        e.preventDefault();
    }

    // When a key is read we care about 2 cases:
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
    let subTrie = currentTrieRoot.children.get(key);

    if (subTrie) {
        
        // Key is a child of current sub trie
        currentTrieRoot = subTrie;
        currentPrefix.push(key);
        
        return;
    } else {
        // The subtrie for this key does not exist
        
        // Key is not a child of the current sub trie
        if (!currentPrefixTrieIsEndOfPrefix()) {
            

            // Current prefix is not valid, so truncate until potentially valid

            currentTrieRoot = PREFIX_TRIE_ROOT;

            currentPrefix.push(key);

            while (currentPrefix && currentPrefix.length != 0) {

                

                // Remove beginning character
                currentPrefix.shift();

                let tracingNode = currentTrieRoot;

                let passedThrough = true;

                for (var i = 0; i < currentPrefix.length; i++) {
                    let key = currentPrefix[i];

                    if (hasTerminatorChildNode(tracingNode)) {

                        // Embedded prefix has been found
                        // Get rest of barcode
                        let barcodeKeys = currentPrefix.splice(i + 1);
                        for (var j = 0; j < barcodeKeys.length; j++) {
                            let barcodeKey = barcodeKeys[j];
                            if (isSingleCharacterKey(barcodeKey)) {
                                barcode = barcode.concat(barcodeKey);
                            }
                        }
                        // Exit the for loop
                        passedThrough = false;
                        break;
                    }
                    if (!tracingNode.children.has(key)) {
                        // Child not found, exit for loop
                        passedThrough = false;
                        break;
                    }
                    // Follow through next node
                    tracingNode = tracingNode.children.get(key);
                }


                // Three cases upon exiting the for loop:
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

                
            }

            

            if (hasTerminatorChildNode(currentTrieRoot)) {
                // Full and valid prefix was found by truncating, so begin creating barcode
                let rawPrefix = '';
                currentPrefix.forEach(key => {
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
        

        if (barcode == '') {
            
            currentPrefix.forEach(key => {
                if (isSingleCharacterKey(key)) {
                    
                    barcode = barcode.concat(key);
                }
            });
        }

        // Correct currentPrefix length
        if (isTerminatorKey(key)) {
            correctCaretPosition();
            // Reached barcode terminator key, finished reading barcode
            setBarcodeInputValue();
            
            // Reset barcode and prefix to read a new barcode if necessary
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
    let len = location.href.length;
    if (location.href.substring(len - 10).indexOf('check-out') !== -1 ||
        location.href.substring(len - 9).indexOf('check-in') !== -1) {
        document.getElementsByTagName('form')[0].submit();
    }
}

function reset() {
    barcode = '';
    currentPrefix = [];
    currentTrieRoot = PREFIX_TRIE_ROOT;
}



