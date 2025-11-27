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
            $model->insert($name, $description);

            header("Location: " . BASE_URL . "?action=list-category");
            exit;
        }
    }

    public function updateCategory()
    {
        $model = new CategoryModel();
        $category = $model->getOne($_GET['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $view = "admin/category/update-category";
            require_once PATH_VIEW . 'main.php';
        } else {
            $name = $_POST['name'];
            $description = $_POST['description'] ?? '';

            $model->update($_GET['id'], $name, $description);

            header("Location: " . BASE_URL . "?action=list-category");
            exit;
        }
    }

    public function deleteCategory()
    {
        $model = new CategoryModel();
        $model->delete($_GET['id']);

        header("Location: " . BASE_URL . "?action=list-category");
        exit;
    }
}
?>
