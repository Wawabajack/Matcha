<?php

    $forgot = '
    <div class="container" class="regform">
        <div class="d-flex justify-content-center h-100">
            <div class="card3">
                <div class="card-header">
                    <h3>Mot de passe oublié</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="../controllers/forgot.php">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class=" input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" placeholder="mail" name="mail" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Envoyer" class="btn btn-primary float-right login_btn">
                        </div>
                    </form>  
                </div>   
            </div>
        </div>
    </div>
    ';
?>