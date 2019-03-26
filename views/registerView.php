<?php

    $regForm = '
    <div class="container" class="regform">
        <div class="d-flex justify-content-center h-100">
            <div class="card2">
                <div class="card-header">
                    <h3>Register</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="../controllers/register.php">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="username" class="form-control" placeholder="username" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class=" input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="name" class="form-control" placeholder="name" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class=" input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="surname" class="form-control" placeholder="surname" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class=" input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" placeholder="mail" name="mail" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class=" input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="password" name="pwd" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Create" name="register" class="btn btn-primary float-right login_btn">
                        </div>
                    </form>  
                </div>   
            </div>
        </div>
    </div>';
?>