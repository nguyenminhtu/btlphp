<?php

$dbc = mysqli_connect("localhost", "root", "", "btlphp");

if (!$dbc) {
    trigger_error("Could not connect to database. \n Error is: " . mysqli_connect_error());
} else {
    mysqli_set_charset($dbc, 'utf-8');
}

