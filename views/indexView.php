<?php

    $loginForm = '
    <div class="container" class="loginForm">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="/controllers/login.php">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="usr" placeholder="username" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="pwd" class="form-control" placeholder="password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn btn-primary float-right login_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        <a href="/pages/register.php">Créer un nouveau compte</a>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="/pages/forgot.php">Mot de passe oublié ?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>';

    $delogBtn = '
    <li><form method="post" action="">
        <input class="btntop" type="submit" value=" Logout " name="logout">
    </form></li></ul></div>';

    $regSuccess = '<p><b>Compte créé avec succès ! Merci de vérifier vos mails !</b></p>';

    $regfail = '<p><b>Erreur lors de la création ducompte !</b></p>';

    $createProfileBtn = '<li><form method="post" action="/pages/profile.php">
        <input class="btntop" type="submit" value=" Créer mon profil "></form></li>';
	$profileBtn = '<li><form method="post" action="/pages/profile.php">
        <input class="btntop" type="submit" value=" Profil "></form></li>';
    $home = '<li><form method="post" action="/index.php">
        <input class="btntop" type="submit" value=" Home "></form></li>';
    $profil = '<li><form method="post" action="/pages/profile.php">
        <input class="btntop" type="submit" value=" Profile "></form></li>';
    $menu = '<div id="nav-a"><ul>';
    