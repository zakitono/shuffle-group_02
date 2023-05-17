<?php
$groups = [];
$mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
if ($mysqli->connect_error) {
    throw new RuntimeException('mysqli接続エラー:' . $mysqli->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $mysqli->query('SELECT name FROM employees');
    $employees = $result->fetch_all(MYSQLI_ASSOC);
    shuffle($employees);
    $cnt = count($employees);

    if ($cnt % 2 === 0) {
        $groups = array_chunk($employees, 2);
    } else {
        //末尾の名前を取得
        $extra = array_pop($employees);
        //配列を2で分割
        $groups = array_chunk($employees, 2);
        if (!empty($groups)) {
            //余りを、どこかのグループへ代入
            array_push($groups[0], $extra);
        } else {
            echo '社員を登録してください。';
        }
    }
}

include  __DIR__ . '/views/index.php';
