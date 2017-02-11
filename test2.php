<?php

class Something extends Thread {

    public function __construct() {

    }

    public function run() {
        global $asd;
        Thread::globally(function () {
            $asd = 'Wut?';
        });
        echo "\n$asd";
    }
}

$asd = 'something';
global $asd;

$a = new Something();
$a->start(PTHREADS_ALLOW_GLOBALS);
$a->join();


echo "\n$asd";
?>


<?php

class Wow extends Thread {
    public $error = false;
    public $stop = false;

    public function __construct($arg) {
        $this->arg = $arg;
    }

    public function run() {
        if ($this->arg) {
            try {

            } catch (Exception $e) {
                $this->error = true;
            }
        }
    }
}
//$a = extension_loaded('pthreads');

// Create a array
$stack = [];

//Initiate Multiple Thread
foreach (range("A", "D") as $i) {
    $stack[] = new Wow($i);
}

echo "\n";
// Start The Threads
foreach ($stack as $t) {
//    $t->start(PTHREADS_INHERIT_ALL);
    $t->start();
}

while (count($stack)) {
    usleep(5000);
    foreach ($stack as $k => $item) {

        if (!$item->isRunning()) {
//            if($item->error){
//                foreach($stack as $i){
//                    echo "\nkilling \n";
//                    $i->stop = true;
//                }
//                echo "\nError " . $item->error . "\n";
//            }

            array_splice($stack, $k, 1);
        }
    }
}

echo "\nAll done. " . $a;

