const bug_list = document.querySelector('.bug_list');
const modal_show_status = document.querySelector('.modal_show_status');
const modal_show_priority = document.querySelector('.modal_show_priority');
const modal_add_comment = document.querySelector('.modal_add_comment');
const bug_application_filter = document.querySelector('.bug_application_filter');
const bug_priority_filter = document.querySelector('.bug_priority_filter');
const bug_status_filter = document.querySelector('.bug_status_filter');
var new_bug_form= document.querySelector('.new_bug form');
const modal_change_app = document.querySelector('.modal_change_app');
const modal_change_app_list_item = document.querySelector('.modal_change_app ul li'); 
const bugs_search_input = document.querySelector('.bugs_search input');
const modal_add_label = document.querySelector('#modal-add-label');
const bugs_form_textarea = document.querySelector('.new_bug textarea[name="bug_text"]');


bugs_form_textarea.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});


modal_add_label.addEventListener('click', function(event) {
    if (event.target.classList.contains('label-btn')) {
        const label = event.target.getAttribute('data-label');
        const bugId = sessionStorage.getItem('bug_id');
        addLabelToBug(bugId, label);
    }
});

bugs_search_input.addEventListener('input', function() {
    const searchQuery = this.value.toLowerCase();
    SearchBugs(searchQuery);
});


new_bug_form.addEventListener('submit', function(event) {
    event.preventDefault();

    const bugTitle = document.querySelector('.new_bug input[name="bug_title"]').value;
    const bugDescription = document.querySelector('.new_bug textarea[name="bug_text"]').value;
    let bugPriority = document.querySelector('.new_bug select[name="bug_priority"]').value;
    let bugStatus = document.querySelector('.new_bug select[name="bug_status"]').value;
    let bugApplication = document.querySelector('.new_bug select[name="bug_application"]').value;

    if (bugDescription === "") {
        alert("Please fill bug description.");
        return;
    }

    // Default values if empty or 0
    if (bugApplication === "0" || bugApplication === "") {
        bugApplication = "bugbuster";
    }

    if (bugStatus === "0" || bugStatus === "") {
        bugStatus = "new";
    }

    if (bugPriority === "0" || bugPriority === "") {
        bugPriority = "low";
    }

    // Call your bug-adding function
    addNewBug(bugTitle, bugDescription, bugApplication, bugPriority, bugStatus);
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

bug_status_filter.addEventListener('click', function(event) {
    if (event.target.tagName === 'BUTTON') {
        const status = event.target.innerText;
        filterBugsByStatus(status);
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
                if(document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).textContent === "fixed") {
                    alert("Cannot remove a fixed bug.");
                    return;
                } else {
                    modal_add_label.showModal();
                }
                //removeBug(bugId);
                
                break;
            case "to_fixed":
                console.log("mark bug as fixed");
                if(document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).textContent === "new"){
                    alert("Cannot set fixed a new bug.");
                    return; 
                } else if(document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).textContent === "fixed") {
                    alert("this bug is already fixed.");
                } else {
                markBugAsFixed(bugId);
                document.querySelector(`.bug[bug-id='${bugId}'] button[name='to_fixed']`).remove();
                document.querySelector(`.bug[bug-id='${bugId}'] button[name='add_comment']`).remove();
                document.querySelector(`.bug[bug-id='${bugId}'] button[name='bug_remove']`).remove();

                const bugElement = document.querySelector(`.bug[bug-id='${bugId}'] .bug_footer .bug_comments`);

                if (bugElement) {
                    const fixedDiv = document.createElement("div");
                    fixedDiv.className = "bug_fixed";
                    fixedDiv.textContent = "fixed";
                    bugElement.after(fixedDiv); // pridá za .bug_comments
                    }
                }
                break;
            case "to_reopen":
                
                if(document.querySelector(`.bug[bug-id='${bugId}'] .bug_status`).textContent === "fixed"){
                    console.log("reopening the  bug");
                    reopenBug(bugId); 
                }
                break;
            case "add_comment":
                modal_add_comment.showModal();
                break;   
            case "move_to_ideas":
                alert("Cannot move a bug to ideas yet.");
                //moveBugToIdeas(bugId);
                break;     
        }
    } if (event.target.classList.contains("bug_application")) {
        const bugId = event.target.closest(".bug").getAttribute('bug-id');
        sessionStorage.setItem('bug_id',bugId);
        modal_change_app.showModal();
    } else if (event.target.classList.contains("bug_github_link")) {
        const bug_url = event.target.getAttribute('data-link');
        window.open(bug_url, '_blank');
    } else if (event.target.classList.contains("bug_title")) {

        const bugId = event.target.closest(".bug").getAttribute('bug-id');
        document.querySelector(`.bug[bug-id='${bugId}'] .bug_title`).setAttribute('contenteditable', 'true');

        document.querySelector(`.bug[bug-id='${bugId}'] .bug_title`).onblur = function() {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_title`).removeAttribute('contenteditable');
            changeBugTitle(bugId);
        }

    } else if (event.target.classList.contains("bug_text")) {
        const bugId = event.target.closest(".bug").getAttribute('bug-id');
        document.querySelector(`.bug[bug-id='${bugId}'] .bug_text`).setAttribute('contenteditable', 'true');
        
        document.querySelector(`.bug[bug-id='${bugId}'] .bug_text`).onblur = function() {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_text`).removeAttribute('contenteditable');
            changeBugText(bugId);
        }
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

function filterBugsByStatus(status) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".bug_list").innerHTML = this.responseText;
           
        }
    };
    xhttp.open("POST", "bugs_filter_by_status.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "status=" + encodeURIComponent(status);
    xhttp.send(params);
}

function addComment(bugId, commentText) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_comments`).innerHTML = this.responseText;
            //console.log("recalculating comments");
           //recalculateBugComments(bugId);
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

function addNewBug(bugTitle, bugDescription, bugApplication, bugPriority, bugStatus) {
    // Skontroluj, či sú všetky potrebné hodnoty vybrané
    
    
    
    if (bugApplication===0){
        bugApplication='bugbuster';
    } 

    if(bugStatus===0){
        bugStatus='new';
    }   
    
    if(bugPriority===0){
        bugPriority='low';
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("New bug has been created!");

            GetLatestBugId()
                .then(function(bugId) {
                    console.log("Latest Bug ID is: " + bugId);

                    var nrofComments = "0 comments";
                    var bug_github_url = ""; // Možná URL na GitHub

                    var newBug = `
                        <div class='bug' bug-id='${bugId}'>
                            <div class='bug_title'>${bugTitle}</div>
                            <div class='bug_text'>${bugDescription}</div>
                            <div class='bug_footer'>
                                <div class='bug_github_link' data-link='${bug_github_url}'>
                                    <i class='fab fa-github-alt'></i>
                                </div>
                                <div class='bug_application'>${bugApplication}</div>
                                <div class='bug_status ${bugStatus}'>${bugStatus}</div>
                                <div class='bug_priority ${bugPriority}'>${bugPriority}</div>
                                <div class='bug_comments'>${nrofComments}</div>
                                <div class='bug_action'>
                                    <button type='button' class='button small_button' name='see_bug_details' title='bug details'><i class='fa fa-eye'></i></button>
                                    <button type='button' class='button small_button' name='to_fixed' title = 'mark as fixed'><i class='fa fa-check'></i></button>
                                    <button type='button' class='button small_button' name='move_to_ideas' title='move to ideas'><i class='fas fa-chevron-right'></i></button>
                                    <button type='button' class='button small_button' name='bug_remove' title='remove bug'><i class='fa fa-times'></i></button>
                                    <button type='button' class='button small_button' name='add_comment' title='add comment'><i class='fa fa-comment'></i></button>
                                </div>
                            </div>
                        </div>`;
                    document.querySelector(".bug_list").insertAdjacentHTML("afterbegin", newBug);
                })
                .catch(function(error) {
                    console.error("Failed to get Bug ID: " + error);
                });
        }
    };

    xhttp.open("POST", "bugs_create_new.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "bug_title=" + encodeURIComponent(bugTitle) +
                 "&bug_description=" + encodeURIComponent(bugDescription) +
                 "&bug_application=" + encodeURIComponent(bugApplication) +
                 "&bug_priority=" + encodeURIComponent(bugPriority) +
                 "&bug_status=" + encodeURIComponent(bugStatus);
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


 function SearchBugs(searchQuery) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".bug_list").innerHTML = this.responseText;
        }
    };    
    
    xhttp.open("POST", "bugs_search.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "search="+searchQuery;
    xhttp.send(params);
    
    }    


    function addLabelToBug(bugId, label) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                removeBug(bugId);
                document.querySelector('#modal-add-label').close();
            }
        };
        xhttp.open("POST", "bugs_label_add.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var params = "bug_id="+bugId+"&label="+encodeURIComponent(label);
        xhttp.send(params);
    }


    function moveBugToIdeas(bugId){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.querySelector(`.bug[bug-id='${bugId}'] `).remove();
            }
        };    
        
        xhttp.open("POST", "bugs_to_ideas.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var params = "bug_id="+bugId;
        xhttp.send(params); 
    }

    function changeBugText(bugId){
        var bugText = document.querySelector(`.bug[bug-id='${bugId}'] .bug_text`).innerText;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.querySelector(`.bug[bug-id='${bugId}'] .bug_text`).removeAttribute('contenteditable');
            }
        };    
        
        xhttp.open("POST", "bugs_text_change.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var params = "bug_id="+bugId+"&bug_text="+encodeURIComponent(bugText);
        xhttp.send(params);
    }


    function changeBugTitle(bugId){
        var bugTitle = document.querySelector(`.bug[bug-id='${bugId}'] .bug_title`).innerText;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.querySelector(`.bug[bug-id='${bugId}'] .bug_title`).removeAttribute('contenteditable');
            }
        };    
        
        xhttp.open("POST", "bugs_title_change.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var params = "bug_id="+bugId+"&bug_title="+encodeURIComponent(bugTitle);
        console.log(params);
        xhttp.send(params);
    }


    function GetLatestBugId() {
        return new Promise((resolve, reject) => {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        resolve(this.responseText); // Úspešne vráti ID
                    } else {
                        reject('Error fetching the latest bug ID');
                    }
                }
            };
            xhttp.open("POST", "bugs_get_latest_id.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var params = "";
            xhttp.send(params);
        });
    }