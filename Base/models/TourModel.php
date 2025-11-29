<?php
class TourModel
{
    public $db;

    public function __construct()
    {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    /** Lấy danh sách tour cơ bản */
    public function getList()
    {
        $sql = "SELECT 
                t.id, t.name, t.base_price, t.tour_type, t.tour_origin, t.category_id,
                c.name AS category_name,ti.image_url AS main_image_path,
                -- 1. TÍNH TOÁN CHÍNH XÁC SỐ LỊCH KHỞI HÀNH (Dùng Subquery)
                (SELECT COUNT(id) FROM tour_departures td WHERE td.tour_id = t.id) AS total_departures_count,
                -- 2. TỔNG HỢP LỘ TRÌNH (GROUP_CONCAT)
                GROUP_CONCAT(DISTINCT d.name ORDER BY tdest.order_number ASC SEPARATOR ' > ') AS destination_route_summary
            FROM tours t
            LEFT JOIN tour_categories c ON t.category_id = c.id
            LEFT JOIN tour_images ti ON ti.tour_id = t.id AND ti.is_featured = 1
            -- Nối N:M để tổng hợp lộ trình
            LEFT JOIN tour_destinations tdest ON tdest.tour_id = t.id
            LEFT JOIN destinations d ON d.id = tdest.destination_id 
            
            -- SỬA LỖI GROUP BY: Đã thêm t.tour_origin và t.category_id
            GROUP BY 
                t.id, t.name, t.base_price, t.tour_type, t.tour_origin, t.category_id, c.name , ti.image_url
            ORDER BY t.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Lấy chi tiết tour và dữ liệu liên quan */
    public function getOne($id)
    {
        $sql = "SELECT t.*, c.name AS category_name, cp.details AS policy_details
                FROM tours t
                LEFT JOIN tour_categories c ON t.category_id = c.id
                LEFT JOIN cancellation_policies cp ON t.policy_id = cp.id
                WHERE t.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $tour = $stmt->fetch();

        if ($tour) {
            // Lấy các mảng dữ liệu phụ thuộc
            $tour['destinations'] = $this->getDestinations($id);
            $tour['departures']   = $this->getDepartures($id);
            $tour['gallery']      = $this->getImages($id);
        }
        return $tour;
    }

    /** Tạo tour mới (Logic Điều phối Tuần tự) */
    public function insert($data, $destinations = [], $departures = [], $uploaded_images = [])
    {
        // 1. INSERT vào bảng tours (Bảng chính)
        $sql = "INSERT INTO tours 
                (name, tour_type, description, base_price, policy_id, category_id, tour_origin) 
                VALUES (:name, :tour_type, :description, :base_price, :policy_id, :category_id, :tour_origin)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':tour_type' => $data['tour_type'],
            ':description' => $data['description'] ?? null,
            ':base_price' => $data['base_price'],
            ':policy_id' => $data['policy_id'],
            ':category_id' => $data['category_id'],
            ':tour_origin' => $data['tour_origin'] ?? 'Catalog',
        ]);
        $tour_id = $this->db->lastInsertId();
        // 2. Chèn Lộ trình (N:M - Bắt buộc order_number)
        $this->saveDestinations($tour_id, $destinations);
        // 3. Chèn Lịch khởi hành (1:N)
        $departureModel = new DepartureModel();
        $departureModel->saveDeparturesForTour($tour_id, $departures);
        // 4. Chèn Gallery ảnh
        $this->saveImages($tour_id, $uploaded_images);
        return $tour_id; // KHÔNG CÓ ROLLBACK NẾU CÁC BƯỚC SAU THẤT BẠI
    }

    /** Cập nhật tour (Logic Điều phối Tuần tự) */
    public function update($id, $data, $destinations = [], $departures = [], $uploaded_images = [])
    {
        // 1. UPDATE bảng tours chính
        $sql = "UPDATE tours SET 
                name = :name, tour_type = :tour_type, description = :description, base_price = :base_price, 
                policy_id = :policy_id, category_id = :category_id, tour_origin = :tour_origin
                WHERE id = :id";
        // ... (Execute UPDATE SQL) ...

        // 2. Cập nhật các bảng phụ thuộc (Xóa cũ, chèn mới)
        $this->saveDestinations($id, $destinations);
        $departureModel = new DepartureModel();
        $departureModel->saveDeparturesForTour($id, $departures);
        $this->saveImages($id, $uploaded_images);
    }

    // Trong TourModel.php::delete($id)

    public function delete($id)
    {
        // BƯỚC 1: Lấy danh sách ảnh vật lý
        $imagesToDelete = $this->getImages($id);

        try {
            // BƯỚC 2: XÓA CÁC TỆP ẢNH VẬT LÝ TRÊN SERVER (Clean up)
            foreach ($imagesToDelete as $image) {
                $filePath = PATH_ASSETS_UPLOADS . '/' . $image['image_url'];
                if (file_exists($filePath)) {
                    unlink($filePath); // Xóa tệp khỏi ổ đĩa
                }
            }

            // BƯỚC 3: XÓA DỮ LIỆU CSDL (Tuần tự an toàn)
            $this->db->prepare("DELETE FROM tour_destinations WHERE tour_id = :id")->execute([':id' => $id]);
            $this->db->prepare("DELETE FROM tour_images WHERE tour_id = :id")->execute([':id' => $id]);
            $this->db->prepare("DELETE FROM tour_departures WHERE tour_id = :id")->execute([':id' => $id]);

            // BƯỚC 4: XÓA BẢN GHI CHÍNH (Cuối cùng)
            $this->db->prepare("DELETE FROM tours WHERE id = :id")->execute([':id' => $id]);

            return true;
        } catch (PDOException $e) {
            // Xử lý lỗi
            throw $e;
        }
    }

    // --- PHƯƠNG THỨC HỖ TRỢ LƯU TRỮ DỮ LIỆU (HELPER METHODS) ---
    /** Lưu Lộ trình: Xóa cũ, Chèn mới (Bao gồm order_number) */
    // Trong TourModel.php

    /** Lưu Lộ trình: Xóa cũ, Chèn mới (Bao gồm order_number) */
    private function saveDestinations($tour_id, $destinations = [])
    {
        // Xóa cũ (giữ nguyên)
        $this->db->prepare("DELETE FROM tour_destinations WHERE tour_id = :tour_id")->execute([':tour_id' => $tour_id]);

        if (!empty($destinations)) {
            // SQL ĐÃ SỬA: Thêm cột order_number vào danh sách cột
            $sql2 = "INSERT INTO tour_destinations (tour_id, destination_id, order_number) 
                 VALUES (:tour_id, :destination_id, :order_number)";
            $stmt2 = $this->db->prepare($sql2);

            foreach ($destinations as $dest) {
                $stmt2->execute([
                    ':tour_id' => $tour_id,
                    ':destination_id' => $dest['destination_id'],
                    // THÊM GIÁ TRỊ ORDER_NUMBER BỊ THIẾU
                    ':order_number' => $dest['order_number']
                ]);
            }
        }
    }


    /** Lưu Ảnh Gallery: Xóa cũ, Chèn mới */
    private function saveImages($tour_id, $image_paths = [])
    {

        // 1. XÓA TẤT CẢ ẢNH CŨ (Bắt buộc khi UPDATE)
        $this->db->prepare("DELETE FROM tour_images WHERE tour_id = :tour_id")
            ->execute([':tour_id' => $tour_id]);

        // 2. CHÈN LẠI CÁC ẢNH MỚI
        if (!empty($image_paths)) {
            $sql_insert = "INSERT INTO tour_images (tour_id, image_url, is_featured, order_number) 
                       VALUES (:tour_id, :image_url, :is_featured, :order_number)";
            $stmt_insert = $this->db->prepare($sql_insert);

            foreach ($image_paths as $index => $path) {
                // Xác định ảnh đầu tiên là ảnh đại diện (is_featured = 1)
                $is_featured = ($index === 0) ? 1 : 0;

                $stmt_insert->execute([
                    ':tour_id' => $tour_id,
                    ':image_url' => $path,
                    ':is_featured' => $is_featured,
                    ':order_number' => $index + 1 // Đảm bảo thứ tự hiển thị
                ]);
            }
        }
    }

    // --- PHƯƠNG THỨC GETTER KHÁC (getDestinations, getDepartures, getImages) ---
    public function getDestinations($tour_id)
    {
        $sql = "SELECT d.*, td.order_number
            FROM tour_destinations td
            JOIN destinations d ON td.destination_id = d.id
            WHERE td.tour_id = :tour_id
            ORDER BY td.order_number ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tour_id' => $tour_id]);
        return $stmt->fetchAll();
    }
    public function getDepartures($tour_id) {
    $sql = "SELECT
                td.id AS departure_id,
                td.start_date,
                td.end_date,
                td.current_price,
                td.available_slots AS max_slots,
                IFNULL(td.available_slots - COUNT(BC.id), 0) AS remaining_slots
            FROM tour_departures td
            LEFT JOIN bookings b ON b.departure_id = td.id AND b.status IN ('Confirmed', 'Pending')
            LEFT JOIN booking_customers BC ON BC.booking_id = b.id
            WHERE td.tour_id = :tour_id
            GROUP BY td.id, td.start_date, td.end_date, td.current_price, td.available_slots
            ORDER BY td.start_date ASC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([':tour_id' => $tour_id]);
    $departures = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Map lại key để form hiển thị đúng
    return array_map(function($dep){
        return [
            'departure_id' => $dep['departure_id'],
            'start_date' => $dep['start_date'],
            'end_date' => $dep['end_date'],
            'current_price' => $dep['current_price'],
            'available_slots' => $dep['max_slots'],
            'remaining_slots' => $dep['remaining_slots']
        ];
    }, $departures);
}

    public function getImages($tour_id)
    {
        $sql = "SELECT image_url, is_featured, order_number 
            FROM tour_images
            WHERE tour_id = :tour_id
            ORDER BY order_number ASC, is_featured DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tour_id' => $tour_id]);
        return $stmt->fetchAll();
    }
}
