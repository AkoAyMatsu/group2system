const uploadButton = document.querySelector(".upload-button")
const fileInput = document.getElementById('file-upload');
const userImageView = document.querySelector(".userImageView");


const firstname = document.getElementById("#FirstName")
const lastname = document.getElementById("#LastName")
const address = document.getElementById("#Address")
const contact = document.getElementById("#ContactNumber")
const username = document.getElementById("#UserName")
const pswd = document.getElementById("#PassWord")



// Add an event listener to detect file selection
fileInput.addEventListener('change', handleFileSelect);

// Handle file selection
function handleFileSelect(event) {
  const selectedFile = event.target.files[0];

  // Display the selected image in the preview
  const reader = new FileReader();
  reader.onload = function() {
    userImageView.src = reader.result;
  };
  reader.readAsDataURL(selectedFile);
}

document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('.form');
    var updateButton = document.querySelector('button[name="updateProfileButton"]');
    var formFields = form.querySelectorAll('input, textarea');

    // Track the initial values of the input fields
    var initialFieldValues = {};
    formFields.forEach(function(field) {
        initialFieldValues[field.name] = field.value;
    });

    // Add event listeners to form fields
    formFields.forEach(function(field) {
        field.addEventListener('input', function() {
            // Enable the update button if the field value has changed
            if (field.value !== initialFieldValues[field.name]) {
                updateButton.removeAttribute('disabled');
            } else {
                updateButton.setAttribute('disabled', 'true');
            }
        });
    });
});

//Contact Number Handling
function handleContactNumberInput(input) {
    const placeholder = "Contact Number";
    const prefix = "09";
    
    if (input.value === "") {
        input.placeholder = placeholder; // Display the placeholder
    } else {
        input.placeholder = ""; // Remove the placeholder
        if (!input.value.startsWith(prefix)) {
        input.value = prefix + input.value; // Prepend "09" to the input value
        }
    }
}

const updateProfile = document.querySelector('.updateProfile')

document.addEventListener("DOMContentLoaded", function(){
        console.error("Hi");
        const notification = document.querySelector('.notification');
        if (notification) {
            notification.classList.add('show');
            setTimeout(function() {
                notification.classList.remove('show');
                // Reload the page only if it hasn't been reloaded alread
                //document.location.reload();
            }, 1000);
            //window.location.reload(); // Adjust the timeout value (in milliseconds) to control how long the notification stays visible
        }
})




    

