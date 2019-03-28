<?php

if (!isset($_SESSION))
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
    

$match = '
<div class="container mini-profile">
	<div class="row">
		<div class="col-lg-3 col-sm-6">

            <div class="card2 hovercard2">
                <div class="card2header">

                </div>
                <div class="avatar">
                    <img alt="" src="../img/404.png">
                </div>
                <div class="info">
                    <div class="title">
                        <a target="_blank" href=" ">Bobby bob</a>
                    </div>
                    <div class="desc">tag 1</div>
                    <div class="desc">tag 2</div>
                    <div class="desc">tag 3</div>
            </div>
        </div>
	</div>
</div>';