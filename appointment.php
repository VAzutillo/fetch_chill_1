<?php
session_start();
header("Content-Type: application/json");
require_once 'pet_connection.php';

class Appointment {
    private $conn;

    public function __construct() {
        $this->conn = PetDatabase::getInstance();
    }

    // Get appointment of specific owner
    public function GetAppointment($id) {
        $stmt = $this->conn->prepare("SELECT * FROM appointments WHERE id = ?");
        if ($stmt === false) {
            throw new mysqli_sql_exception("Prepare statement failed: " . $this->conn->error);
        }
        $stmt->bind_param('i', $id);
        if ($stmt->execute() === false) {
            throw new mysqli_sql_exception("Execute statement failed: " . $stmt->error);
        }
        $result = $stmt->get_result();
        $appointment = $result->fetch_assoc();
        $stmt->close();
        return $appointment;
    }

    // Fetch all appointments
    public function GetAllAppointments() {
        $query = "SELECT * FROM appointments";
        $result = $this->conn->query($query);
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Creating new appointments
    public function CreateAppointments($user_id, $service_type, $appointment_date, $appointment_time) { 
        $query = "INSERT INTO appointments (user_id, service_type, appointment_date, appointment_time) VALUES (?, ?, ?, ?)";
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("isss", $user_id, $service_type, $appointment_date, $appointment_time);
            if ($stmt->execute()) {
                return json_encode(['message' => 'Appointment created successfully']);
            } else {
                return json_encode(['message' => 'Error: ' . $this->conn->error]);
            }
            $stmt->close();
        } else {
            return json_encode(['message' => 'Prepare statement failed: ' . $this->conn->error]);
        }
    }

    // Update appointment status
    public function UpdateStatus($status, $id) {
        $stmt = $this->conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        if ($stmt === false) {
            throw new mysqli_sql_exception("Prepare statement failed: " . $this->conn->error);
        }
        $stmt->bind_param('si', $status, $id);
        if ($stmt->execute() === false) {
            throw new mysqli_sql_exception("Execute statement failed: " . $stmt->error);
        }
        $stmt->close();
    }
}
?>