var x;
var y;

var c = document.getElementById("gameSreen");
var ctx = c.getContext("2d");

ctx.strokeStyle="white";
ctx.lineWidth = 0.01;
var myWidth = 1350;
var myHeight = 900;
var mySizeW = myWidth / 150;
var mySizeH = myHeight / 100;

for (var i = 0; i < myWidth; i+= mySizeW) {
  ctx.moveTo(i,0);
  ctx.lineTo(i, myHeight);
  ctx.stroke();
}

for (var j = 0; j < myHeight; j+= mySizeH) {
  ctx.moveTo(0, j);
  ctx.lineTo(myWidth, j);
  ctx.stroke();
}
x = mySizeW;
y = mySizeH;

ctx.fillStyle = "white";
ctx.fillRect(x, y,10,10);

function myFunction() {
    alert("Hello! I am an alert box!");
}
