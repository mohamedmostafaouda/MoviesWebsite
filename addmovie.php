<?php
    session_start();
    include 'includes/movie.php';
    $correct = FALSE;
    if (isset($_POST['add'])){
        $movie = new Movie();
        $name = addslashes(htmlentities($_POST['name']));
        $type = addslashes(htmlentities($_POST['type']));
        $description = addslashes(htmlentities($_POST['description']));
        $photo = addslashes(htmlentities($_POST['img']));
        $date = addslashes(htmlentities($_POST['date']));
        $correct = $movie->save_movie($name,$description,$date,$type,$photo);   
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movies</title>
    <link rel="stylesheet" href="bootstrap4/css/bootstrap.css">
    <link rel="stylesheet" href="css/head.css">
    <link rel="stylesheet" href="css/addmovie.css">
    <link rel="stylesheet" href="css/animate.css">
    <style>
    .not-allowed{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        color: white;
        font-size: 50px;
    }
    </style>
</head>
<body>
    <?php include 'header.php';?>
    <?php if ($_SESSION['type']!=1){ echo "<div class='text-center not-allowed'><img src='images/tenor.gif'><br>You are not allowed to be here</div>"; die(); } ?>

    <form action="addmovie.php" method="POST" onsubmit="return validate()" class="container signContainer wow fadeIn">
        <div class="alert alert-danger" id="wrongMessage">
            <strong>Something Wrong occured</strong> 
        </div>
        <?php
            if ($correct){
                echo  '<div class="alert alert-success" id="MR">
                <strong>Movie added successfully</strong> 
                </div>';
            }
        ?>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <label id='namel' for="name">Name</label>
                <br>
                <input type="text" name="name" class="inputStyle" id="name">
            </div>
            <div class="col-12 col-lg-6">
                <label id='typel' for="type">Type</label>
                <br>
                <input type="text" name="type" class="inputStyle" id="type">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <label id='datel' for="date">Date</label>
                <br>
                <input type="date" name="date" class="inputStyle" id="date">
            </div>
            <div class="col-12 col-lg-6">
                <label id='descriptionl' for="description">Description</label>
                <br>
                <textarea name="description" id="description" class="inputStyle"></textarea>
            </div>
            <div class="col-12 col-lg-6">
                <label id='imgl' for="img">Image</label>
                <br>
                <input type="file" id="img" class="inputStyle" accept="image/x-png,image/gif,image/jpeg"/>
            </div>
            <div class="col-12 col-lg-6" style="overflow:hidden;">
                <img src="" class="img-fluid" id="imgpreview">
            </div>
        </div>
        <input type="text" style="display:none" name="img"  id="imghidden">
        <div class="text-right">
            <input type="submit" value="submit" name="add" class="btn btn-danger mt-3" />
        </div>
    </form>
    <script src="javascript/jquery.js"></script>
    <script src="bootstrap4/js/bootstrap.js"></script>
    <script src="javascript/wow.js"></script>
    <script>
        new WOW().init();
        $('.nav-link').eq(0).addClass('active');
        $('#img').on('change',function () {
            var x = document.getElementById('img');
            var output = document.getElementById('imgpreview');
            output.src = URL.createObjectURL(event.target.files[0]);
            $('#imghidden').val('images/'+x.files[0].name);
        });
        function validate(){
            var name = document.getElementById('name');
            var date = document.getElementById('date');
            var type = document.getElementById('type');
            var description = document.getElementById('description');
            var img = document.getElementById('imghidden');
            var msgw = document.getElementById('wrongMessage');
            var dis = false;
            if (name.value==''){document.getElementById('namel').classList.add('wrong'); dis=true;}
            else {document.getElementById('namel').classList.remove('wrong');}
            if (date.value==''){document.getElementById('datel').classList.add('wrong'); dis=true;}
            else {document.getElementById('datel').classList.remove('wrong');}
            if (type.value==''){document.getElementById('typel').classList.add('wrong'); dis=true;}
            else {document.getElementById('typel').classList.remove('wrong');}
            if (description.value==''){document.getElementById('descriptionl').classList.add('wrong'); dis=true;}
            else {document.getElementById('descriptionl').classList.remove('wrong');}
            if (img.value==''){document.getElementById('imgl').classList.add('wrong'); dis=true;}
            else {document.getElementById('imgl').classList.remove('wrong');}
            if (dis){msgw.style.display = "block"; $('#MR').css('display','none'); return false;}
            else {msgw.style.display = "none"; return true;}
        }
    </script>
    <script src="javascript/movieEditor.js"></script>
    <script src="https://kit.fontawesome.com/473d9c5ae4.js" crossorigin="anonymous"></script>
</body>
</html>