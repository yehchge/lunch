# 登入流程

## login page:

- 判斷是否登入(是否有 session->user_no & session->user_name)
- 如果有 session, 轉址到登入後的首頁
- method=get, 顯示登入頁
- method=post, 檢查帳號和密碼是否有值, 如果其中之一沒有, 回到登入頁
- 取得 account, password, remember_me.
- 到資料庫內找尋是否有帳號, 如果沒有, 回到登入頁
- 檢查輸入的 password 與資料庫內是否相同
    $authPassword = password_verify($sPassword, $pass);
- 如果不同, 回到登入頁
- 檢查是否有勾選 remember_me, 如果沒有 , 設定 cookie remember_twd browser 就消失
    setcookie("remember_twd", "", time() - (- * - * - * 60));
- 如果勾選 remember_me, 產生 rnd_password 16bytes, rnd_seletor 32bytes,
    兩個值 password_hash 後; 先計算 cookie 一個月後過期的時間是何時?! 取得 admin_token_auth 內
    目前 admin_no 登入的序號且未過期的資料, 如果找到, 將 admin_token_auth user 資料刪除.
    否則新增一筆該 user 的資料到 admin_token_auth. 並組成 remember_twd cookie 的 token
    $rawToken = $rnd_password . ':' . $data['admin_no'] . ':' . $rnd_seletor;
    並設定 cookie. 
    setcookie("remember_twd", $rawToken, $cookie_expiration_time);
- 清除 user_no, user_name, oCurrentUser 的 session
- 設定 user_no, user_name, oCurrentUser 的 session
- 轉址到首頁.

## index page:

- 檢查是否有 session user_no & user_name, 如果沒有, 導回登入頁
- 取得 session user_no & user_name
- 取得 cookie remember_twd
- 檢查 remember_twd cookie 是否存在, 且未過期, 過期時間大於現在.
    且 password_hash & selector_hash 用 password_verify 檢查都相同,
    且有 admin_no.
- 移除 session user_no, user_name, oCurrenrtUser.
- 檢查 admin_no 此序號資料庫是否存在? 且狀態為啟用.
- 如果有, 設定 session user_no, user_name, oCurrentUser.
- 刪除該 admin_no 在 admin_token_auth 內的資料.
- 重新產生並設定新的 remember_twd cookie.(產生方式如 login page)
- 新增新的 token 到 admin_token_auth.

## logout page:

- 取得 session->user_no
- 取得 admin_token_auth 資料
- 刪除 admin_token_auth 該使用者資料
- 設定 remember_twd cookie 時間過期 
    setcookie("remember_twd", "", time() - (- * - * - * 60));
- update session id
    session_regenerate_id(true);
- 設定 login 時設定的 user 等的 session 歸零或為空
- 轉址到登入頁

----


```sql
CREATE TABLE `admin_token_auth` (
    `no` INT(- NOT NULL AUTO_INCREMENT COMMENT '序號',
    `admin_no` INT(- NOT NULL DEFAULT '- COMMENT '使用者序號',
    `password_hash` VARCHAR(- NOT NULL DEFAULT '' COMMENT '驗證碼' COLLATE 'utf8mb4_general_ci',
    `selector_hash` VARCHAR(- NOT NULL DEFAULT '' COMMENT '驗證碼' COLLATE 'utf8mb4_general_ci',
    `is_expired` INT(- NOT NULL DEFAULT '- COMMENT '已過期',
    `expiry_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '有效日期',
    PRIMARY KEY (`no`) USING BTREE
)
COMMENT='後台使用者 remember me'
COLLATE='utf8mb4_general_ci'
ENGINE=MyISAM
```
