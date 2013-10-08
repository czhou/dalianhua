<?php
error_log(print_r($_SERVER, true));
$cmd = str_replace("/", "", $_SERVER['REQUEST_URI']);

if (function_exists($cmd)) {
	header('Content-type: text/json');
	call_user_func($cmd);
}else {
	exit;
}

function question() {
echo '{
    "question": "问题文本:'.rand().'",
    "question_id": "2",
    "audio": "http: //server/1.mp3",
    "answers": [
        {
            "content": "答案文本1",
            "correct": true
        },
        {
            "content": "答案文本2",
            "correct": false
        },
        {
            "content": "答案文本3",
            "correct": false
        }
    ]
}';
}



