<?php
chdir(__FILE__);
require_once dirname(__FILE__)."/app/Controller/LightController.php";
$c = new Controller\LightController();
$color = filter_var($_GET["color"], FILTER_SANITIZE_STRING);
$mode = filter_var($_GET["mode"], FILTER_SANITIZE_STRING);
$c->controlLight(3, $color, $mode);

echo "Changed light to color: ".$color." with mode: ".$mode;