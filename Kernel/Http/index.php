<html>
<pre>
<?php

include './Src/Request.php';

$request =  new \Http\Src\Request();

echo 'IP:'.($request->getIp()). nl2br(PHP_EOL);
echo 'URL:'.($request->getUrl()).nl2br(PHP_EOL);
echo 'QUERY_STRING:'.($request->getQueryString()).nl2br(PHP_EOL);
echo 'QUERY_DATA' . print_r( $request->getQueryData()).nl2br(PHP_EOL);
echo 'HEADERS' . print_r( $request->getHeaders()).nl2br(PHP_EOL);


?>
</pre>

</html>
