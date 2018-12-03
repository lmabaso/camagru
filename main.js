var video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
var photo = document.getElementById('photo');
var tmp;
var input = document.querySelector('input[type="file"]');

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

    input.addEventListener('change', function(e){
        const reader = new FileReader();
    
        var img1 = new Image();
        img1.onload = function() {
            ctx.drawImage(img1, 0, 0, 400, 300);
        }
        reader.onload = function() {
            img1.src = reader.result;
        }
        reader.readAsDataURL(input.files[0]);
    }, false);
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
        document.getElementById('upload').disabled = true;
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
    else if (data === "camera")
    {
        document.getElementById('camera').style = "display:block";
        document.getElementById('cam').style = "display:none";
        document.getElementById('upl').style = "display:none";
    }
    else if (data === "upload")
    {
        document.getElementById('camera').style = "display:block";
        document.getElementById('canvas').style = "display:block";
        document.getElementById('video').style = "display:none";
        document.getElementById("capture").style = "display:none";
        document.getElementById('upload').style = "display:block";
        document.getElementById('new').style = "display:none";
        document.getElementById('upload').disabled = true;
        document.getElementById('upl').style = "display:none";
        document.getElementById('cam').style = "display:none";
    }

}

function superimpose() {
    var img = document.getElementById('filter').value;
    document.getElementById('upload').disabled = false;
    document.getElementById('inner-box').setAttribute('style', 'background-image: url('+img+')')
    document.getElementById('super_img').setAttribute('value', img);
    // ctx.drawImage(document.getElementById('uploadpic').value, 0, 0, 400, 300);
    // document.getElementById('inner-box').style.backgroundImage = url(img);
}

function choosepic() 
{
    alert("lol");
}