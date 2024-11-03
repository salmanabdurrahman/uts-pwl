<?php

// Mulai session
session_start();

// Hapus session yang ada
session_destroy();

// Redirect ke halaman login
header('Location: ../pages/login.php');
exit;
