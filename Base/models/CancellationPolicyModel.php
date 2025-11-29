<?php
class CancellationPolicyModel {
    public $db;

    public function __construct() {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    public function getList() {
        $sql = "SELECT * FROM cancellation_policies";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insert($policy_name, $details) {
        $sql = "INSERT INTO `cancellation_policies`(`policy_name`, `details`)
                VALUES (:policy_name, :details)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':policy_name' => $policy_name,
            ':details'     => $details,
        ]);
    }

    public function getOne($id) {
        $sql = "SELECT * FROM cancellation_policies WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function update($id, $policy_name, $details) {
        $sql = "UPDATE `cancellation_policies` SET
                `policy_name` = :policy_name,
                `details` = :details
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id'          => $id,
            ':policy_name' => $policy_name,
            ':details'     => $details
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM `cancellation_policies` WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
