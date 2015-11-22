<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/adminpanel.css">
</head>
<body>
<?php
if(isset($_SESSION['admin_hash']))
{
    echo<<<_END
<nav id="admin-nav">
    <div id="adminpanel-logo">
        Arrow
    </div>
    <ul id="nav-links">
        <li class="admin-nav-link"><a href="#">General Settings</a></li>
        <li class="admin-nav-link"><a href="/admins/slider">Featured Content</a></li>
        <li class="admin-nav-link"><a href="#">Programs</a></li>
        <li class="admin-nav-link"><a href="#">Services</a></li>
        <li class="admin-nav-link"><a href="#">Blog Posts</a></li>
        <li class="admin-nav-link"><a href="/admins/pages">Pages</a></li>
        <li class="admin-nav-link"><a href="#">Messages</a></li>
        <li class="admin-nav-link"><a href="/admins/logout">Logout</a></li>
    </ul>
</nav>
_END;

}