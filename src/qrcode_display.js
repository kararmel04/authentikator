document.addEventListener("DOMContentLoaded", function(){

    const form = document.querySelector("form");
    const img = document.getElementById("qr"); // et on le met dans le tag img

    form.addEventListener

    form.onsubmit = function (e) {
        e.preventDefault();
        const infos = new FormData(form);
        const parameters = Object.fromEntries(infos)
        console.log(parameters);
        fetch("generate_otp.php", {
            method: "POST",
            body: JSON.stringify(parameters),
            headers:{
                'Content-Type':'application/json'
            }
        }) // on récupère le qrcode brut depuis le backend
        .then(r => r.json())
        .then(data => {
            img.src = data.qrcode;
            console.log(data)
        })
        .catch(error=>console.error(error));
        setTimeout(() => {
            img.src = null;
        }, 5000);
    }
})
