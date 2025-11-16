<?php

/**
 * @param string $user_id 
 * @return array
 */
function get_user_contacts($user_id) {
    return $_SESSION['contacts'] ?? [];
}

/**
 * @param string $user_id 
 * @param array $data
 */
function add_contact($user_id, $data) {
    $user_contacts = get_user_contacts(null);
    
    $data['id'] = 'contact_' . uniqid();
    $user_contacts[] = $data;
    
    $_SESSION['contacts'] = $user_contacts;
}

/**
 * @param string $user_id
 * @param string $contact_id
 * @return array|null
 */
function get_contact_by_id($user_id, $contact_id) {
    $user_contacts = get_user_contacts(null);
    foreach ($user_contacts as $contact) {
        if ($contact['id'] === $contact_id) {
            return $contact;
        }
    }
    return null;
}

/**
 * @param string $user_id
 * @param string $contact_id
 * @param array $data
 * @return bool
 */
function update_contact($user_id, $contact_id, $data) {
    $user_contacts = get_user_contacts(null);
    
    $found = false;
    foreach ($user_contacts as $index => $contact) {
        if ($contact['id'] === $contact_id) {
            $user_contacts[$index] = array_merge($contact, $data);
            $found = true;
            break;
        }
    }
    
    if ($found) {
        $_SESSION['contacts'] = $user_contacts;
        return true;
    }
    
    return false;
}

/**
 * @param string $user_id 
 * @param string $contact_id
 * @return bool
 */
function delete_contact($user_id, $contact_id) {
    $user_contacts = get_user_contacts(null);
    
    $new_contacts = [];
    $found = false;
    foreach ($user_contacts as $contact) {
        if ($contact['id'] === $contact_id) {
            $found = true;
        } else {
            $new_contacts[] = $contact;
        }
    }
    
    if ($found) {
        $_SESSION['contacts'] = $new_contacts;
        return true;
    }
    
    return false;
}
?>