<?php
require_once 'class/Database.php';

if(!isset($_SESSION))
    session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION['user'])) {
    header("Location: SignUp_LogIn_Form.php?value=0");
    exit();
}

// Configurazione
$site_title = "TalkToHand";
$db = Database::getInstance();
$user_name = $db->getUsername($_SESSION['user']) ?? 'Utente';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_title; ?> - Dashboard</title>
    <meta name="description" content="Dashboard di TalkToHand - Inizia a comunicare senza barriere">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-hands brand-icon me-2"></i>
                <?php echo $site_title; ?>
            </a>
            
            <div class="d-flex align-items-center">
                <!-- User Info -->
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar me-2">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="d-none d-md-inline"><?php echo htmlspecialchars($user_name); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Dashboard Section -->
    <section class="hero-dashboard">
        <div class="container-fluid px-4">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="welcome-content">
                        <h1 class="display-4 fw-bold mb-3">
                            Benvenuto, <span class="text-gradient"><?php echo htmlspecialchars($user_name); ?></span>
                        </h1>
                        <p class="lead mb-4">
                            Accedi alle tue chat e inizia a comunicare senza barriere. 
                            Connettiti con persone di tutto il mondo utilizzando la traduzione automatica LIS.
                        </p>
                        <div class="quick-actions d-flex gap-3 flex-wrap">
                            <button class="btn btn-primary btn-lg px-4" id="openChatsBtn">
                                <i class="fas fa-comments me-2"></i>Le Mie Chat
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="dashboard-illustration">
                        <div class="floating-card" data-aos="zoom-in" data-aos-delay="200">
                            <i class="fas fa-comments"></i>
                            <span>Chat Testuale</span>
                        </div>
                        <div class="floating-card" data-aos="zoom-in" data-aos-delay="400">
                            <i class="fas fa-users"></i>
                            <span>Chat di Gruppo</span>
                        </div>
                        <div class="floating-card" data-aos="zoom-in" data-aos-delay="600">
                            <i class="fas fa-hands"></i>
                            <span>Traduzione LIS</span>
                        </div>
                        <div class="center-element" data-aos="pulse" data-aos-delay="800">
                            <i class="fas fa-heart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Features Section -->
    <section class="quick-features py-5 bg-light">
        <div class="container-fluid px-4">
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card h-100 text-center">
                        <div class="feature-icon bg-primary">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h5 class="mt-3">Chat Testuali</h5>
                        <p class="text-muted">Comunicazione attraverso messaggi di testo con traduzione automatica in tempo reale</p>
                        <button class="btn btn-outline-primary btn-sm" id="textChatBtn">Accedi alle Chat</button>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card h-100 text-center">
                        <div class="feature-icon bg-success">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="mt-3">Chat di Gruppo</h5>
                        <p class="text-muted">Partecipa a conversazioni di gruppo per eventi e comunità</p>
                        <button class="btn btn-outline-success btn-sm" id="groupChatBtn">Esplora Gruppi</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="statistics py-5 bg-gradient">
        <div class="container-fluid px-4">
            <div class="row text-center text-white justify-content-center">
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <i class="fas fa-comments stat-icon mb-3"></i>
                        <h3 class="fw-bold mb-2" data-counter="156">0</h3>
                        <p>Messaggi Inviati</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <i class="fas fa-users stat-icon mb-3"></i>
                        <h3 class="fw-bold mb-2" data-counter="23">0</h3>
                        <p>Contatti Attivi</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <i class="fas fa-language stat-icon mb-3"></i>
                        <h3 class="fw-bold mb-2" data-counter="1247">0</h3>
                        <p>Traduzioni Effettuate</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tips Section -->
    <section class="tips py-5">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="tips-card" data-aos="fade-up">
                        <div class="d-flex align-items-start">
                            <div class="tip-icon me-4">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Suggerimento del Giorno</h5>
                                <p class="mb-3">
                                    Per comunicare in modo più efficace, utilizza frasi semplici e chiare. 
                                    Il sistema di traduzione automatica funziona meglio con un linguaggio diretto.
                                </p>
                                <button class="btn btn-outline-primary btn-sm">Altri Suggerimenti</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script src="js/home.js"></script>
</body>
</html>