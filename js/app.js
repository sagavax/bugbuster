
const application_details_header = document.querySelector(".application_details_header");
const application_details_header_title = document.querySelector(".application_details_header_title");
const application_details_header_description = document.querySelector(".application_details_header_description");
const application_details_header_image = document.querySelector(".application_details_header_image");
const application_details_header_image_text = document.querySelector(".application_details_header_image_text");

const application_details_github = document.querySelector(".application_details_github");
const application_details_diary = document.querySelector(".application_details_diary");
const application_details_notes = document.querySelector(".application_details_notes");
const application_details_bugs = document.querySelector(".application_details_bugs");
const application_details_ideas = document.querySelector(".application_details_ideas");


application_details_github.style.display = "flex";
application_details_diary.style.display = "none";
application_details_notes.style.display = "none";
application_details_bugs.style.display = "none";
application_details_ideas.style.display = "none";


application_details_header.addEventListener("click", function(event) {
    if (event.target.tagName === 'BUTTON') {
       eventName = event.target.name;
       if(eventName==="github_link"){
        console.log("shows github repo information");
            showAppGithubDetails();
       } else if (eventName==="app_diary"){
        console.log("shows app diary");
           showAppDiary();
       } else if  (eventName==="app_notes"){
        console.log("shows app notes");
         showAppNotes();
       } else if (eventName==="app_bugs"){
        console.log("show app bugs");
         showAppBugs();
       } else if (eventName==="app_ideas"){
        console.log("show app ideas");
         showAppIdeas();
       }
    }
    });

        function showAppGithubDetails(){
            application_details_github.style.display = "flex";
            application_details_diary.style.display = "none";
            application_details_notes.style.display = "none";
            application_details_bugs.style.display = "none";
            application_details_ideas.style.display = "none";
        }

        function showAppDiary(){
            application_details_github.style.display = "none";
            application_details_diary.style.display = "flex";
            application_details_notes.style.display = "none";
            application_details_bugs.style.display = "none";
            application_details_ideas.style.display = "none";
        }

        function showAppNotes(){
            application_details_github.style.display = "none";
            application_details_diary.style.display = "none";
            application_details_notes.style.display = "flex";
            application_details_bugs.style.display = "none";
            application_details_ideas.style.display = "none";
        }

        function showAppBugs(){
            application_details_github.style.display = "none";
            application_details_diary.style.display = "none";
            application_details_notes.style.display = "none";
            application_details_bugs.style.display = "flex";
            application_details_ideas.style.display = "none";
        }
         
        function showAppIdeas(){
            application_details_github.style.display = "none";
            application_details_diary.style.display = "none";
            application_details_notes.style.display = "none";
            application_details_bugs.style.display = "none";
            application_details_ideas.style.display = "flex";
        }

/*     function showAppGithubDetails(appId) {
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
    }    */