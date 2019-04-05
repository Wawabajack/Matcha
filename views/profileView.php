<?php
if (!isset($_SESSION))
    session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
/** Picture & Frame **/

$startFrame = '<center><div id="frame"><img id="img" src="';
$endFrame = '"></div></center><br/>';

/** User infos **/

if (isset($_SESSION['usr'])) {

    $usr = $_SESSION['usr']->username;
    $username = '' . $usr . '</center><br/>';
    $name = $_SESSION['usr']->name;
    $surname = $_SESSION['usr']->surname;
    $mail = $_SESSION['usr']->mail;


    /** Profile infos **/

    if (isset($_SESSION['profile'])) {
        $gender = '' . $_SESSION['profile']->gender;
        if ($_SESSION['profile']->birthdate == "0000-00-00")
            $_SESSION['profile']->birthdate = "1970-01-01";
        $date = new DateTime($_SESSION['profile']->birthdate);
        $now = new DateTime();
        $interval = $now->diff($date);
        $age = $interval->y;
        $birth = explode('-', $_SESSION['profile']->birthdate);
        $birth = $birth[2] . '/' . $birth[1] . '/' . $birth[0];
        $location = "";
        if ($_SESSION['profile']->city != "")
            $location = $_SESSION['profile']->city;
        $popScore = '' . $_SESSION['profile']->popularity . '<br/>';
        $image = $_SESSION['profile']->img;
    } else {
        $gender = $birthDate = $age = $location = $image = $popScore = $birth = "";
        $image = "/img/blank.png";
    }

    if (isset($_SESSION['prefs'])) {
        $lfgender = $_SESSION['prefs']->gender;
        $bio = $_SESSION['prefs']->bio;
    } else {
        $lfgender = "N";
        $bio = "";
    }

    $profileV = '<div class="container emp-profile">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="' . $image . '" alt=""/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>' .
        $usr . '
                                    </h5>
                                    <h6>' .
        $surname . '
                                    </h6>
                                    <p class="proile-rating">POPULARITY : <span>' . $popScore . '</span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Bio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="mdp-tab" data-toggle="tab" href="#mdp" role="tab" aria-controls="profile" aria-selected="false">Mdp</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a class="profile-edit-btn" href="../pages/usercp.php">Edit profil</a><br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                            <p>Photos</p>
                            <a href="../index.php">Accueil</a><br/>
                            <a href="">link2</a><br/>
                            <a href="">link3</a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p> ' . $name . '</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Genre</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p> ' . $gender . '</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p> ' . $mail . '</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Age</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>' . $age . '</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Ville</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>' . $location . '</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-md-6">
                                        		<label>Intéressé(e) par: </label>
                                       		</div>	
                                            <div class="col-md-6">
                                                <p>' . $lfgender . '</p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>' . $bio . '</label>
                                            </div>
                                        </div>
                             </div>
                             <div class="tab-pane fade" id="mdp" role="tabpanel" aria-labelledby="mdp-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Ancien mot de passe</label>
                                    </div>
                                <div class="col-md-6">
                                    <p>••••••••••</p>
                                </div>
                                <div class="col-md-6">
                                    <label>Nouveau mot de passe</label>
                                </div>
                                <div class="col-md-6">
                                   <p>••••••••••</p>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
          </div>       
    </div>';


// USERCP

    $editprofileV = '<div class="container emp-profile">
    <form method="post" action="../controllers/useredit.php" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    <img src="' . $image . '" alt="" />
                    <div class="file btn btn-lg btn-primary">
                        Change Photo
                        <input type="file" name="file" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                    <textarea style="resize: none; border: none; " name="username">' . $usr . '</textarea>
                    <textarea style="resize: none; border: none; " 0 name="surname">' . $surname . '</textarea>
                    <p class="proile-rating">POPULARITY : <span>' . $popScore . '</span></p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Bio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="mdp-tab" data-toggle="tab" href="#mdp" role="tab" aria-controls="profile" aria-selected="false">Mdp</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <input type="submit" class="profile-edit-btn" value="Finish"></input><br />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="profile-work">
                    <p>Photos</p>
                    <a href="../index.php">Accueil</a><br />
                    <a href="">link2</a><br />
                    <a href="">link3</a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nom</label>
                            </div>
                            <div class="col-md-6">
                                <textarea style="resize: none; border: none; " name="name" placeholder="20 lettres max.">' . $name . '</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Genre</label>
                            </div>
                            <div class="col-md-6">
                                <textarea style="resize: none; border: none; " name="gender" placeholder="M / F / N">' . $gender . '</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <textarea style="resize: none; border: none; " name="mail" placeholder="exemple@gmail.com">' . $mail . '</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Date de naissance</label>
                            </div>
                            <div class="col-md-6">
                                <textarea style="resize: none; border: none; " name="birthdate" placeholder="JJ/MM/AAAA">' . $birth . '</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Ville</label>
                            </div>
                            <div class="col-md-6">
                                <textarea style="resize: none; border: none; " name="location">' . $location . '</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Intéressé(e) par: </label>
                            </div>
                            <div class="col-md-6">
                                <textarea style="resize: none; border: none; " name="lf">' . $lfgender . '</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <textarea style="resize: none; border: none; " name="bio" placeholder="Mes centres d\'intérêt..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="mdp" role="tabpanel" aria-labelledby="mdp-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Ancien mot de passe</label>
                            </div>
                            <div class="col-md-6">
                                <input type="password" style="resize: none; border: none; " name="oldpwd" placeholder="••••••••••"></input>
                            </div>
                            <div class="col-md-6">
                                <label>Nouveau mot de passe</label>
                            </div>
                            <div class="col-md-6">
                                <input type="password" style="resize: none; border: none; " name="newpwd" placeholder="••••••••••"></input>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</form>
</div>';

    $slider = '
<form method="post" action="/pages/search.php">
<div class="research">
    <div class="slidecontainer">
        <input type="range" min="1" max="100" value="20" class="slider" id="agemax" name="min_age">
        <p>age min = <span id="agemaxi:"></span></p>
    </div>
    <div class="slidecontainer">
        <input type="range" min="1" max="100" value="60" class="slider" id="agemin" name="max_age">
        <p>age max = <span id="agemini:"></span></p>
    </div>
    
    <div class="slidecontainer">
        <input type="range" min="0" max="100" value="50" class="slider" id="loc" name="loc">
        <p>loc = <span id="loc:"></span></p>
    </div>
    <div class="slidecontainer">
        <input type="range" min="1" max="5" value="2" class="slider" id="tag" name="tag">
        <p>tag = <span id="tag:"></span></p>
    </div>
    <div class="slidecontainer">
        <input type="range" min="1" max="10000" value="4000" class="slider" id="popmin" name="min_pop">
        <p>pop min = <span id="popmini:"></span></p>
    </div>
    <div class="slidecontainer">
        <input type="range" min="1" max="10000" value="6000" class="slider" id="popmax" name="max_pop">
        <p>pop max = <span id="popmaxi:"></span></p>
    </div>
    <div style="display:block " class="btn">
        <input class="btntop" type="submit" value=" order by Age">
        <input class="btntop" type="submit" value=" order by Loc">
        <input class="btntop" type="submit" value=" order by tag">
        <input class="btntop" type="submit" value=" order by pop">
    </div>
</div>
<input type="submit" value="ok">
</form>
<script>
    var slider = document.getElementById("agemin");
    var output = document.getElementById("agemini:");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    }
</script>
<script>
    var slider5 = document.getElementById("agemax");
    var output5 = document.getElementById("agemaxi:");
    output5.innerHTML = slider5.value;

    slider5.oninput = function() {
        output5.innerHTML = this.value;
    }
</script>
<script>
    var slider2 = document.getElementById("loc");
    var output2 = document.getElementById("loc:");
    output2.innerHTML = slider2.value;

    slider2.oninput = function() {
        output2.innerHTML = this.value;
    }
</script>
<script>
    var slider3 = document.getElementById("tag");
    var output3 = document.getElementById("tag:");
    output3.innerHTML = slider3.value;

    slider3.oninput = function() {
        output3.innerHTML = this.value;
    }
</script>
<script>
    var slider4 = document.getElementById("popmin");
    var output4 = document.getElementById("popmini:");
    output4.innerHTML = slider4.value;

    slider4.oninput = function() {
        output4.innerHTML = this.value;
    }
</script>
<script>
    var slider6 = document.getElementById("popmax");
    var output6 = document.getElementById("popmaxi:");
    output6.innerHTML = slider6.value;

    slider6.oninput = function() {
        output6.innerHTML = this.value;
    }
</script>';

    /**************** a bouger plus tard pour l'algo de march **************************/

    $match = '<div class="profile">
    <div class="profileheader">
    </div>
    <div class="avatar img">
        <img src="../img/a.png" alt="" />
    </div>
    <div class="info">
        <div class="title">
            <h6>
                <a href="" . $username>' . $usr . '</a>
            </h6>
        </div>
        <div class="desc">
            <h5>' .
        $age . '
            </h5>
        </div>
        <div class="desc">
            <h5>' .
        $location . '
            </h5>
        </div>
        <div class="desc">
            <h5>' .
        $gender . '
            </h5>
        </div>
    </div>
</div>';
}