# orderWebsite
面試時製作的訂餐網頁，未完善盡請見諒。


蟬吃茶點餐機器人
===
demo賬號：test
demo密碼：1234

### [Demo](https://kanwebsite.000webhostapp.com/orderWebsite/) | [檔案下載](https://drive.google.com/file/d/1y456ZcZ90M5gSVJSdkCma-sH8Tl4zVLn/view?usp=sharing) | [GitHub Repository](https://github.com/Kan090808/orderWebsite)
## 已完成功能：
- 簡易註冊登入功能
- 展示商品介紹（圖片）
- 菜單展示及搜尋商品（使用名稱或系列搜尋）
- 點餐
  - 透過系列名稱搜尋
  - 選擇商品
  - 編輯商品屬性
  - 加入購物車
  - 修改刪除購物車內商品
  - 確認訂單
  - 清空購物車
  - 點擊購物車內商品名稱可搜尋該產品
- 查看歷史訂單
- 經過RWD設計

## 未完成功能
- 登入可以使用各種api（如line登入，臉書登入）
- 首頁可擺放大型按鈕領導顧客，讓操作更視覺化
- 歷史訂單顯示顧客所需資訊，且訂單內的商品排列出來，使用較人性化
- 咨詢服務（聊天室，收到回復時通知顧客方或店方）
- 店家使用界面（查看訂單）

## 使用的技術：
- 前端：HTML,CSS,JavaScript,JQuery,Bootstrap
- 後端：PHP,MySQL
- 架設伺服器：000webhost

### 遇到的問題及解決方法
1. JSON回傳值繁體中文自動轉換為代碼
    教學文章：http://www.lrxin.com/archives-1029.html
    
    解決方法：(in PHP)
    `echo json_encode($return, JSON_UNESCAPED_UNICODE);`
    
    簡單說明:
    因json_encode()原只支援英文，故自動將傳回值中的中文轉成UTF-8的UNICODE編碼。而PHP5.4以後新增多一個參數"JSON_UNESCAPED_UNICODE"，以避免以上的問題。
    
2. JQuery 動態建立元素無法使用JQuery function
    教學文章：https://stackoverflow.com/questions/6658752/click-event-doesnt-work-on-dynamically-generated-elements
    
    解決方法：(in JQuery)
    `$('#parent').on('click', '.targetElement', function());`
    
    簡單說明：
    因JQuery函式只會套用在現有的網頁元素上，而使用JQuery在不刷新頁面產生新元素時，將遇到無法對其套用事件的情況。
    而找到的解決方法是避免將事件套用在會變動的元素上，而是將事件套用在變動元素的父元素上，因為父元素原已存在，選擇器能夠透過他去重新尋找目標元素。
### HackMD: https://hackmd.io/s/BJ99GKaKN
