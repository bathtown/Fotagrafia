# 🗽 Fotagrafia

> project 01 repository: **[bathtown.github.io](https://github.com/bathtown/bathtown.github.io)**

## 说明

1. 这是 fudan _19ss_web 基础课程\_Project_01_ 旅游照片分享平台（下）
2. my page:
3. my repository: **[Fotagrafia](https://github.com/bathtown/Fotagrafia)**

## 评分项

1. 首页
   - [x] [登录逻辑](frontend/src/html/home.html)
   - [ ] 刷新逻辑
   - [ ] 图片逻辑
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
   - [ ] 删除逻辑
7. 我的收藏
   - [ ] 展示逻辑
   - [ ] 删除逻辑
8. 上传页面
   - [ ] 合法性校验
   - [ ] 修改逻辑
9. 详细图片页面
   - [x] [信息展示](backend/PHP/api/detail.php)
   - [ ] 收藏功能
10. Bonus
    - [x] [密码加盐](backend/PHP/api/register.php)
    - [x] [前端框架](#前端框架使用)
    - [ ] 部署服务器

Bonus 完成情况

## Backend First

### Backend TODO Lists

1. 🥱 TODO
   - [x] 🤜 前后端分离 ...
   - ~~[ ] 🤜 RESTful -> `$_SERVER['REQUEST_METHOD'];`~~
   - [x] 🤜 防 SQL 注入
2. 👋 Doing
3. 👌 Done

   - [x] 👉 [注册 | 密码加盐 | Ajax](backend/PHP/api/register.php)
   - [x] 👉 [登录](backend/PHP/api/login.php)
   - [x] 👉 [跨域](backend/PHP/app/CORS.php)
   - [x] 👉 [错误码](backend/PHP/app/StatusCode.php)
   - [x] 👉 [JWT](backend/PHP/app/Token.php)
   - [x] 👉 [CORS](backend/PHP/app/CORS.php)

### Trick Points 👻

1. token
   - 原想用单例模式实现 token 储存，但是 PHP 页面没有常驻内存，被销毁了，每次都是新的……
   - 最后实现方法：token 自验证
2. [headers](backend/PHP/app/CORS.php)
   - preflight request 要额外注意
   - 学习: [same-origin](https://wangdoc.com/javascript/bom/same-origin.html)

### 参考资料

1. [密码加盐](https://www.cnblogs.com/makai/p/11130703.html)
2. [ajax 请求跨域](https://segmentfault.com/a/1190000012469713)
3. [same-origin](https://wangdoc.com/javascript/bom/same-origin.html)
4. [firebase/php-jwt](https://github.com/firebase/php-jwt) | [firebase/php-jwt token 使用](https://www.cnblogs.com/yehuisir/p/11521165.html)
5. [PHP 实现 RESTful 风格的 API](https://www.jianshu.com/p/f784ad32bf7f)
6. [PHP 实现 RESTful 风格的 API 实例](https://www.cnblogs.com/luyucheng/p/6016801.html)
7. [caoym/phpboot](https://github.com/caoym/phpboot)

## Frontend

### 前端框架使用

- 🤙 [jQuery](https://jquery.com)
- 🤙 [jquery-confirm](http://craftpip.github.io/jquery-confirm)
- 🖖 ~~[Holder.js](https://github.com/imsky/holder)~~
- 🖖 ~~[Bootstrap](https://getbootstrap.com)~~
- 🖖 ~~[bulma](https://bulma.io)~~
- 🖖 ~~[UIkit](https://getuikit.com) | [UIkit 中文网](http://www.getuikit.net)~~

- Tip: 头文件引入顺序

  ```html
  <!-- jQuery -->
  <script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
  <!-- jquery-confirm -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <!-- font-awesome CDN -->
  <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css" />
  <!-- 自定义css -->
  <link rel="stylesheet" type="text/css" href="../css/general.css" />
  <link rel="stylesheet" type="text/css" href="../css/register.css" />
  ```

### Frontend TODO Lists

1. 🥱 TODO
2. 👋 Doing
3. 👌 Done
   - [x] 👉 [more friendly alert](frontend/src/html/register.html)
   - [x] 👉 [前端登录拦截](frontend/src/html/home.html)
   - [x] 👉 [sessionStorage + token](frontend/src/html/login.html)
