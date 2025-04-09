var small_dashboard = document.querySelector(".small_dashboard");


small_dashboard.addEventListener("click", function(ev) {
    if(ev.target.tagName==="DIV" && ev.target.className("dash-item")){
        var targetId = ev.target.getAttribute("dash-item");
        
    }
}