const ideas_list = document.querySelector('.ideas_list');
const modal_show_status = document.querySelector('.modal_show_status');
const modal_show_priority = document.querySelector('.modal_show_priority');
const idea_priority_filter = document.querySelector(".idea_priority_filter");


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
        } else if (buttun.name==="to_apply"){
            alert(`Idea ${ideaId} moved to the Apply section.`);
            moveIdeaToApply(ideaId);
            //document.querySelector(`.idea[idea-id='${ideaId}']`).remove();
        } else if (button.name==="to_review"){
            //for the future use
        }
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


function moveIdeaToApply($ideaId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        // Check if the request is complete and was successful
        if (this.readyState == 4 && this.status == 200) {
            //document.querySelector(`.idea[idea-id='${ideaId}']`).remove();
            alert("Idea moved to the Apply section.");
            window.location.reload();
        }
    };
    xhttp.open("POST", "ideas_move_to_apply.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "idea_id=" + encodeURIComponent($ideaId);
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