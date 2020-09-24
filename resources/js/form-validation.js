function setupListeners() {
    let inputs = document.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].addEventListener('blur', function() {
        validateHelp(this);
      });
      inputs[i].addEventListener('input', function() {
        validateHelp(this);
      });
      inputs[i].addEventListener('otherChange', function() {
        validateHelp(this);
      });
    }
  }
  
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
  
  setupListeners();