
function toggleCheckboxes(checkbox) {
    // Get all the checkboxes in the container
    const checkboxes = checkbox.parentNode.parentNode.querySelectorAll('input[type="checkbox"]');

    // Loop through the checkboxes and show/hide them based on the state of the "All" checkbox
    for (let i = 1; i < checkboxes.length; i++) {
      if (checkbox.checked) {
        checkboxes[i].style.display = "block";
        checkboxes[i].checked = true;
      } else {
        checkboxes[i].style.display = "block";
        checkboxes[i].checked = false;
      }
    }
  }



function toggleDropdown(dropdownId) {
    var dropdownMenu = document.getElementById(dropdownId);
    if (dropdownMenu.classList.contains("show")) {
        dropdownMenu.classList.remove("show");
    } else {
        dropdownMenu.classList.add("show");
    }
}


var dropdowns = document.querySelectorAll(".dropdown");

dropdowns.forEach(function (dropdown) {
    var dropdownId = dropdown.querySelector(".dropdown-content").id;
    dropdown.addEventListener("click", function () {
        toggleDropdown(dropdownId);
    });
});

window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.querySelectorAll(".dropdown-content");
        dropdowns.forEach(function (dropdown) {
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });
    }
}



function hide_eligiblity(checkbox) {
    const hideMenu = document.getElementById("hide_menus");
    if (checkbox.checked) {
        hideMenu.style.display = 'inline-block';
    } else {
        hideMenu.style.display = 'none';
    }
}

function hide_package(checkbox) {
    const hideMenu = document.getElementById("hide_menu");
    if (checkbox.checked) {
        hideMenu.style.display = 'inline-block';
    } else {
        hideMenu.style.display = 'none';
    }
}
  


function uncheckOtherCheckboxes(clickedCheckboxName) {
    var checkboxes = document.getElementsByName('highest_Package');
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].name !== clickedCheckboxName) {
        checkboxes[i].checked = false;
      }
    }
  }

  function uncheckAllCheckboxes() {
    var checkboxes = document.getElementsByName('highest_Package');
    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = false;
    }
  }


