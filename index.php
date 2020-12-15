<?php
    //inisialisasi jika terjadi error 
    $error="Tidak bisa terhubung";

    //connect ke database
    $db=mysqli_connect("tsttodolist-mysqldbserver.mysql.database.azure.com", "mysqldbuser@tsttodolist-mysqldbserver", "Denny13735", "dbtodolist");

    //laporan konfirmasi jika submit button diklik
    if(isset($_POST['submit'])) {
        if(empty($_POST['task'])){
            $errors="Masukkan Task";
        } else{
            $task = $_POST["task"];
            $sql="INSERT INTO tasks (id, task) VALUES ('0','$task')";
            mysqli_query($db,$sql);
            header('location: index.php');
        }
    }

    //delete task
    if(isset($_GET['del_task'])) {
        $id=$_GET['del_task'];

        mysqli_query($db,"DELETE FROM tasks WHERE id=".$id);
        header('location: index.php');
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <title> To Do List </title>
</head>
<body>
    <div class="heading">
        <h1 style="font-style: 'Hervetica';"> To Do List</h1>
        <h3 style="font-style: 'Hervetica';"> By : Denny Fardian - 18218025</h3>
        <link rel="stylesheet" type="text/css" href="style.css">
        </div>
        <form method="post" action="index.php" class="input_form">
        <?php 
            if (isset($errors)) { ?>
            <p><?php echo $errors; ?></p>
            <?php } ?>
            <input type="text" name="task" class="task_input">
            <button type="submit" name="submit" id="add_btn" class="add_btn"> Tambahkan Task</button>
        </form>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tasks</th>
                <th style="width: 60px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //Pilih semua task jika merefresh halaman
            $tasks=mysqli_query($db, "SELECT * FROM tasks");

            $i = 1; while ($row=mysqli_fetch_array($tasks)) { ?>
                <tr>
                    <td> <?php echo $i; ?> </td>
                    <td class="task"> <?php echo $row['task']; ?> </td>
                    <td class="delete">
                        <a href="index.php?del_task=<?php echo $row['id'] ?>">Hapus</a>
                    </td>
                </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
</body>
</html>



