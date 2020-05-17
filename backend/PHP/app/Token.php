  <?php

  require_once 'php-jwt-master/src/JWT.php';

  use \Firebase\JWT\JWT; //导入JWT
  class Token
  {

    private static $key = 'FudanSs2020'; //key

    //签发Token
    public static function lssue($username)
    {
      $time = time(); //当前时间
      $token = [
        'iss' => 'Fotagrafiaer', //签发者 可选
        'aud' => 'Fotagrafiaee', //接收该 JWT 的一方，可选
        'iat' => $time, //签发时间
        'nbf' => $time, //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
        'exp' => $time + 7200, //过期时间,这里设置2个小时
        'data' => [ //自定义信息，不要定义敏感信息
          'username' => $username
        ]
      ];
      return JWT::encode($token, self::$key); //输出Token
    }

    public static function verification($jwt)
    {
      try {
        JWT::$leeway = 60; //当前时间减去60，把时间留点余地
        JWT::decode($jwt, self::$key, ['HS256']); //HS256方式，这里要和签发的时候对应，这里可以获取 user 信息
      } catch (\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
        // echo $e->getMessage();
        return false;
      } catch (\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
        // echo $e->getMessage();
        return false;
      } catch (\Firebase\JWT\ExpiredException $e) {  // token过期
        // echo $e->getMessage();
        return false;
      } catch (Exception $e) {  //其他错误
        // echo $e->getMessage();
        return false;
      }
      return true;
    }
  }
  ?>