<?php
$servername = "127.0.0.1";
$username = "root";
$password = "11111111";
$dbname = 'test';

 
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

//    $stmt = $conn->prepare("SELECT * FROM user"); 
//    $stmt->execute();
//    $result = $stmt->fetchAll();
//    var_dump($result);
    
    
//    foreach ($conn->query('SELECT name FROM user') as $row) {
//        var_dump($row);
//    }
    
    
    //1.mysql随机获取一条或者多条数据
    
    //语句一： MYSQL手册里面针对RAND()的提示大概意思就是，在 ORDER BY从句里面不能使用RAND()函数，
    //因为这样会导致数据列被多次扫描，导致效率相当相当的低，效率不行，切忌使用。
    $stmt = $conn->prepare("select * from user where id>1 order by rand() limit 2"); //rand() 返回在范围0到1.0内的随机浮点值
    $stmt->execute();
    $result = $stmt->fetchAll();
    var_dump($result);

    
    
    
    
    
    
    
    
    
    
    
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
$conn = null;