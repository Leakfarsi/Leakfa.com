<?php
require "../src/common.php";
header('Content-Type: application/json');
echo json_encode(site_stat());
