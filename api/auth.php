<?php
function authBySession(PDO $pdo): array {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        return ['error' => 'Unauthorized: No active session'];
    }

    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(401);
        return ['error' => 'User not found.'];
    }
    return $user;
}

function getUserColor($email) {
    if (empty($email)) return '#CCCCCC';

    $colors = [
        '#448521', '#6CB24A', '#8B26FF', '#3A7C96', '#964773', '#1F4846', '#AB89FC', '#953035', '#456988', '#5AA641', 
        '#033A9E', '#EDA8C9', '#A3385E', '#4F2620', '#C74627', '#4D56E9', '#B89205', '#3D69A9', '#967A9E', '#32A52F', 
        '#15180B', '#9162C3', '#FBC186', '#9D5099', '#CF529E', '#7CAD9E', '#3E82E1', '#2E2325', '#4DD3E6', '#E767C5', 
        '#A361E1', '#AC2F64', '#07AC32', '#0E6866', '#64B68A', '#AAB298', '#EC299C', '#32D174', '#F3319F', '#0CC1EC', 
        '#3465BD', '#622902', '#06E5F8', '#8C0D20', '#5A6EF0', '#C4D32A', '#DBCAA9', '#18E215', '#148887', '#9DEF4E', 
        '#F30927', '#8067F6', '#3EC787', '#933364', '#95777C', '#1ED829', '#6E161B', '#49DF9F', '#13A084', '#9BA8BD', 
        '#880355', '#19D090', '#9C6B15', '#21A022', '#FBDF19', '#79A563', '#45CE81', '#65E3D2', '#50E14E', '#96C554', 
        '#4C419A', '#343145', '#A0BC13', '#215B78', '#B7C159', '#411CFD', '#7C6EA4', '#EF334E', '#EF2E3E', '#79AF7C', 
        '#958EB6', '#2D7355', '#618D26', '#6F082F', '#3BD37E', '#8F81AB', '#54AFCE', '#BDBA38', '#35AE81', '#F4B45F', 
        '#21858C', '#ACA6E8', '#001BDF', '#CDD48A', '#EF0000', '#C30E2E', '#288D6C', '#239BFA', '#9D229D', '#9DBE4D'
    ];
    $colorIndex = ord($email[0]) % count($colors);
    return $colors[$colorIndex];
}
?>
