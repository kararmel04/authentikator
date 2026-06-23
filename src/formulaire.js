//fetch(`server.php`).then(response => response.text()).then(console.log);    
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(e){
        const data = new FormData(form);
        console.log("data");
        fetch("server.php", {
            method: "POST",
            body: data
        }).then(response => response.text()).then(console.log);
    });
});