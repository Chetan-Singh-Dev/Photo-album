<?php
$upload_dir = "images/";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $target_file = $upload_dir . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $target_file);
    exit(json_encode(['success' => true]));
}

$images = array_diff(scandir($upload_dir), ['.', '..']);
$images = array_values($images);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$images_per_page = 6;
$total_pages = ceil(count($images) / $images_per_page);
$start = ($page - 1) * $images_per_page;
$current_images = array_slice($images, $start, $images_per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Photo Album</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <h1 style="color: #333; text-align: center; font-family: Arial, sans-serif; margin-bottom: 20px;">
  Photo Album
</h1>

<div class="form-container"
     style="background-color: #ffffff; padding: 30px 40px; border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); width: 350px; margin: 0 auto; text-align: center; font-family: Arial, sans-serif;">

  <form id="uploadForm" enctype="multipart/form-data">
    <h2 style="margin-bottom: 20px; color: #444;">Upload an Image</h2>

    <input type="file" name="image" accept="image/*" required
           style="margin: 20px 0; padding: 10px; width: 100%; border: 2px dashed #764ba2; border-radius: 10px; background-color: #f9f9f9; cursor: pointer; transition: background 0.3s ease;"
           onmouseover="this.style.backgroundColor='#f0f0f0'"
           onmouseout="this.style.backgroundColor='#f9f9f9'">

    <br>

    <button type="submit"
            style="background: #764ba2; color: white; border: none; padding: 12px 20px; border-radius: 10px; cursor: pointer; font-size: 16px; transition: background 0.3s ease;"
            onmouseover="this.style.background='#5e3b9d'"
            onmouseout="this.style.background='#764ba2'">
      Upload
    </button>
  </form>

</div>

    </div>
    <div class="album">
        <div class="column left">
            <?php for ($i = 0; $i < 3; $i++): ?>
                <?php if (isset($current_images[$i])): ?>
                    <img src="images/<?= htmlspecialchars($current_images[$i]) ?>" class="photo">
                <?php endif; ?>
            <?php endfor; ?>
        </div>
        <div class="column right">
            <?php for ($i = 3; $i < 6; $i++): ?>
                <?php if (isset($current_images[$i])): ?>
                    <img src="images/<?= htmlspecialchars($current_images[$i]) ?>" class="photo">
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    <div class="pagination">
        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
            <a href="?page=<?= $p ?>" class="<?= ($p === $page) ? 'active' : '' ?>"><?= $p ?></a>
        <?php endfor; ?>
    </div>
    <script src="script.js"></script>
</body>
</html>
