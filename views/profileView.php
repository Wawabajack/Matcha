<?php
	if (!isset($_SESSION))
		session_start();
	require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
	/** Picture & Frame **/

	$startFrame = '<center><div id="frame"><img id="img" src="';
	$endFrame = '"></div></center><br/>';

	/** User infos **/

	if (isset($_SESSION['usr'])) {

        $username = '' . ucfirst($_SESSION['usr']->username) . '</center><br/>';
        $name = '' . $_SESSION['usr']->name . '<br/>';
        $surname = '' . $_SESSION['usr']->surname . '<br/>';
        $mail = '' . $_SESSION['usr']->mail . '<br/>';
	}

	/** Profile infos **/

	if (isset($_SESSION['profile'])) {

	    $gender = '' . $_SESSION['profile']->gender . '<br/>';
	    $birthDate = explode("-", $_SESSION['profile']->birthdate);
	    $diff = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md") ? ((date("Y")-$birthDate[0])-1):(date("Y")-$birthDate[0]));
	    $age = ''. $diff . ' ans' . '<br/>';
	    $location = $_SESSION['profile']->city . ', ' . $_SESSION['profile']->region . ', ' . $_SESSION['profile']->country . '<br/>';
	    $popScore = '' . $_SESSION['profile']->popularity . '<br/>';
	    $image = $_SESSION['profile']->img;
    }
    else {
	    $gender = $birthDate = $age = $location = $image = $popScore = "";
        $image = "/img/401.png";
    }

	if (isset($_SESSION['prefs'])) {
	    $lfgender = $_SESSION['prefs']->gender;
    }
	else
	    $lfgender = "";

$profileV = '<div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="' . $image . '" alt=""/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>' .
                                       $username . '
                                    </h5>
                                    <h6>' .
                                        $surname . '
                                    </h6>
                                    <p class="proile-rating">POPULARITY : <span>' . $popScore . '</span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Favorite</a>
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
                                                <p> ' . $mail .'</p>
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
                                                <label>Location</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>' . $location . '</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>looking for</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>' . $lfgender . '</p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Games</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>AOE</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Music</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Cool</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Animes</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>ok</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Mangas</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>plein</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Films</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>padidée</p>
                                            </div>
                                        </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Your Bio</label><br/>
                                        <p>Wéwéwé j ai fiait des trucs</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>';


			// USERCP

$editprofileV = '<div class="container emp-profile">
            <form method="post" action="../controllers/useredit.php">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="' . $image . '" alt=""/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <textarea style="border: none" name="username" contenteditable="true">' .
										substr_replace($username, "", -14) . '
                                    </textarea>
                                    <textarea style="border: none"0 name="surname" contenteditable="true">' .
										substr_replace($surname, "", -5) . '
                                    </textarea>
                                    <p class="proile-rating">POPULARITY : <span>' . $popScore . '</span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Favorite</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="profile-edit-btn" value="Finish"></input><br/>
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
                                            <div class="col-md-6" contenteditable="true">
                                                <textarea style="border: none" name="name"> ' . substr_replace($name, "", -5) . '</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Genre</label>
                                            </div>
                                            <div class="col-md-6" contenteditable="true">
                                                <textarea style="border: none" name="gender" > ' . substr_replace($gender, "", -5) . '</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6" contenteditable="true">
                                                <textarea  style="border: none" name="mail"> ' . substr_replace($mail, "", -5) .'</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Age</label>
                                            </div>
                                            <div class="col-md-6" contenteditable="true">
                                                <textarea name="birth">' . substr_replace($age, "", -5) . '</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Location</label>
                                            </div>
                                            <div class="col-md-6" contenteditable="true">
                                                <textarea style="border: none" name="location">' . substr_replace($location, "", -5) . '</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>looking for</label>
                                            </div>
                                            <div class="col-md-6" contenteditable="true">
                                                <textarea style="border: none" name="lf">' . substr_replace($lfgender, "", -5) . '</textarea>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Games</label>
                                            </div>
                                            <div class="col-md-6" contenteditable="true">
                                                <p>AOE</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Music</label>
                                            </div>
                                            <div class="col-md-6" contenteditable="true">
                                                <p>Cool</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Animes</label>
                                            </div>
                                            <div class="col-md-6" contenteditable="true"> 
                                                <p>ok</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Mangas</label>
                                            </div>
                                            <div class="col-md-6" contenteditable="true">
                                                <p>plein</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Films</label>
                                            </div>
                                            <div class="col-md-6" contenteditable="true">
                                                <p>padidée</p>
                                            </div>
                                        </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Your Bio</label><br/>
                                        <div contenteditable="true" >
                                            <p>Wéwéwé j ai fiait des trucs</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>';

$match = '<div class="profile">
                <div class="profileheader">
                </div>
                <div class="avatar img">
                    <img src="../img/a.png" alt=""/>
                </div>
                <div class="info">
                    <div class="title">
                        <h6>
                            <a href="".$username>'.  $username .'</a>
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