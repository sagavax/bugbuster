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
      
    if (event.target.tagName === 'BUTTON'){
        const appId = event.target.closest(".application").getAttribute('data-app-id');
        if(event.target.name==="app_deactivate_dev"){
            console.log("deactivate app");
            deactivateAppDevelopment(appId);
        } else if (event.target.name==="edit_app"){
            console.log("edit app");
            window.location.href = `application_edit.php?app_id=${appId}`;     
        } else if  (event.target.name==="app_details"){
            console.log("app details");
            window.location.href = `application.php?app_id=${appId}`;
        }
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

function deactivateAppDevelopment(appId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            reloadApplications();
        }
    };
    xhttp.open("POST", "application_dev_deactivate.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "app_id=" + encodeURIComponent(appId);
    xhttp.send(params);
}
