var new_note = document.querySelector('.new_note');
var notes = document.querySelector('.notes');
const modal_change_app = document.querySelector('.modal_change_app');
const modal_change_app_list_item = document.querySelector('.modal_change_app ul li'); 
const modal_tag_note = document.querySelector('.modal_tag_note');


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


modal_tag_note.addEventListener("click", function(event) {
    if (event.target.tagName==="BUTTON") {
        if(event.target.name === "show_create_tag"){
            //const note_id = sessionStorage.getItem('note_id');
            const tag_name = document.querySelector('.modal_tag_note input[name="tag_name"]');
            tag_name.style.display = "flex";
            event.target.name = "create_tag";
        } else if (event.target.name === "create_tag") {
            const tag_name_input = document.querySelector('.modal_tag_note input[name="tag_name"]');
            const tag_name = tag_name_input.value.trim();
            if (tag_name=="") {
                alert("Please fill this field.");
            } else{
                createTag(tag_name);
                tag_name_input.value = "";
        }       
            
            //addNoteTag(note_id, tag_name);

        }  else if(event.target.hasAttribute("tag-id")){
            const note_id = sessionStorage.getItem('note_id');
            const tag_id = event.target.getAttribute("tag-id");
            //check if tag is already added to note
            checkNoteTag(note_id, tag_id, function(exists){
                if(exists){
                    //alert("Tag is already added to note.");
                    document.querySelector(".notification").style.display = "flex";
                    document.querySelector(".notification").style.backgroundColor = "#af574c";
                    document.querySelector(".notification").innerText = "Tag is already added to note.";
                    setTimeout(function() {
                        document.querySelector(".notification").style.display = "none";
                    }, 3000);
                } else {
                    //addNoteTag(note_id, tag_id);
                    const parentNoteTagWrapper = document.querySelector('.note[note-id="'+note_id+'"] .note_tags');
                    parentNoteTagWrapper.insertAdjacentHTML('beforeend', '<button class="button small_button" name="note_tag"><i class="fa fa-tag"></i> '+event.target.innerText+'</button>');
                    addNoteTag(note_id, tag_id,event.target.innerText);
                    //parentNoteTagWrapper.insertAdjacentHTML('beforeend', event.target);
                     document.querySelector(".notification").style.display = "flex";
                        document.querySelector(".notification").style.backgroundColor = "#4CAF50";
                        document.querySelector(".notification").innerText = "Tag "+event.target.innerText+" added successfully.";
                        setTimeout(function() {
                            document.querySelector(".notification").style.display = "none";
                        }, 3000);
                    event.target.remove();
                }
            });
            
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
        } else if (event.target.name === 'note_tag') {
            modal_tag_note.showModal();
          /*   if(modal_tag_note){
                document.querySelector('.modal_tag_note input[name="tag_name"]').value="";
            } */
            getTags();            
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


 function getTags(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseText.trim() === "null" || this.responseText.trim() === "[]"){
            document.querySelector(".tag_note_list").innerHTML = "<p>No tags found. Please create a new tag.</p>";
            return;
        }
        const data = JSON.parse(this.responseText);

        const html = data.map(tag => `<button class="button small_button" tag-id="${tag.tag_id}" type="button">${tag.tag_name}</button>`).join("").concat(`<input type="text" name="tag_name" placeholder="New tag name"><button class="button small_button" name="show_create_tag"><i class="fa fa-plus"></i></button>`);
        //console.log(this.responseText);
        document.querySelector(".tag_note_list").innerHTML = html;        
      }
    };
    xhttp.open("GET", "notes_tags.php", true);
    xhttp.send();
 }


function getLatestTagId(callback) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        callback(this.responseText);
      }
    };
    xhttp.open("GET", "notes_get_latest_tag_id.php", true);
    xhttp.send();
  }

function createTag(tag_name) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.querySelector('.modal_tag_note input[name="tag_name"]').value="";
        //add new tag to list of tags in modal
        getLatestTagId(function(latestTagId){
            const newTagHtml = `<button class="button small_button" tag-id="${latestTagId}" type="button">${tag_name}</button>`;
            document.querySelector(".tag_note_list").insertAdjacentHTML('afterbegin', newTagHtml);
        });
        //document.querySelector('.modal_tag_note').close();
        //getNoteTags(noteId);      
      }
    };
    xhttp.open("POST", "notes_create_tag.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "tag_name="+tag_name;
    xhttp.send(params);
}


function getNoteTags(noteId){
    var xhttp = new XMLHttpRequest();    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            data = JSON.parse(this.responseText);
             const html = data.map(tag => `<button class="button small_button" tag-id="${tag.tag_id}" type="button">${tag.tag_name}</button>`).join("").concat(`<input type="text" name="tag_name" placeholder="New tag name"><button class="button small_button" name="show_create_tag"><i class="fa fa-plus"></i></button>`);
            document.querySelector(".tag_note_list").innerHTML = html;
        }
    };
    xhttp.open("GET", "note_tags.php?note_id="+noteId, true);
    xhttp.send();
    }

    function addNoteTag(noteId, tagId,tagName) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
        
           };
       }
        xhttp.open("POST", "notes_tags_add.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var params = "note_id="+noteId+"&tag_id="+tagId+"&tag_name="+tagName;
        xhttp.send(params);
    }


    function checkNoteTag(noteId, tagId, callback){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            const exists = this.responseText === "true";
            callback(exists);
          }
        };
        xhttp.open("POST", "notes_tags_check.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var params = "note_id="+noteId+"&tag_id="+tagId;
        xhttp.send(params);
    }