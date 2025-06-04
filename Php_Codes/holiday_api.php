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
        
        // Set timeout to prevent hanging
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            error_log('Curl error: ' . curl_error($ch));
            curl_close($ch);
            return null;
        }
        
        curl_close($ch);
        
        if ($httpCode === 200) {
            $decoded = json_decode($response, true);
            error_log("API Response: " . print_r($decoded, true));
            return $decoded;
        }
        
        error_log("API request failed with status $httpCode: $response");
        return null;
    }

    public function isHoliday($date) {
        try {
            $dateObj = new DateTime($date);
            $year = $dateObj->format('Y');
            $month = $dateObj->format('m');
            $day = $dateObj->format('d');

            $response = $this->makeRequest("/holidays/$year/$month/$day");
            
            // Check if response is valid and contains holiday data
            if (is_array($response) && !empty($response)) {
                foreach ($response as $holiday) {
                    if (isset($holiday['date']) && $holiday['date'] === $date) {
                        return true;
                    }
                }
            }
            return false;
        } catch (Exception $e) {
            error_log("Error in isHoliday: " . $e->getMessage());
            return false;
        }
    }

    public function getHolidayInfo($date) {
        try {
            $dateObj = new DateTime($date);
            $year = $dateObj->format('Y');
            $month = $dateObj->format('m');
            $day = $dateObj->format('d');

            $response = $this->makeRequest("/holidays/$year/$month/$day");
            
            if (is_array($response) && !empty($response)) {
                foreach ($response as $holiday) {
                    if (isset($holiday['date']) && $holiday['date'] === $date) {
                        return [$holiday];
                    }
                }
            }
            return null;
        } catch (Exception $e) {
            error_log("Error in getHolidayInfo: " . $e->getMessage());
            return null;
        }
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