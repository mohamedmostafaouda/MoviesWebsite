<?php 
    session_start();
    include 'includes/movie.php';
    $movie = new Movie();
    if (isset($_POST['edit']) && $_SESSION['type']==1){
      for ($i=0; $i<sizeof($_POST['id']); $i++){
            $movie->edit_moive(addslashes($_POST['name'][$i]),addslashes($_POST['description'][$i]),addslashes($_POST['date'][$i]),addslashes($_POST['type'][$i]),addslashes($_POST['id'][$i]));
            $movie->edit_order($_POST['id'][$i],$_POST['order'][$i]);
      }
    }
    if (isset($_POST['delete']) && $_SESSION['type']==1){
        $movie->delete_movie($_POST['ida']);
        $movie->delete_order($_POST['ida']);
        $movie->remove_likes($_POST['ida']);
    }
    $films = $movie->get_all_movies();
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
    <link rel="stylesheet" href="css/movies.css">
    <link rel="stylesheet" href="css/animate.css">
</head>
<body>
    <?php include 'header.php'?>
    <div class="inTheatreText">
    </div>
    <?php if (isset($_SESSION['type']) && ($_SESSION['type']==1)){ ?>
    <form method="POST" action="editmovies.php" class="container-fluid p-4 movies">
        <div class="row justify-content-start">
            <?php while ($row = $films->fetch_assoc()) {?>
            <div style="background-image: url('<?php echo $row['photo']; ?>');" class="order-<?php echo $movie->get_order($row['id']);?> image movie img-fluid col-12 col-lg-3">
                <div class="control">
                    <input type="number" value="<?php echo $row['id']; ?>"  style="display:none" name="id[]" class=" form-control" readonly="readonly" value="1">
                    <input type="number" value="<?php echo $movie->get_order($row['id']); ?>" required name="order[]" class="order form-control" readonly="readonly">
                    <br>
                    <input type="text" value="<?php echo $row['name']; ?>" required placeholder="Name" name="name[]" class="form-control">
                    <br>
                    <textarea type="text" required placeholder="Description" name="description[]" class="form-control"><?php echo $row['description']; ?></textarea>
                    <br>
                    <input type="date" value="<?php echo $row['date']; ?>" required placeholder="Date" name="date[]" class="form-control">
                    <br>
                    <input type="text" value="<?php echo $row['type']; ?>" required placeholder="Type" name="type[]" class="form-control">
                    <br>
                    <button type="button" class="btn btn-danger left"><</button>
                    <button type="button" class="btn btn-danger right">></button>
                    <input type="hidden" class="id" name="ida" value ="<?php echo $row['id']?>">
                    <button type="button" class="btn btn-danger deletes">Deletes</button>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="text-center mt-2">
            <button type="submit" name="edit" class="btn btn-danger">Save</button>
        </div>
    </form>
    <?php } else { echo "<div class='text-center not-allowed'><img src='images/tenor.gif'><br>You are not allowed to be here</div>"; } ?>
    <script src="javascript/jquery.js"></script>
    <script src="bootstrap4/js/bootstrap.js"></script>
    <script src="javascript/wow.js"></script>
    <script>
        new WOW().init();
        $('.nav-link').eq(0).addClass('active');
        $('.deletes').click(function(){
            var ids = $(this).parent().find('.id').val();
            $.post( "editmovies.php", { delete: '', ida: ids });
            $(this).parent().parent().remove();
            location.reload();
        })
    </script>
    <script src="javascript/movieEditor.js"></script>
    <script src="https://kit.fontawesome.com/473d9c5ae4.js" crossorigin="anonymous"></script>
</body>
</html>