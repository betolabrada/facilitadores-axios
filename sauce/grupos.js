function getData() {
    const http = new XMLHttpRequest();
    var received;
    http.open("GET","sauce/grupos.php");
    http.send();

    http.onreadystatechange=(e)=>{
        received = http.responseText;
        /*console.log("This is what we got:");
        console.log(received);*/
        setTimeout(() => {  return received; }, 200);
    }
}

var json = getData();
console.log(json);



