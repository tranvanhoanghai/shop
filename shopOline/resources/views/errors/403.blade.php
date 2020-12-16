<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>403 | Error</title>
    <link rel="stylesheet" href="{{ asset('css\app.css') }}">
</head>
<style>
    @import url("https://fonts.googleapis.com/css?family=Fira+Code&display=swap");
* {
  margin: 0;
  padding: 0;
  font-family: "Fira Code", monospace;
}

body {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #ecf0f1;
}

.container {
  text-align: center;
  margin: auto;
  padding: 4em;
}
.container img {
  width: 256px;
  height: 225px;
}
.container h1 {
  margin-top: 1rem;
  font-size: 35px;
  text-align: center;
}
.container h1 span {
  font-size: 60px;
}
.container p {
  margin-top: 1rem;
}
.container p.info {
  margin-top: 4em;
  font-size: 12px;
}
.container p.info a {
  text-decoration: none;
  color: #5454ce;
}


</style>
<body>
    <div class="container">
        <img src="https://i.imgur.com/qIufhof.png" />
  
        <h1>
          <span>403</span> <br />
          Forbidden
        </h1>
        <p>BẠN KHÔNG CÓ QUYỀN ĐỂ TRUY CẬP TRANG NÀY</p>
        <p class="info">
          
          <button class="btn btn-primary" onclick="goBack()"    >
            BACK
          </button>
        </p>
      </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
 
</body>

</html>