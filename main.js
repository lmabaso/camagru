var video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
var photo = document.getElementById('photo');
var tmp;

(function()
{
    navigator.getMedia =    navigator.getUserMedia ||
                            navigator.webkitGetUserMedia ||
                            navigator.mozGetUserMedia ||
                            navigator.mediaDevices.getUserMedia||
                            navigator.msGetUserMedia;
    navigator.getMedia({
        video: true,
        audio: false
    }, function(stream) {
        video.srcObject = stream;
        video.play();
    }, function (error) {

    });
}) ();

function capture(data)
{
    if (data === "capture")
    {
        ctx.drawImage(video, 0, 0, 400, 300);
        document.getElementById('canvas').style = "display:block";
        document.getElementById('video').style = "display:none";
        document.getElementById("capture").style = "display:none";
        document.getElementById('upload').style = "display:block";
        document.getElementById('new').style = "display:block";
    }
    else if (data === "new")
    {
        document.getElementById('canvas').style = "display:none";
        document.getElementById('video').style = "display:block";
        document.getElementById("capture").style = "display:block";
        document.getElementById("new").style = "display:none";
        document.getElementById("upload").style = "display:none";
        document.getElementById('photoform').disabled = true;
    }
    else if (data === "save")
    {
        photo.setAttribute('value', canvas.toDataURL('Image/png'));
        document.getElementById('photoform').disabled = false;
    }  
}

function superimpose() {
    var img = document.getElementById('filter').value;
    document.getElementById('inner-box').setAttribute('style', 'background-image: url('+img+')')
    document.getElementById('super_img').setAttribute('value', img);
    // document.getElementById('inner-box').style.backgroundImage = url(img);
}