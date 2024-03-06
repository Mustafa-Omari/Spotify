<?php 

    include("includes/config.php");

    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");

    $account = new Account($conn);
    
    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");


    function getInputValue($name) {
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Spotify</title>
    
    <link rel="stylesheet" href="assets/css/register.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>


    <?php 
        if(isset($_POST['registerButton'])){
            echo '<script>
                    $(document).ready(function() {
                            $("#loginForm").hide();
                            $("#registerForm").show();
                    });
                </script>';
        }
        else { 
            echo '<script>
                    $(document).ready(function() {
                            $("#loginForm").show();
                            $("#registerForm").hide();
                    });
                </script>';
        }

    ?>

    

    <div id="background">

        <div id="loginContainer">

            <div id="inputContainer">
                <form action="register.php" method="POST" id="loginForm">
                    <h2>Login to your account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$loginFail); ?>
                        <label for="loginUsername">Username</label>
                        <input type="text" name="loginUsername"  id="loginUsername" placeholder="e.g. MustafaOmari" <?php getInputValue('loginUsername'); ?> required>
                    </p>
                    <p>
                        <label for="loginPassword">Password</label>
                        <input type="password" name="loginPassword"  id="loginPassword" placeholder="Your Password" required>
                    </p>

                    <button type="submit" name="loginButton">LOGIN</button>
                
                    <div class="hasAccountText">
                        <span id="hideLogin">Don't have an account yet? Signup here.</span>
                    </div>
                
                </form>


                <form action="register.php" method="POST" id="registerForm">
                    <h2>Create your free account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                        <label for="username">Username</label>
                        <input type="text" name="username"  id="username" value="<?php getInputValue('username'); ?>" placeholder="e.g. MustafaOmari" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                        <label for="firstName">Fisrt Name</label>
                        <input type="text" name="firstName"  id="firstName" value="<?php getInputValue('firstName'); ?>" placeholder="e.g. Mustafa" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName"  id="lastName" value="<?php getInputValue('lastName'); ?>" placeholder="e.g. Omari" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>

                        <label for="email">Email</label>
                        <input type="email" name="email"  id="email" value="<?php getInputValue('email'); ?>" placeholder="e.g. mustafa@gmail.com" required>
                    </p>
                    <p>
                        <label for="email2">Confirm email</label>
                        <input type="email" name="email2"  id="email2" value="<?php getInputValue('email2'); ?>" placeholder="e.g. mustafa@gmail.com" required>
                    </p>
                    <p>
                    <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                    <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                    <?php echo $account->getError(Constants::$passwordCharacters); ?>

                        <label for="password">Password</label>
                        <input type="password" name="password"  id="password" placeholder="Your Password" required>
                    </p>
                    
                    <p>
                        <label for="password2">Confirm Password</label>
                        <input type="password" name="password2"  id="password2" placeholder="Your Password" required>
                    </p>

                    <button type="submit" name="registerButton">SIGN UP</button>

                    <div class="hasAccountText">
                        <span id="hideRegister">Already have an account? Login here.</span>
                    </div>

                </form>

            </div>

            <div id="loginText">
                <h1>Get great music, right now</h1>
                <h2>Listen to loads of songs for free</h2>
                <ul>
                    <li>Discover music you'll fall in love with</li>
                    <li>Create your own playlists </li>
                    <li>Follow artists to keep up to date</li>
                </ul>
            </div>

        </div>

    </div>
</body>
</html>