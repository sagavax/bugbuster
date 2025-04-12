const bug_list = document.querySelector('.bug_list');
const modal_show_status = document.querySelector('.modal_show_status');
const modal_show_priority = document.querySelector('.modal_show_priority');
const modal_add_comment = document.querySelector('.modal_add_comment');
const bug_application_filter = document.querySelector('.bug_application_filter');
const bug_priority_filter = document.querySelector('.bug_priority_filter');
var new_bug_form= document.querySelector('.new_bug form');
const modal_change_app = document.querySelector('.modal_change_app');
const modal_change_app_list_item = document.querySelector('.modal_change_app ul li'); 
//markdown editor

 
/* modal_show_status.style.visibility = "hidden";
modal_show_priority.style.visibility = "hidden";
modal_show_priority.style.display = "block";
modal_show_status.style.display = "block";

const width = modal_show_priority.offsetWidth;
const height = modal_show_priority.offsetHeight;

const width_modal_status = modal_show_status.offsetWidth;
const height_modal_status = modal_show_status.offsetHeight; */
/* 
modal_show_priority.style.display = 'none';
modal_show_status.style.display = 'none';
modal_show_priority.style.visibility = 'visible';
modal_show_status.style.visibility = 'visible'; */


new_bug_form.addEventListener('submit', function(event) {
    event.preventDefault();
    const bugTitle = document.querySelector('.new_bug input[name="bug_title"]').value;
    const bugDescription = document.querySelector('.new_bug textarea[name="bug_text"]').value;
    const bugPriority = document.querySelector('.new_bug select[name="bug_priority"]').value;
    const bugStatus = document.querySelector('.new_bug select[name="bug_status"]').value;
    const bugApplication = document.querySelector('.new_bug select[name="bug_application"]').value; // Fixed typo

    if (bugDescription === "") {   
        alert("Please fill in all fields.");
    } else {
        addNewBug(bugTitle, bugDescription, bugApplication, bugPriority, bugStatus);
    }
});

bug_application_filter.addEventListener('click', function(event) {
    if (event.target.tagName === 'BUTTON') {
        const application = event.target.innerText;
        filterBugsByApplication(application);
    }
});

bug_priority_filter.addEventListener('click', function(event) {
    if (event.target.tagName === 'BUTTON') {
        const priority = event.target.innerText;
        filterBugsByPriority(priority);
    }
});

bug_list.addEventListener('click', function(event) {
    const targetClass = event.target.classList;

    if (event.target.tagName === 'DIV' && (targetClass.contains("bug_status") || targetClass.contains("bug_priority"))) {
        const bugId = event.target.closest(".bug").getAttribute('bug-id');
        sessionStorage.setItem('bug_id', bugId);
        console.log(bugId);

        const modal = targetClass.contains("bug_status") ? modal_show_status : modal_show_priority;
        
        if (!modal) return;

        const rect = event.target.getBoundingClientRect();
        
        // Posunutie o 10px doľava
      /*   modal.style.left = `${rect.left + rect.width / 2 - modal.offsetWidth / 2}px`;
        modal.style.top = `${rect.top - modal.offsetHeight}px`; */
        modal.style.left = `${rect.left + rect.width / 2 - 172 / 2}px`; // Centers the modal horizontally
        modal.style.top = `${rect.top - 164 - 10}px`; // Places it 10px above the element
        
        console.log("Element position:", rect.left, rect.top);
        console.log("Modal dimensions:", modal.offsetWidth, modal.offsetHeight);

        modal.showModal();
    } 
    
    if (event.target.tagName === 'BUTTON') {
        const bugId = event.target.closest(".bug")?.getAttribute('bug-id');
        sessionStorage.setItem('bug_id',bugId);
        if (!bugId) return;
    
        switch (event.target.name) {
            case "see_bug_details":
                window.location.href = `bug.php?bug_id=${bugId}`;
                break;
            case "bug_remove":
                removeBug(bugId);
                break;
            case "to_fixed":
                console.log("mark bug as fixed");
                markBugAsFixed(bugId);
                break;
            case "to_reopen":
                console.log("reopen bug");
                reopenBug(bugId);
                break;
            case "add_comment":
                modal_add_comment.showModal();
                break;    
        }
    } if (event.target.classList.contains("bug_application")) {
        const bugId = event.target.closest(".bug").getAttribute('bug-id');
        sessionStorage.setItem('bug_id',bugId);
        modal_change_app.showModal();
    }
});


modal_show_status.addEventListener('click', function(event) {
if (event.target.tagName === 'LI') {    
    const bugId = sessionStorage.getItem('bug_id');
    const bugStatus = event.target.innerText;
    console.log(`Bug ${bugId} status updated to ${bugStatus}`);
    if(document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).innerText === "fixed"){
        alert("Cannot change status of a fixed bug.");
        modal_show_status.close();
        return;
        
    } else {
    changeBugStatus(bugId, bugStatus);
    modal_show_status.close();
    }
}
});

modal_show_priority.addEventListener('click', function(event) {
    if (event.target.tagName === 'LI') {    
        const bugId = sessionStorage.getItem('bug_id');
        const bugPriority = event.target.innerText;
        console.log(`Bug ${bugId} status updated to ${bugPriority}`);
        if(document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).innerText === "fixed"){
            alert("Cannot change priority of a fixed bug.");
            modal_show_priority.close();
            return;
            
        } else {
        changeBugPriority(bugId, bugPriority);
        modal_show_priority.close();
        }
    }
});


modal_add_comment.addEventListener('click', function(event) {
    if (event.target.tagName === 'BUTTON') {    
        const bugId = sessionStorage.getItem('bug_id');
        const commentText = modal_add_comment.querySelector('textarea').value;
        console.log(`Bug ${bugId} status updated to ${commentText}`);
        addComment(bugId, commentText);
        modal_add_comment.close();
    }
});

function changeBugStatus(bugId, bugStatus) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).innerText = bugStatus;
           
        }
    };
    xhttp.open("POST", "bugs_change_status.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "bug_id=" + encodeURIComponent(bugId) + "&bug_status=" + encodeURIComponent(bugStatus);
    xhttp.send(params);
}

function changeBugPriority(bugId, bugPriority) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_priority`).innerText = bugPriority;
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_priority`).classList.remove("low", "medium", "high", "critical");
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_priority`).classList.add(bugPriority);
            //document.querySelector(`.bug[bug-id='${bugId}'] .bug_priority`).style.border = "1px solid #d1d1d1"; 
        }
    };
    xhttp.open("POST", "bugs_change_priority.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "bug_id=" + encodeURIComponent(bugId) + "&bug_priority=" + encodeURIComponent(bugPriority);
    xhttp.send(params);
}


function addNewComment(bugId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_comments`).innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "bugs_add_comment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");    

    // Send the request with the videoId and modpackId
}

function filterBugsByApplication(application) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".bug_list").innerHTML = this.responseText;
           
        }
    };
    xhttp.open("POST", "bugs_filter_by_application.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "application=" + encodeURIComponent(application);
    xhttp.send(params);
}


function filterBugsByPriority(priority) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".bug_list").innerHTML = this.responseText;
           
        }
    };
    xhttp.open("POST", "bugs_filter_by_priority.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "priority=" + encodeURIComponent(priority);
    xhttp.send(params);
}

function addComment(bugId, commentText) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            //document.querySelector(`.bug[bug-id='${bugId}'] .bug_comments`).innerHTML = this.responseText;
            //console.log("recalculating comments");
           recalculateBugComments(bugId);
        }
    };
    xhttp.open("POST", "bugs_comment_add.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "bug_id=" + encodeURIComponent(bugId) + "&comment_text=" + encodeURIComponent(commentText);
    xhttp.send(params);
}


function recalculateBugComments(bugId){
    console.log("recalculating comments begins...");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            //document.querySelector(`.bug[bug-id='${bugId}'] .bug_comments`).innerHTML = this.responseText;
            console.log("recalculating comments: " + this.responseText+" comments");
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_comments`).innerHTML = this.responseText+" comments";
        }
    };
    xhttp.open("POST", "bugs_recalculate_comments.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Send the request with the videoId and modpackId            
    var params = "bug_id=" + encodeURIComponent(bugId);
    xhttp.send(params);
}


function removeBug(bugId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.bug[bug-id='${bugId}']`).remove();
            console.log("removed bug");
            alert("Bug has been removed!");
        }
    };
    xhttp.open("POST", "bugs_delete.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "bug_id=" + encodeURIComponent(bugId);
    xhttp.send(params);
}

function addNewBug(bugTitle,bugDescription,bugApplication, bugPriority, bugStatus) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".bug_list").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "bugs_create_new.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "bug_title="+encodeURIComponent(bugTitle)+"&bug_description="+encodeURIComponent(bugDescription)+"&bug_application="+encodeURIComponent(bugApplication)+"&bug_priority="+encodeURIComponent(bugPriority)+"&bug_status="+encodeURIComponent(bugStatus);
    xhttp.send(params);
}   


function markBugAsFixed(bugId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).innerText = "Fixed";    
        }
    }
    xhttp.open("POST", "bugs_mark_as_fixed.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "bug_id=" + encodeURIComponent(bugId);
    xhttp.send(params);
} 

function reopenBug(bugId) {
    if(document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).innerText != "fixed"){
        alert("Cannot reopen a bug that is not fixed.");
        return;
    } else {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).innerText = "Open";    
        }
    }
    xhttp.open("POST", "bugs_reopen.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "bug_id=" + encodeURIComponent(bugId);
    xhttp.send(params);
    }
}

modal_change_app.addEventListener("click", function(event) {
    if (event.target.tagName==="LI") {
        //console.log("clicked on listitem:"+event.target.innerText);
        const old_app_name = sessionStorage.getItem('old_app_name');
        if(old_app_name===event.target.innerText){
            alert("Cannot change application to the same one.");
            modal_change_app.close();
            return;
        } else {
        
        const appName = event.target.innerText;
        const bugId = sessionStorage.getItem('bug_id');
        console.log("app name: "+appName+" note id: "+bugId);
        //console.log("app id: "+app_id);
        changeApplication(appName, bugId);
        }
    }
}); 

function changeApplication(appName, bugId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        //document.getElementById("diary_content").innerHTML = this.responseText;
        //var app_name =  sessionStorage.getItem('app_name');
        modal_change_app.close();
        document.querySelector(`.bug[bug-id='${bugId}'] .bug_application`).innerText = appName;
      }
    };
    xhttp.open("POST", "bugs_change_app.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "app_name="+appName+"&bug_id="+bugId;
    xhttp.send(params);
 }