# Fotagrafia 🗽

> project 01 repository: **[Fotagrafia-frontend](https://github.com/bathtown/Fotagrafia-frontend)**

## 说明

1. 这是 fudan _19ss_web 基础课程\_Project_01_ 旅游照片分享平台（下）
2. my page:
3. my repository: **[Fotagrafia 🗽](https://github.com/bathtown/Fotagrafia)**

## 评分项

1. 首页
   - [x] [登录逻辑](frontend/js/feature.js#hintRegister)
   - [x] [刷新逻辑](frontend/html/home.html#getPhotos)
   - [x] [图片逻辑](backend/PHP/api/home.php)
2. 浏览页
   - [x] [筛选逻辑](backend/PHP/api/browser.php)
   - [ ] 图片逻辑
3. 搜索页
   - [x] [搜索逻辑](backend/PHP/api/search.php)
   - [ ] 图片逻辑
4. 登录页面
   - [x] [登录逻辑](backend/PHP/api/login.php)
5. 注册页面
   - [x] [注册逻辑](backend/PHP/api/register.php)
6. 我的照片
   - [ ] 图片逻辑
   - [x] [删除逻辑](backend/PHP/api/myGallery.php)
7. 我的收藏
   - [ ] 展示逻辑
   - [x] [删除逻辑](frontend/html/myHearts.html#deleteHeart)
8. 上传页面
   - [x] [合法性校验](frontend/html/upload.html#submitImg)
   - [x] [修改逻辑](frontend/html/upload.html)
9. 详细图片页面
   - [x] [信息展示](backend/PHP/api/detail.php)
   - [x] [收藏功能](backend/PHP/api/like.php)
10. Bonus
    - [x] [密码加盐](backend/PHP/api/register.php)
    - [x] [前端框架](#前端框架使用)
    - [ ] 部署服务器

## Drawbacks

1. 未使用缩略图
2. Log in 和 My Account 显示闪烁
3. search page 亮晶晶

## Backend

### ToDo Lists

- [x] [RESTful](backend/PHP/api/myHeart.php)
- [x] [防 SQL 注入](backend/PHP/app/SQLConfig.php)
- [x] [CORS](backend/PHP/app/CORS.php)
- [x] [HTTP Status Codes](backend/PHP/app/StatusCode.php)
- [x] [JWT](backend/PHP/app/Token.php)

### Trick Points 👻

1. token
   - 原想用单例模式实现 token 储存，但是 PHP 页面没有常驻内存，被销毁了，每次都是新的……
   - 最后实现方法：token 自验证
2. [CORS](backend/PHP/app/CORS.php)
   - preflight request 要额外注意
   - [same-origin policy](https://wangdoc.com/javascript/bom/same-origin.html)
3. RESTful
   - `$_SERVER['REQUEST_METHOD']` 实现
   - 没有内置 `$_PUT` `$_DELETE` 超级全局变量，要用 `file_get_contents('php://input')` 获取，一点都不优雅

### 参考资料

1. [密码加盐](https://www.cnblogs.com/makai/p/11130703.html)
2. [ajax 请求跨域](https://segmentfault.com/a/1190000012469713)
3. [firebase/php-jwt](https://github.com/firebase/php-jwt)
4. [firebase/php-jwt token 使用](https://www.cnblogs.com/yehuisir/p/11521165.html)

## Frontend

### ToDo Lists

- [x] [more friendly alert](frontend/html/register.html)
- [x] [前端登录拦截](frontend/html/myGallery.html)
- [x] [sessionStorage + token](frontend/html/login.html)

### 前端框架使用

- [jQuery](https://jquery.com)
- [jquery-confirm](http://craftpip.github.io/jquery-confirm)
- ~~[Holder.js](https://github.com/imsky/holder)~~
- ~~[Bootstrap](https://getbootstrap.com)~~
- ~~[bulma](https://bulma.io)~~
- ~~[UIkit](https://getuikit.com) | [UIkit 中文网](http://www.getuikit.net)~~

- Tip: 头文件引入顺序

  ```html
  <!-- jQuery -->
  <script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <!-- jquery-confirm -->
  <link href="https://cdn.bootcdn.net/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" rel="stylesheet" />
  <script src="https://cdn.bootcdn.net/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
  <!-- font-awesome CDN -->
  <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css" />
  <!-- 自定义css -->
  <link rel="stylesheet" type="text/css" href="../css/general.css" />
  <link rel="stylesheet" type="text/css" href="../css/register.css" />
  ```
