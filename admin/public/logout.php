<?php
session_start();

session_unset();
session_destroy();

header("Location: login?error=You have been logged out");
exit;
