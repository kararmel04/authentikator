document.addEventListener("DOMContentLoaded", function(){

    const form = document.querySelector("form");

    form.onsubmit = function (e) {
        e.preventDefault();
        const infos = new FormData(form);
        const parameters = Object.fromEntries(infos)
        
        fetch("verify_otp.php", {
            method: "POST",
            body: JSON.stringify(parameters),
            headers:{
                'Content-Type':'application/json'
            }
        }) // on récupère le qrcode brut depuis le backend
        .then(r => r.json())
        .then(data => {
            console.log(data);
        })
        .catch(error=>console.error(error));
    }
})