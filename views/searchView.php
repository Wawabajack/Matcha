<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');

    if (isset($_SESSION['usr']->id) && isset($_SESSION['prefs']->id) && isset($_SESSION['profile']->id) && isset($_SESSION['search'])) {
        $user = getUserInfo($db, $_SESSION['search']);
        $prefs = getUserPrefs($db, $_SESSION['search']);
        $profile = getUserProfile($db, $_SESSION['search']);
        $tag = gettags($db, $_SESSION['search']);
        //var_dump($profile);
        $isFriend = isBlocked($db, $user->id);
        $other = hasBlocked($db, $user->id);
            $image = $profile->img;
            $usr = $user->username;
            $surname = $user->surname;
            $popScore = $profile->popularity;
            $name = $user->name;
            $gender = $profile->gender;
            if (isset($isFriend->value) && $isFriend->value == "1" && isset($other->value) && $other->value == 1)
                $mail = $user->mail;
            else
                $mail = "";
            if ($profile->birthdate != "0000-00-00") {
                $date = new DateTime($profile->birthdate);
                $now = new DateTime();
                $interval = $now->diff($date);
                $age = $interval->y;
                $birth = explode('-', $profile->birthdate);
                $birth = $birth[2] . '/' . $birth[1] . '/' . $birth[0]; }
            else
                $age = "";
            $location = $profile->city;
            $lfgender = $prefs->gender;
            $bio = $prefs->bio;
            $tagU = $tag->tag;
            $lastconnect = "";
            if (isset($user->online))
                $on = $user->online;
            if (isset($on) && $on == 1)
                $online = '<img src="/img/green.png" style="width:3%">';
            else {
                $online = '<img src="/img/red.png" style="width:3%">';
                if ($profile->lastseen != "0000-00-00 00:00:00")
                    $lastconnect = $profile->lastseen;
            }
        $profileS = '<div class="container emp-profile">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="' . $image . '" alt=""/>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>' . $usr . " " . $online . ' ' . $lastconnect . '
                                    </h5>
                                    <h6>' . $surname . '
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
                            <div class="btnp">
                            <form method="post" action="/controllers/friend.php">
                            <div>
                                <input type="submit" id="btnlike" class="btnlike" name="friend" value="1"></input>
                            </div> 
                            <div>   
                                <input type="submit" id="btnblock" class="btnblok" name="block" value="1"></input>
                            </div>
                            <div>
                                <input type="submit" id="btnreport" class="btnreport" name="report" value="1"></input>
                            </div>
                            </form>
                            </div>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label> ' . $tagU . ' </label>
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
        header('refresh:0;url=/pages/error401.html');