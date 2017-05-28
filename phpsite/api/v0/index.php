<?php 
require dirname(__DIR__) . "/include/" . "config.php";
require dirname(__DIR__) . "/include/" . "imageutils.php";



function get() {
   global $json_encode_props, $versions, $stable_version, $testing_version;
   header("Content-Type: application/json");
   handle_version(basename(__DIR__));
   $result = array();
   $dates = array();
   $calendars = array();
   array_push($results, $calendars);
   array_push($results, $dates);

   $proto = "http".((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')?'s':'' );

   $dates['link'] = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/dates';
   $dates['path'] = $_SERVER['REQUEST_URI'].'/dates';
   $dates['description'] = 'Get current date for different calendars, do date algebra or convert a date from one calendar to another.'; 

   $calendars['link'] = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/calendars';
   $calendars['path'] = $_SERVER['REQUEST_URI'].'/calendars';
   $calendars['description'] = 'Get information for supported calendars or define a new calendar'; 

   $result['links'] = array($dates, $calendars);
   
   echo json_encode($result, $json_encode_props)."\n";
}

function post() {
   http_exit(400, "Unsupported method POST. Only supported method is GET.");
}

function put() {
   http_exit(400, "Unsupported method PUT. Only supported method is GET.");
}

function delete() {
   http_exit(400, "Unsupported method DELETE. Only supported method is GET.");
}



$method = isset($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : "";
if ($method == "GET") {
  get();
} else if ($method == "POST") {
  post();
} else if ($method == "PUT") {
  put();
} else if ($method == "DELETE") {
  delete();
} else {
  $method = $method.replace("\\", "\\\\");
  $method = $method.replace("'", "\\'");
  http_exit(405, "Method '" . $method . "' not allowed. Allowed methods are 'GET', 'POST', 'PUT' and 'DELETE'.");
}
?>
