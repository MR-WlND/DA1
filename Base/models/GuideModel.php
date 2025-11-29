<?php 
class GuideModel extends BaseModel
{
    protected $table = 'users';
    public $pdo;

    public function __construct()
    {
        $this->pdo = (new BaseModel())->getConnection();
    }

    // =================================================================
    // 1. LẤY DANH SÁCH (JOIN users + guide_profiles)
    // Controller gọi: $guideModel->getListWithProfile();
    // =================================================================
    public function getListWithProfile()
    {
        // Sử dụng LEFT JOIN để lấy dữ liệu từ cả 2 bảng
        $sql = "SELECT u.id, u.name, u.email, u.phone, u.role, 
                       gp.photo_url, gp.experience_years, gp.languages, gp.category, 
                       gp.specialty_route, gp.specialty_group, gp.certification, 
                       gp.health_status, gp.notes, gp.date_of_birth
                FROM users u
                LEFT JOIN guide_profiles gp ON u.id = gp.user_id
                WHERE u.role = 'guide'
                ORDER BY u.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // =================================================================
    // 2. LẤY 1 HDV CHI TIẾT (JOIN users + guide_profiles)
    // Controller gọi: $guideModel->getOneWithProfile($id);
    // =================================================================
    public function getOneWithProfile($id)
    {
        $sql = "SELECT u.*, gp.*
                FROM users u
                LEFT JOIN guide_profiles gp ON u.id = gp.user_id
                WHERE u.id = :id AND u.role = 'guide'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // =================================================================
    // 3. THÊM VÀO BẢNG USERS (Trả về ID vừa tạo)
    // =================================================================
    public function insert($name, $email, $password, $phone)
    {
        // 1. Insert vào bảng users trước
        $sql = "INSERT INTO users (name, email, password, phone, role) 
                VALUES (:name, :email, :password, :phone, 'guide')";
        
        $stmt = $this->pdo->prepare($sql);
        $hashedPassword = md5($password);

        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':phone' => $phone
        ]);

        // 2. Trả về ID của user vừa tạo để dùng cho bảng profile
        return $this->pdo->lastInsertId();
    }

    // =================================================================
    // 4. THÊM VÀO BẢNG GUIDE_PROFILES
    // =================================================================
    public function insertProfile($data)
    {
        $sql = "INSERT INTO guide_profiles 
                (user_id, category, specialty_route, specialty_group, certification, 
                 health_status, notes, date_of_birth, photo_url, experience_years, languages)
                VALUES 
                (:user_id, :category, :specialty_route, :specialty_group, :certification, 
                 :health_status, :notes, :date_of_birth, :photo_url, :experience_years, :languages)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data); // $data là mảng truyền từ controller
    }

    // =================================================================
    // 5. CẬP NHẬT BẢNG USERS
    // =================================================================
    public function update($id, $name, $email, $password, $phone)
    {
        // Logic: Nếu không nhập pass thì giữ nguyên
        $passSql = "";
        $params = [
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone
        ];

        if (!empty($password)) {
            $passSql = ", password = :password";
            $params[':password'] = md5($password);
        }

        $sql = "UPDATE users SET 
                    name = :name,
                    email = :email,
                    phone = :phone
                    $passSql
                WHERE id = :id AND role = 'guide'";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    // =================================================================
    // 6. CẬP NHẬT BẢNG GUIDE_PROFILES
    // =================================================================
    public function updateProfile($id, $data)
    {
        // Kiểm tra xem user này đã có profile chưa
        $checkSql = "SELECT count(*) FROM guide_profiles WHERE user_id = :id";
        $checkStmt = $this->pdo->prepare($checkSql);
        $checkStmt->execute([':id' => $id]);
        
        if ($checkStmt->fetchColumn() > 0) {
            // Có rồi thì UPDATE
            $sql = "UPDATE guide_profiles SET 
                        category = :category,
                        specialty_route = :specialty_route,
                        specialty_group = :specialty_group,
                        certification = :certification,
                        health_status = :health_status,
                        notes = :notes,
                        date_of_birth = :date_of_birth,
                        photo_url = :photo_url,
                        experience_years = :experience_years,
                        languages = :languages
                    WHERE user_id = :id";
            
            // Thêm ID vào data để execute
            $data[':id'] = $id; 
            
            // Chuyển key mảng $data cho khớp với placeholder (thêm dấu :)
            $params = [
                ':id' => $id,
                ':category' => $data['category'],
                ':specialty_route' => $data['specialty_route'],
                ':specialty_group' => $data['specialty_group'],
                ':certification' => $data['certification'],
                ':health_status' => $data['health_status'],
                ':notes' => $data['notes'],
                ':date_of_birth' => $data['date_of_birth'],
                ':photo_url' => $data['photo_url'],
                ':experience_years' => $data['experience_years'],
                ':languages' => $data['languages']
            ];
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

        } else {
            // Chưa có thì INSERT (phòng trường hợp data cũ bị thiếu)
            $data['user_id'] = $id;
            $this->insertProfile($data);
        }
    }

    // =================================================================
    // 7. XÓA HDV
    // =================================================================
    public function delete($id)
    {
        // Xóa bảng users (nếu có foreign key cascade thì profile tự mất)
        $sql = "DELETE FROM users WHERE id = :id AND role = 'guide'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        // Xóa thủ công bảng profile để chắc chắn sạch rác
        $sqlProfile = "DELETE FROM guide_profiles WHERE user_id = :id";
        $stmtProfile = $this->pdo->prepare($sqlProfile);
        $stmtProfile->execute([':id' => $id]);
    }
}
?>