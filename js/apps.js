var add_new_app_action = document.querySelector(".add_new_app_action");
var add_new_app_dialog = document.querySelector(".add_new_app_dialog");
var application_list = document.querySelector(".application_list");

add_new_app_action.addEventListener("click", function(event) {
    if (event.target.tagName === 'BUTTON') {
        const appTitle = document.querySelector(".add_new_app_dialog input").value;
        const appDescription = document.querySelector(".add_new_app_dialog textarea").value;
        if(appTitle===""){
            alert("Please fill in all fields.");
            return;
        } else {
            addNewApplication(appTitle, appDescription);    
        }
      }
});

application_list.addEventListener("click", function(event) {
    if (event.target.tagName === 'DIV' && event.target.classList.contains("application")) {
        const appId = event.target.getAttribute('data-app-id');
        window.location.href = `application.php?app_id=${appId}`;        
    }
});

function addNewApplication(appTitle, appDescription) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            //document.querySelector(".application_list").innerHTML = this.responseText;
            reloadApplications();
            add_new_app_dialog.close();
        }
    };
    xhttp.open("POST", "applications_create_new.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "app_name=" + encodeURIComponent(appTitle) + "&app_descr=" + encodeURIComponent(appDescription);
    xhttp.send(params);
}


function reloadApplications() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".application_list").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "applications_load.php", true);
    xhttp.send();
}

