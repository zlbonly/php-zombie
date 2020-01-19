<?php

/***
 * 孤儿进程：一个父进程退出，而它的一个或多个子进程还在运行，
 * 那么那些子进程将成为孤儿进程。孤儿进程将被init进程(进程号为1)所收养，并由init进程对它们完成状态收集工作。
 *
 */
$pid = pcntl_fork(); // 当pcntl_fork（）创建子进程成功后，在父进程内，返回子进程号，在子进程内返回0，失败则返回-1

if($pid == -1){
    exit("fork fail");
}elseif($pid){
    $id = getmypid();
    echo "Parent process,pid {$id}, child pid {$pid}\n";
    exit();
}else{
    sleep(30);
    $id = getmypid();
    echo "Child process,pid {$id}，ppid : ".posix_getppid()."\n";

}