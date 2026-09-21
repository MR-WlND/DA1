<?php
class CategoryController
{
    public function listCategory()
    {
        requireAdmin();
        $model = new CategoryModel();
        $listCategory = $model->getList();

        $view = "admin/category/list-category";
        require_once PATH_VIEW . 'main.php';
    }

    public function createCategory()
    {
        requireAdmin();
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
                $_SESSION['error'] = "TĂªn danh má»¥c Ä‘Ă£ tá»“n táº¡i.";
                header("Location: " . BASE_URL . "?action=create-category");
                exit;
            }

            $model->insert($name, $description);

            $_SESSION['success'] = "ThĂªm danh má»¥c thĂ nh cĂ´ng!";
            header("Location: " . BASE_URL . "?action=list-category");
            exit;
        }
    }

    public function updateCategory()
    {
        requireAdmin();
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
                $_SESSION['error'] = "TĂªn danh má»¥c Ä‘Ă£ tá»“n táº¡i.";
                header("Location: " . BASE_URL . "?action=update-category&id=" . $categoryID);
                exit;
            }

            $model->update($categoryID, $name, $description);

            $_SESSION['success'] = "Cáº­p nháº­t danh má»¥c thĂ nh cĂ´ng!";
            header("Location: " . BASE_URL . "?action=list-category");
            exit;
        }
    }

    public function deleteCategory()
    {
        requireAdmin();
        $categoryID = $_GET['id'];
        $tourModel = new TourModel();
        $tourCount = $tourModel->countToursByCategoryId($categoryID);

        if ($tourCount > 0) {
            $_SESSION['error'] = "KhĂ´ng thá»ƒ xĂ³a danh má»¥c nĂ y vĂ¬ Ä‘ang cĂ³ tour thuá»™c danh má»¥c nĂ y.";
        } else {
            $categoryModel = new CategoryModel();
            $categoryModel->delete($categoryID);
            $_SESSION['success'] = "XĂ³a danh má»¥c thĂ nh cĂ´ng!";
        }

        header("Location: " . BASE_URL . "?action=list-category");
        exit;
    }
}
?>

