<?php
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");

class dbConnect{
    private $conn;
    private $response=array();
    private $status="";
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
    public function getAllRows($tableName):array{
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
            $this->status="success";
        } else {
            $this->status="success";
            $this->response="failed to retrive data";
        }
        return array("status"=>$this->status,"data"=>$this->response);
    }

    public function getSingleRow($tableName,$conditionQuery):array {
        $query = "SELECT * FROM ".$tableName." WHERE ".$conditionQuery;
        //echo $query."</br>";
        $result = $this->conn->query($query);
        if ($result->num_rows >0) {
            while($row = $result->fetch_assoc()) {
                $this->response = array("id"=>$row["Id"],
                    "loginId"=>$row["LoginId"],
                    "pass"=>$row["Password"]);
            }
            $this->status="success";
        } else {
            $this->status="success";
            $this->response="failed to retrive data";
        }
        //var_dump(array("status"=> $this->status , "data"=> $this->response ));
        return array("status"=> $this->status , "data"=> $this->response );
    }
}
class api2test
{

    public function __construct()
    {
        $request_method = $_SERVER['REQUEST_METHOD'];
        switch ($request_method) {
            case 'POST':
                self::doPost();
                break;
            case 'GET':
                //echo "getMethod";
                self::doGet();
                break;

            default:

                break;
        }
    }

    function doPost()
    {
        if ($_POST) {
            if (isset($_POST["loginId"]) && isset($_POST["pass"])) {
                $dbObj = new dbConnect("localhost", "a92c734d_suraj", "CozensHackleAppendCuss", "a92c734d_suraj");
                $conn = $dbObj->getDbConnection();
                $LoginId = $_POST["loginId"];

                $Password = $_POST["pass"];
                $query = "LoginId = '$LoginId' AND Password = '$Password'";
                //echo $query;
                $result = $dbObj->getSingleRow("logintable", $query);
                $conn->close();
                if ($result['data']['loginId'] == $LoginId && $result['data']['pass'] == $Password) {
                    echo json_encode($result);
                } else {
                    $result['data'] = "wrong Credentials";
                    echo json_encode($result);
                }
//            echo json_encode($result);
            } else {
                echo json_encode(array("status" => "failed", "data" => "empty fields"));
            }
        } else {
            echo json_encode(array("status" => "failed", "data" => "failed to connect"));
        }
    }

    function doGet()
    {
        $dbObj = new dbConnect("localhost", "a92c734d_suraj", "CozensHackleAppendCuss", "a92c734d_suraj");
        $conn = $dbObj->getDbConnection();
        $LoginId = "suraj";
        $Password = "12345";
        $query = "LoginId = '$LoginId' AND Password = '$Password'";
        $result = $dbObj->getSingleRow("logintable", $query);
        http_response_code(200);
        echo json_encode($result);
        $conn->close();
    }
}

new api2test();


// Create connection
//$conn = new mysqli("localhost", "a92c734d_suraj", "CozensHackleAppendCuss","a92c734d_suraj");
// Check connection
