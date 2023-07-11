

    function checkEmail() {
      var email = document.getElementById("email").value;
      if (!email.endsWith("iitp.ac.in")) {
        alert("Please enter a valid iitp.ac.in email.");
        return false;
      }
      return true;
    }
 document.addEventListener("DOMContentLoaded", function() {
    function checkPasswordStrength(password) {
      var strength = 0;

      if (password.length < 6) {
        return "Weak";
      }

      if (password.match(/[a-z]/)) {
        strength++;
      }

      if (password.match(/[A-Z]/)) {
        strength++;
      }

      if (password.match(/[0-9]/)) {
        strength++;
      }

      if (password.match(/[$@#&!]/)) {
        strength++;
      }

      if (password.length > 12) {
        strength++;
      }

      if (strength < 3) {
        return "Weak";
      } else if (strength < 5) {
        return "Moderate";
      } else {
        return "Strong";
      }
    }

    var passwordInput = document.getElementById("password");
    var passwordStrength = document.getElementById("password-strength");

    passwordInput.addEventListener("input", function() {
      var password = passwordInput.value;
      var strength = checkPasswordStrength(password);

      passwordStrength.innerHTML = "Password Strength: " + strength;
    });

});

    function checkPasswordsMatch() {
      var password = document.getElementById("password").value;
      var confirmPassword = document.getElementById("confirmPassword").value;

      if (password !== confirmPassword) {
        alert("Passwords do not match. Please try again.");
        return false;
      }

      return true;
    }


    

  
 


