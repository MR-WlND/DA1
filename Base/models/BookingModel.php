<?php
// File: models/BookingModel.php

class BookingModel extends BaseModel
{
    protected $table = "bookings";
    public $db;

    public function __construct()
    {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    // Thêm đơn đặt tour mới
    public function insertBooking($dataBooking, $customerDetails)
    {
        // 1. INSERT bookings: đổi "status" thành "payment_status"
        $sqlBooking = "INSERT INTO {$this->table} 
                       (user_id, departure_id, total_price, payment_status) 
                       VALUES (:user_id, :departure_id, :total_price, :payment_status)";
        $stmt = $this->db->prepare($sqlBooking);
        $stmt->execute([
            ":user_id"         => $dataBooking['user_id'],
            ":departure_id"    => $dataBooking['departure_id'],
            ":total_price"     => $dataBooking['total_price'],
            ":payment_status"  => 'Pending'
        ]);

        $bookingId = $this->db->lastInsertId();

        // 2. INSERT booking_customers
        $sqlCustomer = "INSERT INTO booking_customers 
                 (booking_id, name, phone, special_note, date_of_birth) 
                 VALUES (:booking_id, :name, :phone, :special_note, :dob)";
        $stmtCustomer = $this->db->prepare($sqlCustomer);

        foreach ($customerDetails as $customer) {
            $stmtCustomer->execute([
                ":booking_id"    => $bookingId,
                ":name"          => $customer['name'],
                ":phone"         => $customer['phone'] ?? null,
                ":special_note"  => $customer['special_note'] ?? null,
                ":dob"           => $customer['date_of_birth'] ?? null,
            ]);
        }

        // 3. Giảm tồn kho
        $this->updateInventory($dataBooking['departure_id'], count($customerDetails));

        return $bookingId;
    }

    // Giảm số ghế trống
    private function updateInventory($departureId, $seatsBooked)
    {
        $sql = "UPDATE tour_departures 
                SET available_slots = available_slots - :seatsBooked
                WHERE id = :departureId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":seatsBooked" => $seatsBooked,
            ":departureId" => $departureId
        ]);
    }

    // Lấy danh sách booking
    public function getList()
    {
        $sql = "SELECT b.*, td.start_date, t.name AS tour_name, u.name AS customer_name
                FROM bookings b
                JOIN tour_departures td ON b.departure_id = td.id
                JOIN tours t ON td.tour_id = t.id
                LEFT JOIN users u ON b.user_id = u.id
                ORDER BY b.booking_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy 1 booking theo ID
    public function getOne($id)
    {
        $sql = "SELECT 
                b.*, 
                td.start_date, 
                td.end_date, 
                t.name AS tour_name, 
                u.name AS customer_name
            FROM bookings b
            JOIN tour_departures td ON b.departure_id = td.id
            JOIN tours t ON td.tour_id = t.id
            LEFT JOIN users u ON b.user_id = u.id
            WHERE b.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        $booking = $stmt->fetch();

        if ($booking) {
            // Lấy khách
            $sqlCustomers = "SELECT * FROM booking_customers WHERE booking_id = :booking_id";
            $stmtCustomers = $this->db->prepare($sqlCustomers);
            $stmtCustomers->execute([':booking_id' => $id]);
            $customers = $stmtCustomers->fetchAll();

            $normalized = [];
            foreach ($customers as $c) {
                $normalized[] = [
                    'id' => $c['id'] ?? null,
                    'name' => $c['name'] ?? 'Khách',
                    'phone' => $c['phone'] ?? null,
                    'special_note' => $c['special_note'] ?? null,
                    'date_of_birth' => $c['date_of_birth'] ?? null,
                    'is_checked_in' => isset($c['is_checked_in']) ? (int)$c['is_checked_in'] : 0,
                ];
            }

            $booking['customers'] = $normalized;
        }

        return $booking;
    }

    // Cập nhật tổng tiền (KHÔNG ĐỤNG ĐẾN STATUS NỮA)
    public function update($id, $total_price)
    {
        $sql = "UPDATE {$this->table} 
                SET total_price = :total_price 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":id" => $id,
            ":total_price" => $total_price
        ]);
    }

    // Xóa booking
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
    }

    // Cập nhật trạng thái thanh toán
    public function updatePaymentStatus($bookingId, $paymentStatus, $transactionId)
    {
        $sql = "UPDATE bookings 
                SET payment_status = :payment_status, 
                    transaction_id = :transaction_id, 
                    payment_date = NOW()
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':payment_status' => $paymentStatus,
            ':transaction_id' => $transactionId,
            ':id' => $bookingId
        ]);
    }

    public function find($id)
    {
        $sql = "
        SELECT 
            b.*,
            -- TÍNH SỐ LƯỢNG KHÁCH
            (SELECT COUNT(bc.id) 
             FROM booking_customers bc 
             WHERE bc.booking_id = b.id) AS customer_count,
            
            -- Thông tin từ các bảng JOIN
            u.name AS customer_name,
            u.email AS customer_email,
            u.phone AS customer_phone, 
            t.name AS tour_name,
            td.start_date AS departure_date 

        FROM bookings b
        LEFT JOIN users u ON u.id = b.user_id
        LEFT JOIN tour_departures td ON td.id = b.departure_id 
        LEFT JOIN tours t ON t.id = td.tour_id
        
        WHERE b.id = :id
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateBookingDetails($id, $totalPrice, $departureId, $userId, $paymentStatus)
{
    $sql = "UPDATE {$this->table} 
            SET total_price = :total_price, 
                departure_id = :departure_id,
                user_id = :user_id,
                payment_status = :payment_status,
                last_status_change = NOW()  -- Ghi lại thời gian cập nhật trạng thái
            WHERE id = :id";
            
    $stmt = $this->db->prepare($sql);
    
    return $stmt->execute([
        ":id" => $id,
        ":total_price" => $totalPrice,
        ":departure_id" => $departureId,
        ":user_id" => $userId,
        ":payment_status" => $paymentStatus
    ]);
}
public function getRecent(int $limit = 5)
{
    // Truy vấn này tương tự getList(), nhưng có thêm LIMIT và ORDER BY
    $sql = "SELECT 
                b.id, 
                b.total_price, 
                b.booking_date, 
                b.payment_status, 
                t.name AS tour_name,
                td.start_date
            FROM bookings b
            JOIN tour_departures td ON b.departure_id = td.id
            JOIN tours t ON td.tour_id = t.id
            -- KHÔNG cần JOIN users để tăng tốc độ truy vấn
            ORDER BY b.booking_date DESC
            LIMIT :limit";

    $stmt = $this->db->prepare($sql);
    
    // Lưu ý: LIMIT trong PDO cần bindParam với kiểu dữ liệu INT
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
