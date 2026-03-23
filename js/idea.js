const idea_comment_new_form= document.querySelector(".idea_comment_new form" );
const idea_comments_list = document.querySelector(".idea_comments_list");
const idea_application_filter = document.querySelector(".idea_application_filter");
const idea_comment_new = document.querySelector(".idea_comment_new");


idea_comment_new.addEventListener("click", function(event) {
  if (event.target.tagName === "BUTTON" && event.target.name === "save_idea_comment") {
    // Alert or call the saveIdeaComment function
    // alert("Uložiť komentár");
    const ideaId = sessionStorage.getItem("idea_id");
    saveIdeaComment(ideaId);
  }
});


idea_comments_list.addEventListener("click",function(event) {
    if(event.target.tagName==="BUTTON"){
        if (event.target.name==="delete_comment"){
            const commentId = event.target.closest(".idea_comment").getAttribute("data-comment-id");
            const ideaId = sessionStorage.getItem("idea_id");
            console.log(commentId, ideaId);
            deleteIdeaComment(commentId, ideaId);
        }
        
    }
});


function getIdeaComment(commentId) {
}

function deleteIdeaComment(commentId,ideaId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
        document.querySelector(`.idea_comment[data-comment-id='${commentId}']`).remove();

        document.querySelector(".idea_detail .nr_of_comments").textContent = parseInt(document.querySelector(".idea_detail .nr_of_comments").textContent) - 1 + " comment(s)";
          alert("Komment bol vymazany!");
        }
      };
    var data = "comm_id="+commentId+"&idea_id="+ideaId;
    xhttp.open("POST", "idea_comment_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function saveIdeaComment(ideaId) {
   if(document.querySelector(".idea_comment_new textarea").value==""){
     alert("Prosím, vložte komentár.");
     return;
   }
   
    var textarea = document.querySelector(".idea_comment_new textarea");
    var input = document.querySelector(".idea_comment_new input");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
          alert("Komentár bol uložený!");
          // refresh comments list
          const newCommentId = this.responseText.trim();

          const html = `<div class="idea_comment" data-comment-id="${newCommentId}">
                          <div class='connector-line'></div>
                          <div class="idea_top_banner"></div>
                          <div class="idea_comment_header">${document.querySelector(".idea_comment_new input").value}</div>
                          <div class="idea_comment_body">${document.querySelector(".idea_comment_new textarea").value}</div>
                          <div class="idea_comm_action">
                            <button type="button" name="delete_comment" class="button"><i class="fa fa-times"></i></button>
                          </div>
                        </div>`;
          document.querySelector(".idea_comments_list").insertAdjacentHTML("beforeend", html);
        
          //nr of comments update
          document.querySelector(".idea_detail .nr_of_comments").textContent = parseInt(document.querySelector(".idea_detail .nr_of_comments").textContent) + 1 + " comment(s)";

        }
      };
   
    var data = "comment="+encodeURIComponent(textarea.value)+"&comment_title="+encodeURIComponent(input.value)+"&idea_id="+encodeURIComponent(ideaId);
    xhttp.open("POST", "idea_comment_save.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}


function getIdeaComments(ideaId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
          document.querySelector(".idea_comments_list").innerHTML = this.responseText;
        }
      };
    xhttp.open("POST", "idea_comments_get.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("idea_id="+encodeURIComponent(ideaId));
}

function clearIdeaComments() {
    while (idea_comments_list.firstChild) {
        idea_comments_list.removeChild(idea_comments_list.firstChild);
    }
}


function addIdeaComment(ideaId) {
    
}

function filterIdeasByApplication(application) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      // Check if the request is complete and was successful
      if (this.readyState == 4 && this.status == 200) {
          document.querySelector(".bug_list").innerHTML = this.responseText;
         
      }
  };
  xhttp.open("POST", "ideas_filter_by_application.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Send the request with the videoId and modpackId
  var params = "application=" + encodeURIComponent(application);
  xhttp.send(params);
}