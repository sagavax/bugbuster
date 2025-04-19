const openModal = document.querySelectorAll("[data-open]");
const closeModal = document.querySelectorAll("[data-close]");
const isVisible = "is-visible";
var diary_content = document.getElementById("diary_content");
const modal_change_app = document.querySelector('.modal_change_app');
const modal_change_app_list_item = document.querySelectorAll('.modal_change_app ul li'); 
const diary_button_filter = document.querySelector(".diary_button_filter");



diary_button_filter.addEventListener("click",function(event) {
    if(event.target.tagName==="BUTTON"){
       const recordId = event.target.getAttribute('data-app-id');
       filterDiaryByButton(recordId);
    }
});

diary_content.addEventListener("click", function(event) {
    if (event.target.classList.contains("app_name")) {
        console.log("clicked");
        //get old app name
        const old_app_name = event.target.innerText;
        sessionStorage.setItem('old_app_name', old_app_name);
        //get ID of clicked record
        const record_id = event.target.closest(".diary_record").getAttribute('data-id');
        //set it in session storage for later use
        sessionStorage.setItem('diary_id', record_id);
        //show modal
        modal_change_app.showModal();
    } else if (event.target.classList.contains("diary_text")) {
        //document.querySelector('.diary_record[data-id="'+record_id+'"] .diary_text').setAttribute('contenteditable', 'true');
        event.target.setAttribute('contenteditable', 'true');

        event.target.addEventListener("blur", function() {
            const record_id = event.target.closest(".diary_record").getAttribute('data-id');
            // get the new value after editing
            const updatedText = event.target.innerText;
           
            // save or send the updated text to the server or sessionStorage
            changeDiaryText(record_id, updatedText)
            
            // Optionally, you can disable contenteditable when the user finishes editing
            event.target.setAttribute('contenteditable', 'false');
        });
    } else if (event.target.tagName==="BUTTON" && event.target.name==="delete_record") {
        const record_id = event.target.closest(".diary_record").getAttribute('data-id');
        console.log(record_id);
        deleteDiaryRecord(record_id);
    }
})

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
        const app_id = event.target.getAttribute('data-app-id');
        const record_id = sessionStorage.getItem('diary_id');
        sessionStorage.setItem('app_name', event.target.innerText);
        //console.log("app id: "+app_id);
        changeApplication(app_id, record_id);
        }
    }
});       

for (const el of openModal) {
el.addEventListener("click", function () {
    const modalId = this.dataset.open;
    document.getElementById(modalId).classList.add(isVisible);
});
}

for (const el of closeModal) {
el.addEventListener("click", function () {
    this.parentElement.parentElement.parentElement.classList.remove(isVisible);
});
}

document.addEventListener("click", (e) => {
if (e.target == document.querySelector(".modal.is-visible")) {
    document.querySelector(".modal.is-visible [data-close]").click();
}
});

// Close if we press the ESC
document.addEventListener("keyup", (e) => {
if (e.key == "Escape" && document.querySelector(".modal.is-visible")) {
    document.querySelector(".modal.is-visible [data-close]").click();
}
});


function list_records(id){
                       
    console.log(id);
     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
        document.getElementById("diary_content").innerHTML = this.responseText;
       }
     };
     xhttp.open("GET", "diary_filter_by_application.php?application_id="+id, true);
     xhttp.send();
  } 


function changeApplication(app_id, record_id){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        //document.getElementById("diary_content").innerHTML = this.responseText;
        var app_name =  sessionStorage.getItem('app_name');
        modal_change_app.close();
        document.querySelector('.diary_record[data-id="'+record_id+'"] .app_name').innerText = app_name;
      }
    };
    xhttp.open("POST", "diary_change_app.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "project_id="+app_id+"&record_id="+record_id;
    xhttp.send(params);
 }


 function changeDiaryText(record_id, new_text) {
    //console.log(record_id + " " + new_text);
    
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) { // Skontroluj, či sa požiadavka dokončila
            if (this.status == 200) {
                // Úspešné spracovanie
                document.querySelector('.diary_record[data-id="'+record_id+'"] .diary_text').removeAttribute('contenteditable');
                console.log("Text successfully updated.");
            } else {
                // Chyba, ak status nie je 200
                console.error("Error with status code: " + this.status);
            }
        }
    };
    
    // Otvor požiadavku (asynchrónne)
    xhttp.open("POST", "diary_change_text.php", true);
    
    // Nastav hlavičky
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    // Priprav parametre
    var params = "record_id=" + record_id + "&new_text=" + encodeURIComponent(new_text);
    
    // Pošli požiadavku
    xhttp.send(params);
}

function deleteDiaryRecord(record_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) { // Skontroluj, či sa požiadavka dokončila
            if (this.status == 200) {
                // Úspešné spracovanie
                document.querySelector('.diary_record[data-id="'+record_id+'"]').remove();
                console.log("Record successfully deleted.");
                alert("Record successfully deleted.");
                //reloadDiary();
            } else {
                // Chyba, ak status nie je 200
                console.error("Error with status code: " + this.status);
            }
        }
    };
    // Otvor požiadavku (asynchrónne)
    xhttp.open("POST", "diary_record_delete.php", true);
    // Nastav hlavičky
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Priprav parametre
    var params = "record_id=" + record_id;
    // Pošli požiadavku
    xhttp.send(params);    
}


function reloadDiary() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("diary_content").innerHTML = this.responseText;
            alert("Diary successfully reloaded.");
        }
    };
    xhttp.open("GET", "diary_records.php", true);
    xhttp.send();
}   
function filterDiaryByButton(record_id){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("diary_content").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "diary_filter_by_application.php?application_id="+record_id, true);
    xhttp.send();
}