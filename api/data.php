<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$dataFile = '/tmp/data.json';

if (!file_exists($dataFile)) {
    $defaultRoles = [
        '丛云添', '大黑可不可', '西园练牙', '神名雪风', '鹿礼光',
        '斜木七基', '衣川季助', '五十竹芥太', '久乐间潮', '夏烧千弥',
        '畔川几成', '北片来人', '木之内太绪', '百目鬼潜', '白光琉衣',
        '白光潜衣', '蜂乃屋凪', '夜半', '辉矢宗氏'
    ];
    
    $inventory = [];
    foreach ($defaultRoles as $role) {
        $inventory[$role] = ['total' => 320, 'remaining' => 320];
    }
    
    $defaultData = [
        'roles' => $defaultRoles,
        'inventory' => $inventory,
        'orders' => []
    ];
    
    file_put_contents($dataFile, json_encode($defaultData, JSON_UNESCAPED_UNICODE));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = json_decode(file_get_contents($dataFile), true);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input) {
        file_put_contents($dataFile, json_encode($input, JSON_UNESCAPED_UNICODE));
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => '无效的数据']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['error' => '不支持的请求方法']);
?>
Add api/data.php for Vercel deployment
