<?php
if(isset($_POST['btn-upload']))
{
     // $pic = rand(1000,100000)."-".$_FILES['pic']['name'];
    $pic = $_FILES['pic']['name'];
    $pic_loc = $_FILES['pic']['tmp_name'];
    $folder= dirname(__FILE__)."\../Uploads/";
    if(move_uploaded_file($pic_loc,$folder.$pic)) {
?>      <script>
                alert('successfully uploaded');
                // console.log(window.location);
                window.location.href = "../Views/<?php echo $_GET['type']; ?>/dashboard.php?uploadImage=true&id=<?php echo $_GET['id'];?>";

        </script>
<?php
        // header('location:../Views/admin/dashboard.php?id='.$_GET['id']);
    }
    else {
?>      <script>alert('error while uploading file');</script><?php
    }
}