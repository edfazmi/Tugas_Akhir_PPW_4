<?php

define('DUMMY_USERNAME', 'edfa');
define('DUMMY_PASSWORD', 'admin123');

/**
 * @return array
 */
function get_initial_dummy_contacts() {
    return [
        [
            'id' => 'contact_' . uniqid(),
            'nama' => 'M. Azmi',
            'email' => 'azmi@edfa.com',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Durian, Bandar Lampung'
        ],
        [
            'id' => 'contact_' . uniqid(),
            'nama' => 'Edfa Alhafizh',
            'email' => 'edfa@edfa.com',
            'telepon' => '089876543210',
            'alamat' => 'Jl. Mangga, Bandar Lampung'
        ]
    ];
}

/**
 * @param string $username
 * @param string $password
 * @return bool
 */
function login_user($username, $password) {
    if ($username === DUMMY_USERNAME && $password === DUMMY_PASSWORD) {
        $_SESSION['user_id'] = $username;
        $_SESSION['contacts'] = get_initial_dummy_contacts();
        return true;
    }
    
    return false;
}

/**
 * @return bool
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * @return string|null
 */
function get_current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

function force_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
?>