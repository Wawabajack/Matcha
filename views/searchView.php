<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');

    if (isset($_SESSION['usr']->id) && isset($_SESSION['prefs']->id) && isset($_SESSION['profile']->id) && isset($_SESSION['search'])) {
        $user = getUserInfo($db, $_SESSION['search']);
        $prefs = getUserPrefs($db, $_SESSION['search']);
        $profile = getUserProfile($db, $_SESSION['search']);
        //var_dump($profile);
        if (isset($profile->id) && isset($prefs->id))
        {
            $image = $profile->img;
            $usr = $user->username;
            $surname = $user->surname;
            $popScore = $profile->popularity;
            $name = $user->name;
            $gender = $profile->gender;
            $mail = $user->mail;
            if ($profile->birthdate != "0000-00-00") {
                $date = new DateTime($_SESSION['profile']->birthdate);
                $now = new DateTime();
                $interval = $now->diff($date);
                $age = $interval->y;
                $birth = explode('-', $_SESSION['profile']->birthdate);
                $birth = $birth[2] . '/' . $birth[1] . '/' . $birth[0]; }
            else
                $age = "";
            $location = $profile->city;
            $lfgender = $prefs->gender;
            $bio = $prefs->bio;


        $profileS = '<div class="container emp-profile">
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
                            </ul>
                        </div>
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
                        </div> 
                    </div>
                </div>
          </div>       
    </div>';
    }
        else
            header('refresh:0;url=/pages/error404.html');
    }
    else
        header('refresh:0;url=/pages/error401.html');