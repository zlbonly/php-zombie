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




/**
优化：
  PHP的 ticks=1 表示每执行1行PHP代码就回调此函数（指的pcntl_signal_dispatch）。实际上大部分时间都没有信号产生，但ticks的函数一直会执行。如果一个服务器程序1秒中接收1000次请求，平均每个请求要执行1000行PHP代码。那么PHP的pcntl_signal，就带来了额外的 1000 * 1000，也就是100万次空的函数调用。这样会浪费大量的CPU资源。
(摘自：韩天峰(Rango)的博客 » PHP官方的pcntl_signal性能极差

 说明：如果去掉declare( ticks = 1 );无法响应信号。因php的信号处理函数是基于ticks来实现的，而不是注册到真正系统底层的信号处理函数中。

pcntl_signal_dispatch的作用就是查看是否收到了信号需要处理，如果有信号的话，就调用相应的信号处理函数。

 */



