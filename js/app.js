
const application_details_header = document.querySelector(".application_details_header");
const application_details_header_title = document.querySelector(".application_details_header_title");
const application_details_header_description = document.querySelector(".application_details_header_description");
const application_details_header_image = document.querySelector(".application_details_header_image");
const application_details_header_image_text = document.querySelector(".application_details_header_image_text");


application_details_header.addEventListener("click", function(event) {
    if (event.target.tagName === 'BUTTON') {
       eventName = event.target.name;
       if(eventName==="github_link"){
        console.log("shows github repo information");
            showAppGithubDetails(appId);
       } else if (eventName==="app_diary"){
        console.log("shows app diary");
           showAppDiary(appId);
       } else if  (eventName==="app_notes"){
        console.log("shows app notes");
         showAppNotes(appId);
       } else if (eventName==="app_bugs"){
        console.log("show app bugs");
         showAppBugs(appId);
       } else if (eventName==="app_ideas"){
        console.log("show app ideas");
         showAppIdeas(appId);
       }
    }
    });


    function showAppGithubDetails(appId) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("application_details_body").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "application_github_details.php?app_id="+appId, true);
        xhttp.send();
    }

    function showAppDiary(appId) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("application_details_body").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "application_diary.php?app_id="+appId, true);
        xhttp.send();
    }   


    function showAppNotes(appId) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("application_details_body").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "application_notes.php?app_id="+appId, true);
        xhttp.send();
    }

    function showAppBugs(appId) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("application_details_body").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "application_bugs.php?app_id="+appId, true);
        xhttp.send();
    }

    function showAppIdeas(appId) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("application_details_body").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "application_ideas.php?app_id="+appId, true);
        xhttp.send();
    }   