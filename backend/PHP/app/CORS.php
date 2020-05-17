  <?php
  header('access-control-allow-origin:http://127.0.0.1:5500');
  header("access-control-allow-methods: GET, POST");
  header('Content-Type:application/json;charset=utf-8');
  // header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Authorization");
  // TODO: 想加到请求头，但是一直被 Apache 拦截，qwq
  ?>  