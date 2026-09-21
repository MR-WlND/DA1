<?php

class TransportSupplierController
{
    public function listSupplier()
    {
        requireAdmin();
        $model = new TransportSupplierModel(); // Khá»Ÿi táº¡o Model cá»¥c bá»™
        $listSuppliers = $model->getList();
        $title = "Quáº£n lĂ½ NCC Váº­n táº£i";
        $view = "admin/transport/list-supplier";
        require_once PATH_VIEW . 'main.php';
    }

    // 2. ThĂªm NCC má»›i (CREATE)
    public function createSupplier()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // CĂ³ thá»ƒ cáº§n TourModel Ä‘á»ƒ láº¥y list Destinations náº¿u NCC liĂªn káº¿t vá»›i Ä‘á»‹a Ä‘iá»ƒm
            // $destinationModel = new DestinationModel(); 
            // $listDestination = $destinationModel->getList(); 

            $title = "ThĂªm NCC Váº­n táº£i";
            $view = "admin/transport/create-supplier";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Láº¥y dá»¯ liá»‡u tá»« form vĂ  gá»i Model
            $name = $_POST['supplier_name'];
            $contact = $_POST['contact_person'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $email = $_POST['email'] ?? null;
            $details = $_POST['details'] ?? null;

            try {
                $model = new TransportSupplierModel();
                $model->insert($name, $contact, $phone, $email, $details);

                // Chuyá»ƒn hÆ°á»›ng sau khi táº¡o thĂ nh cĂ´ng
                header("Location: " . BASE_URL . "?action=list-supplier");
                exit;
            } catch (Exception $e) {
                // Xá»­ lĂ½ lá»—i CSDL
                echo "Lá»—i: KhĂ´ng thá»ƒ thĂªm NCC. " . $e->getMessage();
            }
        }
    }

    // 3. Cáº­p nháº­t NCC (UPDATE)
    public function updateSupplier()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        $model = new TransportSupplierModel();
        $supplier = $model->getOne($id);
        
        if (!$supplier) {
            echo "NhĂ  cung cáº¥p khĂ´ng tá»“n táº¡i!";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "Cáº­p nháº­t NCC Váº­n táº£i";
            $view = "admin/transport/update-supplier";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Láº¥y dá»¯ liá»‡u vĂ  gá»i Model
            $name = $_POST['supplier_name'];
            $contact = $_POST['contact_person'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $email = $_POST['email'] ?? null;
            $details = $_POST['details'] ?? null;

            $model->update($id, $name, $contact, $phone, $email, $details);

            header("Location: " . BASE_URL . "?action=list-supplier");
            exit;
        }
    }

    // 4. XĂ³a NCC (DELETE)
    public function deleteSupplier()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        $model = new TransportSupplierModel();
        
        // Cáº§n láº¥y dá»¯ liá»‡u trÆ°á»›c Ä‘á»ƒ kiá»ƒm tra tá»“n táº¡i vĂ  xá»­ lĂ½ FK (náº¿u cáº§n)
        if (!$model->getOne($id)) {
            echo "NhĂ  cung cáº¥p khĂ´ng tá»“n táº¡i!";
            return;
        }

        try {
            $model->delete($id);
            header("Location: " . BASE_URL . "?action=list-supplier");
            exit;
        } catch (Exception $e) {
            // Báº¯t lá»—i FK náº¿u NCC nĂ y cĂ²n Ä‘Æ°á»£c tham chiáº¿u trong departure_resources
            echo "Lá»—i: KhĂ´ng thá»ƒ xĂ³a NCC (CĂ³ thá»ƒ cĂ²n liĂªn káº¿t vá»›i chuyáº¿n khá»Ÿi hĂ nh).";
        }
    }
}
