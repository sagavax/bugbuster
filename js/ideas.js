const ideas_list = document.querySelector('.ideas_list');
const modal_show_status = document.querySelector('.modal_show_status');
const modal_show_priority = document.querySelector('.modal_show_priority');
const idea_priority_filter = document.querySelector(".idea_priority_filter");
const modal_change_app = document.querySelector('.modal_change_app');
const modal_change_app_list_item = document.querySelector('.modal_change_app ul li'); 
const idea_application_filter = document.querySelector(".idea_application_filter");

idea_priority_filter.addEventListener("click",function(event) {
    if(event.target.tagName==="BUTTON"){
       const priority = event.target.innerText;
       filterIdeasByPriority(priority);
    }
});

ideas_list.addEventListener('click', function(event) {
    const targetClass = event.target.classList;

    if (event.target.tagName === 'DIV' && (targetClass.contains("idea_status") || targetClass.contains("idea_priority"))) {
        const ideaId = event.target.closest(".idea").getAttribute('idea-id');
        sessionStorage.setItem('idea_id', ideaId);
        console.log(ideaId);

        const modal = targetClass.contains("idea_status") ? modal_show_status : modal_show_priority;
        
        if (!modal) return;

        const rect = event.target.getBoundingClientRect();
        
        // Posunutie o 10px doľava
        modal.style.left = `${rect.left + rect.width / 2 - modal.offsetWidth / 2 - 10}px`;
        modal.style.top = `${rect.top - modal.offsetHeight - 20}px`;
        modal.showModal();

    } else if (event.target.tagName==="BUTTON" || event.target.tagName==="I") {
        const button = event.target.tagName === "I" ? event.target.closest("button") : event.target;
        //sconsole.log(event.target.tagName);
        const ideaId = event.target.closest(".idea").getAttribute('idea-id');
        //console.log(ideaId);
        sessionStorage.setItem('idea_id', ideaId);
        
        if(button.name==="see_idea_details"){
            window.location.href = `idea.php?idea_id=${ideaId}`;
        } else if (button.name==="delete_idea"){
            alert(`Idea ${ideaId} deleted.`);
            deleteIdea(ideaId);
            //document.querySelector(`.idea[idea-id='${ideaId}']`).remove();
        } else if (button.name==="to_apply"){
            //alert(`Idea ${ideaId} moved to the Apply section.`);
            markIdeaAsImplemented(ideaId);
            
            document.querySelector(`.idea[idea-id='${ideaId}'] button[name='to_apply']`).remove();
            document.querySelector(`.idea[idea-id='${ideaId}'] button[name='delete_idea']`).remove();

            const footer = document.querySelector(`.idea[idea-id='${ideaId}'] .idea_footer`);
            if (footer) {
                const implementedDiv = document.createElement("div");
                implementedDiv.className = "idea_implemented";
                implementedDiv.textContent = "Implemented";
                footer.appendChild(implementedDiv);
            }

            /* document.querySelector(`.idea[idea-id='${ideaId}']`)
            .appendChild(Object.assign(document.createElement("div"), {
                className: "idea_implemented",
                innerHTML: "Implemented"
            }));
 */
            
        } else if (button.name==="to_review"){
            //for the future use
        }
    } if (event.target.classList.contains("idea_application")) {
        const ideaId = event.target.closest(".idea").getAttribute('idea-id');
        sessionStorage.setItem('idea_id',ideaId);
        sessionStorage.setItem('old_app_name', event.target.innerText);
        modal_change_app.showModal();
    }
});



idea_application_filter.addEventListener('click', function(event) {
    if (event.target.tagName === 'BUTTON') {
        console.log("clicked on listitem:"+event.target.innerText);
        const application = event.target.innerText;
        filterIdeasByApplication(application);
    }
  });
  


modal_show_status.addEventListener('click', function(event) {
if (event.target.tagName === 'LI') {    
    const ideaId = sessionStorage.getItem('idea_id');
    const ideastatus = event.target.innerText;
    console.log(`idea ${ideaId} status updated to ${ideastatus}`);
    if(document.querySelector(`.idea[idea-id='${ideaId}'] .idea_status`).innerText === "fixed"){
        alert("Cannot change status of a fixed idea.");
        modal_show_status.close();
        return;
        
    } else {
    changeideastatus(ideaId, ideastatus);
    modal_show_status.close();
    }
}
});

modal_show_priority.addEventListener('click', function(event) {
    if (event.target.tagName === 'LI') {    
        const ideaId = sessionStorage.getItem('idea_id');
        const ideaPriority = event.target.innerText;
        console.log(`idea ${ideaId} status updated to ${ideaPriority}`);
        if(document.querySelector(`.idea[idea-id='${ideaId}'] .idea_status`).innerText === "fixed"){
            alert("Cannot change priority of a fixed idea.");
            modal_show_priority.close();
            return;
            
        } else {
        changeideaPriority(ideaId, ideaPriority);
        modal_show_priority.close();
        }
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
        const ideaId = sessionStorage.getItem('idea_id');
        console.log("app name: "+appName+" idea id: "+ideaId);
        //console.log("app id: "+app_id);
        changeApplication(appName, ideaId);
        }
    }
});

function changeideastatus(ideaId, ideastatus) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.idea[idea-id='${ideaId}'] .idea_status`).innerText = ideastatus;
           
        }
    };
    xhttp.open("POST", "ideas_change_status.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "idea_id=" + encodeURIComponent(ideaId) + "&idea_status=" + encodeURIComponent(ideastatus);
    xhttp.send(params);
}

function changeideaPriority(ideaId, ideaPriority) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.idea[idea-id='${ideaId}'] .idea_priority`).innerText = ideaPriority;
            document.querySelector(`.idea[idea-id='${ideaId}'] .idea_priority`).classList.remove("low", "medium", "high", "critical");
            document.querySelector(`.idea[idea-id='${ideaId}'] .idea_priority`).classList.add(ideaPriority);
            //document.querySelector(`.idea[idea-id='${ideaId}'] .idea_priority`).style.border = "1px solid #d1d1d1"; 
        }
    };
    xhttp.open("POST", "ideas_change_priority.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the videoId and modpackId
    var params = "idea_id=" + encodeURIComponent(ideaId) + "&idea_priority=" + encodeURIComponent(ideaPriority);
    xhttp.send(params);
}


function addNewComment(ideaId) {
    document.queryselector('.modal_add_comment').showModal();
}

function deleteIdea(ideaId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(`.idea[idea-id='${ideaId}']`).remove();
        }
    };
    xhttp.open("POST", "ideas_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "idea_id=" + encodeURIComponent(ideaId);
    xhttp.send(params);
}


function markIdeaAsImplemented(ideaId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            //document.querySelector(`.idea[idea-id='${ideaId}']`).remove();
            alert("Idea maked as implemented.");
            //window.location.reload();
        }
    };
    xhttp.open("POST", "ideas_mark_as_implemented.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "idea_id=" + encodeURIComponent(ideaId);
    xhttp.send(params);
}


function  filterIdeasByPriority(priority){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
        document.querySelector(".ideas_list").innerHTML = this.responseText;
       
        }
      };
    xhttp.open("POST", "ideas_filter_by_priority.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("priority="+encodeURIComponent(priority));
  }
  
  function recalculateIdeaComments(IdeaId){
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            //document.querySelector(`.bug[bug-id='${bugId}'] .bug_comments`).innerHTML = this.responseText;
            console.log("recalculating comments: " + this.responseText+" comments");
            document.querySelector(`.bug[bug-id='${bugId}'] .bug_comments`).innerHTML = this.responseText+" comments";
        }
    };
    xhttp.open("POST", "ideas_recalculate_comments.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Send the request with the videoId and modpackId            
    var params = "bug_id=" + encodeURIComponent(bugId);
    xhttp.send(params);
}



function changeApplication(appName, ideaId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        //document.getElementById("diary_content").innerHTML = this.responseText;
        //var app_name =  sessionStorage.getItem('app_name');
        modal_change_app.close();
        //document.querySelector('.idea[idea-id='${ideaId}'] .idea_application').innerText = appName;
        document.querySelector(`.idea[idea-id='${ideaId}'] .idea_application`).innerText = appName
      }
    };
    xhttp.open("POST", "ideas_change_app.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "app_name="+appName+"&idea_id="+ideaId;
    xhttp.send(params);
 }

 
function filterIdeasByApplication(application) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".ideas_list").innerHTML = this.responseText;
           
        }
    };
    xhttp.open("POST", "ideas_filter_by_application.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
    // Send the request with the videoId and modpackId
    var params = "application=" + encodeURIComponent(application);
    xhttp.send(params);
  }