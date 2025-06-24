var task_footer = document.querySelector(".task_footer");


task_footer.addEventListener("click",function(event) {
    sessionStorage.setItem("task_id",event.target.closest(".task").getAttribute("data-task-id"));
    if (event.target.tagName === "BUTTON" && event.target.name === "remove_task") {
        // Alert or call the saveIdeaComment function
        // alert("Uložiť komentár");
        removeTask();
    } else if (event.target.tagName === "BUTTON" && event.target.name === "mark_complete") {
        // Alert or call the saveIdeaComment function
        // alert("Uložiť komentár");
        markTaskComplete();
    } else if (event.target.tagName ==="DIV" && event.target.classList.contains("task_status")) {
        // Alert or call the saveIdeaComment function
        // alert("Uložiť komentár");
        changeTaskStatus();
    } else if (event.target.tagName ==="DIV" && event.target.classList.contains("task_priority")) {
        // Alert or call the saveIdeaComment function
        // alert("Uložiť komentár");
        changeTaskPriority();
    }
})


function removeTask() {
    const task_id = sessionStorage.getItem("task_id");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Task removed.");
            document.querySelector(`.task[data-task-id="${task_id}"]`).remove();
            //window.location.href = "index.php";
        }
    };
    var data = "task_id="+encodeURIComponent(task_id);
    xhttp.open("POST", "task_remove.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function MarkTaskComplete() {
    const task_id = sessionStorage.getItem("task_id");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Task marked as complete.");
           document.querySelector(`.task[data-task-id="${task_id}"] button[name="mark_complete"]`).innerHTML = "<i class='fas fa-check'></i>";

            //window.location.href = "index.php";
        }
    };
    var data = "task_id="+encodeURIComponent(task_id);
    xhttp.open("POST", "task_mark_complete.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function changeTaskStatus() {
    const task_id = sessionStorage.getItem("task_id");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Task status changed.");
            //window.location.href = "index.php";
        }
    };
    var data = "task_id="+encodeURIComponent(task_id);
    xhttp.open("POST", "task_change_status.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function changeTaskPriority() {
    const task_id = sessionStorage.getItem("task_id");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Task priority changed.");
            //window.location.href = "index.php";
        }
    };
    var data = "task_id="+encodeURIComponent(task_id);
    xhttp.open("POST", "task_change_priority.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}