<?php
    function log_audit_trail($event_type, $description, $username, $user_role){
        try{
            $conn = conn::getConnection();
            $query = $conn->prepare("INSERT INTO `audit_trail` (`event_type`, `description`, `datetime`, `username`,`user_type`)
                            VALUES 
                            (:event_type, :description, NOW(), :username, :user_type)");
            $query->execute([
                ':event_type' => $event_type,
                ':description' => $description,
                ':username' => $username,
                ':user_type' => $user_role
        ]);
        } catch(Exception $e){
            echo "Error: ".$e->getMessage();
        }
    }
    function isUniqueStaffIDAdmin($connection, $staff_id) {
        $query = $connection->prepare("SELECT COUNT(*) as count FROM admin WHERE staff_id = :staff_id");
        $query->execute([':staff_id' => $staff_id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0; 
        
    }
    function isUniqueStaffIDDoc($connection, $staff_id) {
        $query = $connection->prepare("SELECT COUNT(*) as count FROM doctor WHERE staff_id = :staff_id");
        $query->execute([':staff_id' => $staff_id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0; 
    }
    function isUniqueStaffIDLab($connection, $staff_id) {
        $query = $connection->prepare("SELECT COUNT(*) as count FROM lab_technician WHERE staff_id = :staff_id");
        $query->execute([':staff_id' => $staff_id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0; 
    }
    function isUniqueStaffIDRecptionist($connection, $staff_id) {
        $query = $connection->prepare("SELECT COUNT(*) as count FROM receptionist WHERE staff_id = :staff_id");
        $query->execute([':staff_id' => $staff_id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0; 
    }
    function isUniqueStaffIDPharamacist($connection, $staff_id) {
        $query = $connection->prepare("SELECT COUNT(*) as count FROM pharmacist WHERE staff_id = :staff_id");
        $query->execute([':staff_id' => $staff_id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0; 
    }

    function isUniqueUsername($connection, $username) {
        $query = $connection->prepare("SELECT COUNT(*) as count FROM user WHERE username = :username");
        $query->execute([':username' => $username]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0;
    }
?>