
const application_details_header = document.querySelector(".application_details_header");
const application_details_header_title = document.querySelector(".application_details_header_title");
const application_details_header_description = document.querySelector(".application_details_header_description");
const application_details_header_image = document.querySelector(".application_details_header_image");
const application_details_header_image_text = document.querySelector(".application_details_header_image_text");
const application_details_body = document.querySelector(".application_details_body");

const application_details_github = document.querySelector(".application_details_github");
const application_details_diary = document.querySelector(".application_details_diary");
const application_details_notes = document.querySelector(".application_details_notes");
const application_details_bugs = document.querySelector(".application_details_bugs");
const application_details_ideas = document.querySelector(".application_details_ideas");

const buttons = document.querySelectorAll('.application_details_body button[name="page"]');


application_details_github.style.display = "flex";
application_details_diary.style.display = "none";
application_details_notes.style.display = "none";
application_details_bugs.style.display = "none";
application_details_ideas.style.display = "none";

//tabs
application_details_header.addEventListener("click", function(event) {
    if (event.target.tagName === 'BUTTON') {
        eventName = event.target.innerText.toLowerCase();
        console.log(eventName);
       sessionStorage.setItem('module_name', eventName.toLowerCase())
       if(eventName==="github"){
        console.log("shows github repo");
         showAppGithubDetails();
       } else if (eventName==="diary"){
         console.log("shows app diary");
         showAppDiary();
       } else if  (eventName==="notes"){
        console.log("shows app notes");
         showAppNotes();
       } else if (eventName==="bugs"){
        console.log("show app bugs");
         showAppBugs();
       } else if (eventName==="ideas"){
        console.log("show app ideas");
         showAppIdeas();
       } 
    }
    });


 //change paging styles buttons after click
 application_details_body.addEventListener("click", function(event) {
     if(event.target.tagName==="BUTTON" && event.target.name==="page"){
         const buttons = document.querySelectorAll('.application_details_body button[name="page"]');
         for (let i = 0; i < buttons.length; i++) {
             buttons[i].style.opacity=1;
         }
        event.target.style.opacity=0.8;
        pageNumber=event.target.innerText;
        getModulesPage(pageNumber, sessionStorage.getItem('module_name'));
     }
 })




    function showAppGithubDetails(){
        console.log("shows github repo information");
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