<?php

return array(
    "driver" => "smtp",
    "host" => "smtp.mailtrap.io",
    "port" => 2525,
    "from" => array(
        "address" => "from@example.com",
        "name" => "Example"
    ),
    "username" => "4ea7ff1c7f0d6d",
    "password" => "326ba8e2d3b238",
    "sendmail" => "/usr/sbin/sendmail -bs",
    "pretend" => false
);