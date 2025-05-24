<?php
    if(!isset($_GET["value"]))
        $_GET["value"] = 0;

    $value = $_GET["value"];
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accedi / Registrati</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/SignUp_LogIn_Form.css">
</head>

<body>
    <?php
        if($value == 0)
            echo '<div class="container-custom loading" id="mainContainer">';
        else 
            echo '<div class="container-custom active loading" id="mainContainer">';
    ?>
        <div class="form-box login">
            <form data-aos="fade-right">
                <h1>Accedi</h1>
                <p>Benvenuto! Inserisci i tuoi dati per accedere</p>
                
                <div class="input-box">
                    <input type="text" placeholder="Nome utente" required>
                    <i class='bx bxs-user'></i>
                </div>
                
                <div class="input-box">
                    <input type="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                
                <div class="forgot-link">
                    <a href="#">Password dimenticata?</a>
                </div>
                
                <button class="btn" onclick="accedi()">Accedi</button>
                
                <p class="social-text">oppure accedi con</p>
                
                <div class="social-icons">
                    <a href="#" title="Google"><i class='bx bxl-google'></i></a>
                    <a href="#" title="Facebook"><i class='bx bxl-facebook'></i></a>
                    <a href="#" title="GitHub"><i class='bx bxl-github'></i></a>
                    <a href="#" title="LinkedIn"><i class='bx bxl-linkedin'></i></a>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <form data-aos="fade-left">
                <h1>Registrati</h1>
                <p>Crea il tuo account per iniziare</p>
                
                <div class="input-box">
                    <input type="text" placeholder="Nome utente" required>
                    <i class='bx bxs-user'></i>
                </div>
                
                <div class="input-box">
                    <input type="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                
                <div class="input-box">
                    <input type="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                
                <button class="btn" onclick="registra()">Registrati</button>
                
                <p class="social-text">oppure registrati con</p>
                
                <div class="social-icons">
                    <a href="#" title="Google"><i class='bx bxl-google'></i></a>
                    <a href="#" title="Facebook"><i class='bx bxl-facebook'></i></a>
                    <a href="#" title="GitHub"><i class='bx bxl-github'></i></a>
                    <a href="#" title="LinkedIn"><i class='bx bxl-linkedin'></i></a>
                </div>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left" data-aos="fade-up">
                <h1>Ciao, Benvenuto!</h1>
                <p>Non hai ancora un account? Registrati ora per accedere a tutte le funzionalità</p>
                <button class="btn register-btn">Registrati</button>
            </div>

            <div class="toggle-panel toggle-right" data-aos="fade-up">
                <h1>Bentornato!</h1>
                <p>Hai già un account? Accedi per continuare la tua esperienza</p>
                <button class="btn login-btn">Accedi</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="js/SignUp_LogIn_Form.js"></script>
</body>

</html>