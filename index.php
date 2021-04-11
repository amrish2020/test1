<?php
include('Testclass.php');

$tcls = new Testclass();

if(isset($_POST['submitupload']))
{
    $fndata = $tcls->Uploadfiles($_FILES['file']);
    exit;
}

if(isset($_POST['searchfile']))
{
    $srchtree = $tcls->searchTree($_POST['search']);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Test1</title>
        <!-- Bootstrap core CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    
    <main role="main" class="container">
        <div class="starter-template">
            <h1>Test1</h1>
            <div class="row">
                <div class="col-md-12">
                    <p>Upload file here</p>
                    <form name="uploadfile" action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-12 mb-3">
                            <input type="file" name="file" class="form-control" required="">
                            <button class="btn btn-primary float-left" name="submitupload" type="submit">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr/>   
            <div class="row">
                <div class="col-md-12">
                    <p>Search file here</p>
                </div>
                <div class="col-md-12">
                    <form name="searchfile" method="POST" action="">
                        <div class="col-md-12 mb-3">
                            <input type="text" class="form-control" placeholder="Search here.." name="search" value="" required="">
                            <button class="btn btn-primary float-left" name="searchfile" type="submit">Search</button>
                        </div>
                    </form>
                    <br/><br/>
                    <div class="col-md-12">
                        <p><b>Recursive Search Result here</b></p>
                    </div>
                    <div class="col-md-12">
                        <?php
                            if(isset($srchtree)){
                                if ($srchtree->num_rows > 0) {
                                        // output data of each row
                                        while($row = $srchtree->fetch_assoc()) {
                                            echo $row["path"]."<br>";
                                        }
                                } else {
                                    echo "0 results";
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- /.container -->
</html>

