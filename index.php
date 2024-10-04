<?php
// Cek jika form telah disubmit
if(isset($_POST['submit'])){
    // Direktori tujuan untuk menyimpan file yang diupload
    $target_dir = "uploads/";
    // Tentukan target file, termasuk nama file
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    // Tipe file yang diizinkan
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file adalah gambar
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Cek jika file sudah ada
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Batasi ukuran file (misalnya 2MB)
    if ($_FILES["fileToUpload"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Izinkan tipe file tertentu (jpg, png, jpeg, gif)
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Cek jika $uploadOk tidak ada error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // Jika semua OK, upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gambar</title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">
    Pilih gambar untuk diupload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php
// Jika file berhasil diupload, tampilkan gambar dan link menuju file
if(isset($target_file) && file_exists($target_file)) {
    echo "<h3>Gambar yang diupload:</h3>";
    echo "<img src='" . $target_file . "' alt='Uploaded Image' style='max-width:500px;'><br>";
    echo "<a href='" . $target_file . "' target='_blank'>Klik di sini untuk melihat gambar</a>";
}
?>

</body>
</html>
