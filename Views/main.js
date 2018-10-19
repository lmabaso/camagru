var video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
var vendorUrl = window.URL || window.webkitURL;

(function() {
    navigator.getMedia =    navigator.getUserMedia ||
                            navigator.webkitGetUserMedia ||
                            navigator.mozGetUserMedia ||
                            navigator.mediaDevices.getUserMedia;
    navigator.getMedia({
        video: true,
        audio: false
    }, function(stream) {
        video.src = vendorUrl.createObjectURL(stream);
        video.play();
    }, function (error) {

    });
})();

function capture() {
    ctx.drawImage(video, 0, 0, 400, 300);
    document.getElementById('canvas').style = "display:block";
    document.getElementById('video').style = "display:none";
    document.getElementById("capture").style = "display:none";
    document.getElementById('upload').style = "display:block";
    document.getElementById('new').style = "display:block";
}

function newcap() {
    document.getElementById('canvas').style = "display:none";
    document.getElementById('video').style = "display:block";
    document.getElementById("capture").style = "display:block";
    document.getElementById("new").style = "display:none";
    document.getElementById("upload").style = "display:none";
}

function save() {
    var new_img = new Image();
    var dataURL = canvas.toDataURL('image/png');
    button.href = dataURL;
}