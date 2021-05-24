<?php

// Destroy session
session_destroy();

// Redirect to home
header("Location: /");
exit;