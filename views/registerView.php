<?php

    $regForm = '
    <div class="container" class="regform">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Register</h3>
                </div>
                <div class="card-body">
                    <form action="../controllers/register.php" method="post">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class=" input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="username" placeholder="username" required><br/>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class=" input-group-text"><i class="fas fa-name"></i></span>
                            </div>
                            <input type="text" name="name" placeholder="name" required><br/>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class=" input-group-text"><i class="fas fa-surname"></i></span>
                            </div>
                            <input type="text" name="surname" placeholder="surname" required><br/>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class=" input-group-text"><i class="fas fa-mail"></i></span>
                            </div>
                            <input type="email" autocomplete="mail" placeholder="mail" name="mail" required><br/>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class=" input-group-text"><i class="fas fa-pwd"></i></span>
                            </div>
                            <input type="password" autocomplete="current-password" placeholder="password" name="pwd" required><br/>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Create" name="register">
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center links">
                                <a href="../index.php">acceuil</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>';
?>