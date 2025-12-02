const app_tabs = document.querySelector(".app_tabs");
const sidebar = document.querySelector(".sidebar");
const add_new_app_dialog = document.querySelector(".add_new_app_dialog");


sidebar.addEventListener("click", function(e){
    if(e.target.tagName==="BUTTON" && e.target.name==="app_details"){
        const appId = e.target.getAttribute('data-app-id');
        sessionStorage.setItem('app_id', appId);
    } else if (e.target.tagName==="BUTTON" && e.target.name==="add_app"){
        add_new_app_dialog.showModal();
    }
})


app_tabs.addEventListener("click", function(e) {
    if(e.target.tagName==="BUTTON"){
        const tab_name = e.target.name;
        const appId = sessionStorage.getItem('app_id');
        console.log("tab name: "+tab_name+" app id: "+appId);
        if(tab_name==="app_diary"){
            loadAppDiary(appId);
        }
        if(tab_name==="app_notes"){
            loadAppNotes(appId);
        }
        if(tab_name==="app_bugs"){

            loadAppBugs(appId);
        }
        if(tab_name==="app_ideas"){
            loadAppIdeas(appId);
        } 
       
        if(tab_name==="app_ideas"){
            loadAppGithub(appId);
        } 

    }
})





 function getModulesPage(pageNumber, moduleName) {
    console.log("page number: " + pageNumber + " module name: " + moduleName);
    const appName = sessionStorage.getItem('app_name');
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector("." + moduleName+"_container").innerHTML = this.responseText;
        }
    };

    xhttp.open("POST", "application_" + moduleName + "_filter_by_page.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var params = "page=" + encodeURIComponent(pageNumber) + "&app_name=" + encodeURIComponent(appName);
    xhttp.send(params);
}


function loadAppDiary(appId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".app_content").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "load_app_diary.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "app_id=" + encodeURIComponent(appId);
    xhttp.send(params);
}

function loadAppNotes(appId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".app_content").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "load_app_notes.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "app_id=" + encodeURIComponent(appId);
    xhttp.send(params);
}


function loadAppBugs(appId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".app_content").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "load_app_bugs.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "app_id=" + encodeURIComponent(appId);
    console.log(params);
    xhttp.send(params);
}

function loadAppIdeas(appId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".app_content").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "load_app_ideas.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "app_id=" + encodeURIComponent(appId);
    xhttp.send(params);
}

function loadAppGithub(appId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".app_content").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "load_app_github.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   var params = "app_id=" + encodeURIComponent(appId);
    xhttp.send(params);
}

function loadAppOverview(appId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".app_content").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "load_app_overview.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "app_id=" + encodeURIComponent(appId);
    xhttp.send(params);
}