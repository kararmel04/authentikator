document.addEventListener("DOMContentLoaded", function(){

    const form = document.querySelector("form");
    const img = document.getElementById("qr"); // et on le met dans le tag img
    let modal = document.getElementById("myModal");
    let modalImage = document.getElementById("imgmodal");

    form.onsubmit = function (e) {
        e.preventDefault();
        const infos = new FormData(form);
        const parameters = Object.fromEntries(infos)

        fetch("generate_otp.php", {
            method: "POST",
            body: JSON.stringify(parameters),
            headers:{
                'Content-Type':'application/json'
            }
        }) // on récupère le qrcode brut depuis le backend
        .then(r => r.json())
        .then(data => {
            console.log(data);
            img.alt = "voir le QR code";
            img.onclick = function() {
                modal.style.display = "block";
                modalImage.src = data.qrcode;
                document.getElementsByClassName("close")[0].onclick = function() {
                modal.style.display = "none";
                }
                img.alt = " ";
                setTimeout(function() {
                    modal.style.display = "none";
                },15000);
            }
        })
        .catch(error=>console.error(error));
    }
})