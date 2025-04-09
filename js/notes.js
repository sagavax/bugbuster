var new_note = document.querySelector('.new_note');
var notes = document.querySelector('.notes');


new_note.addEventListener('click', function(event) {
    if (event.target.tagName === 'BUTTON') {
        var note_title = document.querySelector('.new_note input[name="note_title"]').value;
        var note_text = document.querySelector('.new_note textarea[name="note_text"]').value;
        addNewNote(note_title, note_text);
    }
});


notes.addEventListener('click', function(event) {
    if (event.target.tagName === 'BUTTON') {
        var note_id = event.target.closest('.note').getAttribute('note-id');
        deleteNote(note_id);
    }
});



function addNewNote(note_title, note_text) {
    var note_data = {
        note_title: note_title,
        note_text: note_text
    };

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'notes_create.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // Po dokončení requestu
            if (xhr.status === 200) {
                console.log('Note added successfully:', xhr.responseText);
                reloadNotes()
            } else {
                console.error('Error adding note:', xhr.status, xhr.responseText);
            }
        }
    };

    xhr.send(JSON.stringify(note_data));
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