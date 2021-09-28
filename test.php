<?php
session_start();
require_once 'Session.php';


echo Session::flash('success');
