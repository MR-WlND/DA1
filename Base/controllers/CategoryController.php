<?php
class CategoryController
{
    public function listCategory()
    {
        $model = new CategoryModel();
        $listCategory = $model->getList();

        $view = "admin/category/list-category";
        require_once PATH_VIEW . 'main.php';
    }

    public function createCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $view = "admin/category/create-category";
            require_once PATH_VIEW . 'main.php';
        } else {
            $name = $_POST['name'];
            $description = $_POST['description'] ?? '';

            $model = new CategoryModel();
            
            // Validate unique name
            $existingCategory = $model->findByName($name);
            if ($existingCategory) {
                $_SESSION['error'] = "Tên danh mục đã tồn tại.";
                header("Location: " . BASE_URL . "?action=create-category");
                exit;
            }

            $model->insert($name, $description);

            $_SESSION['success'] = "Thêm danh mục thành công!";
            header("Location: " . BASE_URL . "?action=list-category");
            exit;
        }
    }

    public function updateCategory()
    {
        $model = new CategoryModel();
        $categoryID = $_GET['id'];
        $category = $model->getOne($categoryID);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $view = "admin/category/update-category";
            require_once PATH_VIEW . 'main.php';
        } else {
            $name = $_POST['name'];
            $description = $_POST['description'] ?? '';

            // Validate unique name
            $existingCategory = $model->findByName($name);
            if ($existingCategory && $existingCategory['id'] != $categoryID) {
                $_SESSION['error'] = "Tên danh mục đã tồn tại.";
                header("Location: " . BASE_URL . "?action=update-category&id=" . $categoryID);
                exit;
            }

            $model->update($categoryID, $name, $description);

            $_SESSION['success'] = "Cập nhật danh mục thành công!";
            header("Location: " . BASE_URL . "?action=list-category");
            exit;
        }
    }

    public function deleteCategory()
    {
        $categoryID = $_GET['id'];
        $tourModel = new TourModel();
        $tourCount = $tourModel->countToursByCategoryId($categoryID);

        if ($tourCount > 0) {
            $_SESSION['error'] = "Không thể xóa danh mục này vì đang có tour thuộc danh mục này.";
        } else {
            $categoryModel = new CategoryModel();
            $categoryModel->delete($categoryID);
            $_SESSION['success'] = "Xóa danh mục thành công!";
        }

        header("Location: " . BASE_URL . "?action=list-category");
        exit;
    }
}
?>
