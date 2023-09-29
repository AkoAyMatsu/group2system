    //Profile Image Handling
    const fileInput = document.getElementById('file-upload');
    const previewImage = document.getElementById('preview-image');
    const backToLoginText = document.querySelector('.backToLoginText');
    const passwordToggle = document.querySelector('.passwordToggle');
    const passwordInput = document.querySelector('input[name="password"]');
    const backIcon = document.querySelector('.backIcon');

    backIcon.addEventListener('click', () => {
        window.open('login.php')
    })

    passwordToggle.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordToggle.classList.add('clicked');
        } else {
            passwordInput.type = 'password';
            passwordToggle.classList.remove('clicked');
        }
    });


    document.addEventListener('DOMContentLoaded', function() {
      const notification = document.querySelector('.notification');
      if (notification) {
          notification.classList.add('show');
          setTimeout(function() {
              notification.classList.remove('show');
          }, 4000); // Adjust the timeout value (in milliseconds) to control how long the notification stays visible
      }
    
    });

    /*backToLoginText.addEventListener('click', function (event) {
        //event.preventDefault();
        window.open('login.php');
    });*/


    // Add an event listener to detect file selection
    fileInput.addEventListener('change', handleFileSelect);

    // Handle file selection
    function handleFileSelect(event) {
      const selectedFile = event.target.files[0];

      // Display the selected image in the preview
      const reader = new FileReader();
      reader.onload = function() {
        previewImage.src = reader.result;
      };
      reader.readAsDataURL(selectedFile);
    }
    //Role Selection
    function removeDefaultOption(selectElement) {
      const defaultOption = selectElement.querySelector('option[value=""]');
      defaultOption.remove();
    }

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

      



//}