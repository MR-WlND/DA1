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
                t.id, t.name, t.base_price, t.tour_type, t.tour_origin, t.category_id, t.description,
                c.name AS category_name,ti.image_url AS main_image_path,
                -- 1. TÍNH TOÁN SỐ LỊCH KHỞI HÀNH (Dùng Subquery)
                (SELECT COUNT(id) FROM tour_departures td WHERE td.tour_id = t.id) AS total_departures_count,
                -- 2. TỔNG HỢP LỘ TRÌNH (GROUP_CONCAT)
                GROUP_CONCAT(DISTINCT d.name ORDER BY tdest.order_number ASC SEPARATOR ' > ') AS destination_route_summary
            FROM tours t
            LEFT JOIN tour_categories c ON t.category_id = c.id
            LEFT JOIN tour_images ti ON ti.tour_id = t.id AND ti.is_featured = 1
            LEFT JOIN tour_destinations tdest ON tdest.tour_id = t.id
            LEFT JOIN destinations d ON d.id = tdest.destination_id 
            GROUP BY 
                t.id, t.name, t.base_price, t.tour_type, t.tour_origin, t.category_id, c.name, ti.image_url
            ORDER BY t.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Lấy chi tiết tour và dữ liệu liên quan (Orchestrator) */
    // TRONG TourModel.php

/** Lấy chi tiết tour và dữ liệu liên quan (Orchestrator) */
/** Lấy chi tiết tour và dữ liệu liên quan (Orchestrator) */
/** Lấy chi tiết tour và dữ liệu liên quan (Orchestrator) */
// TRONG TourModel.php

/** Lấy chi tiết tour và dữ liệu liên quan (Orchestrator) */
/** Lấy chi tiết tour và dữ liệu liên quan (Orchestrator) */
public function getOne($id)
{
    $sql = "SELECT t.*, c.name AS category_name
            FROM tours t
            LEFT JOIN tour_categories c ON t.category_id = c.id
            -- KHÔNG CÒN JOIN BẢNG CHÍNH SÁCH NÀO NỮA
            WHERE t.id = :id";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $tour = $stmt->fetch();

    if ($tour) {
        // CHỈ GỌI CÁC GETTER ĐƠN GIẢN (KHÔNG GỌI getTourPolicies/N:M)
        $tour['destinations']      = $this->getDestinations($id);
        $tour['departures']        = $this->getDepartures($id);
        $tour['gallery']           = $this->getImages($id);
        $tour['itinerary_details'] = $this->getItineraryDetails($id);
    }
    return $tour;
}

    /** Tạo tour mới (Logic Điều phối Tuần tự) */
    public function insert($data, $destinations = [], $departures = [], $uploaded_images = [], $itineraryDetails = [])
{
    // SỬA: Loại bỏ policy_id, thêm cancellation_policy_text
    $sql = "INSERT INTO tours 
            (name, tour_type, description, base_price, category_id, tour_origin, cancellation_policy_text) 
            VALUES (:name, :tour_type, :description, :base_price, :category_id, :tour_origin, :policy_text)";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':name' => $data['name'],
        ':tour_type' => $data['tour_type'],
        ':description' => $data['description'] ?? null,
        ':base_price' => $data['base_price'],
        
        ':category_id' => $data['category_id'],
        ':tour_origin' => $data['tour_origin'] ?? 'Catalog',
        
        // <<< THAM SỐ TEXT MỚI >>>
        ':policy_text' => $data['cancellation_policy_text'] ?? null,
    ]);
    $tour_id = $this->db->lastInsertId();

        // Gọi các hàm lưu trữ phụ thuộc
        $this->saveDestinations($tour_id, $destinations);
        $departureModel = new DepartureModel(); // Gọi Model bên ngoài
        $departureModel->saveDeparturesForTour($tour_id, $departures);
        $this->saveImages($tour_id, $uploaded_images);
        $this->saveItineraryDetails($tour_id, $itineraryDetails);

        return $tour_id;
    }

/** Cập nhật tour (Logic Điều phối Tuần tự) */
public function update($id, $data, $destinations = [], $departures = [], $uploaded_images = [], $itineraryDetails = [])
{
    // SỬA LỖI LỚN NHẤT: Loại bỏ policy_id khỏi SQL
    $sql = "UPDATE tours SET 
            name = :name, tour_type = :tour_type, description = :description, base_price = :base_price, 
            category_id = :category_id, tour_origin = :tour_origin, cancellation_policy_text = :policy_text
            WHERE id = :id";
    
    $stmt = $this->db->prepare($sql);
    
    // Sửa mảng execution
    $executionArray = [
        ':id' => $id,
        ':name' => $data['name'] ?? null,
        ':tour_type' => $data['tour_type'] ?? null,
        ':description' => $data['description'] ?? null,
        ':base_price' => $data['base_price'] ?? 0, 
        
        ':category_id' => $data['category_id'] ?? null,
        ':tour_origin' => $data['tour_origin'] ?? 'Catalog',
        
        // <<< THAM SỐ TEXT MỚI >>>
        ':policy_text' => $data['cancellation_policy_text'] ?? null,
    ];
    
    $stmt->execute($executionArray); // THỰC THI

    // 2. Cập nhật các bảng phụ thuộc (KHÔNG GỌI savePolicies!)
    $this->saveDestinations($id, $destinations);
    $departureModel = new DepartureModel();
    $departureModel->saveDeparturesForTour($id, $departures);
    $this->saveImages($id, $uploaded_images);
    $this->saveItineraryDetails($id, $itineraryDetails);
}

    // Trong TourModel.php::delete($id)

    public function delete($id)
    {
        try {
            // 1. XÓA CÁC TỆP ẢNH VẬT LÝ TRƯỚC
            $imagesToDelete = $this->getImages($id);
            foreach ($imagesToDelete as $image) {
                $filePath = PATH_ASSETS_UPLOADS . '/' . $image['image_url'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            // 2. XÓA DỮ LIỆU CSDL (Theo đúng thứ tự phụ thuộc)
            $this->db->prepare("DELETE FROM tour_destinations WHERE tour_id = :id")->execute([':id' => $id]);
            $this->db->prepare("DELETE FROM tour_images WHERE tour_id = :id")->execute([':id' => $id]);
            $this->db->prepare("DELETE FROM tour_departures WHERE tour_id = :id")->execute([':id' => $id]);
            $this->db->prepare("DELETE FROM tours WHERE id = :id")->execute([':id' => $id]);

            return true;
        } catch (PDOException $e) {
            // CẦN CÓ TRY/CATCH DÙ KHÔNG CÓ ROLLBACK
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
    public function getDepartures($tour_id)
    {
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
        return array_map(function ($dep) {
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

    public function getItineraryDetails($tour_id)
    {
        $sql = "SELECT id, day_number, time_slot, activity
            FROM itinerary_details 
            WHERE tour_id = :tour_id
            -- Sắp xếp theo ngày, sau đó sắp xếp theo giờ
            ORDER BY day_number ASC, time_slot ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tour_id' => $tour_id]);
        return $stmt->fetchAll();
    }

    /** Lưu Lịch trình Chi tiết (Day-by-Day schedule) */
    // TRONG TourModel.php::saveItineraryDetails()

private function saveItineraryDetails($tour_id, $details = [])
{
    // 1. XÓA TẤT CẢ LỊCH TRÌNH CŨ
    $this->db->prepare("DELETE FROM itinerary_details WHERE tour_id = :tour_id")
        ->execute([':tour_id' => $tour_id]);

    // 2. CHÈN LẠI CÁC BẢN GHI MỚI
    if (!empty($details)) {
        $sql = "INSERT INTO itinerary_details (tour_id, day_number, time_slot, activity)
            VALUES (:tour_id, :day_number, :time_slot, :activity)";
        $stmt = $this->db->prepare($sql);

        foreach ($details as $item) {
            $stmt->execute([
                ':tour_id'    => $tour_id,
                // SỬA: Dùng 0 nếu day_number rỗng (Vì là cột INT NOT NULL)
                ':day_number' => $item['day_number'] ?? 0, 
                // SỬA: Dùng NULL nếu time_slot rỗng (Vì là cột TIME/DATETIME, NULL an toàn hơn)
                ':time_slot'  => $item['time_slot'] ?? NULL,
                ':activity'   => $item['activity']
            ]);
        }
    }
}
}
