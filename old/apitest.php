<?php
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
$request_method = $_SERVER['REQUEST_METHOD'];
//echo $request_method;
$response = array();
$status="";

class dbConnect{
    private $conn;
    public $response=array();
    public function __construct($host,$userName,$password,$dbName)
     {
         $this->conn = new mysqli($host,$userName,$password,$dbName);
         if ($this->conn->connect_error) {
             die("Connection failed: " . $this->conn->connect_error);
         }
     }
     public function getDbConnection(){
        return $this->conn;
     }
     public function getAllData($tableName){
         $query = "SELECT * FROM ".$tableName;
         $result = $this->conn->query($query);
         if ($result->num_rows > 0) {
             //$row = $result-> fetch_all();
             //$rows = $result->fetch_all(PDO::FETCH_ASSOC);
             while($row = $result->fetch_assoc()) {
                 $this->response[] = array("id"=>$row["Id"],
                     "loginId"=>$row["LoginId"],
                     "pass"=>$row["Password"]);
             }
             //http_response_code(200);
             $this->status="success";
         } else {
             $this->status="success";
             $this->response="failed to retrive data";
         }
         return json_encode(array("status"=>$this->status,"data"=>$this->response));
     }

    public function getSingleRow($tableName,$conditionQuery){
        $query = "SELECT * FROM ".$tableName." WHERE ".$conditionQuery;
        //echo $query."</br>";
        $result = $this->conn->query($query);
        if ($result->num_rows >0) {
            while($row = $result->fetch_assoc()) {
                $this->response = array("id"=>$row["Id"],
                    "loginId"=>$row["LoginId"],
                    "pass"=>$row["Password"]);
            }
            //http_response_code(200);
            $this->status="success";
        } else {
            $this->status="success";
            $this->response="failed to retrive data";
        }
        return json_encode(array("status"=> $this->status , "data"=> $this->response ));
    }
}

switch ($request_method) {
    case 'POST':
        doPost();
        break;

    case 'GET':
        //echo "getMethod";
        doGet();
        break;

    default:
        doNothing();
        break;
}

function doPost(){
    //$_POST = file_get_contents("php://input");
    if ($_POST){
        //$data = json_decode($_POST);
        //echo json_encode($_POST["loginId"]);
        //echo "</br>";
        if(isset($_POST["loginId"]) && isset($_POST["pass"])) {
            $dbObj = new dbConnect("localhost", "a92c734d_suraj", "CozensHackleAppendCuss","a92c734d_suraj");
            $conn = $dbObj->getDbConnection();
            $LoginId = "suraj";
            $Password ="12345";
            //$result = $dbObj->getAllData("logintable");
            $query ="LoginId = '$LoginId' AND Password = '$Password'";
            //echo $query."</br>";
            $result = $dbObj->getSingleRow("logintable",$query);
            if ($result)
            $conn->close();
            echo $result;
        }
        else{
              echo json_encode(array("status"=>"failed","data"=>"empty fields"));
        }
    }else{
        echo json_encode(array("status"=>"failed","data"=>"failed to connect"));
    }
}

function doGet(){
        $dbObj = new dbConnect("localhost", "a92c734d_suraj", "CozensHackleAppendCuss","a92c734d_suraj");
        $conn = $dbObj->getDbConnection();
        $LoginId = "suraj";
        $Password ="12345";
        //$result = $dbObj->getAllData("logintable");
        $query ="LoginId = '$LoginId' AND Password = '$Password'";
        //echo $query."</br>";
        $result = $dbObj->getSingleRow("logintable",$query);
        http_response_code(200);
        echo $result;
        //echo $this->status;
        //echo  json_encode(array("status"=> $this->status , "data"=> $result ));
        $conn->close();
}

// Create connection
//$conn = new mysqli("localhost", "a92c734d_suraj", "CozensHackleAppendCuss","a92c734d_suraj");
// Check connection
