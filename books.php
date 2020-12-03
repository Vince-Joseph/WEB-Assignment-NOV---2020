<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Search</title>
     <!-- Latest compiled and minified CSS -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
</head>
<body>
<?php
   
    
   
?>
   <div class="container mt-5 p-5 shadow">
        <form action="#" method="get">
            <div class="row">
                <div class="col-md">
                    <div class="form-group">
                
                        <label for="category">Category:</label>
                        <input type="text" class="form-control form-control-lg" name="category" 
                        id="category" placeholder="Enter a category" 
                        value="<?php echo isset($_GET['category']) ? $_GET['category'] : '' ?>"required>
           
                    </div>
                </div>
                <div class="col-md">
                     <div class="form-group">
                
                            <label for="maxprice">Maximum Price:</label>
                            <input type="text" class="form-control form-control-lg" name="maxprice" 
                            id="maxprice" placeholder="Enter the maximum price" 
                            value="<?php echo isset($_GET['maxprice']) ? $_GET['maxprice'] : '' ?>"required>
           
                    </div>
                </div>
               
            </div>
            <div class="row">
                <div class="col-md-12">
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input"
                                 name="prime">Prime Member?
                            </label>
                         </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                     <div class="form-group">
                
                            <input type="Submit" class="form-control form-control-lg bg-primary text-white" name="submit" id="submit" value="View Books">
            
                     </div>
                </div>
            </div>
        </form>
        <?php
         if(isset($_GET['category'])&&isset($_GET['maxprice']))
         {     $category_of_book=strtolower($_GET['category']);
              $maximum_price=($_GET['maxprice']);
              $file_to_check=$category_of_book.".txt";
          
        if(!file_exists($file_to_check))
        echo"<p class='text-danger'>Sorry No such category !</p>";
    else
    {
        try {
                $file = fopen($category_of_book.".txt", "r");
                if (! $file) {
                    throw new Exception("Could not open the file!");
                }
                else{
                  //  echo "opended successfuly."; 
                    $theData = fread($file, filesize($file_to_check));
                    $associative_array = array();
                    $my_array = explode("\n", $theData);
                    foreach($my_array as $line)
                    {
                        $tmp = explode(":", $line);
                        $associative_array[$tmp[0]] = $tmp[1];
                    }
                    
                }
            }
            catch (Exception $e) {
                echo "Error (File: ".$e->getFile().", line ".
                      $e->getLine()."): ".$e->getMessage();
            }
            $counter=0;
            echo "<ul>";
            foreach($associative_array as $associative_key => $associative_value) {
                
               if(isset($_GET['prime']))
                    $associative_value=((int)$associative_value-(int)$associative_value*0.20);
                if((int)$associative_value<(int)$maximum_price)
                {
                    $counter++;
                    echo "<li class='pt-3'>$associative_key, \$$associative_value</li>";
                }
            }
            echo "</ul>";

            if($counter===0)
                echo "<p class='text-danger'>No books under the given price range !</p>";
            fclose($file);
        }
    }
        ?>
    </div>
</body>
</html>
