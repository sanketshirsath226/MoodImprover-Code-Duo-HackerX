<?php

if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $target_dir = "uploads/{$username}/";
  $target_file = $target_dir . $username . ".webm";
  $count = 1;
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
    <img id="image" hidden src="../uploads/<?php echo $username; ?>/<?php echo $username;
                                                                    echo $count ?>.png"></img>
  </body>
  <script src="face-api.min.js"></script>
  <script defer>
    const val=[];
    const video = document.getElementById('image')
    Promise.all([
      faceapi.nets.tinyFaceDetector.loadFromUri('./models'),
      faceapi.nets.faceLandmark68Net.loadFromUri('./models'),
      faceapi.nets.faceRecognitionNet.loadFromUri('./models'),
      faceapi.nets.faceExpressionNet.loadFromUri('./models')
    ])

    function getMaxVal(maxSpeed) {
      console.log(maxSpeed)
      let entries = Object.entries(maxSpeed);
      let sorted = entries.sort((a, b) => a[1] - b[1]);
      console.log(sorted);
      val["status"] = "success"
      val["mood"] = "happy"
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
        try {
          const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
          const resizedDetections = faceapi.resizeResults(detections, displaySize)
          canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
          faceapi.draw.drawDetections(canvas, resizedDetections)
          faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
          faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
          const expn = detections[0]["expressions"];
          while (true) {
            if(!getMaxVal(expn))
            {
              console.log(val)
              return json_encode(val);
              break;
            }
            
          }
        } catch (err) {
          <?php $count++; ?>
          video.src = src = "../uploads/<?php echo $username; ?>/<?php echo $username;
                                                                  echo $count ?>.png"
          if (<?php echo $count++; ?> <= 5) {
            if (val["status"] != "success") {
              val["status"] = "Failed"
              val["error"] = "Failed To Read Try Again"
            }
            return false;
          }
        }
      }, 1000);
    }

    detectface();
  </script>

  </html>
<?php

}
?>