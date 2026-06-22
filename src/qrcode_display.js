document.addEventListener("DOMContentLoaded", function(){
    fetch("generate_otp.php") // on récupère le qrcode brut depuis le backend
        .then(r => r.json())
        .then(data => {
            const img = document.getElementById("qr"); // et on le met dans le tag img
            img.src = data.qrcode;
        });
})
