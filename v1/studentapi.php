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
    public function getAllRecord($tableName):array{
        $query = "SELECT * FROM ".$tableName;
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            //$row = $result-> fetch_all();
            //$rows = $result->fetch_all(PDO::FETCH_ASSOC);
            while($row = $result->fetch_assoc()) {
                $this->response[] = array("id"=>$row["id"],
                    "roll_no"=>$row["roll_no"],
                    "fname"=>$row["fname"],
                    "email_id"=>$row["email_id"]);
            }
            $this->status="success";
        } else {
            $this->status="success";
            $this->response="failed to retrive data";
        }
        return array("status"=>$this->status,"data"=>$this->response);
    }

    public function getSingleRecord($tableName, $conditionQuery):array {
        $query = "SELECT * FROM ".$tableName." WHERE ".$conditionQuery;
        $result = $this->conn->query($query);
        if ($result->num_rows >0) {
            while($row = $result->fetch_assoc()) {
                $this->response = array("id"=>$row["id"],
                    "roll_no"=>$row["roll_no"],
                    "fname"=>$row["fname"],
                    "email_id"=>$row["email_id"]);
            }
            $this->status="success";
        } else {
            $this->status="failed";
            $this->response="failed to retrive data";
        }
        //var_dump(array("status"=> $this->status , "data"=> $this->response ));
        return array("status"=> $this->status , "data"=> $this->response );
    }

    public function insertRecord($query):array {
        $result = $this->conn->query($query);
        if ($result == 1) {
            $this->status="success";
            $this->response="recored successfully inserted";
        } else {
            $this->status="failed";
            $this->response="roll number exist";
        }
        return array("status"=> $this->status , "data"=> $this->response );
    }

    public function updateRecord($query){
        $result = $this->conn->query($query);
        if ($result == 1) {
            $this->status="success";
            $this->response="recored successfully updated";
        } else {
            $this->status="failed";
            $this->response="can't update";
        }
        return array("status"=> $this->status , "data"=> $this->response );

    }

    public function deleteRecord($query){
        $result = $this->conn->query($query);
        if ($result == 1) {
            $this->status="success";
            $this->response="recored deleted successfully";
        } else {
            $this->status="failed";
            $this->response="roll doesn't exist";
        }
        return array("status"=> $this->status , "data"=> $this->response );

    }

    public function deleteAllRecord(){

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
                self::doGet();
                break;
            case 'PUT':
                self::doPut();
                break;
            case 'DELETE':
                self::doDelete();
                break;
            default:
                break;
        }
    }

    function doPost()
    {
        if ($_POST) {
            if (isset($_POST["fname"]) && isset($_POST["id"])) {
                $dbObj = new dbConnect("localhost", "a92c734d_suraj", "CozensHackleAppendCuss", "a92c734d_suraj");
                $conn = $dbObj->getDbConnection();
                $fname = $_POST["fname"] ;
                $id = $_POST["id"];
                $query = "id = '$id' AND fname = '$fname'";
                $result = $dbObj->getSingleRecord("student", $query);
                $conn->close();
                if ($result['data']['id'] == $id && $result['data']['fname'] == $fname) {
                    echo json_encode($result);
                } else {
                    $result['data'] = "wrong Credentials";
                    echo json_encode($result);
                }
            }
            elseif (isset($_POST["insert"])) {
                $dbObj = new dbConnect("localhost", "a92c734d_suraj", "CozensHackleAppendCuss", "a92c734d_suraj");
                $conn = $dbObj->getDbConnection();
                $roll_no = $_POST["iroll_no"];
                $fname = $_POST["ifname"];
                $email_id = $_POST["iemail"];
                $query = "INSERT INTO student (`roll_no`,`fname`,`email_id`) VALUES ('$roll_no', '$fname' ,NULLIF('$email_id','')) ";
                $result = $dbObj->insertRecord($query);
                $conn->close();
                echo json_encode($result);
            }
            else {
                echo json_encode(array("status" => "failed", "data" => "empty fields"));
            }
        } else {
            echo json_encode(array("status" => "failed", "data" => "failed to connect"));
        }
    }

    function doPut()
    {
        parse_str(file_get_contents('php://input'),$_PUT);
        //echo($_PUT);
        if ($_PUT) {
            if (isset($_PUT["ufname"]) && isset($_PUT["uroll_no"])) {
                $dbObj = new dbConnect("localhost", "a92c734d_suraj", "CozensHackleAppendCuss", "a92c734d_suraj");
                $conn = $dbObj->getDbConnection();
                $roll_no = $_PUT["uroll_no"];
                $fname = $_PUT["ufname"];
                $id = $_PUT["id"];
                $email_id = $_PUT["uemail"];
                $query = "UPDATE student SET `roll_no` = '$roll_no', `fname` = '$fname', `email_id` = '$email_id' WHERE `id` = NULLIF('$id','') OR `roll_no`= NULLIF('$roll_no','') ";
                $result = $dbObj->updateRecord($query);
                $conn->close();
                   echo json_encode($result);
            }
            else {
                echo json_encode(array("status" => "failed", "data" => "empty fields"));
            }
        } else {
            echo json_encode(array("status" => "failed", "data" => "connection error"));
        }
    }

    function doDelete()
    {
        parse_str(file_get_contents('php://input'), $_DELETE);
        if ($_DELETE) {
            if (isset($_DELETE["delid"]) || isset($_DELETE["delroll_no"])) {
                $dbObj = new dbConnect("localhost", "a92c734d_suraj", "CozensHackleAppendCuss", "a92c734d_suraj");
                $conn = $dbObj->getDbConnection();
                $roll_no = $_DELETE["delroll_no"] ;
                $id = $_DELETE["delid"];
                $query = "DELETE FROM `student` WHERE `id` = NULLIF('$id','') OR `roll_no`= NULLIF('$roll_no','') ";
                $result = $dbObj->deleteRecord($query);
                $conn->close();
                    echo json_encode($result);
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
        $result = $dbObj->getAllRecord("student");
        http_response_code(200);
        echo json_encode($result);
        $conn->close();
    }
}

new api2test();
