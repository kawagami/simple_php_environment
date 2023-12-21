<?php

// 以較長的 key 為優先
function searchFilesForChineseLonger($dir, $chinese_to_code_array)
{
    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $path = $dir . '/' . $file;

            if (is_dir($path)) {
                // 如果是目錄，遞迴搜尋
                searchFilesForChinese($path, $chinese_to_code_array);
            } else {
                // 如果是檔案，讀取檔案內容
                $content = file_get_contents($path);

                // 使用正規表達式找尋兩個以上的中文字
                preg_match_all('/[\x{4e00}-\x{9fa5}]{2,}/u', $content, $matches);

                // 如果找到匹配，進行替換
                if (!empty($matches[0])) {
                    foreach ($matches[0] as $match) {
                        if (isset($chinese_to_code_array[$match])) {
                            // 取得中文對應的長度
                            $matchLength = mb_strlen($match, 'UTF-8');

                            // 檢查其他中文是否包含這個中文，且長度更長
                            foreach ($matches[0] as $otherMatch) {
                                $otherMatchLength = mb_strlen($otherMatch, 'UTF-8');
                                if ($otherMatchLength > $matchLength && mb_strpos($otherMatch, $match, 0, 'UTF-8') !== false) {
                                    // 如果找到比較長且包含的中文，不進行替換
                                    continue 2;
                                }
                            }

                            // 沒有更長的中文包含這個中文，進行替換
                            $replacement = $chinese_to_code_array[$match];
                            $content = str_replace($match, $replacement, $content);
                        }
                    }

                    // 寫回檔案
                    file_put_contents($path, $content);
                }
            }
        }
    }
}

// 處理第二次，有就替換
function searchFilesForChinese($dir, $chinese_to_code_array)
{
    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $path = $dir . '/' . $file;

            if (is_dir($path)) {
                // 如果是目錄，遞迴搜尋
                searchFilesForChinese($path, $chinese_to_code_array);
            } else {
                // 如果是檔案，讀取檔案內容
                $content = file_get_contents($path);

                // 使用正規表達式找尋兩個以上的中文字
                preg_match_all('/[\x{4e00}-\x{9fa5}]{2,}/u', $content, $matches);

                // 如果找到匹配，進行替換
                if (!empty($matches[0])) {
                    foreach ($matches[0] as $match) {
                        if (isset($chinese_to_code_array[$match])) {
                            $replacement = $chinese_to_code_array[$match];
                            $content = str_replace($match, $replacement, $content);
                        }
                    }

                    // 寫回檔案
                    file_put_contents($path, $content);
                }
            }
        }
    }
}
