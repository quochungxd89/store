<?php
// Tạo thư mục nếu chưa tồn tại
$upload_dir = __DIR__ . '/public/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
    $tmp_name  = $_FILES['product_image']['tmp_name'];
    $ext       = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
    $allowed   = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $allowed)) {
        die('Định dạng ảnh không hợp lệ.');
    }

    $new_name = time() . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
    $dest     = $upload_dir . $new_name;

    if (move_uploaded_file($tmp_name, $dest)) {
        $image_path = 'public/uploads/' . $new_name;

  
    } else {
        die('Không thể lưu file, kiểm tra quyền thư mục.');
    }
} else {
    die('Vui lòng chọn ảnh.');
}
?>
