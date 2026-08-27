<?php
    session_start();

    //checking user auth.
    if(!isset($_SESSION["name"])){
        //Redirect to the Login Page (index.php)
        header("location:index.php");
        exit();
    }


    //Import DB Connection file
    require_once("dbConnection.php");
   
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/app.css">
    <script src="js/popper.min.js" ></script>
    <script src="js/bootstrap.min.js" ></script>
</head>
<body class="app-body">

<div class="app-shell bg-body-tertiary min-vh-100 d-flex flex-column">
    <nav class="navbar navbar-expand-lg app-navbar border-bottom">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="dashboard.php">Dashboard</a>
            <div class="d-flex align-items-center gap-2 ms-auto">
                <span class="badge text-bg-light border">
                    <!-- <?php echo $_SESSION["name"]." (".$_SESSION["role"].")"; ?> -->
                </span>
                <a class="btn btn-outline-danger btn-sm" href="logout.php">Log out</a>
            </div>
        </div>
    </nav>

    <main class="app-main flex-grow-1 py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-lg-5">
                    <div class="card app-card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h2 class="h5 app-section-title mb-3">Find subject</h2>
                            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="row g-2 align-items-end">
                                <div class="col-12">
                                    <label class="form-label" for="find">Course Code</label>
                                    <input class="form-control" type="text" name="find" id="find" placeholder="e.g. HNDIT1012">
                                </div>
                                <div class="col-12 d-grid">
                                    <input class="btn btn-success" type="submit" name="btnFind" value="Find">
                                </div>
                            </form>

<?php

 $fcode = "";
 $fname = "";
 $fcredits = "";
 $fcourse = "";

if(isset($_POST["btnFind"])){

    $query = "SELECT * FROM subjects where code='".$_POST["find"]."'";
    $result = mysqli_query($con,$query);

    //Count no of Rows
    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        $fcode = $row["code"];
        $fname = $row["name"];
        $fcredits = $row["credits"];
        $fcourse =  $row["course"];

    }
    else{
         echo '<div class="alert alert-warning mt-3 mb-0" role="alert">There is no subject named '.$_POST["find"].'</div>';
    }

}
?>

                            <hr class="my-4">
                            <h2 class="h5 app-section-title mb-3">Subject details</h2>
                            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="vstack gap-3">
                                <div>
                                    <label class="form-label" for="code">Course Code</label>
                                    <input class="form-control" type="text" name="code" id="code" value="<?php echo $fcode; ?>">
                                </div>
                                <div>
                                    <label class="form-label" for="name">Course Name</label>
                                    <input class="form-control" type="text" name="name" id="name" value="<?php echo $fname; ?>">
                                </div>
                                <div>
                                    <label class="form-label" for="credits">Credits</label>
                                    <input class="form-control" type="number" name="credits" id="credits" value="<?php echo $fcredits; ?>">
                                </div>
                                <div>
                                    <label class="form-label" for="course">Course</label>
                                    <select class="form-select" name="course" id="course">
                                        <option value="HNDIT" <?php ($fcourse=="HNDIT")? "selected":"";?>>HNDIT</option>
                                        <option value="HNDE"<?php ($fcourse=="HNDE")? "selected":"";?>>HNDE</option>
                                        <option value="HNDA"<?php ($fcourse=="HNDA")? "selected":"";?>>HNDA</option>
                                        <option value="HNDMGT"<?php ($fcourse=="HNDMGT")? "selected":"";?>>HNDMGT</option>
                                    </select>
                                </div>

                                <div class="d-flex flex-wrap gap-2 pt-1">
                                    <input class="btn btn-primary" type="submit" name="btnSave" value="Save">
                                    <input class="btn btn-warning" type="submit" name="btnUpdate" value="Update">
                                    <input class="btn btn-outline-secondary" type="submit" name="btnLoad" value="Load">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-7">
                    <div class="card app-card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                                <h2 class="h5 app-section-title mb-0">Subjects</h2>
                                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="m-0">
                                    <input class="btn btn-outline-secondary btn-sm" type="submit" name="btnLoad" value="Refresh">
                                </form>
                            </div>


<?php


//INSERT
if(isset($_POST["btnSave"])){

    $code = $_POST["code"];
    $name = $_POST["name"];
    $credits = $_POST["credits"];
    $course =  $_POST["course"];
    
    $query = "INSERT INTO subjects (code,name,credits,course) VALUES('$code','$name',$credits,'$course')";

    //Execute SQL Query
    $result = mysqli_query($con,$query);

    if($result){
        echo '<div class="alert alert-success mt-3" role="alert">Save Successfull..!</div>';
        LoadData($con);
    }
    else{
        echo '<div class="alert alert-danger mt-3" role="alert">Error: Subject Save. '.mysqli_error($con).'</div>';
    }
    //Close the Connection
    mysqli_close($con);
}

//UPDATE
if(isset($_POST["btnUpdate"])){

    $code= $_POST["code"];
    $name = $_POST["name"];
    $course = $_POST["course"];
    $credits = $_POST["credits"];
    

    $query = "UPDATE subjects SET name='$name', course='$course' , credits = $credits WHERE code= '$code' ";

    $result = mysqli_query($con,$query);

    if($result){
        echo '<div class="alert alert-success mt-3" role="alert">Update Successfull..!</div>';
    }
    else{
        echo mysqli_error($con). '<br>';
         echo '<div class="alert alert-danger mt-3" role="alert">Error: Update Fail..!</div>';
    }

    mysqli_close($con);
}


//DELETE
if(isset($_POST["btnDelete"])){

    $code = $_POST["dcode"];//this is unique col.

    $query = "DELETE FROM subjects WHERE code='$code'";

    $result = mysqli_query($con,$query);

    if($result){
        echo '<div class="alert alert-success mt-3" role="alert">Delete Successfull..!</div>';
        LoadData($con);
    }
    else{
         echo '<div class="alert alert-danger mt-3" role="alert">Error: Delete Fail..!</div>';
    }
}

//Retrive / View Data
if(isset($_POST["btnLoad"])){
    LoadData($con);
}

function LoadData($con){
     $query = "SELECT * FROM subjects";
    $result = mysqli_query($con,$query);

    //Count no of Rows
    if(mysqli_num_rows($result) > 0){

        echo '<div class="table-responsive app-table-wrap">';
        echo '<table class="table table-hover align-middle mb-0">';
        echo "<tr>";
            echo "<th scope='col'>ID</th>";
            echo "<th scope='col'>Code</th>";
            echo "<th scope='col'>Name</th>";
            echo "<th scope='col'>Credits</th>";
            echo "<th scope='col'>Course</th>";
            echo "<th scope='col' class='text-end'>Action</th>";
        echo "</tr>";
        //Convert table data to Associative Array
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["code"]."</td>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["credits"]."</td>";
                echo "<td><span class='badge text-bg-light border'>".$row["course"]."</span></td>";
                echo 
                '<td>
                <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
                    <input type="hidden" name="dcode" value="'.$row["code"].'"/>
                    <div class="d-flex justify-content-end">
                        <input class="btn btn-outline-danger btn-sm" type="submit" name="btnDelete" value="Delete">
                    </div>
                </form>

                </td>';
            echo "</tr>";
        }

        /*
        //Convert table data to Numeric Array
        while($row = mysqli_fetch_row($result)){
            //Query is SELECT * so id=0, code=1, name=2 and credits =3
            // SELECT name, credits then name=0, credits = 1
            echo "<li>".$row[1]."-".$row[2]."(".$row[3].")";
        }
        */
        echo "</table>";
        echo "</div>";
    }
}

function AddUser($username, $password, $dbcon){

    //Hash the Password
    $hashP = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name,password) VALUES('$username','$hashP')";

    //Execute SQL Query
    $result = mysqli_query($dbcon,$query);

    if($result){
        echo "Save Successfull..!";
    }
    else{
        echo "Error: User Save. ".mysqli_error($dbcon);
    }
}

//AddUser("admin","123",$con);

?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>