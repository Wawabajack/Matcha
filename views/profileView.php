<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/pages/profile.php');
	if (!isset($_SESSION))
		session_start();

	if (isset($_SESSION['usr'])) {

        /** Picture & Frame **/

	$startFrame = '<center><div id="frame"><img id="img" src="';
	$endFrame = '"></div></center><br/>';

	/** User infos **/

	$username = '' . ucfirst($_SESSION['usr']->username) . '</center><br/>';
	$gender = '' . $_SESSION['profile']->gender . '<br/>';
	$birthDate = explode("-", $_SESSION['profile']->birthdate);
	$diff = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md") ? ((date("Y")-$birthDate[0])-1):(date("Y")-$birthDate[0]));
	$age = ''. $diff . ' ans' . '<br/>';
	$location = $_SESSION['profile']->city . ', ' . $_SESSION['profile']->region . ', ' . $_SESSION['profile']->country . '<br/>';
	$popScore = '' . $_SESSION['profile']->popularity . '<br/>';
	$name = '' . $_SESSION['usr']->name . '<br/>';
	$surname = '' . $_SESSION['usr']->surname . '<br/>';
    $mail = '' . $_SESSION['usr']->mail . '<br/>';
	}
?>
<div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="<?php  echo($_SESSION['profile']->img); ?>" alt=""/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                       <?php echo($username); ?>
                                    </h5>
                                    <h6>
                                        <?php echo($surname); ?>   
                                    </h6>
                                    <p class="proile-rating">POPULARITY : <span><?php echo($popScore); ?></span></p>
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
                        <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile" href="/pages/usercp.php">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                            <p>Photos</p>
                            <a href="">link</a><br/>
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
                                                <p> <?php echo($name); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Genre</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <?php echo($gender); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <?php echo($mail); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Age</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <?php echo($age); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Location</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo($location); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>looking for</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Weeeeeb</p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Game</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>AOE</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Musique</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Cool/p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Anime</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>ok</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Manga</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>plein</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Film</label>
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
        </div>