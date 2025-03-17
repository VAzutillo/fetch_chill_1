<?php
session_start();
header("Content-Type: application/json");

require_once  'appointment.php';
include 'pet_connection.php';
 // Assuming you have a User model

class AppointmentController {
    private $appointment;

    public function __construct() {
        $this->appointment = new Appointment();
    }

    // Get a specific appointment by ID
    public function GetAppointment($id) {
        $appointment = $this->appointment->GetAppointment($id);
        if ($appointment) {
            echo json_encode($appointment);
        } else {
            echo json_encode(['message' => 'No appointment found']);
        }
    }

    // Get all appointments
    public function GetAllAppointments() {
        $appointments = $this->appointment->GetAllAppointments();
        if ($appointments) {
            echo json_encode($appointments);
        } else {
            echo json_encode(['message' => 'No appointments found']);
        } 
    }

    // Create a new appointment
    public function CreateAppointment($input) {
    // Validate input
    if (empty($input['user_id']) || empty($input['service_type']) || empty($input['appointment_date']) || empty($input['appointment_time'])) {
        echo json_encode(['message' => 'All fields are required.']);
        return;
    }

    // Call the method to create the appointment
    $response = $this->appointment->CreateAppointments($input['user_id'], $input['service_type'], $input['appointment_date'], $input['appointment_time']);
    echo $response; // Output the response

        // Check if user exists
        $userId = $input['user_id'];
        if (!$this->isUserExists($userId)) { // Fixed method name
            echo json_encode(['message' => 'User  not found.']);
            return;
        }

        $service_type = $input['service_type'];
        $appointment_date = $input['appointment_date'];
        $appointment_time = $input['appointment_time'];

        // Call the method to create the appointment
        $this->appointment->CreateAppointments($userId, $service_type, $appointment_date, $appointment_time);
    }

    // Update the status of an appointment
    public function UpdateAppointmentsStatus($id, $input) {
        $appointment = $this->appointment->GetAppointment($id);
        if (!$appointment) {
            echo json_encode(['message' => 'No appointment found']);
            return;
        }

        if (empty($input['status'])) {
            echo json_encode(['message' => 'Status is required.']);
            return;
        }

        $status = $input['status'];
        $this->appointment->UpdateStatus($status, $id);
        echo json_encode(['message' => 'Appointment status updated']);
    }

    // Check if a user exists in the database
    private function isUserExists($userId) { // Fixed method name
        // Assuming you have a User model to check for user existence
        $userModel = new User(); // You need to create this model
        return $userModel->GetUserById($userId) !== null; // Fixed method name
    }
}
?>