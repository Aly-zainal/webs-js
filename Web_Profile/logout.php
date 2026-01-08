<?php
require_once 'inc.php';
session_destroy();
header('Location: index.php');
exit;
