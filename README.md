# 🗽 Fotagrafia

- project 01 repository: **[bathtown.github.io](https://github.com/bathtown/bathtown.github.io)**

## 说明

- 这是 fudan*19ss_web 基础课程\_Project_01* 旅游照片分享平台（下）

- my page:

- my repository: **[Fotagrafia](https://github.com/bathtown/Fotagrafia)**

- Bonus 完成情况

## Backend First

### Backend TODO Lists

- 🥱 TODO
  - 👉 前后端分离 ...
- 👋 Doing
- 👌 Done

  - 👉 [注册 | 密码加盐 | Ajax](backend/PHP/api/register.php) √
  - 👉 [登录](backend/PHP/api/login.php) √
  - 👉 [跨域](backend/PHP/app/CORS.php) √
  - 👉 [错误码](backend/PHP/app/statusCode.php) √
  - 👉 [JWT](backend/PHP/app/JwtAuth.php) **half √**

### 一些实现 | 参考资料

- [php 修行之路](https://github.com/threadshare/php)
- [密码加盐](https://www.cnblogs.com/makai/p/11130703.html)
- [ajax 请求跨域](https://segmentfault.com/a/1190000012469713)
- [JWT](https://github.com/firebase/php-jwt)
  - 真的坑，原是想用单例模式实现 token 储存，没想到 PHP 页面被销毁了，没有内存常驻，每次都是新的……

## Frontend

### 前端框架使用

- 🤙 [jQuery](https://jquery.com/)
- 🤙 [jquery-confirm](http://craftpip.github.io/jquery-confirm/)
- 🖖 ~~[Bootstrap](https://getbootstrap.com/)~~
- 🖖 ~~[bulma](https://bulma.io/)~~
- 🖖 ~~[UIkit](https://getuikit.com/) | [UIkit 中文网](http://www.getuikit.net/)~~

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

- 🥱 TODO
- 👋 Doing
- 👌 Done
  - 👉 [more friendly alert](frontend/src/html/register.html) √
  - 👉 [前端登录拦截](frontend/src/html/home.html) √
  - 👉 [localStorage | sessionStorage | cookie + token](frontend/src/html/login.html) √

### 设计手册

- 颜色
  - 蓝 #409EFF
  - 红 #ff4500
  - 橙 #ff9e57
  - 绿 #35e898
  - 青 #35d3a7
  - 灰 #a7adba
  - 黑 #444444
  - 浅灰 #dcdfe6
  - 浅白 #fafafa
  - 白 #ffffff
