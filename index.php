<?php
session_start();

// 数据文件路径
$usersFile = sys_get_temp_dir() . '/stock_game_users.json';
$stocksFile = sys_get_temp_dir() . '/stock_game_stocks.json';
$timerFile = sys_get_temp_dir() . '/stock_game_timer.json';
$messagesFile = sys_get_temp_dir() . '/stock_game_messages.json';
$settingsFile = sys_get_temp_dir() . '/stock_game_settings.json';
$eventsFile = sys_get_temp_dir() . '/stock_game_events.json';

// 预设股票类型
$presetStockTypes = [
    '科技', '互联网', '酒业', '新能源', '汽车制造', 
    '银行', '金融', '制造业', '家电', '消费品',
    '医药', '房地产', '传媒', '旅游', '食品',
    '军工', '航天', '农业', '教育', '物流'
];

// 初始化股票数据
$initialStocks = [
    ['id' => 1, 'name' => '星辰科技', 'type' => '科技', 'price' => 320.5, 'high' => 325.8, 'low' => 318.2, 'volume' => 125800, 'change' => 1.2, 'created_by' => 'system', 'total_shares' => 1000000, 'circulating_shares' => 1000000],
    ['id' => 2, 'name' => '远航互联', 'type' => '互联网', 'price' => 85.6, 'high' => 87.2, 'low' => 84.1, 'volume' => 98500, 'change' => -0.8, 'created_by' => 'system', 'total_shares' => 1000000, 'circulating_shares' => 1000000],
    ['id' => 3, 'name' => '盛世酒业', 'type' => '酒业', 'price' => 1850.3, 'high' => 1865.5, 'low' => 1840.2, 'volume' => 45200, 'change' => 0.5, 'created_by' => 'system', 'total_shares' => 1000000, 'circulating_shares' => 1000000],
    ['id' => 4, 'name' => '绿能动力', 'type' => '新能源', 'price' => 285.7, 'high' => 290.1, 'low' => 282.3, 'volume' => 156300, 'change' => 2.1, 'created_by' => 'system', 'total_shares' => 1000000, 'circulating_shares' => 1000000],
    ['id' => 5, 'name' => '未来汽车', 'type' => '汽车制造', 'price' => 258.9, 'high' => 262.5, 'low' => 256.8, 'volume' => 189500, 'change' => -1.5, 'created_by' => 'system', 'total_shares' => 1000000, 'circulating_shares' => 1000000],
    ['id' => 6, 'name' => '恒信银行', 'type' => '银行', 'price' => 38.2, 'high' => 38.8, 'low' => 37.9, 'volume' => 215600, 'change' => 0.3, 'created_by' => 'system', 'total_shares' => 1000000, 'circulating_shares' => 1000000],
    ['id' => 7, 'name' => '安泰保险', 'type' => '金融', 'price' => 42.8, 'high' => 43.2, 'low' => 42.5, 'volume' => 178900, 'change' => -0.4, 'created_by' => 'system', 'total_shares' => 1000000, 'circulating_shares' => 1000000],
    ['id' => 8, 'name' => '华宇制造', 'type' => '制造业', 'price' => 68.5, 'high' => 69.2, 'low' => 67.8, 'volume' => 89700, 'change' => 0.9, 'created_by' => 'system', 'total_shares' => 1000000, 'circulating_shares' => 1000000],
    ['id' => 9, 'name' => '佳家电器', 'type' => '家电', 'price' => 35.7, 'high' => 36.1, 'low' => 35.3, 'volume' => 78500, 'change' => -0.2, 'created_by' => 'system', 'total_shares' => 1000000, 'circulating_shares' => 1000000],
    ['id' => 10, 'name' => '乐享生活', 'type' => '消费品', 'price' => 45.8, 'high' => 46.5, 'low' => 45.2, 'volume' => 65400, 'change' => 1.8, 'created_by' => 'system', 'total_shares' => 1000000, 'circulating_shares' => 1000000]
];

// 初始化突发事件数据
$initialEvents = [
    [
        'id' => 1,
        'name' => '政策利好',
        'description' => '国家出台新政策，利好新能源行业，相关股票涨幅大幅提升！',
        'type' => 'rise',
        'stockTypes' => ['新能源', '汽车制造'],
        'multiplier' => 3,
        'created_by' => 'system'
    ],
    [
        'id' => 2,
        'name' => '行业利空',
        'description' => '原材料价格暴涨，制造业成本大幅上升，相关股票跌幅加大！',
        'type' => 'fall',
        'stockTypes' => ['制造业', '家电'],
        'multiplier' => 3,
        'created_by' => 'system'
    ],
    [
        'id' => 3,
        'name' => '业绩暴增',
        'description' => '多家科技公司发布超预期财报，股价应声大涨！',
        'type' => 'rise',
        'stockTypes' => ['科技', '互联网'],
        'multiplier' => 2.5,
        'created_by' => 'system'
    ],
    [
        'id' => 4,
        'name' => '市场恐慌',
        'description' => '国际局势紧张，金融板块受到冲击，股价大幅下跌！',
        'type' => 'fall',
        'stockTypes' => ['金融', '银行'],
        'multiplier' => 2.5,
        'created_by' => 'system'
    ],
    [
        'id' => 5,
        'name' => '消费升级',
        'description' => '消费市场复苏，高端消费品需求激增，相关股票上涨！',
        'type' => 'rise',
        'stockTypes' => ['消费品', '酒业'],
        'multiplier' => 2,
        'created_by' => 'system'
    ],
    [
        'id' => 6,
        'name' => '产能过剩',
        'description' => '行业产能过剩问题凸显，相关企业股价承压下跌！',
        'type' => 'fall',
        'stockTypes' => ['制造业', '电器'],
        'multiplier' => 2,
        'created_by' => 'system'
    ]
];

// 工具函数
function getUsers() {
    global $usersFile;
    if (!file_exists($usersFile)) return [];
    $content = file_get_contents($usersFile);
    return $content ? json_decode($content, true) : [];
}

function saveUsers($users) {
    global $usersFile;
    file_put_contents($usersFile, json_encode($users, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    chmod($usersFile, 0666);
}

function getStocks() {
    global $stocksFile;
    if (!file_exists($stocksFile)) return [];
    $content = file_get_contents($stocksFile);
    return $content ? json_decode($content, true) : [];
}

function saveStocks($stocks) {
    global $stocksFile;
    file_put_contents($stocksFile, json_encode($stocks, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    chmod($stocksFile, 0666);
}

function getTimer() {
    global $timerFile;
    $default = [
        'last_update' => time(),
        'next_update' => time() + 180,
        'last_interest' => time()
    ];
    
    if (!file_exists($timerFile)) {
        file_put_contents($timerFile, json_encode($default));
        chmod($timerFile, 0666);
        return $default;
    }
    
    $content = file_get_contents($timerFile);
    return $content ? json_decode($content, true) : $default;
}

function saveTimer($timer) {
    global $timerFile;
    file_put_contents($timerFile, json_encode($timer));
    chmod($timerFile, 0666);
}

// 获取聊天消息
function getMessages() {
    global $messagesFile;
    if (!file_exists($messagesFile)) return [];
    $content = file_get_contents($messagesFile);
    return $content ? json_decode($content, true) : [];
}

// 保存聊天消息
function saveMessages($messages) {
    global $messagesFile;
    // 只保留最近200条消息
    if (count($messages) > 200) {
        $messages = array_slice($messages, -200);
    }
    file_put_contents($messagesFile, json_encode($messages, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    chmod($messagesFile, 0666);
}

// 添加聊天消息
function addMessage($username, $nickname, $content) {
    $messages = getMessages();
    $messages[] = [
        'username' => $username,
        'nickname' => $nickname,
        'content' => htmlspecialchars($content),
        'time' => time()
    ];
    saveMessages($messages);
    return $messages;
}

// 获取设置
function getSettings() {
    global $settingsFile;
    $default = [
        'barrage_enabled' => false
    ];
    
    if (!file_exists($settingsFile)) {
        file_put_contents($settingsFile, json_encode($default));
        chmod($settingsFile, 0666);
        return $default;
    }
    
    $content = file_get_contents($settingsFile);
    return $content ? json_decode($content, true) : $default;
}

// 保存设置
function saveSettings($settings) {
    global $settingsFile;
    file_put_contents($settingsFile, json_encode($settings));
    chmod($settingsFile, 0666);
}

// 获取突发事件
function getEvents() {
    global $eventsFile;
    if (!file_exists($eventsFile)) return [];
    $content = file_get_contents($eventsFile);
    return $content ? json_decode($content, true) : [];
}

// 保存突发事件
function saveEvents($events) {
    global $eventsFile;
    file_put_contents($eventsFile, json_encode($events, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    chmod($eventsFile, 0666);
}

// 触发随机事件
function triggerRandomEvent() {
    $events = getEvents();
    if (empty($events)) return null;
    
    $stocks = getStocks();
    $randomEvent = $events[array_rand($events)];
    
    foreach ($stocks as &$stock) {
        if (in_array($stock['type'], $randomEvent['stockTypes'])) {
            if ($randomEvent['type'] === 'rise') {
                $change = abs($stock['change'] > 0 ? $stock['change'] : rand(1, 5));
                $stock['change'] = round($change * $randomEvent['multiplier'], 2);
            } else {
                $change = abs($stock['change'] < 0 ? $stock['change'] : -rand(1, 5));
                $stock['change'] = round($change * $randomEvent['multiplier'], 2);
            }
            $stock['price'] = round($stock['price'] * (1 + $stock['change'] / 100), 2);
            $stock['high'] = max($stock['high'], $stock['price']);
            $stock['low'] = min($stock['low'], $stock['price']);
        }
    }
    
    saveStocks($stocks);
    
    return $randomEvent;
}

function getUser($users, $username) {
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return $user;
        }
    }
    return null;
}

function getUserByNickname($users, $nickname) {
    foreach ($users as $user) {
        if ($user['nickname'] === $nickname) {
            return $user;
        }
    }
    return null;
}

function updateUser(&$users, $username, $newData) {
    foreach ($users as &$user) {
        if ($user['username'] === $username) {
            $user = array_merge($user, $newData);
            return true;
        }
    }
    return false;
}

// 获取用户创建的自定义股票数量
function getUserCustomStockCount($username) {
    $stocks = getStocks();
    $count = 0;
    foreach ($stocks as $stock) {
        if (isset($stock['created_by']) && $stock['created_by'] === $username) {
            $count++;
        }
    }
    return $count;
}

// 检查用户是否可以创建股票
function canUserCreateStock($username) {
    $users = getUsers();
    $user = getUser($users, $username);
    
    // 管理员可以无限创建
    if ($user && isset($user['is_admin']) && $user['is_admin']) {
        return true;
    }
    
    // 普通用户只能创建1个
    return getUserCustomStockCount($username) < 1;
}

// 更新股票价格（内部函数）
function updateStockPricesInternal() {
    $stocks = getStocks();
    $timer = getTimer();
    
    // 检查是否需要更新
    if (time() < $timer['next_update']) {
        return ['updated' => false, 'stocks' => $stocks];
    }
    
    foreach ($stocks as &$stock) {
        $randomChange = (mt_rand() / mt_getrandmax() - 0.5) * 6;
        $stock['change'] = round($randomChange, 2);
        $stock['price'] = round($stock['price'] * (1 + $randomChange / 100), 2);
        $stock['high'] = max($stock['high'], $stock['price']);
        $stock['low'] = min($stock['low'], $stock['price']);
        $stock['volume'] = floor($stock['volume'] * (0.95 + mt_rand() / mt_getrandmax() * 0.1));
    }
    
    saveStocks($stocks);
    
    $timer['last_update'] = time();
    $timer['next_update'] = time() + 180;
    saveTimer($timer);
    
    return ['updated' => true, 'stocks' => $stocks];
}

// 触发事件（内部函数）
function triggerEventInternal() {
    $stocks = getStocks();
    $timer = getTimer();
    
    // 检查是否需要更新
    if (time() < $timer['next_update']) {
        return ['triggered' => false, 'stocks' => $stocks];
    }
    
    $randomEvent = triggerRandomEvent();
    
    if ($randomEvent) {
        saveTimer($timer);
        return ['triggered' => true, 'stocks' => getStocks(), 'event' => $randomEvent];
    }
    
    return ['triggered' => false, 'stocks' => $stocks];
}

// 计算利息（内部函数）
function calculateInterestInternal() {
    $users = getUsers();
    $timer = getTimer();
    
    // 检查是否需要计算利息
    if (time() - $timer['last_interest'] < 180) {
        return false;
    }
    
    $interestRate = 0.005;
    $hasLoan = false;
    
    foreach ($users as &$user) {
        if ($user['loan'] > 0) {
            $hasLoan = true;
            $interest = round($user['loan'] * $interestRate, 2);
            $user['loan'] = round($user['loan'] + $interest, 2);
        }
    }
    
    if ($hasLoan) {
        saveUsers($users);
    }
    
    $timer['last_interest'] = time();
    saveTimer($timer);
    
    return true;
}

// 获取用户总资产
function getUserTotalAssets($username) {
    $users = getUsers();
    $stocks = getStocks();
    $user = getUser($users, $username);
    
    if (!$user) return 0;
    
    $portfolioValue = 0;
    foreach ($user['portfolio'] as $stockId => $amount) {
        foreach ($stocks as $stock) {
            if ($stock['id'] == $stockId) {
                $portfolioValue += round($stock['price'] * $amount, 2);
                break;
            }
        }
    }
    
    return round($user['balance'] + $portfolioValue - $user['loan'], 2);
}

// 初始化数据文件
if (!file_exists($usersFile)) {
    // 创建默认admin用户
    $defaultUsers = [
        [
            'username' => 'admin',
            'password' => 'admin123',
            'nickname' => '管理员',
            'balance' => 1000000.00,
            'loan' => 0.00,
            'portfolio' => [],
            'is_admin' => true
        ]
    ];
    saveUsers($defaultUsers);
}
if (!file_exists($stocksFile)) {
    saveStocks($initialStocks);
}
if (!file_exists($timerFile)) {
    saveTimer(['last_update' => time(), 'next_update' => time() + 180, 'last_interest' => time()]);
}
if (!file_exists($messagesFile)) {
    saveMessages([]);
}
if (!file_exists($settingsFile)) {
    saveSettings(['barrage_enabled' => false]);
}
if (!file_exists($eventsFile)) {
    saveEvents($initialEvents);
}

// 处理AJAX请求
if (isset($_POST['ajax_action'])) {
    header('Content-Type: application/json; charset=utf-8');
    
    $action = $_POST['ajax_action'];
    $response = ['success' => false, 'message' => '无效操作'];
    
    switch ($action) {
        case 'login':
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $users = getUsers();
            $user = getUser($users, $username);
            
            if (!$user) {
                $response = ['success' => false, 'message' => '用户不存在'];
            } elseif ($user['password'] !== $password) {
                $response = ['success' => false, 'message' => '密码错误'];
            } else {
                $_SESSION['username'] = $username;
                $_SESSION['is_admin'] = $user['is_admin'] ?? false;
                $response = ['success' => true, 'message' => '登录成功', 'is_admin' => $user['is_admin'] ?? false];
            }
            break;
            
        case 'register':
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $nickname = $_POST['nickname'] ?? '';
            $users = getUsers();
            
            if (getUser($users, $username)) {
                $response = ['success' => false, 'message' => '用户名已存在'];
            } elseif (getUserByNickname($users, $nickname)) {
                $response = ['success' => false, 'message' => '昵称已存在'];
            } else {
                $users[] = [
                    'username' => $username,
                    'password' => $password,
                    'nickname' => $nickname,
                    'balance' => 10000.00,
                    'loan' => 0.00,
                    'portfolio' => [],
                    'is_admin' => false
                ];
                saveUsers($users);
                $response = ['success' => true, 'message' => '注册成功'];
            }
            break;
            
        case 'logout':
            session_destroy();
            $response = ['success' => true];
            break;
            
        case 'check_login':
            $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
            $response = ['success' => true, 'logged_in' => isset($_SESSION['username']), 'username' => $_SESSION['username'] ?? '', 'is_admin' => $isAdmin];
            break;
            
        case 'get_game_data':
            if (!isset($_SESSION['username'])) {
                $response = ['success' => false, 'message' => '未登录'];
                break;
            }
            
            $username = $_SESSION['username'];
            $users = getUsers();
            $user = getUser($users, $username);
            $stocks = getStocks();
            $timer = getTimer();
            $settings = getSettings();
            $events = getEvents();
            
            // 自动更新股票价格（如果需要）
            $stockUpdateResult = updateStockPricesInternal();
            if ($stockUpdateResult['updated']) {
                $stocks = $stockUpdateResult['stocks'];
            }
            
            // 自动触发事件（30%概率）
            if (rand(1, 100) <= 30 && !$stockUpdateResult['updated']) {
                $eventResult = triggerEventInternal();
                if ($eventResult['triggered']) {
                    $stocks = $eventResult['stocks'];
                    $response['event'] = $eventResult['event'];
                }
            }
            
            // 自动计算利息
            calculateInterestInternal();
            
            // 重新获取用户数据（可能被利息更新）
            $users = getUsers();
            $user = getUser($users, $username);
            
            // 计算总资产
            $totalAssets = getUserTotalAssets($username);
            
            // 获取排行榜（使用昵称）
            $ranking = [];
            foreach ($users as $u) {
                $ranking[] = [
                    'username' => $u['username'],
                    'nickname' => $u['nickname'] ?? $u['username'],
                    'totalAssets' => getUserTotalAssets($u['username'])
                ];
            }
            usort($ranking, function($a, $b) {
                return $b['totalAssets'] - $a['totalAssets'];
            });
            
            $response = [
                'success' => true,
                'user' => [
                    'username' => $user['username'],
                    'nickname' => $user['nickname'] ?? $user['username'],
                    'balance' => $user['balance'],
                    'loan' => $user['loan'],
                    'portfolio' => $user['portfolio'],
                    'is_admin' => $user['is_admin'] ?? false,
                    'can_create_stock' => canUserCreateStock($username)
                ],
                'stocks' => $stocks,
                'timer' => [
                    'next_update' => $timer['next_update'],
                    'current_time' => time()
                ],
                'total_assets' => $totalAssets,
                'ranking' => array_slice($ranking, 0, 10),
                'settings' => $settings,
                'preset_types' => $presetStockTypes,
                'events' => $events
            ];
            break;
            
        case 'trade':
            if (!isset($_SESSION['username'])) {
                $response = ['success' => false, 'message' => '请先登录'];
                break;
            }
            
            $username = $_SESSION['username'];
            $stockId = intval($_POST['stock_id'] ?? 0);
            $type = $_POST['type'] ?? '';
            $amount = intval($_POST['amount'] ?? 0);
            
            $users = getUsers();
            $user = getUser($users, $username);
            $stocks = getStocks();
            
            if (!$user) {
                $response = ['success' => false, 'message' => '用户不存在'];
                break;
            }
            
            $stock = null;
            foreach ($stocks as $s) {
                if ($s['id'] == $stockId) {
                    $stock = $s;
                    break;
                }
            }
            
            if (!$stock) {
                $response = ['success' => false, 'message' => '股票不存在'];
                break;
            }
            
            $totalCost = $stock['price'] * $amount;
            $nickname = $user['nickname'] ?? $username;
            
            if ($type === 'buy') {
                if ($user['balance'] < $totalCost) {
                    $response = ['success' => false, 'message' => '余额不足'];
                } else {
                    // 扣除买家资金
                    $user['balance'] = round($user['balance'] - $totalCost, 2);
                    
                    // 如果是自定义股票，资金转给创建者
                    if (isset($stock['created_by']) && $stock['created_by'] !== 'system' && $stock['created_by'] !== $username) {
                        $creator = getUser($users, $stock['created_by']);
                        if ($creator) {
                            $creator['balance'] = round($creator['balance'] + $totalCost, 2);
                            updateUser($users, $creator['username'], $creator);
                            
                            // 添加创建者收款消息
                            $creatorNickname = $creator['nickname'] ?? $creator['username'];
                            addMessage('system', '系统', "🔔 {$creatorNickname} 收到来自 {$nickname} 的 {$amount} 股 {$stock['name']} 购买款 {$totalCost} 元");
                        }
                    }
                    
                    $user['portfolio'][$stockId] = ($user['portfolio'][$stockId] ?? 0) + $amount;
                    updateUser($users, $username, $user);
                    saveUsers($users);
                    
                    // 添加交易播报
                    $creatorInfo = '';
                    if (isset($stock['created_by']) && $stock['created_by'] !== 'system') {
                        $creator = getUser($users, $stock['created_by']);
                        $creatorName = $creator ? ($creator['nickname'] ?? $creator['username']) : $stock['created_by'];
                        $creatorInfo = " (创建者: {$creatorName})";
                    }
                    addMessage('system', '系统', "💰 {$nickname} 以 {$stock['price']} 元/股的价格买入了 {$amount} 股 {$stock['name']}{$creatorInfo}，花费 {$totalCost} 元");
                    
                    $response = [
                        'success' => true,
                        'message' => "成功买入 {$amount} 股 {$stock['name']}",
                        'balance' => $user['balance'],
                        'holding' => $user['portfolio'][$stockId]
                    ];
                }
            } elseif ($type === 'sell') {
                if (($user['portfolio'][$stockId] ?? 0) < $amount) {
                    $response = ['success' => false, 'message' => '持仓不足'];
                } else {
                    $user['balance'] = round($user['balance'] + $totalCost, 2);
                    $user['portfolio'][$stockId] -= $amount;
                    if ($user['portfolio'][$stockId] == 0) {
                        unset($user['portfolio'][$stockId]);
                    }
                    updateUser($users, $username, $user);
                    
                    // 如果是自定义股票，从创建者账户扣除资金
                    if (isset($stock['created_by']) && $stock['created_by'] !== 'system' && $stock['created_by'] !== $username) {
                        $creator = getUser($users, $stock['created_by']);
                        if ($creator) {
                            $creator['balance'] = round($creator['balance'] - $totalCost, 2);
                            updateUser($users, $creator['username'], $creator);
                            
                            // 添加创建者付款消息
                            $creatorNickname = $creator['nickname'] ?? $creator['username'];
                            addMessage('system', '系统', "🔔 {$creatorNickname} 向 {$nickname} 支付了 {$amount} 股 {$stock['name']} 的回购款 {$totalCost} 元");
                        }
                    }
                    
                    saveUsers($users);
                    
                    // 添加交易播报
                    $creatorInfo = '';
                    if (isset($stock['created_by']) && $stock['created_by'] !== 'system') {
                        $creator = getUser($users, $stock['created_by']);
                        $creatorName = $creator ? ($creator['nickname'] ?? $creator['username']) : $stock['created_by'];
                        $creatorInfo = " (创建者: {$creatorName})";
                    }
                    addMessage('system', '系统', "💸 {$nickname} 以 {$stock['price']} 元/股的价格卖出了 {$amount} 股 {$stock['name']}{$creatorInfo}，获得 {$totalCost} 元");
                    
                    $response = [
                        'success' => true,
                        'message' => "成功卖出 {$amount} 股 {$stock['name']}",
                        'balance' => $user['balance'],
                        'holding' => $user['portfolio'][$stockId] ?? 0
                    ];
                }
            }
            break;
            
        case 'sell_all':
            if (!isset($_SESSION['username'])) {
                $response = ['success' => false, 'message' => '请先登录'];
                break;
            }
            
            $username = $_SESSION['username'];
            $stockId = intval($_POST['stock_id'] ?? 0);
            
            $users = getUsers();
            $user = getUser($users, $username);
            $stocks = getStocks();
            
            if (!$user) {
                $response = ['success' => false, 'message' => '用户不存在'];
                break;
            }
            
            if (($user['portfolio'][$stockId] ?? 0) <= 0) {
                $response = ['success' => false, 'message' => '暂无持仓'];
                break;
            }
            
            $stock = null;
            foreach ($stocks as $s) {
                if ($s['id'] == $stockId) {
                    $stock = $s;
                    break;
                }
            }
            
            if (!$stock) {
                $response = ['success' => false, 'message' => '股票不存在'];
                break;
            }
            
            $holdingAmount = $user['portfolio'][$stockId];
            $totalValue = $stock['price'] * $holdingAmount;
            $nickname = $user['nickname'] ?? $username;
            
            $user['balance'] = round($user['balance'] + $totalValue, 2);
            unset($user['portfolio'][$stockId]);
            
            updateUser($users, $username, $user);
            
            // 如果是自定义股票，从创建者账户扣除资金
            if (isset($stock['created_by']) && $stock['created_by'] !== 'system' && $stock['created_by'] !== $username) {
                $creator = getUser($users, $stock['created_by']);
                if ($creator) {
                    $creator['balance'] = round($creator['balance'] - $totalValue, 2);
                    updateUser($users, $creator['username'], $creator);
                    
                    // 添加创建者付款消息
                    $creatorNickname = $creator['nickname'] ?? $creator['username'];
                    addMessage('system', '系统', "🔔 {$creatorNickname} 向 {$nickname} 支付了全部 {$holdingAmount} 股 {$stock['name']} 的回购款 {$totalValue} 元");
                }
            }
            
            saveUsers($users);
            
            // 添加全部卖出播报
            $creatorInfo = '';
            if (isset($stock['created_by']) && $stock['created_by'] !== 'system') {
                $creator = getUser($users, $stock['created_by']);
                $creatorName = $creator ? ($creator['nickname'] ?? $creator['username']) : $stock['created_by'];
                $creatorInfo = " (创建者: {$creatorName})";
            }
            addMessage('system', '系统', "💸 {$nickname} 以 {$stock['price']} 元/股的价格清仓了全部 {$holdingAmount} 股 {$stock['name']}{$creatorInfo}，获得 {$totalValue} 元");
            
            $response = [
                'success' => true,
                'message' => "成功卖出全部 {$holdingAmount} 股 {$stock['name']}",
                'balance' => $user['balance']
            ];
            break;
            
        case 'take_loan':
            if (!isset($_SESSION['username'])) {
                $response = ['success' => false, 'message' => '请先登录'];
                break;
            }
            
            $username = $_SESSION['username'];
            $amount = intval($_POST['amount'] ?? 0);
            
            if ($amount < 100 || $amount > 5000) {
                $response = ['success' => false, 'message' => '请输入100-5000之间的金额'];
                break;
            }
            
            $users = getUsers();
            $user = getUser($users, $username);
            
            if (!$user) {
                $response = ['success' => false, 'message' => '用户不存在'];
                break;
            }
            
            $user['loan'] = round($user['loan'] + $amount, 2);
            $user['balance'] = round($user['balance'] + $amount, 2);
            
            updateUser($users, $username, $user);
            saveUsers($users);
            
            // 添加贷款播报
            $nickname = $user['nickname'] ?? $username;
            addMessage('system', '系统', "🏦 {$nickname} 申请了 {$amount} 元贷款");
            
            $response = [
                'success' => true,
                'message' => "成功贷款 {$amount} 元",
                'balance' => $user['balance'],
                'loan' => $user['loan']
            ];
            break;
            
        case 'repay_loan':
            if (!isset($_SESSION['username'])) {
                $response = ['success' => false, 'message' => '请先登录'];
                break;
            }
            
            $username = $_SESSION['username'];
            $users = getUsers();
            $user = getUser($users, $username);
            
            if (!$user) {
                $response = ['success' => false, 'message' => '用户不存在'];
                break;
            }
            
            if ($user['loan'] <= 0) {
                $response = ['success' => false, 'message' => '暂无贷款'];
                break;
            }
            
            if ($user['balance'] < $user['loan']) {
                $response = ['success' => false, 'message' => '余额不足'];
                break;
            }
            
            $repaidAmount = $user['loan'];
            $user['balance'] = round($user['balance'] - $repaidAmount, 2);
            $user['loan'] = 0;
            
            updateUser($users, $username, $user);
            saveUsers($users);
            
            // 添加还款播报
            $nickname = $user['nickname'] ?? $username;
            addMessage('system', '系统', "💳 {$nickname} 偿还了 {$repaidAmount} 元贷款");
            
            $response = [
                'success' => true,
                'message' => "成功偿还贷款 {$repaidAmount} 元",
                'balance' => $user['balance'],
                'loan' => 0
            ];
            break;
            
        // 获取聊天消息
        case 'get_messages':
            if (!isset($_SESSION['username'])) {
                $response = ['success' => false, 'message' => '未登录'];
                break;
            }
            
            $messages = getMessages();
            // 格式化时间，添加年月日
            foreach ($messages as &$msg) {
                $msg['time_formatted'] = date('Y-m-d H:i:s', $msg['time']);
                $msg['display_name'] = $msg['nickname'] ?? $msg['username'];
            }
            $response = ['success' => true, 'messages' => $messages];
            break;
            
        // 发送聊天消息
        case 'send_message':
            if (!isset($_SESSION['username'])) {
                $response = ['success' => false, 'message' => '未登录'];
                break;
            }
            
            $username = $_SESSION['username'];
            $content = trim($_POST['content'] ?? '');
            
            if (empty($content)) {
                $response = ['success' => false, 'message' => '消息不能为空'];
                break;
            }
            
            if (mb_strlen($content) > 200) {
                $response = ['success' => false, 'message' => '消息不能超过200字'];
                break;
            }
            
            $users = getUsers();
            $user = getUser($users, $username);
            $nickname = $user['nickname'] ?? $username;
            
            addMessage($username, $nickname, $content);
            $messages = getMessages();
            foreach ($messages as &$msg) {
                $msg['time_formatted'] = date('Y-m-d H:i:s', $msg['time']);
                $msg['display_name'] = $msg['nickname'] ?? $msg['username'];
            }
            
            $response = ['success' => true, 'messages' => $messages];
            break;
            
        // 创建自定义股票
        case 'create_stock':
            if (!isset($_SESSION['username'])) {
                $response = ['success' => false, 'message' => '请先登录'];
                break;
            }
            
            $username = $_SESSION['username'];
            $name = trim($_POST['name'] ?? '');
            $type = trim($_POST['type'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            
            if (empty($name) || empty($type) || $price <= 0) {
                $response = ['success' => false, 'message' => '请填写完整的股票信息'];
                break;
            }
            
            if ($price < 1 || $price > 10000) {
                $response = ['success' => false, 'message' => '价格必须在1-10000之间'];
                break;
            }
            
            // 检查类型是否有效
            $users = getUsers();
            $user = getUser($users, $username);
            $isAdmin = $user && isset($user['is_admin']) && $user['is_admin'];
            
            if (!$isAdmin && !in_array($type, $presetStockTypes)) {
                $response = ['success' => false, 'message' => '请选择预设的股票类型'];
                break;
            }
            
            if (!canUserCreateStock($username)) {
                $response = ['success' => false, 'message' => '您已经创建过自定义股票了'];
                break;
            }
            
            // 检查余额是否足够支付创建费用（需要支付股票价格）
            if ($user['balance'] < $price) {
                $response = ['success' => false, 'message' => '余额不足，创建股票需要支付 ' . $price . ' 元'];
                break;
            }
            
            $stocks = getStocks();
            
            // 生成新ID
            $maxId = 0;
            foreach ($stocks as $stock) {
                if ($stock['id'] > $maxId) {
                    $maxId = $stock['id'];
                }
            }
            $newId = $maxId + 1;
            
            $newStock = [
                'id' => $newId,
                'name' => $name,
                'type' => $type,
                'price' => $price,
                'high' => $price,
                'low' => $price,
                'volume' => 0,
                'change' => 0,
                'created_by' => $username,
                'is_custom' => true,
                'online' => true,
                'total_shares' => 1000000, // 总股本
                'circulating_shares' => 1000000 // 流通股本
            ];
            
            $stocks[] = $newStock;
            saveStocks($stocks);
            
            // 扣除创建者的费用
            $user['balance'] = round($user['balance'] - $price, 2);
            updateUser($users, $username, $user);
            saveUsers($users);
            
            // 添加系统消息
            $nickname = $user['nickname'] ?? $username;
            addMessage('system', '系统', "🏢 {$nickname} 花费 {$price} 元创建了新股票：{$name}（{$type}）");
            
            $response = ['success' => true, 'message' => '股票创建成功，花费 ' . $price . ' 元', 'stock' => $newStock, 'balance' => $user['balance']];
            break;
            
        // 管理员获取用户列表
        case 'admin_get_users':
            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                $response = ['success' => false, 'message' => '权限不足'];
                break;
            }
            
            $users = getUsers();
            $userList = [];
            foreach ($users as $user) {
                $userList[] = [
                    'username' => $user['username'],
                    'nickname' => $user['nickname'] ?? $user['username'],
                    'balance' => $user['balance'],
                    'loan' => $user['loan'],
                    'is_admin' => $user['is_admin'] ?? false
                ];
            }
            
            $response = ['success' => true, 'users' => $userList];
            break;
            
        // 管理员更新用户
        case 'admin_update_user':
            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                $response = ['success' => false, 'message' => '权限不足'];
                break;
            }
            
            $targetUsername = $_POST['target_username'] ?? '';
            $field = $_POST['field'] ?? '';
            $value = $_POST['value'] ?? '';
            
            $users = getUsers();
            $user = getUser($users, $targetUsername);
            
            if (!$user) {
                $response = ['success' => false, 'message' => '用户不存在'];
                break;
            }
            
            if ($field === 'password') {
                $user['password'] = $value;
            } elseif ($field === 'nickname') {
                $user['nickname'] = $value;
            } elseif ($field === 'balance') {
                $user['balance'] = floatval($value);
            } elseif ($field === 'loan') {
                $user['loan'] = floatval($value);
            } else {
                $response = ['success' => false, 'message' => '无效字段'];
                break;
            }
            
            updateUser($users, $targetUsername, $user);
            saveUsers($users);
            
            $response = ['success' => true, 'message' => '更新成功'];
            break;
            
        // 管理员更新股票
        case 'admin_update_stock':
            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                $response = ['success' => false, 'message' => '权限不足'];
                break;
            }
            
            $stockId = intval($_POST['stock_id'] ?? 0);
            $field = $_POST['field'] ?? '';
            $value = $_POST['value'] ?? '';
            
            $stocks = getStocks();
            $stockIndex = -1;
            foreach ($stocks as $index => $s) {
                if ($s['id'] == $stockId) {
                    $stockIndex = $index;
                    break;
                }
            }
            
            if ($stockIndex === -1) {
                $response = ['success' => false, 'message' => '股票不存在'];
                break;
            }
            
            if ($field === 'name') {
                $stocks[$stockIndex]['name'] = $value;
            } elseif ($field === 'price') {
                $stocks[$stockIndex]['price'] = floatval($value);
            } elseif ($field === 'type') {
                $stocks[$stockIndex]['type'] = $value;
            } else {
                $response = ['success' => false, 'message' => '无效字段'];
                break;
            }
            
            saveStocks($stocks);
            
            $response = ['success' => true, 'message' => '更新成功'];
            break;
            
        // 管理员删除股票
        case 'admin_delete_stock':
            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                $response = ['success' => false, 'message' => '权限不足'];
                break;
            }
            
            $stockId = intval($_POST['stock_id'] ?? 0);
            
            $stocks = getStocks();
            $stockIndex = -1;
            foreach ($stocks as $index => $s) {
                if ($s['id'] == $stockId) {
                    $stockIndex = $index;
                    break;
                }
            }
            
            if ($stockIndex === -1) {
                $response = ['success' => false, 'message' => '股票不存在'];
                break;
            }
            
            // 不能删除系统股票
            if (!isset($stocks[$stockIndex]['is_custom']) || !$stocks[$stockIndex]['is_custom']) {
                $response = ['success' => false, 'message' => '不能删除系统股票'];
                break;
            }
            
            array_splice($stocks, $stockIndex, 1);
            saveStocks($stocks);
            
            $response = ['success' => true, 'message' => '删除成功'];
            break;
            
        // 管理员上线/下线股票
        case 'admin_toggle_stock':
            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                $response = ['success' => false, 'message' => '权限不足'];
                break;
            }
            
            $stockId = intval($_POST['stock_id'] ?? 0);
            $online = $_POST['online'] === 'true';
            
            $stocks = getStocks();
            $stockIndex = -1;
            foreach ($stocks as $index => $s) {
                if ($s['id'] == $stockId) {
                    $stockIndex = $index;
                    break;
                }
            }
            
            if ($stockIndex === -1) {
                $response = ['success' => false, 'message' => '股票不存在'];
                break;
            }
            
            $stocks[$stockIndex]['online'] = $online;
            saveStocks($stocks);
            
            $response = ['success' => true, 'message' => $online ? '股票已上线' : '股票已下线'];
            break;
            
        // 管理员创建突发事件
        case 'admin_create_event':
            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                $response = ['success' => false, 'message' => '权限不足'];
                break;
            }
            
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $type = $_POST['type'] ?? 'rise';
            $stockTypes = json_decode($_POST['stockTypes'] ?? '[]', true);
            $multiplier = floatval($_POST['multiplier'] ?? 1);
            
            if (empty($name) || empty($description) || empty($stockTypes) || $multiplier < 1 || $multiplier > 5) {
                $response = ['success' => false, 'message' => '请填写完整的突发事件信息'];
                break;
            }
            
            $events = getEvents();
            
            // 生成新ID
            $maxId = 0;
            foreach ($events as $event) {
                if ($event['id'] > $maxId) {
                    $maxId = $event['id'];
                }
            }
            $newId = $maxId + 1;
            
            $newEvent = [
                'id' => $newId,
                'name' => $name,
                'description' => $description,
                'type' => $type,
                'stockTypes' => $stockTypes,
                'multiplier' => $multiplier,
                'created_by' => $_SESSION['username']
            ];
            
            $events[] = $newEvent;
            saveEvents($events);
            
            $response = ['success' => true, 'message' => '突发事件创建成功', 'event' => $newEvent];
            break;
            
        // 管理员更新突发事件
        case 'admin_update_event':
            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                $response = ['success' => false, 'message' => '权限不足'];
                break;
            }
            
            $eventId = intval($_POST['event_id'] ?? 0);
            $field = $_POST['field'] ?? '';
            $value = $_POST['value'] ?? '';
            
            $events = getEvents();
            $eventIndex = -1;
            foreach ($events as $index => $e) {
                if ($e['id'] == $eventId) {
                    $eventIndex = $index;
                    break;
                }
            }
            
            if ($eventIndex === -1) {
                $response = ['success' => false, 'message' => '突发事件不存在'];
                break;
            }
            
            if ($field === 'name') {
                $events[$eventIndex]['name'] = $value;
            } elseif ($field === 'description') {
                $events[$eventIndex]['description'] = $value;
            } elseif ($field === 'multiplier') {
                $events[$eventIndex]['multiplier'] = floatval($value);
            } else {
                $response = ['success' => false, 'message' => '无效字段'];
                break;
            }
            
            saveEvents($events);
            
            $response = ['success' => true, 'message' => '更新成功'];
            break;
            
        // 管理员删除突发事件
        case 'admin_delete_event':
            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                $response = ['success' => false, 'message' => '权限不足'];
                break;
            }
            
            $eventId = intval($_POST['event_id'] ?? 0);
            
            $events = getEvents();
            $eventIndex = -1;
            foreach ($events as $index => $e) {
                if ($e['id'] == $eventId) {
                    $eventIndex = $index;
                    break;
                }
            }
            
            if ($eventIndex === -1) {
                $response = ['success' => false, 'message' => '突发事件不存在'];
                break;
            }
            
            array_splice($events, $eventIndex, 1);
            saveEvents($events);
            
            $response = ['success' => true, 'message' => '删除成功'];
            break;
            
        // 管理员手动触发突发事件
        case 'admin_trigger_event':
            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                $response = ['success' => false, 'message' => '权限不足'];
                break;
            }
            
            $eventId = intval($_POST['event_id'] ?? 0);
            
            $events = getEvents();
            $event = null;
            foreach ($events as $e) {
                if ($e['id'] == $eventId) {
                    $event = $e;
                    break;
                }
            }
            
            if (!$event) {
                $response = ['success' => false, 'message' => '突发事件不存在'];
                break;
            }
            
            $stocks = getStocks();
            foreach ($stocks as &$stock) {
                if (in_array($stock['type'], $event['stockTypes'])) {
                    if ($event['type'] === 'rise') {
                        $change = abs($stock['change'] > 0 ? $stock['change'] : rand(1, 5));
                        $stock['change'] = round($change * $event['multiplier'], 2);
                    } else {
                        $change = abs($stock['change'] < 0 ? $stock['change'] : -rand(1, 5));
                        $stock['change'] = round($change * $event['multiplier'], 2);
                    }
                    $stock['price'] = round($stock['price'] * (1 + $stock['change'] / 100), 2);
                    $stock['high'] = max($stock['high'], $stock['price']);
                    $stock['low'] = min($stock['low'], $stock['price']);
                }
            }
            
            saveStocks($stocks);
            
            // 添加系统消息
            addMessage('system', '系统', "⚠️ 管理员触发了突发事件：{$event['name']} - {$event['description']}");
            
            $response = ['success' => true, 'message' => '突发事件已触发', 'event' => $event];
            break;
    }
    
    echo json_encode($response);
    exit;
}

// 检查登录状态
$isLoggedIn = isset($_SESSION['username']);
$username = $_SESSION['username'] ?? '';
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>简易炒股小游戏 - PHP版</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Microsoft YaHei', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            padding: 20px;
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
        }

        #auth-panel {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        #auth-panel h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .btn:disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 14px;
            width: auto;
        }

        .toggle-auth {
            text-align: center;
            margin-top: 15px;
            color: #666;
        }

        .toggle-auth span {
            color: #3498db;
            cursor: pointer;
            text-decoration: underline;
        }

        #game-panel {
            max-width: 1200px;
            margin: 0 auto;
            margin-right: 320px; /* 为聊天室留出空间 */
            transition: margin-right 0.3s ease;
        }

        #game-panel.chat-hidden {
            margin-right: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .user-info {
            font-size: 18px;
            font-weight: 600;
        }

        .user-info .admin-badge {
            background: #f39c12;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 10px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .refresh-countdown {
            font-size: 16px;
            color: #666;
            margin-right: 15px;
            padding: 5px 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #eee;
        }

        .ranking-btn {
            padding: 8px 15px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .ranking-btn:hover {
            background-color: #27ae60;
        }

        .admin-btn {
            padding: 8px 15px;
            background-color: #f39c12;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .admin-btn:hover {
            background-color: #e67e22;
        }

        .create-stock-btn {
            padding: 8px 15px;
            background-color: #9b59b6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .create-stock-btn:hover {
            background-color: #8e44ad;
        }

        .create-stock-btn.disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }

        .logout-btn {
            padding: 8px 15px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .stocks-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stock-card {
            width: calc(10% - 15px);
            min-width: 120px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.2s;
            position: relative;
        }

        .stock-card:hover {
            transform: translateY(-5px);
        }

        .stock-card.offline {
            opacity: 0.6;
            background: #f0f0f0;
        }

        .stock-admin-controls {
            position: absolute;
            top: 5px;
            right: 5px;
            display: none;
        }

        .stock-card:hover .stock-admin-controls {
            display: block;
        }

        .stock-admin-btn {
            background: #f39c12;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 2px 5px;
            font-size: 10px;
            cursor: pointer;
            margin-left: 2px;
        }

        .stock-custom-badge {
            position: absolute;
            top: 5px;
            left: 5px;
            background: #9b59b6;
            color: white;
            font-size: 10px;
            padding: 2px 4px;
            border-radius: 4px;
        }

        .stock-name {
            font-weight: 600;
            margin-bottom: 5px;
            margin-top: 15px;
        }

        .stock-price {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .stock-change {
            font-size: 14px;
        }

        .rise {
            color: #e74c3c;
        }

        .fall {
            color: #27ae60;
        }

        #stock-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 8px;
            width: 600px;
            max-width: 90%;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .close-modal {
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .stock-detail {
            font-size: 16px;
            line-height: 1.8;
        }

        .stock-creator {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        .chart-container {
            width: 100%;
            height: 200px;
            margin: 20px 0;
            border: 1px solid #eee;
            border-radius: 4px;
            position: relative;
        }

        .trade-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .trade-btn {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            font-weight: 600;
            min-width: 120px;
        }

        .buy-btn {
            background-color: #27ae60;
        }

        .sell-btn {
            background-color: #e74c3c;
        }

        .sell-all-btn {
            background-color: #e67e22;
            flex: 100%;
            margin-top: 10px;
        }

        .loan-panel {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 300px;
            z-index: 90;
        }

        .loan-panel h3 {
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .loan-amount {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .loan-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .loan-btn {
            width: 100%;
            padding: 10px;
            background-color: #f39c12;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .repay-btn {
            width: 100%;
            padding: 10px;
            background-color: #9b59b6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .portfolio-panel {
            position: fixed;
            bottom: 20px;
            right: 340px; /* 调整为聊天室左侧 */
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 300px;
            transition: right 0.3s ease;
            z-index: 90;
        }

        .portfolio-panel.chat-hidden {
            right: 20px;
        }

        .portfolio-panel h3 {
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .portfolio-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .portfolio-item-info {
            display: flex;
            flex-direction: column;
        }

        .portfolio-item-name {
            font-weight: 600;
        }

        .portfolio-item-amount {
            font-size: 14px;
            color: #666;
        }

        .portfolio-sell-all {
            padding: 4px 8px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        #ranking-modal, #admin-modal, #create-stock-modal, #event-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .ranking-content, .admin-content, .create-stock-content, .event-content {
            background: white;
            padding: 30px;
            border-radius: 8px;
            width: 900px;
            max-width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .ranking-header, .admin-header, .create-stock-header, .event-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .ranking-title, .admin-title, .create-stock-title, .event-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
        }

        .ranking-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .ranking-rank {
            width: 30px;
            text-align: center;
            font-weight: 600;
            color: #3498db;
        }

        .ranking-username {
            flex: 1;
            margin: 0 15px;
        }

        .ranking-assets {
            text-align: right;
            min-width: 120px;
            font-weight: 600;
        }

        .user-item, .stock-item, .event-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-bottom: 1px solid #eee;
            flex-wrap: wrap;
        }

        .user-info-text, .stock-info-text, .event-info-text {
            flex: 1;
            min-width: 200px;
        }

        .user-actions, .stock-actions, .event-actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .user-actions input, .stock-actions input, .event-actions input {
            width: 80px;
            padding: 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .user-actions button, .stock-actions button, .event-actions button {
            padding: 4px 8px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .stock-actions .delete-btn, .event-actions .delete-btn {
            background: #e74c3c;
        }

        .stock-actions .toggle-btn, .event-actions .toggle-btn {
            background: #f39c12;
        }

        .stock-custom-badge-admin {
            background: #9b59b6;
            color: white;
            font-size: 10px;
            padding: 2px 4px;
            border-radius: 4px;
            margin-left: 5px;
        }

        .type-tag {
            display: inline-block;
            background: #3498db;
            color: white;
            font-size: 10px;
            padding: 2px 4px;
            border-radius: 4px;
            margin-right: 3px;
        }

        /* 聊天室样式 */
        #chat-panel {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 300px;
            height: calc(100vh - 40px);
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            transition: right 0.3s ease;
            z-index: 100;
        }

        #chat-panel.hidden {
            right: -300px;
        }

        .chat-header {
            padding: 15px;
            background: #3498db;
            color: white;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: move;
        }

        .chat-header h3 {
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .chat-header h3 i {
            font-size: 18px;
        }

        .chat-controls {
            display: flex;
            gap: 10px;
        }

        .chat-control-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 18px;
            padding: 0 5px;
            transition: opacity 0.3s;
        }

        .chat-control-btn:hover {
            opacity: 0.8;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 10px;
            padding: 8px 12px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .message-username {
            font-weight: 600;
            color: #3498db;
        }

        .message-time {
            color: #999;
        }

        .message-content {
            font-size: 14px;
            word-break: break-all;
        }

        .message.system {
            background: #e8f4f8;
            border-left: 3px solid #3498db;
        }

        .message.system .message-username {
            color: #e67e22;
        }

        .chat-input-area {
            padding: 15px;
            background: white;
            border-top: 1px solid #eee;
            border-radius: 0 0 8px 8px;
        }

        .chat-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            resize: none;
            font-size: 14px;
        }

        .chat-send-btn {
            width: 100%;
            padding: 8px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .chat-send-btn:hover {
            background-color: #2980b9;
        }

        .chat-send-btn:disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }

        .chat-toggle-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: background 0.3s, opacity 0.3s;
            z-index: 101;
            opacity: 0;
            pointer-events: none;
        }

        .chat-toggle-btn.visible {
            opacity: 1;
            pointer-events: auto;
        }

        .chat-toggle-btn:hover {
            background: #2980b9;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            display: none;
            z-index: 1001;
            animation: slideIn 0.3s;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .success {
            border-left: 4px solid #27ae60;
        }

        .error {
            border-left: 4px solid #e74c3c;
        }

        .event-notification {
            position: fixed;
            top: 80px;
            right: 340px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            z-index: 1002;
            max-width: 400px;
            border-left: 5px solid #3498db;
            display: none;
            transition: right 0.3s ease;
            animation: slideIn 0.3s;
        }

        .event-notification.chat-hidden {
            right: 20px;
        }

        .event-title {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .event-content {
            line-height: 1.6;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .unread-badge {
            background: #e74c3c;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 5px;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div id="auth-panel" style="<?php echo $isLoggedIn ? 'display: none;' : ''; ?>">
        <div id="login-form">
            <h2>用户登录</h2>
            <div class="form-group">
                <label for="login-username">用户名</label>
                <input type="text" id="login-username" placeholder="请输入用户名" required>
            </div>
            <div class="form-group">
                <label for="login-password">密码</label>
                <input type="password" id="login-password" placeholder="请输入密码" required>
            </div>
            <button class="btn" onclick="login()">登录</button>
            <div class="toggle-auth">
                还没有账号？<span onclick="switchToRegister()">立即注册</span>
            </div>
        </div>

        <div id="register-form" style="display: none;">
            <h2>用户注册</h2>
            <div class="form-group">
                <label for="reg-username">用户名</label>
                <input type="text" id="reg-username" placeholder="请输入用户名" required>
            </div>
            <div class="form-group">
                <label for="reg-nickname">昵称</label>
                <input type="text" id="reg-nickname" placeholder="请输入昵称" required>
            </div>
            <div class="form-group">
                <label for="reg-password">密码</label>
                <input type="password" id="reg-password" placeholder="请输入密码" required>
            </div>
            <div class="form-group">
                <label for="reg-confirm">确认密码</label>
                <input type="password" id="reg-confirm" placeholder="请确认密码" required>
            </div>
            <button class="btn" onclick="register()">注册</button>
            <div class="toggle-auth">
                已有账号？<span onclick="switchToLogin()">立即登录</span>
            </div>
        </div>
    </div>

    <div id="game-panel" style="<?php echo $isLoggedIn ? 'display: block;' : 'display: none;'; ?>">
        <div class="header">
            <div class="user-info" id="user-info">
                昵称: <span id="nickname-display"><?php echo htmlspecialchars($username); ?></span> | 
                账户余额: <span id="balance-display">0</span> 元 |
                贷款金额: <span id="loan-display">0</span> 元 |
                总资产: <span id="total-assets-display">0</span> 元
                <?php if ($isAdmin): ?>
                <span class="admin-badge">管理员</span>
                <?php endif; ?>
            </div>
            <div class="header-actions">
                <div class="refresh-countdown" id="refresh-countdown">
                    下次行情更新: 加载中...
                </div>
                <button class="ranking-btn" onclick="openRanking()">财富排行榜</button>
                <button class="create-stock-btn" id="create-stock-btn" onclick="openCreateStockModal()">创建股票</button>
                <?php if ($isAdmin): ?>
                <button class="admin-btn" onclick="openAdminPanel()">管理面板</button>
                <?php endif; ?>
                <button class="logout-btn" onclick="logout()">退出登录</button>
            </div>
        </div>

        <h2>股票行情</h2>
        <div class="stocks-container" id="stocks-container">
            <div class="loading">加载中...</div>
        </div>

        <div id="stock-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="modal-stock-name">股票详情</h3>
                    <span class="close-modal" onclick="closeModal()">&times;</span>
                </div>
                <div class="stock-detail">
                    <p>股票类型: <span id="modal-stock-type">未知</span></p>
                    <p>当前价格: <span id="modal-stock-price">0</span> 元</p>
                    <p>涨跌幅: <span id="modal-stock-change">0</span>%</p>
                    <p>今日最高价: <span id="modal-stock-high">0</span> 元</p>
                    <p>今日最低价: <span id="modal-stock-low">0</span> 元</p>
                    <p>成交量: <span id="modal-stock-volume">0</span> 手</p>
                    <p>当前持仓: <span id="modal-stock-holding">0</span> 股</p>
                    <p class="stock-creator" id="modal-stock-creator"></p>
                    
                    <div class="chart-container">
                        <canvas id="price-chart" width="500" height="200"></canvas>
                    </div>
                    
                    <div class="form-group">
                        <label for="trade-amount">交易数量</label>
                        <input type="number" id="trade-amount" min="1" value="1">
                    </div>
                    <div class="trade-buttons">
                        <button class="trade-btn buy-btn" onclick="tradeStock('buy')">买入</button>
                        <button class="trade-btn sell-btn" onclick="tradeStock('sell')">卖出</button>
                        <button class="trade-btn sell-all-btn" onclick="sellAllStock()">卖出全部</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="ranking-modal">
            <div class="ranking-content">
                <div class="ranking-header">
                    <div class="ranking-title">财富排行榜</div>
                    <span class="close-modal" onclick="closeRanking()">&times;</span>
                </div>
                <div id="ranking-list"></div>
            </div>
        </div>

        <div id="create-stock-modal">
            <div class="create-stock-content">
                <div class="create-stock-header">
                    <div class="create-stock-title">创建自定义股票</div>
                    <span class="close-modal" onclick="closeCreateStockModal()">&times;</span>
                </div>
                <div class="form-group">
                    <label for="stock-name">股票名称</label>
                    <input type="text" id="stock-name" placeholder="请输入股票名称" maxlength="20">
                </div>
                <div class="form-group">
                    <label for="stock-type">股票类型</label>
                    <select id="stock-type" class="stock-type-select">
                        <option value="">请选择股票类型</option>
                    </select>
                    <?php if ($isAdmin): ?>
                    <div style="margin-top: 10px;">
                        <input type="text" id="stock-type-custom" placeholder="或输入自定义类型" maxlength="20">
                    </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="stock-price">初始价格 (1-10000元)</label>
                    <input type="number" id="stock-price" min="1" max="10000" step="0.01" value="100">
                    <p class="loan-info" style="color: #e74c3c;">创建股票需要支付等于初始价格的金额</p>
                </div>
                <button class="btn" onclick="createStock()">创建股票 (支付 <span id="create-stock-cost">100</span> 元)</button>
            </div>
        </div>

        <?php if ($isAdmin): ?>
        <div id="admin-modal">
            <div class="admin-content">
                <div class="admin-header">
                    <div class="admin-title">管理员面板</div>
                    <span class="close-modal" onclick="closeAdminPanel()">&times;</span>
                </div>
                
                <h3>用户管理</h3>
                <div id="user-list"></div>
                
                <h3 style="margin-top: 20px;">股票管理</h3>
                <div id="stock-list-admin"></div>
                
                <h3 style="margin-top: 20px;">突发事件管理</h3>
                <button class="btn btn-small" onclick="openEventModal()">创建新事件</button>
                <div id="event-list"></div>
            </div>
        </div>

        <div id="event-modal">
            <div class="event-content">
                <div class="event-header">
                    <div class="event-title">创建突发事件</div>
                    <span class="close-modal" onclick="closeEventModal()">&times;</span>
                </div>
                <div class="form-group">
                    <label for="event-name">事件名称</label>
                    <input type="text" id="event-name" placeholder="请输入事件名称" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="event-description">事件描述</label>
                    <textarea id="event-description" placeholder="请输入事件描述" maxlength="200"></textarea>
                </div>
                <div class="form-group">
                    <label for="event-type">事件类型</label>
                    <select id="event-type">
                        <option value="rise">利好（上涨）</option>
                        <option value="fall">利空（下跌）</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="event-multiplier">影响倍数 (1-5倍)</label>
                    <input type="number" id="event-multiplier" min="1" max="5" step="0.5" value="2">
                </div>
                <div class="form-group">
                    <label>影响股票类型</label>
                    <div id="event-stock-types">
                        <?php foreach ($presetStockTypes as $type): ?>
                        <label style="display: inline-block; margin-right: 10px;">
                            <input type="checkbox" value="<?php echo $type; ?>"> <?php echo $type; ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                    <div style="margin-top: 10px;">
                        <input type="text" id="event-custom-type" placeholder="自定义类型">
                        <button class="btn btn-small" onclick="addCustomEventType()">添加</button>
                    </div>
                </div>
                <button class="btn" onclick="createEvent()">创建事件</button>
            </div>
        </div>
        <?php endif; ?>

        <div class="loan-panel">
            <h3>贷款中心</h3>
            <p class="loan-info">利息: 每3分钟0.5% (自动计算)</p>
            <input type="number" class="loan-amount" id="loan-amount" min="100" max="5000" placeholder="输入贷款金额(100-5000)">
            <button class="loan-btn" onclick="takeLoan()">申请贷款</button>
            <button class="repay-btn" onclick="repayLoan()">偿还贷款</button>
        </div>

        <div class="portfolio-panel" id="portfolio-panel">
            <h3>我的持仓</h3>
            <div id="portfolio-list"></div>
        </div>
    </div>

    <!-- 聊天室 -->
    <div id="chat-panel" class="<?php echo $isLoggedIn ? '' : 'hidden'; ?>">
        <div class="chat-header">
            <h3>
                <span>💬</span> 股民聊天室
                <span id="unread-count" class="unread-badge" style="display: none;">0</span>
            </h3>
            <div class="chat-controls">
                <button class="chat-control-btn" onclick="hideChat(event)" title="隐藏聊天室">🗕</button>
            </div>
        </div>
        <div class="chat-messages" id="chat-messages"></div>
        <div class="chat-input-area">
            <textarea class="chat-input" id="chat-input" placeholder="输入消息... (最多200字)" rows="2" maxlength="200"></textarea>
            <button class="chat-send-btn" onclick="sendMessage()" id="send-btn">发送</button>
        </div>
    </div>

    <!-- 聊天室显示按钮 -->
    <button class="chat-toggle-btn" id="chat-toggle-btn" onclick="showChat()" title="显示聊天室">💬</button>

    <div class="notification" id="notification"></div>
    
    <div class="event-notification" id="event-notification">
        <div class="event-title">市场突发事件</div>
        <div class="event-content" id="event-content"></div>
    </div>

    <script>
        let currentStock = null;
        let stocks = [];
        let updateTimer = null;
        let countdownTimer = null;
        let chatTimer = null;
        let chatHidden = false;
        let unreadCount = 0;
        let lastMessageCount = 0;
        let currentUsername = '<?php echo htmlspecialchars($username); ?>';
        let currentNickname = '';
        let isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
        let canCreateStock = true;
        let presetTypes = [];
        let events = [];

        // 检查登录状态
        function checkLogin() {
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'ajax_action=check_login'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.logged_in) {
                    document.getElementById('auth-panel').style.display = 'none';
                    document.getElementById('game-panel').style.display = 'block';
                    document.getElementById('chat-panel').classList.remove('hidden');
                    document.getElementById('chat-toggle-btn').classList.remove('visible');
                    document.getElementById('username-display').textContent = data.username;
                    currentUsername = data.username;
                    isAdmin = data.is_admin;
                    chatHidden = false;
                    loadGameData();
                    loadChatMessages();
                    startAutoUpdate();
                    startChatUpdate();
                }
            });
        }

        // 加载游戏数据
        function loadGameData() {
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'ajax_action=get_game_data'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 更新用户信息
                    document.getElementById('nickname-display').textContent = data.user.nickname;
                    document.getElementById('balance-display').textContent = data.user.balance.toFixed(2);
                    document.getElementById('loan-display').textContent = data.user.loan.toFixed(2);
                    document.getElementById('total-assets-display').textContent = data.total_assets.toFixed(2);
                    
                    // 更新股票数据
                    stocks = data.stocks;
                    renderStocks();
                    
                    // 更新持仓
                    renderPortfolio(data.user.portfolio, data.stocks);
                    
                    // 更新倒计时
                    startCountdown(data.timer.next_update, data.timer.current_time);
                    
                    // 更新创建股票按钮状态
                    canCreateStock = data.user.can_create_stock;
                    updateCreateStockButton();
                    
                    // 保存预设类型
                    presetTypes = data.preset_types || [];
                    renderStockTypes();
                    
                    // 保存事件
                    events = data.events || [];
                    
                    // 显示事件通知
                    if (data.event) {
                        showEventNotification(data.event);
                    }
                }
            });
        }

        // 渲染股票类型下拉框
        function renderStockTypes() {
            const select = document.getElementById('stock-type');
            if (select) {
                select.innerHTML = '<option value="">请选择股票类型</option>';
                presetTypes.forEach(type => {
                    select.innerHTML += `<option value="${type}">${type}</option>`;
                });
            }
        }

        // 渲染股票列表
        function renderStocks() {
            const container = document.getElementById('stocks-container');
            if (!stocks || stocks.length === 0) {
                container.innerHTML = '<p style="text-align: center; width: 100%;">暂无股票数据</p>';
                return;
            }
            
            container.innerHTML = '';
            
            stocks.forEach(stock => {
                // 跳过下线的股票（管理员可见）
                if (stock.online === false && !isAdmin) {
                    return;
                }
                
                const card = document.createElement('div');
                card.className = 'stock-card' + (stock.online === false ? ' offline' : '');
                card.onclick = () => showStockDetail(stock);
                
                const changeClass = stock.change >= 0 ? 'rise' : 'fall';
                const changeSymbol = stock.change >= 0 ? '+' : '';
                
                let adminControls = '';
                if (isAdmin) {
                    adminControls = `
                        <div class="stock-admin-controls">
                            <button class="stock-admin-btn" onclick="event.stopPropagation(); editStock(${stock.id})">编辑</button>
                            <button class="stock-admin-btn" onclick="event.stopPropagation(); toggleStockOnline(${stock.id}, ${!stock.online})">${stock.online === false ? '上线' : '下线'}</button>
                        </div>
                    `;
                }
                
                let customBadge = '';
                if (stock.is_custom) {
                    customBadge = '<div class="stock-custom-badge">自定义</div>';
                }
                
                card.innerHTML = `
                    ${adminControls}
                    ${customBadge}
                    <div class="stock-name">${stock.name}</div>
                    <div class="stock-price">${stock.price.toFixed(2)} 元</div>
                    <div class="stock-change ${changeClass}">${changeSymbol}${stock.change.toFixed(2)}%</div>
                `;
                
                container.appendChild(card);
            });
        }

        // 显示股票详情
        function showStockDetail(stock) {
            currentStock = stock;
            const modal = document.getElementById('stock-modal');
            
            document.getElementById('modal-stock-name').textContent = stock.name;
            document.getElementById('modal-stock-type').textContent = stock.type;
            document.getElementById('modal-stock-price').textContent = stock.price.toFixed(2);
            
            const changeClass = stock.change >= 0 ? 'rise' : 'fall';
            const changeSymbol = stock.change >= 0 ? '+' : '';
            document.getElementById('modal-stock-change').textContent = `${changeSymbol}${stock.change.toFixed(2)}`;
            document.getElementById('modal-stock-change').className = changeClass;
            
            document.getElementById('modal-stock-high').textContent = stock.high.toFixed(2);
            document.getElementById('modal-stock-low').textContent = stock.low.toFixed(2);
            document.getElementById('modal-stock-volume').textContent = stock.volume.toLocaleString();
            
            // 显示创建者信息
            const creatorSpan = document.getElementById('modal-stock-creator');
            if (stock.created_by && stock.created_by !== 'system') {
                creatorSpan.textContent = `创建者: ${stock.created_by}`;
            } else {
                creatorSpan.textContent = '创建者: 系统';
            }
            
            // 获取持仓
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'ajax_action=get_game_data'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const holding = data.user.portfolio[stock.id] || 0;
                    document.getElementById('modal-stock-holding').textContent = holding;
                }
            });
            
            drawPriceChart(stock);
            
            modal.style.display = 'flex';
        }

        // 绘制价格图表
        function drawPriceChart(stock) {
            const canvas = document.getElementById('price-chart');
            const ctx = canvas.getContext('2d');
            
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // 生成模拟数据
            const priceData = [];
            let currentPrice = stock.price;
            for (let i = 0; i < 20; i++) {
                currentPrice = currentPrice * (1 + (Math.random() - 0.5) * 0.02);
                priceData.push(currentPrice);
            }
            
            const maxPrice = Math.max(...priceData);
            const minPrice = Math.min(...priceData);
            const range = maxPrice - minPrice || 1;
            
            const padding = 20;
            const chartWidth = canvas.width - padding * 2;
            const chartHeight = canvas.height - padding * 2;
            
            // 绘制网格
            ctx.strokeStyle = '#f0f0f0';
            ctx.lineWidth = 1;
            
            for (let i = 0; i <= 4; i++) {
                const y = padding + (chartHeight / 4) * i;
                ctx.beginPath();
                ctx.moveTo(padding, y);
                ctx.lineTo(canvas.width - padding, y);
                ctx.stroke();
            }
            
            // 绘制折线
            ctx.strokeStyle = stock.change >= 0 ? '#e74c3c' : '#27ae60';
            ctx.fillStyle = stock.change >= 0 ? 'rgba(231, 76, 60, 0.1)' : 'rgba(39, 174, 96, 0.1)';
            ctx.lineWidth = 2;
            
            ctx.beginPath();
            
            priceData.forEach((price, index) => {
                const x = padding + (chartWidth / (priceData.length - 1)) * index;
                const y = canvas.height - padding - ((price - minPrice) / range) * chartHeight;
                
                if (index === 0) {
                    ctx.moveTo(x, y);
                    ctx.lineTo(x, canvas.height - padding);
                } else {
                    ctx.lineTo(x, y);
                }
            });
            
            const lastX = padding + (chartWidth / (priceData.length - 1)) * (priceData.length - 1);
            ctx.lineTo(lastX, canvas.height - padding);
            ctx.closePath();
            ctx.fill();
            
            ctx.beginPath();
            priceData.forEach((price, index) => {
                const x = padding + (chartWidth / (priceData.length - 1)) * index;
                const y = canvas.height - padding - ((price - minPrice) / range) * chartHeight;
                
                if (index === 0) {
                    ctx.moveTo(x, y);
                } else {
                    ctx.lineTo(x, y);
                }
                
                ctx.fillStyle = stock.change >= 0 ? '#e74c3c' : '#27ae60';
                ctx.beginPath();
                ctx.arc(x, y, 3, 0, Math.PI * 2);
                ctx.fill();
            });
            ctx.stroke();
        }

        // 关闭弹窗
        function closeModal() {
            document.getElementById('stock-modal').style.display = 'none';
            currentStock = null;
        }

        // 交易股票
        function tradeStock(type) {
            if (!currentStock) return;
            
            const amount = parseInt(document.getElementById('trade-amount').value);
            if (isNaN(amount) || amount < 1) {
                showNotification('请输入有效的交易数量', 'error');
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=trade&stock_id=${currentStock.id}&type=${type}&amount=${amount}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    document.getElementById('balance-display').textContent = data.balance.toFixed(2);
                    document.getElementById('modal-stock-holding').textContent = data.holding;
                    loadGameData(); // 重新加载所有数据
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        // 卖出全部
        function sellAllStock(stockId = null) {
            const targetStockId = stockId || (currentStock ? currentStock.id : null);
            if (!targetStockId) return;
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=sell_all&stock_id=${targetStockId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    document.getElementById('balance-display').textContent = data.balance.toFixed(2);
                    if (!stockId && currentStock) {
                        closeModal();
                    }
                    loadGameData();
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        // 登录
        function login() {
            const username = document.getElementById('login-username').value;
            const password = document.getElementById('login-password').value;
            
            if (!username || !password) {
                showNotification('请输入用户名和密码', 'error');
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=login&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('auth-panel').style.display = 'none';
                    document.getElementById('game-panel').style.display = 'block';
                    document.getElementById('chat-panel').classList.remove('hidden');
                    document.getElementById('chat-toggle-btn').classList.remove('visible');
                    document.getElementById('username-display').textContent = username;
                    currentUsername = username;
                    isAdmin = data.is_admin;
                    chatHidden = false;
                    loadGameData();
                    loadChatMessages();
                    startAutoUpdate();
                    startChatUpdate();
                    showNotification('登录成功', 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        // 注册
        function register() {
            const username = document.getElementById('reg-username').value;
            const nickname = document.getElementById('reg-nickname').value;
            const password = document.getElementById('reg-password').value;
            const confirm = document.getElementById('reg-confirm').value;
            
            if (!username || !nickname || !password || !confirm) {
                showNotification('请填写所有字段', 'error');
                return;
            }
            
            if (password !== confirm) {
                showNotification('两次输入的密码不一致', 'error');
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=register&username=${encodeURIComponent(username)}&nickname=${encodeURIComponent(nickname)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('注册成功，请登录', 'success');
                    switchToLogin();
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        // 退出登录
        function logout() {
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'ajax_action=logout'
            })
            .then(() => {
                document.getElementById('auth-panel').style.display = 'block';
                document.getElementById('game-panel').style.display = 'none';
                document.getElementById('chat-panel').classList.add('hidden');
                document.getElementById('chat-toggle-btn').classList.remove('visible');
                if (updateTimer) clearInterval(updateTimer);
                if (countdownTimer) clearInterval(countdownTimer);
                if (chatTimer) clearInterval(chatTimer);
            });
        }

        // 切换表单
        function switchToRegister() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        }

        function switchToLogin() {
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }

        // 贷款
        function takeLoan() {
            const amount = parseInt(document.getElementById('loan-amount').value);
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=take_loan&amount=${amount}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    document.getElementById('balance-display').textContent = data.balance.toFixed(2);
                    document.getElementById('loan-display').textContent = data.loan.toFixed(2);
                    document.getElementById('loan-amount').value = '';
                    loadGameData();
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        // 还款
        function repayLoan() {
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'ajax_action=repay_loan'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    document.getElementById('balance-display').textContent = data.balance.toFixed(2);
                    document.getElementById('loan-display').textContent = data.loan;
                    loadGameData();
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        // 渲染持仓
        function renderPortfolio(portfolio, stocks) {
            const container = document.getElementById('portfolio-list');
            
            if (!portfolio || Object.keys(portfolio).length === 0) {
                container.innerHTML = '<p style="color: #666; text-align: center;">暂无持仓</p>';
                return;
            }
            
            container.innerHTML = '';
            
            for (const [stockId, amount] of Object.entries(portfolio)) {
                const stock = stocks.find(s => s.id === parseInt(stockId));
                if (!stock || amount <= 0) continue;
                
                const item = document.createElement('div');
                item.className = 'portfolio-item';
                item.innerHTML = `
                    <div class="portfolio-item-info">
                        <div class="portfolio-item-name">${stock.name}</div>
                        <div class="portfolio-item-amount">持有 ${amount} 股 | 市值: ${(stock.price * amount).toFixed(2)} 元</div>
                    </div>
                    <button class="portfolio-sell-all" onclick="sellAllStock(${stock.id})">全部卖出</button>
                `;
                
                container.appendChild(item);
            }
        }

        // 启动自动更新
        function startAutoUpdate() {
            if (updateTimer) clearInterval(updateTimer);
            updateTimer = setInterval(loadGameData, 30000); // 30秒更新一次
        }

        // 启动聊天自动更新
        function startChatUpdate() {
            if (chatTimer) clearInterval(chatTimer);
            chatTimer = setInterval(loadChatMessages, 5000); // 5秒更新一次
        }

        // 启动倒计时
        function startCountdown(nextUpdate, currentTime) {
            if (countdownTimer) clearInterval(countdownTimer);
            
            let remaining = Math.max(0, nextUpdate - currentTime);
            
            function updateDisplay() {
                const minutes = Math.floor(remaining / 60);
                const seconds = Math.floor(remaining % 60);
                document.getElementById('refresh-countdown').textContent = 
                    `下次行情更新: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if (remaining > 0) {
                    remaining--;
                }
            }
            
            updateDisplay();
            countdownTimer = setInterval(updateDisplay, 1000);
        }

        // 打开排行榜
        function openRanking() {
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'ajax_action=get_game_data'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const list = document.getElementById('ranking-list');
                    list.innerHTML = '';
                    
                    data.ranking.forEach((user, index) => {
                        const item = document.createElement('div');
                        item.className = 'ranking-item';
                        item.innerHTML = `
                            <div class="ranking-rank">${index + 1}</div>
                            <div class="ranking-username">${user.nickname}</div>
                            <div class="ranking-assets">${user.totalAssets.toFixed(2)} 元</div>
                        `;
                        list.appendChild(item);
                    });
                    
                    document.getElementById('ranking-modal').style.display = 'flex';
                }
            });
        }

        function closeRanking() {
            document.getElementById('ranking-modal').style.display = 'none';
        }

        // 创建股票相关
        function openCreateStockModal() {
            if (!canCreateStock && !isAdmin) {
                showNotification('您已经创建过自定义股票了', 'error');
                return;
            }
            document.getElementById('create-stock-modal').style.display = 'flex';
            renderStockTypes();
            
            // 更新价格显示
            const priceInput = document.getElementById('stock-price');
            const costSpan = document.getElementById('create-stock-cost');
            
            // 移除旧的事件监听器，添加新的
            priceInput.removeEventListener('input', updateCost);
            priceInput.addEventListener('input', updateCost);
            
            function updateCost() {
                costSpan.textContent = priceInput.value;
            }
            updateCost();
        }

        function closeCreateStockModal() {
            document.getElementById('create-stock-modal').style.display = 'none';
            document.getElementById('stock-name').value = '';
            document.getElementById('stock-type').value = '';
            if (document.getElementById('stock-type-custom')) {
                document.getElementById('stock-type-custom').value = '';
            }
            document.getElementById('stock-price').value = '100';
        }

        function updateCreateStockButton() {
            const btn = document.getElementById('create-stock-btn');
            if (!canCreateStock && !isAdmin) {
                btn.classList.add('disabled');
                btn.title = '您已经创建过自定义股票了';
            } else {
                btn.classList.remove('disabled');
                btn.title = '创建自定义股票';
            }
        }

        function createStock() {
            const name = document.getElementById('stock-name').value.trim();
            let type = document.getElementById('stock-type').value;
            const customType = document.getElementById('stock-type-custom')?.value.trim();
            const price = parseFloat(document.getElementById('stock-price').value);
            
            // 管理员可以使用自定义类型
            if (isAdmin && customType) {
                type = customType;
            }
            
            if (!name || !type) {
                showNotification('请填写股票名称和类型', 'error');
                return;
            }
            
            if (isNaN(price) || price < 1 || price > 10000) {
                showNotification('价格必须在1-10000之间', 'error');
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=create_stock&name=${encodeURIComponent(name)}&type=${encodeURIComponent(type)}&price=${price}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    document.getElementById('balance-display').textContent = data.balance.toFixed(2);
                    closeCreateStockModal();
                    loadGameData();
                    loadChatMessages();
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        // 显示事件通知
        function showEventNotification(event) {
            const notification = document.getElementById('event-notification');
            document.getElementById('event-content').textContent = event.description;
            notification.style.display = 'block';
            
            setTimeout(() => {
                notification.style.display = 'none';
            }, 5000);
        }

        // 显示普通通知
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type}`;
            notification.style.display = 'block';
            
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

        // 点击空白处关闭弹窗
        window.onclick = function(event) {
            const stockModal = document.getElementById('stock-modal');
            const rankingModal = document.getElementById('ranking-modal');
            const adminModal = document.getElementById('admin-modal');
            const createStockModal = document.getElementById('create-stock-modal');
            const eventModal = document.getElementById('event-modal');
            
            if (event.target === stockModal) {
                closeModal();
            }
            
            if (event.target === rankingModal) {
                closeRanking();
            }
            
            if (event.target === adminModal) {
                closeAdminPanel();
            }
            
            if (event.target === createStockModal) {
                closeCreateStockModal();
            }
            
            if (event.target === eventModal) {
                closeEventModal();
            }
        }

        // 聊天室功能
        function loadChatMessages() {
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'ajax_action=get_messages'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderMessages(data.messages);
                    
                    // 更新未读消息计数
                    if (data.messages.length > lastMessageCount) {
                        if (chatHidden) {
                            unreadCount += (data.messages.length - lastMessageCount);
                            updateUnreadBadge();
                        }
                        lastMessageCount = data.messages.length;
                    }
                }
            });
        }

        function renderMessages(messages) {
            const container = document.getElementById('chat-messages');
            const wasAtBottom = isScrolledToBottom(container);
            
            container.innerHTML = '';
            
            messages.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message' + (msg.username === 'system' ? ' system' : '');
                
                // 高亮当前用户的消息
                if (msg.username === currentUsername) {
                    messageDiv.style.background = '#e3f2fd';
                }
                
                messageDiv.innerHTML = `
                    <div class="message-header">
                        <span class="message-username">${msg.display_name}</span>
                        <span class="message-time">${msg.time_formatted}</span>
                    </div>
                    <div class="message-content">${msg.content}</div>
                `;
                
                container.appendChild(messageDiv);
            });
            
            // 如果之前在底部，自动滚动到底部
            if (wasAtBottom || messages.length > 0) {
                container.scrollTop = container.scrollHeight;
            }
        }

        function isScrolledToBottom(element) {
            return element.scrollHeight - element.scrollTop - element.clientHeight < 50;
        }

        function sendMessage() {
            const input = document.getElementById('chat-input');
            const content = input.value.trim();
            const sendBtn = document.getElementById('send-btn');
            
            if (!content) {
                showNotification('请输入消息', 'error');
                return;
            }
            
            sendBtn.disabled = true;
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=send_message&content=${encodeURIComponent(content)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    input.value = '';
                    renderMessages(data.messages);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .finally(() => {
                sendBtn.disabled = false;
            });
        }

        function hideChat(event) {
            event.stopPropagation();
            document.getElementById('chat-panel').classList.add('hidden');
            document.getElementById('chat-toggle-btn').classList.add('visible');
            document.getElementById('game-panel').classList.add('chat-hidden');
            document.getElementById('portfolio-panel').classList.add('chat-hidden');
            document.getElementById('event-notification').classList.add('chat-hidden');
            chatHidden = true;
            unreadCount = 0;
            updateUnreadBadge();
        }

        function showChat() {
            document.getElementById('chat-panel').classList.remove('hidden');
            document.getElementById('chat-toggle-btn').classList.remove('visible');
            document.getElementById('game-panel').classList.remove('chat-hidden');
            document.getElementById('portfolio-panel').classList.remove('chat-hidden');
            document.getElementById('event-notification').classList.remove('chat-hidden');
            chatHidden = false;
            unreadCount = 0;
            updateUnreadBadge();
            
            // 重新加载消息并滚动到底部
            loadChatMessages();
        }

        function updateUnreadBadge() {
            const badge = document.getElementById('unread-count');
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = 'inline';
            } else {
                badge.style.display = 'none';
            }
        }

        // 管理员功能
        function openAdminPanel() {
            if (!isAdmin) {
                showNotification('权限不足', 'error');
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'ajax_action=admin_get_users'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderUserList(data.users);
                    renderStockListAdmin();
                    renderEventList();
                    document.getElementById('admin-modal').style.display = 'flex';
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error opening admin panel:', error);
                showNotification('加载失败', 'error');
            });
        }

        function closeAdminPanel() {
            document.getElementById('admin-modal').style.display = 'none';
        }

        function renderUserList(users) {
            const container = document.getElementById('user-list');
            container.innerHTML = '';
            
            users.forEach(user => {
                const item = document.createElement('div');
                item.className = 'user-item';
                item.innerHTML = `
                    <div class="user-info-text">
                        <strong>${user.nickname}</strong> (${user.username})
                        <br>
                        余额: ${user.balance.toFixed(2)} | 贷款: ${user.loan.toFixed(2)}
                    </div>
                    <div class="user-actions">
                        <input type="text" placeholder="新密码" id="pass-${user.username}">
                        <button onclick="updateUser('${user.username}', 'password', document.getElementById('pass-${user.username}').value)">改密码</button>
                        <input type="text" placeholder="新昵称" id="nick-${user.username}">
                        <button onclick="updateUser('${user.username}', 'nickname', document.getElementById('nick-${user.username}').value)">改昵称</button>
                        <input type="number" placeholder="余额" id="bal-${user.username}" value="${user.balance}">
                        <button onclick="updateUser('${user.username}', 'balance', document.getElementById('bal-${user.username}').value)">改余额</button>
                        <input type="number" placeholder="贷款" id="loan-${user.username}" value="${user.loan}">
                        <button onclick="updateUser('${user.username}', 'loan', document.getElementById('loan-${user.username}').value)">改贷款</button>
                    </div>
                `;
                container.appendChild(item);
            });
        }

        function renderStockListAdmin() {
            const container = document.getElementById('stock-list-admin');
            container.innerHTML = '';
            
            stocks.forEach(stock => {
                const customBadge = stock.is_custom ? '<span class="stock-custom-badge-admin">自定义</span>' : '';
                const onlineStatus = stock.online === false ? ' (已下线)' : '';
                
                const item = document.createElement('div');
                item.className = 'stock-item';
                item.innerHTML = `
                    <div class="stock-info-text">
                        <strong>${stock.name}</strong> ${customBadge} (${stock.type})${onlineStatus}
                        <br>
                        价格: ${stock.price.toFixed(2)} | 创建者: ${stock.created_by || '系统'}
                    </div>
                    <div class="stock-actions">
                        <input type="text" placeholder="新名称" id="name-${stock.id}">
                        <button onclick="updateStock(${stock.id}, 'name', document.getElementById('name-${stock.id}').value)">改名称</button>
                        <input type="number" placeholder="新价格" id="price-${stock.id}" value="${stock.price}">
                        <button onclick="updateStock(${stock.id}, 'price', document.getElementById('price-${stock.id}').value)">改价格</button>
                        <input type="text" placeholder="新类型" id="type-${stock.id}">
                        <button onclick="updateStock(${stock.id}, 'type', document.getElementById('type-${stock.id}').value)">改类型</button>
                        ${stock.is_custom ? `
                            <button class="delete-btn" onclick="deleteStock(${stock.id})">删除</button>
                        ` : ''}
                        <button class="toggle-btn" onclick="toggleStockOnline(${stock.id}, ${stock.online === false})">
                            ${stock.online === false ? '上线' : '下线'}
                        </button>
                    </div>
                `;
                container.appendChild(item);
            });
        }

        function renderEventList() {
            const container = document.getElementById('event-list');
            if (!container) return;
            
            container.innerHTML = '';
            
            events.forEach(event => {
                const typeText = event.type === 'rise' ? '利好' : '利空';
                const typesHtml = event.stockTypes.map(t => `<span class="type-tag">${t}</span>`).join('');
                
                const item = document.createElement('div');
                item.className = 'event-item';
                item.innerHTML = `
                    <div class="event-info-text">
                        <strong>${event.name}</strong> (${typeText}, ${event.multiplier}倍)
                        <br>
                        <small>${event.description}</small>
                        <br>
                        影响类型: ${typesHtml}
                        <br>
                        创建者: ${event.created_by || '系统'}
                    </div>
                    <div class="event-actions">
                        <button class="toggle-btn" onclick="triggerEvent(${event.id})">触发事件</button>
                        <input type="text" placeholder="新名称" id="event-name-${event.id}" value="${event.name}">
                        <button onclick="updateEvent(${event.id}, 'name', document.getElementById('event-name-${event.id}').value)">改名称</button>
                        <input type="text" placeholder="新描述" id="event-desc-${event.id}" value="${event.description}">
                        <button onclick="updateEvent(${event.id}, 'description', document.getElementById('event-desc-${event.id}').value)">改描述</button>
                        <input type="number" placeholder="倍数" id="event-mul-${event.id}" value="${event.multiplier}" step="0.5" min="1" max="5">
                        <button onclick="updateEvent(${event.id}, 'multiplier', document.getElementById('event-mul-${event.id}').value)">改倍数</button>
                        <button class="delete-btn" onclick="deleteEvent(${event.id})">删除</button>
                    </div>
                `;
                container.appendChild(item);
            });
        }

        function updateUser(username, field, value) {
            if (!value && field !== 'balance' && field !== 'loan') {
                showNotification('请输入值', 'error');
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=admin_update_user&target_username=${encodeURIComponent(username)}&field=${field}&value=${encodeURIComponent(value)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('更新成功', 'success');
                    openAdminPanel(); // 刷新列表
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        function updateStock(stockId, field, value) {
            if (!value) {
                showNotification('请输入值', 'error');
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=admin_update_stock&stock_id=${stockId}&field=${field}&value=${encodeURIComponent(value)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('更新成功', 'success');
                    loadGameData(); // 刷新股票数据
                    openAdminPanel(); // 刷新管理面板
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        function deleteStock(stockId) {
            if (!confirm('确定要删除这个自定义股票吗？')) {
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=admin_delete_stock&stock_id=${stockId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('删除成功', 'success');
                    loadGameData(); // 刷新股票数据
                    openAdminPanel(); // 刷新管理面板
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        function toggleStockOnline(stockId, online) {
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=admin_toggle_stock&stock_id=${stockId}&online=${online}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    loadGameData(); // 刷新股票数据
                    if (document.getElementById('admin-modal').style.display === 'flex') {
                        openAdminPanel(); // 刷新管理面板
                    }
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        function editStock(stockId) {
            const stock = stocks.find(s => s.id === stockId);
            if (stock) {
                openAdminPanel();
                // 滚动到对应的股票
                setTimeout(() => {
                    document.getElementById(`name-${stockId}`)?.scrollIntoView({ behavior: 'smooth' });
                }, 100);
            }
        }

        // 事件管理功能
        function openEventModal() {
            document.getElementById('event-modal').style.display = 'flex';
        }

        function closeEventModal() {
            document.getElementById('event-modal').style.display = 'none';
            document.getElementById('event-name').value = '';
            document.getElementById('event-description').value = '';
            document.getElementById('event-type').value = 'rise';
            document.getElementById('event-multiplier').value = '2';
            document.querySelectorAll('#event-stock-types input[type="checkbox"]').forEach(cb => cb.checked = false);
            document.getElementById('event-custom-type').value = '';
        }

        function addCustomEventType() {
            const customType = document.getElementById('event-custom-type').value.trim();
            if (!customType) return;
            
            // 创建新的checkbox
            const container = document.getElementById('event-stock-types');
            const label = document.createElement('label');
            label.style.display = 'inline-block';
            label.style.marginRight = '10px';
            label.innerHTML = `<input type="checkbox" value="${customType}" checked> ${customType}`;
            container.appendChild(label);
            
            document.getElementById('event-custom-type').value = '';
        }

        function createEvent() {
            const name = document.getElementById('event-name').value.trim();
            const description = document.getElementById('event-description').value.trim();
            const type = document.getElementById('event-type').value;
            const multiplier = parseFloat(document.getElementById('event-multiplier').value);
            
            // 获取选中的股票类型
            const stockTypes = [];
            document.querySelectorAll('#event-stock-types input[type="checkbox"]:checked').forEach(cb => {
                stockTypes.push(cb.value);
            });
            
            if (!name || !description || stockTypes.length === 0) {
                showNotification('请填写完整的事件信息', 'error');
                return;
            }
            
            if (multiplier < 1 || multiplier > 5) {
                showNotification('倍数必须在1-5之间', 'error');
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=admin_create_event&name=${encodeURIComponent(name)}&description=${encodeURIComponent(description)}&type=${type}&multiplier=${multiplier}&stockTypes=${encodeURIComponent(JSON.stringify(stockTypes))}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('事件创建成功', 'success');
                    closeEventModal();
                    loadGameData();
                    openAdminPanel();
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        function updateEvent(eventId, field, value) {
            if (!value) {
                showNotification('请输入值', 'error');
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=admin_update_event&event_id=${eventId}&field=${field}&value=${encodeURIComponent(value)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('更新成功', 'success');
                    loadGameData();
                    openAdminPanel();
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        function deleteEvent(eventId) {
            if (!confirm('确定要删除这个突发事件吗？')) {
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=admin_delete_event&event_id=${eventId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('删除成功', 'success');
                    loadGameData();
                    openAdminPanel();
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        function triggerEvent(eventId) {
            if (!confirm('确定要手动触发这个突发事件吗？')) {
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ajax_action=admin_trigger_event&event_id=${eventId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('事件已触发', 'success');
                    loadGameData();
                    if (data.event) {
                        showEventNotification(data.event);
                    }
                    if (document.getElementById('admin-modal').style.display === 'flex') {
                        openAdminPanel();
                    }
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        // 按回车发送消息
        document.getElementById('chat-input')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // 初始化
        document.addEventListener('DOMContentLoaded', function() {
            checkLogin();
            if (document.getElementById('game-panel').style.display === 'block') {
                loadGameData();
                loadChatMessages();
                startAutoUpdate();
                startChatUpdate();
            }
        });
    </script>
</body>
</html>