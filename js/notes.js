var new_note = document.querySelector('.new_note');
var notes = document.querySelector('.notes');
const modal_change_app = document.querySelector('.modal_change_app');
const modal_change_app_list_item = document.querySelector('.modal_change_app ul li'); 

new_note.addEventListener('click', function(event) {
    if (event.target.tagName === 'BUTTON') {
        var note_title = document.querySelector('.new_note input[name="note_title"]').value;
        var note_text = document.querySelector('.new_note textarea[name="note_text"]').value;
        if (note_text=="") {
            alert("Please fill this field.");
            return
        } else{
            addNewNote(note_title, note_text);
        }
     }
});


notes.addEventListener('click', function(event) {
    if (event.target.tagName === 'BUTTON') {
        //get note id
        var note_id = event.target.closest('.note').getAttribute('note-id');
        //save note id in session storage
        sessionStorage.setItem('note_id', note_id);

        if(event.target.name === 'delete_note'){
            deleteNote(note_id);    
        } else if (event.target.name === 'note_application') {
            modal_change_app.showModal();
     }
   }
});

//click on list items
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
        const noteId = sessionStorage.getItem('note_id');
        console.log("app name: "+appName+" note id: "+noteId);
        //console.log("app id: "+app_id);
        changeApplication(appName, noteId);
        }
    }
}); 


function addNewNote(note_title, note_text) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.querySelector('.new_note input[name="note_title"]').value="";
        document.querySelector('.new_note textarea[name="note_text"]').value="";
        reloadNotes();
      }
    };
    xhttp.open("POST", "notes_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "note_title="+note_title+"&note_text="+note_text;
    xhttp.send(params);
}


function reloadNotes() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'notes_reload.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // Po dokončení requestu
            if (xhr.status === 200) {
                document.querySelector('.notes').innerHTML = xhr.responseText;
            } else {
                console.error('Error loading notes:', xhr.status, xhr.responseText);
            }
        }
    };
    xhr.send();
}

function deleteNote(note_id){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'notes_remove.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {    
        if (xhr.readyState === 4) { // Po dokončání requestu
            if (xhr.status === 200) {
                console.log('Note deleted successfully:', xhr.responseText);
                reloadNotes();
            } else {
                console.error('Error deleting note:', xhr.status, xhr.responseText);
            }
        }
    };

    xhr.send('note_id=' + note_id);
}

function reloadNotes(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'notes_reload.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // Po dokončání requestu
            if (xhr.status === 200) {
                document.querySelector('.notes').innerHTML = xhr.responseText;
            } else {
                console.error('Error loading notes:', xhr.status, xhr.responseText);
            }
        }
    };
    xhr.send();
}

function changeApplication(appName, noteId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        //document.getElementById("diary_content").innerHTML = this.responseText;
        //var app_name =  sessionStorage.getItem('app_name');
        modal_change_app.close();
        document.querySelector('.note[note-id="'+noteId+'"] .button[name="note_application"]').innerText = appName;
      }
    };
    xhttp.open("POST", "notes_change_app.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "app_name="+appName+"&note_id="+noteId;
    xhttp.send(params);
 }