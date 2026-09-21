<?php

if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}

if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        $targetFile = $folder . '/' . time() . '-' . $file["name"];

        if (move_uploaded_file($file["tmp_name"], PATH_ASSETS_UPLOADS . $targetFile)) {
            return $targetFile;
        }

        throw new Exception('Upload file không thành công!');
    }
}
function upload_multiple_files($folder, $files)
{
    $uploaded_paths = [];

    // 1. Chuẩn bị thư mục upload
    $upload_dir = PATH_ASSETS_UPLOADS . '/' . $folder . '/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // 2. Lặp qua mảng tệp đã upload (Cấu trúc PHP phức tạp)
    // Lặp dựa trên số lượng tệp được gửi lên
    $file_count = count($files['name']);

    for ($i = 0; $i < $file_count; $i++) {
        // Kiểm tra xem tệp có được upload thành công hay không
        if ($files['error'][$i] === UPLOAD_ERR_OK) {

            $temp_name = $files['tmp_name'][$i];
            $original_name = $files['name'][$i];

            // Đổi tên tệp để tránh trùng lặp
            $ext = pathinfo($original_name, PATHINFO_EXTENSION);
            $new_name = time() . uniqid() . '.' . $ext;
            $upload_path = $upload_dir . $new_name;

            // Di chuyển tệp tạm thời đến thư mục đích
            if (move_uploaded_file($temp_name, $upload_path)) {
                // Lưu đường dẫn tương đối
                $uploaded_paths[] = $folder . '/' . $new_name;
            }
        }
    }
    return $uploaded_paths;
}

if (!function_exists('checkAuth')) {
    function checkAuth()
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?action=login');
            exit();
        }
    }
}

if (!function_exists('checkRole')) {
    function checkRole($allowedRoles = [])
    {
        checkAuth();
        $userRole = $_SESSION['user']['role'] ?? '';
        if (!in_array($userRole, (array)$allowedRoles)) {
            header('Location: ' . BASE_URL . '?action=login');
            exit();
        }
    }
}

// Yeu cau phai dang nhap va la customer
if (!function_exists('requireCustomer')) {
    function requireCustomer()
    {
        if (empty($_SESSION['user'])) {
            // Chua dang nhap -> chuyen den trang dang nhap
            header('Location: ' . BASE_URL . '?action=login');
            exit();
        }
        if (($_SESSION['user']['role'] ?? '') !== 'customer') {
            // Dang nhap nhung khong phai customer -> chuyen ve trang cua role do
            $role = $_SESSION['user']['role'];
            if ($role === 'admin') {
                header('Location: ' . BASE_URL . '?action=dashboard');
            } elseif ($role === 'guide') {
                header('Location: ' . BASE_URL . '?action=schedule');
            } else {
                header('Location: ' . BASE_URL . '?action=login');
            }
            exit();
        }
    }
}

// Yeu cau phai dang nhap va la admin
if (!function_exists('requireAdmin')) {
    function requireAdmin()
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?action=admin-login');
            exit();
        }
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            $role = $_SESSION['user']['role'];
            if ($role === 'guide') {
                header('Location: ' . BASE_URL . '?action=schedule');
            } elseif ($role === 'customer') {
                header('Location: ' . BASE_URL . '?action=public-tours');
            } else {
                header('Location: ' . BASE_URL . '?action=login');
            }
            exit();
        }
    }
}

// Yeu cau phai dang nhap va la guide
if (!function_exists('requireGuide')) {
    function requireGuide()
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?action=admin-login');
            exit();
        }
        if (($_SESSION['user']['role'] ?? '') !== 'guide') {
            $role = $_SESSION['user']['role'];
            if ($role === 'admin') {
                header('Location: ' . BASE_URL . '?action=dashboard');
            } elseif ($role === 'customer') {
                header('Location: ' . BASE_URL . '?action=public-tours');
            } else {
                header('Location: ' . BASE_URL . '?action=login');
            }
            exit();
        }
    }
}

