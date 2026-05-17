<?php

session_start();

$pdo = require __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/routes/web.php';
