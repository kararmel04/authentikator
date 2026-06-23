document.addEventListener("DOMContentLoaded", function(){

    const form = document.querySelector("form");
    const img = document.getElementById("qr"); // et on le met dans le tag img
    let data;

    form.addEventListener("submit", function(e){
        data = new FormData(form);
    });

    img.onclick = function() {
        fetch("generate_otp.php") // on récupère le qrcode brut depuis le backend
        .then(r => r.json())
        .then(data => {
            img.src = data.qrcode;
            console.log(data.qrcode)
        });
        setTimeout(() => {
            img.src = null;
        }, 5000);
    }
})
