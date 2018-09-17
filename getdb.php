<?php

$jsonArray;

 //class rep {
 //      public $caseName = "";
//       public $success  = "";
//       public $successPct = "";
 //      public $failed = "";
//   }

   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('C:\GraphingTesting\Sqlite\gta.db');
      }
   }
   $db = new MyDB();
   if(!$db){
     // echo $db->lastErrorMsg();
   } else {
     // echo "Opened database successfully\n";
   }

  // $sql ="select * from report;"

//last build newest data
   $sql =<<<EOF
      SELECT   * FROM report where buildID=(SELECT buildID FROM report ORDER BY buildID DESC LIMIT 1) GROUP BY caseName ORDER BY successPct DESC;

EOF;

      
   $ret = $db->query($sql);
    $i = 0;
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
   	  global $jsonArray;
     // echo "caseName = ". $row['caseName'] . "</br>";
    //  echo "success = ". $row['success'] ."</br>";
    //  echo "successPct = ". $row['successPct'] ."</br>";
    //  echo "failed =  ".$row['failed'] ."</br>";
       $e;
     $e['reportFile'] = $row['reportFile'];  
	   $e['caseName'] = $row['caseName'];
     $e['buildID'] = $row['buildID'];
	   $e['success']  = $row['success'];
	   $e['successPct'] = $row['successPct'];
	   $e['failed'] = $row['failed'];
     $e['startTime'] = $row['startTime'];
	    if ($i == 0) $jsonArray = array($e);
        else array_push($jsonArray, $e);
        $i++;//echo "i".$i;
   }
  // echo "Operation done successfully</br>";
   $db->close();
   echo json_encode($jsonArray);

?>
