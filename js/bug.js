const footer = document.querySelector(".bug_footer");
const bug_comment_new_form = document.querySelector(".bug_comment_new form");
const bug_comm_action_form = document.querySelector(".bug_comm_action form");
const bug_comments_list = document.querySelector(".bug_comments_list");



bug_comments_list.addEventListener("click",function(ev){
  if(ev.target.tagName==="BUTTON"){
    buttonName=ev.target.name;
    if(buttonName==="delete_comment"){
      bug_comm_action_form.preventDefault();
      deleteComment(ev.target.getAttribute("comment-id"));
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
            footer.innerHTML="<button type='button' title='mark the bug as fixed' class='button small_button' name='reopen_bug'>Reopen</button><div class='span_modpack'>fixed</div>";
          }
          
        xhttp.open("POST", "bug_set_fixed.php",true);
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
            //showBugComments(bugId);
          }
          
        xhttp.open("POST", "bug_comment_save.php",true);        
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "bug_id="+encodeURIComponent(bugId)+"&comment="+encodeURIComponent(comment)+"&header="+encodeURIComponent(header);                
        xhttp.send(data);
}

function showBugComments(bugId){
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.querySelector(".bug_comments_list").innerHTML = this.responseText;
          }
          
        var data = "bug_id="+encodeURIComponent(bugId);                
        xhttp.open("GET", "bug_comments.php?"+data,true);
        xhttp.send();
}