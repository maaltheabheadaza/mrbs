<?php
class HolidayAPI {
    private $api_key = 'E7TUGZduvZGrwj2s2vK8fCKEz9GB0ij87L5OFSkmOQ2KnEL4nv3O4eVpJcfs';
    private $base_url = 'https://ph-holiday-api.fly.dev/api';

    private function makeRequest($endpoint) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $this->api_key,
            'Content-Type: application/json'
        ]);
        
        // Enable verbose debug output
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            // Log the detailed error
            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);
            error_log("Curl verbose output:\n" . $verboseLog);
            error_log('Curl error: ' . curl_error($ch));
            curl_close($ch);
            return null;
        }
        
        // Log the response for debugging
        error_log("API Response (HTTP $httpCode): " . $response);
        
        curl_close($ch);
        fclose($verbose);
        
        if ($httpCode === 200) {
            return json_decode($response, true);
        }
        
        error_log("API request failed with status $httpCode: $response");
        return null;
    }

    public function isHoliday($date) {
        $dateObj = new DateTime($date);
        $year = $dateObj->format('Y');
        $month = $dateObj->format('m');
        $day = $dateObj->format('d');

        $response = $this->makeRequest("/holidays/$year/$month/$day");
        return !empty($response);
    }

    public function getHolidayInfo($date) {
        $dateObj = new DateTime($date);
        $year = $dateObj->format('Y');
        $month = $dateObj->format('m');
        $day = $dateObj->format('d');

        return $this->makeRequest("/holidays/$year/$month/$day");
    }

    public function getMonthHolidays($year, $month) {
        return $this->makeRequest("/holidays/$year/$month");
    }

    public function getYearHolidays($year) {
        return $this->makeRequest("/holidays/$year");
    }

    // Test method to verify API connection
    public function testConnection() {
        $currentYear = date('Y');
        $response = $this->makeRequest("/holidays/$currentYear");
        
        if ($response === null) {
            error_log("API test connection failed");
            return false;
        }
        
        error_log("API test connection successful. Response: " . print_r($response, true));
        return true;
    }
}

// Test the API connection when the file is loaded
$api = new HolidayAPI();
$api->testConnection();
?> 