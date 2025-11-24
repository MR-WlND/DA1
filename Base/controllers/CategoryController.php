<?php 
class CategoryController {
    public function listCategory()
    {
        $category = new CategoryModel();
        $listCategory = $category->getList();
        $view = "admin/Category/list-category";
        require_once PATH_VIEW . 'main.php';
    }
    public function createCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryModel = new CategoryModel();
            $categoryModel->insert(
                $_POST['name'],
                $_POST['description']
            );
            header('Location:' . BASE_URL . '?action=list-category');
            exit();
        }
        $view = "admin/Category/create-category";
        require_once PATH_VIEW . 'main.php';
    }
    public function updateCategory()
    {
        $categoryModel = new CategoryModel();
        $data = $categoryModel->getOne($_GET['id']);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $category = $categoryModel->getOne($_GET['id']);
            require_once PATH_VIEW . 'admin/Category/update-category.php';
        } else {
            $categoryModel->update(
                $_GET['id'],
                $_POST['name'], 
                $_POST['description']
            );
            header('Location:' . BASE_URL . '?action=list-category');
            exit();
        }
    }
    public function deleteCategory()
    {
        $category = new CategoryModel();
        $category->delete($_GET['id']);
        header('Location: index.php?action=list-category');
        exit();
    }

}
?>