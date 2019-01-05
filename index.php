<?php
/**
 * [
 *   123 => 222,
 *   124 => 222,
 *   129 => 222,
 * ]
 *
 * @var array
 */
//8byte => 64bit, 500w * 8byte /1024/1024 =  38mb
$arr =[

];

echo "memory usage:".(memory_get_usage()/1024/1024).'Mb'.PHP_EOL;
for($i=0;$i<500000;$i++){
    $arr[$i]= rand(0,50);
}
echo "memory usage:".(memory_get_usage()/1024/1024).'Mb'.PHP_EOL;

#10w
foreach ($classList as $class) {
    
    $studentList=  getStudentListByClassId($class['classId']);
    
    #50
    foreach ($studentList as $student) {
        $finishHomeworkNumInClass=  getFinishHomeworkNumByStudentIdAndClassId($student['studentId'],$class['classId']);
        
        if(isset($arr[$student['studentId']])){
            $arr[$student['studentId']] += $finishHomeworkNumInClass;
        }
    }
}



