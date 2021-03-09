#!/usr/bin/env php
<?php

const pharfile = __DIR__."/dumpload.phar";

if (file_exists(pharfile)) unlink(pharfile);

// create phar
$phar = new Phar(pharfile);

// start buffering. Mandatory to modify stub to add shebang
$phar->startBuffering();
$phar->buildFromDirectory(__DIR__ . '/src');


$stub = $phar->createDefaultStub("boatload.php");
#$stub = "#!/usr/bin/php \n" . $stub;
$phar->setStub($stub);

$phar->stopBuffering();
$phar->compressFiles(Phar::GZ);

# Make the file executable
//chmod(pharfile, 0770);


printf("%s successfully created\n", pharfile);

