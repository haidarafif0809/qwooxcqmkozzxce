<!DOCTYPE html>
<html>
<head>
	<title>Membuat Efek Hover Zoom Dengan CSS3 | www.malasngoding.com</title>
	<link rel="stylesheet" type="text/css" href="style.css">

<style type="text/css">
	body {
  color: #232323;
  font-family: roboto;
  background-color: #85D1D8;
}

h1{
  text-align: center;
}

p{
  text-align: center;
}

a{
  color: #232323;
  text-decoration: none;
  font-weight: 500;
}

a:hover{
  text-decoration: underline;
}

.wrapper {
  width: 700px;
  margin: 0 auto;
}

.zoom-effect {  
  position: relative;
  width: 100%;
  height: 360px;
  margin: 0 auto;
  overflow: hidden;  
}

.kotak {
  position: absolute;
  top: 0;
  left: 0;
  
}

.kotak img {
  -webkit-transition: 0.4s ease;
  transition: 0.4s ease;
  width: 700px;
}

.zoom-effect:hover .kotak img {
  -webkit-transform: scale(2.08);
  transform: scale(2.08);
}
</style>

</head>
<body>
	<h1>Membuat Efek Zoom Dengan CSS3 | www.malasngoding.com</h1>

	<p>
		<a href="https://www.malasngoding.com/zoom-effect-image-css/">Tutorial Efek Hover Zoom CSS3</a>
	</p>
	
	<div class="wrapper">
		<div class="zoom-effect">
			<div class="kotak">
				<img src="http://www.malasngoding.com/wp-content/uploads/2016/02/gambar.jpg"/>
			</div>
		</div>		
	</div>
	
</body>
</html>