var canvas = document.getElementById("myCanvas");
var ctx = canvas.getContext("2d");
var knln = document.getElementById('knlink');
var skln = document.getElementById('sklink');

knlink.onclick = function () {
    document.getElementById("knui").style.display = "block";
    document.getElementById("snake").style.display = "none";

}


sklink.onclick = function () {
    document.getElementById("knui").style.display = "none";
    document.getElementById("snake").style.display = "block";
}

