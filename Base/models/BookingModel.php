<?php
// File: models/BookingModel.php

class BookingModel extends BaseModel
{
    protected $table = "bookings";

    // Hàm này sẽ được gọi khi có đơn đặt chỗ mới
    public function insertBooking($dataBooking, $customerDetails)
    {
        // CẢNH BÁO: KHÔNG SỬ DỤNG TRANSACTION. Dữ liệu có thể bị hỏng.

        // 1. INSERT vào bảng bookings (Đơn đặt hàng chính)
        $sqlBooking = "INSERT INTO {$this->table} 
                       (user_id, departure_id, total_price, status) 
                       VALUES (:user_id, :departure_id, :total_price, :status)";
        $stmt = $this->pdo->prepare($sqlBooking);
        $stmt->execute([
            ":user_id"      => $dataBooking['user_id'],
            ":departure_id" => $dataBooking['departure_id'],
            ":total_price"  => $dataBooking['total_price'],
            ":status"       => $dataBooking['status'] ?? 'Pending'
        ]);

        $bookingId = $this->pdo->lastInsertId();

        // 2. INSERT vào bảng booking_customers (Chi tiết từng khách)
        $sqlCustomer = "INSERT INTO booking_customers 
                        (booking_id, name, phone, special_note)
                        VALUES (:booking_id, :name, :phone, :special_note)";
        $stmtCustomer = $this->pdo->prepare($sqlCustomer);

        foreach ($customerDetails as $customer) {
            $stmtCustomer->execute([
                ":booking_id"    => $bookingId,
                ":name"          => $customer['name'],
                ":phone"         => $customer['phone'] ?? null,
                ":special_note"  => $customer['special_note'] ?? null,
            ]);
        }

        // 3. CẬP NHẬT TỒN KHO (Giảm available_slots)
        $this->updateInventory($dataBooking['departure_id'], count($customerDetails));

        return $bookingId;
    }

    // Hàm hỗ trợ giảm tồn kho (Phần quan trọng của Booking)
    private function updateInventory($departureId, $seatsBooked)
    {
        $sql = "UPDATE tour_departures 
                SET available_slots = available_slots - :seatsBooked
                WHERE id = :departureId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":seatsBooked" => $seatsBooked,
            ":departureId" => $departureId
        ]);
    }

    // --- CÁC HÀM CRUD CƠ BẢN ---

    public function getList()
    {
        // Lấy danh sách bookings, JOIN với tour_departures và users
        $sql = "SELECT b.*, td.start_date, t.name AS tour_name, u.name AS customer_name
                FROM bookings b
                JOIN tour_departures td ON b.departure_id = td.id
                JOIN tours t ON td.tour_id = t.id
                LEFT JOIN users u ON b.user_id = u.id
                ORDER BY b.booking_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Trong BookingModel.php

    public function getOne($id)
    {
        // 1. Truy vấn Booking chính (Đã bao gồm JOIN Tour/Departure)
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

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        $booking = $stmt->fetch(); // Lấy bản ghi chính

        if ($booking) {
            // 2. Lấy danh sách khách tham gia (MANIFEST) và chuẩn hóa dữ liệu
            $sqlCustomers = "SELECT * FROM booking_customers WHERE booking_id = :booking_id";
            $stmtCustomers = $this->pdo->prepare($sqlCustomers);
            $stmtCustomers->execute([':booking_id' => $id]);
            $customers = $stmtCustomers->fetchAll();

            // Đảm bảo luôn có mảng 'customers' và chuẩn hóa các trường được view sử dụng
            $normalized = [];
            foreach ($customers as $c) {
                $normalized[] = [
                    'id' => $c['id'] ?? null,
                    'name' => $c['name'] ?? ($c['full_name'] ?? 'Khách'),
                    'phone' => $c['phone'] ?? null,
                    'special_note' => $c['special_note'] ?? $c['note'] ?? null,
                    // Một số schema cũ có thể thiếu cột is_checked_in; mặc định là 0
                    'is_checked_in' => isset($c['is_checked_in']) ? (int) $c['is_checked_in'] : 0,
                ];
            }

            $booking['customers'] = $normalized;
        }

        return $booking;
    }

    public function update($id, $status, $total_price = null)
    {
        $sql = "UPDATE {$this->table} SET status = :status, total_price = :total_price WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":id" => $id,
            ":status" => $status,
            ":total_price" => $total_price
        ]);
    }

    public function delete($id)
    {
        // Xóa đơn đặt hàng (ON DELETE CASCADE sẽ xóa booking_customers)
        // CẦN THÊM LOGIC CẬP NHẬT LẠI TỒN KHO (Tăng available_slots) NẾU DÙNG HÀM NÀY
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
    }
}
