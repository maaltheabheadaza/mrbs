<?php
require_once __DIR__ . '/holiday_api.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if (!isset($_GET['date'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Date parameter is required']);
    exit;
}

try {
    $date = $_GET['date'];
    $holidayAPI = new HolidayAPI();
    
    // Get holiday information for the specific date
    $holidayInfo = $holidayAPI->getHolidayInfo($date);
    
    // Log the response for debugging
    error_log("Holiday check for date $date: " . print_r($holidayInfo, true));
    
    if ($holidayInfo === null) {
        echo json_encode([
            'isHoliday' => false,
            'name' => null,
            'type' => null,
            'date' => $date
        ]);
    } else {
        // The API returns an array for a specific date
        echo json_encode([
            'isHoliday' => true,
            'name' => $holidayInfo[0]['name'] ?? null,
            'type' => $holidayInfo[0]['type'] ?? null,
            'date' => $holidayInfo[0]['date'] ?? $date
        ]);
    }
} catch (Exception $e) {
    error_log("Error in check_holiday.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => 'Internal server error',
        'message' => $e->getMessage()
    ]);
}
?> 