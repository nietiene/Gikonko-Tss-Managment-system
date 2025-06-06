<?php
include('conn.php');
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['login_error'] = "Please login to access this page";
    header("Location:login.php");
    exit();
}

// Handle select logic
if (isset($_GET['Trainee_Id'])) {
    $Trainee_Id = $_GET['Trainee_Id'];

    $sql = "SELECT t.Trainee_Id,
                   t.Firstname,
                   t.lastname,
                   t.Gender,
                   t.Trade_Id,
                   td.Trade_Name
            FROM trainees t 
            JOIN trades td ON t.Trade_Id = td.Trade_Id
            WHERE t.Trainee_Id = '$Trainee_Id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $trainee = mysqli_fetch_assoc($query);
    } else {
        die("ERROR:" . mysqli_error($conn));
    }
}

$error = "";
// Handle update logic
if (isset($_POST['update'])) {
    if (!empty($_POST['Firstname']) && !empty($_POST['lastname']) && !empty($_POST['Gender']) && !empty($_POST['Trade_Id'])) {
        $FirstName = $_POST['Firstname'];
        $lastname = $_POST['lastname'];
        $Gender = $_POST['Gender'];
        $Trade_Id = $_POST['Trade_Id'];

        $sql = "UPDATE trainees SET 
                    Firstname='$FirstName',
                    lastname='$lastname',
                    Gender='$Gender',
                    Trade_Id='$Trade_Id'
                WHERE Trainee_Id = $Trainee_Id";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect after successful update
            header("Location:listOfTrainee.php");
            exit();
        } else {
            die("ERROR:" . mysqli_error($conn));
        }
    } else {
        $error = "Please fill out the empty space";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Update <?php echo $trainee['Firstname']; ?></title>
   <link href="output.css" rel="stylesheet" />
   <link rel="icon" type="/png" href="gikonko.png" />
</head>

<body class="min-h-screen bg-green-100">


   <div class="w-full fixed top-0 left-0 z-10">
      <?php include("Dashboard.php"); ?>
   </div>


   <main class="flex justify-center items-center min-h-screen pt-32">
      <form action="" method="post" class="bg-blue-700 p-8 max-w-lg w-full rounded-lg shadow-2xl">
         <h1 class="text-center text-green-500 text-xl underline mb-6">Update <?php echo $trainee['Firstname']; ?></h1>

         <label class="text-lg text-green-500 font-semibold">Trainee Code</label>
         <input type="text" name="Trainee_Id" value="<?php echo $trainee['Trainee_Id']; ?>" readonly
            class="w-[75%] px-3 py-2 bg-blue-200 rounded-lg focus:outline-none text-blue-500 focus:ring-2 mb-6" /> <br>

         <label class="text-lg text-green-500 font-semibold">First Name</label>
         <input type="text" name="Firstname" value="<?php echo $trainee['Firstname']; ?>"
            class="w-[74.7%] py-2 px-3 ms-5 bg-blue-200 rounded-lg focus:outline-none text-blue-500 focus:ring-2 mb-6" /> <br>

         <label class="text-lg text-green-500 font-semibold">Last Name</label>
         <input type="text" name="lastname" value="<?php echo $trainee['lastname']; ?>"
            class="w-[75%] py-2 px-3 bg-blue-200 ms-5 rounded-lg focus:outline-none text-blue-500 focus:ring-2 mb-6" /> <br>

         <label class="text-lg text-green-500 font-semibold">Gender</label>
         <input type="text" name="Gender" value="<?php echo $trainee['Gender']; ?>"
            class="w-[75%] py-2 px-3 bg-blue-200 ms-[10%] rounded-lg focus:outline-none text-blue-500 focus:ring-2 mb-6" /> <br>

         <label class="text-lg text-green-500 font-semibold">Trade Code</label>
         <input type="text" name="Trade_Id" value="<?php echo $trainee['Trade_Id']; ?>"
            class="w-[75%] py-2 px-3 ms-3 bg-blue-200 rounded-lg focus:outline-none text-blue-500 focus:ring-2 mb-6" /> <br>

         <label class="text-lg text-green-500 font-semibold">Trade Name</label>
         <input type="text" name="Trade_Name" value="<?php echo $trainee['Trade_Name']; ?>" readonly
            class="w-[75%] py-2 ms-2 px-3 bg-blue-200 rounded-lg focus:outline-none text-blue-500 focus:ring-2 mb-6" /> <br>

         <div class="flex justify-between mb-6">
            <button name="update" class="px-8 py-2 bg-green-500 rounded-lg text-white font-semibold hover:bg-green-600 shadow-lg">Save Changes</button>
            <a href="listOfTrainee.php" class="px-8 me-2 py-2 bg-red-500 rounded-lg text-white font-semibold hover:bg-red-600 shadow-lg">← Back</a>
         </div>

         <?php if (!empty($error)): ?>
            <div class="py-1 text-red-500 px-1">
               <?php echo $error; ?>
            </div>
         <?php endif; ?>
      </form>
   </main>

       <footer class="bg-blue-500 text-center py-4 shadow-inner text-sm text-white fixed bottom-0 w-full">
          &copy; <?php echo date("Y"); ?> GIKONKO TSS. All rights reserved.
  </footer>
</body>
</html>
