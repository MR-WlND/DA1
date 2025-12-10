<?php
// File: models/CustomTourRequestModel.php

class CustomTourRequestModel extends BaseModel
{
    public $db;

    public function __construct()
    {
        $baseModel = new BaseModel(); 
        $this->db = $baseModel->getConnection();
    }
    
    // ------------------------------------------------------------------------
    // --- PHƯƠNG THỨC GETTERS (TRUY VẤN DỮ LIỆU) ---
    // ------------------------------------------------------------------------
    
    public function getListRequests()
    {
        $sql = "SELECT 
                r.*, u.name AS user_name, u.email AS user_account_email
            FROM custom_tour_requests r
            LEFT JOIN users u ON r.user_id = u.id
            ORDER BY r.request_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getQuotesByRequestId($requestId) {
        $sql = "SELECT q.*, s.name AS staff_name
                FROM custom_tour_quotes q
                LEFT JOIN users s ON q.staff_id = s.id
                WHERE q.request_id = :request_id
                ORDER BY q.quote_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':request_id' => $requestId]);
        return $stmt->fetchAll();
    }

    public function getRequestDetail($id) {
        $sql = "SELECT r.*, u.name AS user_name, u.email AS user_account_email
                FROM custom_tour_requests r
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $request = $stmt->fetch();

        if ($request) {
            $request['quotes'] = $this->getQuotesByRequestId($id);
        }
        return $request;
    }

    public function getRequestsAndQuotesByUserId($userId)
    {
        $sql = "SELECT 
                r.id AS request_id, r.request_status, r.destination_notes, r.num_people,
                q.id AS quote_id, q.final_price, q.valid_until, q.itinerary_draft, q.quote_status, q.quote_date
            FROM custom_tour_requests r
            LEFT JOIN custom_tour_quotes q ON r.id = q.request_id
            WHERE r.user_id = :user_id
            ORDER BY r.request_date DESC, q.quote_date DESC";
            
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    // ------------------------------------------------------------------------
    // --- PHƯƠNG THỨC MUTATORS (THAY ĐỔI DỮ LIỆU) ---
    // ------------------------------------------------------------------------

    public function insertRequest(array $data): bool
    {
        $sql = "INSERT INTO custom_tour_requests (
            user_id, customer_name, customer_email, customer_phone, 
            num_people, desired_start_date, destination_notes, budget_range
        ) VALUES (
            :user_id, :name, :email, :phone, 
            :num_people, :start_date, :notes, :budget
        )";

        $user_id = $_SESSION['user']['id'] ?? null; 
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':user_id' => $user_id,
            ':name' => $data['customer_name'] ?? null,
            ':email' => $data['customer_email'] ?? null,
            ':phone' => $data['customer_phone'] ?? null,
            ':num_people' => $data['num_people'] ?? 1,
            ':start_date' => $data['desired_start_date'] ?? null,
            ':notes' => $data['destination_notes'] ?? null,
            ':budget' => $data['budget_range'] ?? null 
        ]);
    }

    /**
     * Lưu báo giá mới do Staff/Admin tạo
     */
    public function insertQuote(array $data, $staffId): bool
    {
        $sql = "INSERT INTO custom_tour_quotes (
            request_id, staff_id, valid_until, final_price, 
            itinerary_draft, quote_status
        ) VALUES (
            :request_id, :staff_id, :valid_until, :final_price, 
            :itinerary_draft, 'Sent'
        )";

        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':request_id' => $data['request_id'],
            ':staff_id' => $staffId, 
            ':valid_until' => $data['valid_until'],
            ':final_price' => $data['final_price'],
            ':itinerary_draft' => $data['itinerary_draft']
        ]);
    }

    /**
     * Cập nhật trạng thái của một yêu cầu tùy chỉnh
     */
    public function updateRequestStatus($requestId, $status): bool
    {
        $sql = "UPDATE custom_tour_requests SET request_status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id' => $requestId
        ]);
    }
}