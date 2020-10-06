<?php

class test{
    public $a = "test";
    private function  getTest(){
        return $this->a;
    }
    public function description(){
        $value2="abc";
        $value = self::getTest();
        return $value." ".$value2;
    }
}
class test2 extends test{
   function __construct($a)
   {
       echo self::description().$a;
   }


}
new test2(2);
//echo $this->obj;
//$obj->getValue();

?>