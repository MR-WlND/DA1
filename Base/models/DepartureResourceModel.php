<?php
// File: models/DepartureResourceModel.php

class DepartureResourceModel extends BaseModel
{
    public $db; 

    public function __construct()
    {
        $baseModel = new BaseModel();
        // Giữ lại kết nối DB thủ công
        $this->db = $baseModel->getConnection();
    }
    
    // --- GETTERS (Nối Đa hình) ---

    /** Lấy danh sách phân công, hiển thị tên tài nguyên */
    public function getList()
    {
        // Sử dụng tên bảng cố định "departure_resources"
        $sql = "
            SELECT 
                dr.*,
                td.start_date,
                t.name AS tour_name,
                
                -- HIỂN THỊ TÊN TÀI NGUYÊN
                CASE dr.resource_type
                    WHEN 'guide' THEN u.name
                    WHEN 'hotel' THEN h.name
                    WHEN 'transport' THEN ts.supplier_name
                    ELSE dr.details
                END AS resource_name,
                
                td.current_price AS departure_price
            FROM departure_resources dr 
            JOIN tour_departures td ON dr.departure_id = td.id
            JOIN tours t ON td.tour_id = t.id
            
            -- Nối Có Điều kiện
            LEFT JOIN users u ON dr.resource_id = u.id AND dr.resource_type = 'guide'
            LEFT JOIN hotels h ON dr.resource_id = h.id AND dr.resource_type = 'hotel'
            LEFT JOIN transport_suppliers ts ON dr.resource_id = ts.id AND dr.resource_type = 'transport'
            
            ORDER BY dr.departure_id DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /** Lấy chi tiết 1 bản ghi phân công */
    public function getOne($id)
    {
        $sql = "
            SELECT dr.*,
                CASE dr.resource_type
                    WHEN 'guide' THEN u.name
                    WHEN 'hotel' THEN h.name
                    WHEN 'transport' THEN ts.supplier_name
                    ELSE dr.details
                END AS resource_name
            FROM departure_resources dr 
            LEFT JOIN users u ON dr.resource_id = u.id AND dr.resource_type = 'guide'
            LEFT JOIN hotels h ON dr.resource_id = h.id AND dr.resource_type = 'hotel'
            LEFT JOIN transport_suppliers ts ON dr.resource_id = ts.id AND dr.resource_type = 'transport'
            WHERE dr.id = :id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // --- CÁC HÀM CRUD CƠ BẢN ---

    public function insert($departure_id, $resource_type, $resource_id, $details, $cost)
    {
        $sql = "INSERT INTO departure_resources (departure_id, resource_type, resource_id, details, cost)
                VALUES (:departure_id, :resource_type, :resource_id, :details, :cost)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':departure_id' => $departure_id,
            ':resource_type' => $resource_type,
            ':resource_id' => $resource_id,
            ':details' => $details,
            ':cost' => $cost
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $departure_id, $resource_type, $resource_id, $details, $cost)
    {
        $sql = "UPDATE departure_resources SET departure_id=:departure_id, resource_type=:resource_type, 
                resource_id=:resource_id, details=:details, cost=:cost WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':departure_id' => $departure_id,
            ':resource_type' => $resource_type,
            ':resource_id' => $resource_id,
            ':details' => $details,
            ':cost' => $cost
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM departure_resources WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}