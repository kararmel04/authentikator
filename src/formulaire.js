console.log("abba");

fetch(`server.php`).then(response => response.text()).then(console.log);    