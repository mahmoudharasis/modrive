<?php

// File Sharing API Endpoints

header('Content-Type: application/json');

// Dummy data for shares
$shares = [];

// Create share
function createShare($data) {
    global $shares;
    $shareId = count($shares) + 1;
    $data['id'] = $shareId;
    $shares[] = $data;
    return $data;
}

// List shares
function listShares() {
    global $shares;
    return $shares;
}

// Update share
function updateShare($id, $data) {
    global $shares;
    foreach ($shares as &$share) {
        if ($share['id'] == $id) {
            $share = array_merge($share, $data);
            return $share;
        }
    }
    return null;
}

// Delete share
function deleteShare($id) {
    global $shares;
    foreach ($shares as $key => $share) {
        if ($share['id'] == $id) {
            unset($shares[$key]);
            return true;
        }
    }
    return false;
}

// Routing
$requestMethod = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

switch ($requestMethod) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $response = createShare($data);
        echo json_encode($response);
        break;
    case 'GET':
        $response = listShares();
        echo json_encode($response);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $uri[2];
        $response = updateShare($id, $data);
        echo json_encode($response);
        break;
    case 'DELETE':
        $id = $uri[2];
        $response = deleteShare($id);
        echo json_encode(['deleted' => $response]);
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
}
?>
