<?php

require "./helpler.php";

/**
 * return [
 *     "關閉" => '<?php echo $this->multilingual("multilingual_000001") ?>',
 *     "錯誤訊息" => '<?php echo $this->multilingual("multilingual_000002") ?>',
 *     "棄用" => '<?php echo $this->multilingual("multilingual_000003") ?>',
 *     "注意" => '<?php echo $this->multilingual("multilingual_000004") ?>',
 *     "警告" => '<?php echo $this->multilingual("multilingual_000005") ?>',
 *     "嚴格" => '<?php echo $this->multilingual("multilingual_000006") ?>',
 *     "同步" => '<?php echo $this->multilingual("multilingual_000007") ?>',
 *      ......
 */
$chinese_to_code = "./data/chinese_to_code.php";

/**
 * return [
 *     "multilingual_000001" => "關閉",
 *     "multilingual_000002" => "錯誤訊息",
 *     "multilingual_000003" => "棄用",
 *     "multilingual_000004" => "注意",
 *     "multilingual_000005" => "警告",
 *     "multilingual_000006" => "嚴格",
 *     "multilingual_000007" => "同步",
 *     "multilingual_000008" => "失敗",
 *     "multilingual_000009" => "非同步",
 *      ......
 */
$code_to_chinese = "./data/code_to_chinese.php";

// 要搜尋的目錄路徑
$searchPath = './waiting_process';

// load code_to_chinese.php
if (is_readable($code_to_chinese)) {
    $code_to_chinese_array = require $code_to_chinese;
} else {
    echo "沒讀到 code_to_chinese";
    return;
}

// load chinese_to_code.php
if (is_readable($chinese_to_code)) {
    $chinese_to_code_array = require $chinese_to_code;
} else {
    echo "沒讀到 chinese_to_code";
    return;
}

// 第一次，以較長的 key 為優先
searchFilesForChineseLonger($searchPath, $chinese_to_code_array);
// 處理第二次，有 key 就替換
searchFilesForChinese($searchPath, $chinese_to_code_array);

echo "完成中文對應替換！\n";
