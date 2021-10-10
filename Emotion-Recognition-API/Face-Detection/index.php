<?php

if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $target_dir = "uploads/{$username}/";
  $target_file = $target_dir . $username . ".webm";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
      body {
        margin: 0;
        padding: 0;
        width: 100vw;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      canvas {
        position: absolute;
      }
    </style>
  </head>

  <body>
    <img id="image" src="../uploads/<?php echo $username; ?>/<?php echo $username ?>1.png"></img>
  </body>
  <script src="face-api.min.js"></script>
  <script defer>
    const video = document.getElementById('image')
    Promise.all([
      faceapi.nets.tinyFaceDetector.loadFromUri('./models'),
      faceapi.nets.faceLandmark68Net.loadFromUri('./models'),
      faceapi.nets.faceRecognitionNet.loadFromUri('./models'),
      faceapi.nets.faceExpressionNet.loadFromUri('./models')
    ])

    function getMaxVal(maxSpeed) {
      console.log(maxSpeed)
      let obj = {"you": 100, "me": 75, "foo": 116, "bar": 15};

      if(maxSpeed["happy"]>maxSpeed["sad"])
      {
        console.log(maxSpeed["happy"])
      }
      
      let entries = Object.entries(obj);

      let sorted = entries.sort((a, b) => a[1] - b[1]);

      return false;
    }

    function detectface() {
      const canvas = faceapi.createCanvasFromMedia(video)
      const displaySize = {
        width: video.width,
        height: video.height
      }
      faceapi.matchDimensions(canvas, displaySize)
      setTimeout(async () => {
        const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
        const resizedDetections = faceapi.resizeResults(detections, displaySize)
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
        faceapi.draw.drawDetections(canvas, resizedDetections)
        faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
        faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
        const expn = detections[0]["expressions"];
        while (true) {
          getMaxVal(expn);
          return false;
        }
        console.log(expn)
      }, 1000);
    }

    detectface();
  </script>

  </html>
<?php } ?>