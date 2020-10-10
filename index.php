<?php 

    error_reporting(0);

    $con = mysqli_connect('localhost', 'root', '', 'multi_delete');

    if ($con) {
        // echo "Connect success";
    } else {
        echo "Failed to connect " . mysqli_connect_error();
    }

    if (isset($_POST['delete'])) {
        if (count($_POST['ids']) > 0) {
            $all = implode(",", $_POST['ids']);
            $sql = mysqli_query($con, "DELETE FROM tblusers WHERE id in ($all)");
            if ($sql) {
                echo "<script>alert('Data deleted successful');</script>";
            } else {
                echo "<script>alert('Something went wrong');</script>";
            }
        } else {
            $errmsg = "You need to select atleast one checkbox to delete";
        }
    }

    if (isset($_POST['add'])) {
        $fullname = $_POST['fullname'];
        $education = $_POST['education'];
        $date = $_POST['date'];

        $sql = mysqli_query($con, "INSERT INTO tblusers(fullname, education, postingDate) VALUES('$fullname', '$education', '$date')");
        if ($sql) {
            echo "<script>alert('Data inserted successfully');</script>";
        } else {
            echo "<script>alert('Something went wrong!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Delete</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
</head>
<body>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add infomation</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST">
            <div class="modal-body">
                <label for="name" class="form-label mt-3">Add fullname</label>
                <input type="text" name="fullname" class="form-control" placeholder="Add fullname">
                <label for="education" class="form-label mt-3">Add education</label>
                <input type="text" name="education" class="form-control" placeholder="Add education">
                <label for="date" class="form-label mt-3">Add Date</label>
                <input type="date" name="date" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="add" class="btn btn-primary">Add</button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <div class="container">
        <form method="post">
            <?php if(isset($errmsg)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errmsg; ?>
            </div>
            <?php } ?>
            <table class="table table-striped">

                <tr>
                    <td colspan="4">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                    Add
                    </button>
                    <input type="submit" name="delete" value="Delete" class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?');">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input" id="select_all">
                        <label class="form-check-label">Select All</label>
                    </td>
                    <td>Name</td>
                    <td>Education</td>
                    <td>Date</td>
                </tr>

                <tr>
                    <?php 

                        $query = mysqli_query($con, "SELECT * FROM tblusers");
                        $totalcnt = mysqli_num_rows($query);
                        if ($totalcnt > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                    ?>

                        <tr>
                            <td><input type="checkbox" class="checkbox" name="ids[]" value=<?php echo $row['id'] ?>></td>
                            <td><?php echo $row['fullname'] ?></td>
                            <td><?php echo $row['education'] ?></td>
                            <td><?php echo $row['postingDate'] ?></td>
                        </tr>

                    <?php 
                        } } else {
                    ?>
                        <tr>
                            <td colspan="4">No record found</td>
                        </tr>
                    <?php } ?>
                </tr>

            </table>
        </form>
    </div>
    

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    
        $(document).ready(function() {
            $('#select_all').on('click', function() {
                if (this.checked) {
                    $('.checkbox').each(function() {
                        this.checked = true;
                    })
                } else {
                    $('.checkbox').each(function() {
                        this.checked = false;
                    }) 
                }
            })
            $('.checkbox').on('click', function() {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#select_all').prop('checked', true);
                } else {
                    $('#select_all').prop('checked', false);
                }
            })
        }); 
    
    </script>
</body>
</html>