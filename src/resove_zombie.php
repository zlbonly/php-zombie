<?php

declare(ticks = 1);

pcntl_signal(SIGCHLD,function (){
   echo 'SIGCHLD \r\n';
   pcntl_wait($stauts);
}); #2


$pid = pcntl_fork();
if($pid == -1) {
    exit("fork fail");
}elseif($pid){
    $id = getmypid();
    echo "Parent process,pid {$id}, child pid {$pid}\n";

    //先sleep一下，否则代码一直循环，无法处理信号接收
    while(1){sleep(3);} //#1
}else{
    $id = getmypid();
    echo "Child process,pid {$id}\n";
    sleep(2);
    exit();
}

/***
第一次注释掉#1和#2处的代码，父进程提前结束，子进程被init进程接手，所以没有产生僵尸进程。
第二次我们注释掉#2处的代码，开启#1处的代码，即父进程是个死循环，又没有回收子进程，就产生僵尸进程了。
第三次我们开启#1处和#2处的代码，父进程由于安装了信号处理，并调用wait函数等待子进程结束，所以也没有产生僵尸进程。
 */






