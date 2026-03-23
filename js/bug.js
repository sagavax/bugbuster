const footer = document.querySelector(".bug_footer");
const bug_comment_new_form = document.querySelector(".bug_comment_new form");
const bug_comm_action_form = document.querySelector(".bug_comm_action form");
const bug_comments_list = document.querySelector(".bug_comments_list");




bug_comments_list.addEventListener("click",function(ev){
  if(ev.target.tagName==="BUTTON"){
    buttonName=ev.target.name;
    if(buttonName==="delete_comment"){
      deleteComment(ev.target.closest(".bug_comment").getAttribute("comment-id"));
    } 
  }
})


footer.addEventListener("click",function(ev){
    const bugId =sessionStorage.getItem("bug_id");
    if(ev.target.tagName==="BUTTON"){
        buttonName=ev.target.name;
        if(buttonName==="reopen_bug"){
            BugReopened(bugId)   
        } else if (buttonName==="bug_set_fixed"){
            BugFixed(bugId);
        }
     }   
})

bug_comment_new_form.addEventListener("submit", function(event){
//form validation
    event.preventDefault(); // Prevent form submission
     const textarea = document.querySelector(".bug_comment_new form textarea");
    if(textarea.value.trim() === ""){
        alert("Please enter a comment.");
        return;
    } else {
        const bugId =sessionStorage.getItem("bug_id");
        saveBugComment(bugId);
    }
});


 function BugFixed(bugId){
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("bug has been fixed;");
            footer.innerHTML="";
            footer.innerHTML="<button type='button' title='mark the bug as fixed' class='button small_button' name='reopen_bug'>Reopen</button><div class='bug_fixed'>fixed</div>";
          }
          
        xhttp.open("POST", "bugs_mark_as_fixed",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "bug_id="+encodeURIComponent(bugId);                
        xhttp.send(data);
}


function BugReopened(bugId){
      const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("bug has been reopened;")
            //footer remove all content
            footer.innerHTML="";
            //set new
            footer.innerHTML="<button type='button' title='mark the bug as fixed' name='bug_set_fixed' class='button'><i class='fa fa-check'></i></button>"
          }
          
        xhttp.open("POST", "bug_set_reopened.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "bug_id="+encodeURIComponent(bugId);                
        xhttp.send(data);
}

function saveBugComment(bugId){
    const input = document.querySelector(".bug_comment_new form input[name='bug_comment_header']");
    const textarea = document.querySelector(".bug_comment_new form textarea");
    const header = input.value;
    const comment = textarea.value;
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("comment has been saved;");
            textarea.value=""; //clear textarea
            //clear input
            input.value="";

            //get new comment id from response and create new comment element
            const bugCommentId = this.responseText; //assuming response is the new comment id

            const html = "<div class='bug_comment' comment-id="+bugCommentId+">"+
                            "<div class='connector-line'></div>"+
                            "<div class='bug_top_banner'></div>"+
                            "<div class='bug_comment_header'>"+header+"</div>"+
                            "<div class='bug_text'>"+comment+"</div>"+
                            "<div class='bug_comm_action'>"+
                                "<button type='button' class='button' name='delete_comment'><i class='fa fa-times'></i></button>"+
                            "</div>"+
                        "</div>";
            //add new comment to the list without reloading
            document.querySelector(".bug_comments_list").insertAdjacentHTML("beforeend", html);


            
          }
          
        xhttp.open("POST", "bug_comment_save.php",true);        
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "bug_id="+encodeURIComponent(bugId)+"&comment="+encodeURIComponent(comment)+"&header="+encodeURIComponent(header);                
        xhttp.send(data);
}

function reloadBugComments(bugId){
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.querySelector(".bug_comments_list").innerHTML = this.responseText;
          }
          
        var data = "bug_id="+encodeURIComponent(bugId);                
        xhttp.open("GET", "bug_comments.php?"+data,true);
        xhttp.send();
}


function deleteComment(commentId){
    const bugId =sessionStorage.getItem("bug_id");
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("comment has been deleted;");
            document.querySelector(".bug_comment[comment-id='"+commentId+"']").remove(); //remove comment from DOM
            //reloadBugComments(bugId);
          }
          
        xhttp.open("POST", "bug_comment_remove.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "comm_id="+encodeURIComponent(commentId)+"&bug_id="+encodeURIComponent(bugId);                
        xhttp.send(data);
}