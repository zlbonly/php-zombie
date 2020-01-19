<?php

$pid = pcntl_fork(); // 当pcntl_fork（）创建子进程成功后，在父进程内，返回子进程号，在子进程内返回0，失败则返回-1

if($pid == -1){
    exit("fork fail");
}elseif($pid){
    $id = getmypid();
    echo "Parent process,pid {$id}, child pid {$pid}\n";

    while(1){sleep(3);} //#1
}else{
    $id = getmypid();
    echo "Child process,pid {$id}\n";
    sleep(2);
    exit();
}