<?php
session_start();
require_once __DIR__ . '/../auth_api.php';

$auth_api = new UserAuthAPI('ak_9b668ca54c3669ef57fe218fa4f51773');

// Call the logout API endpoint
$response = $auth_api->logout();

// Clear all session data
session_unset();
session_destroy();

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'message' => 'You have been successfully logged out.',
    'data' => $response['data'] ?? null
]); 