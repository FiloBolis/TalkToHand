<?php
// Configurazione base del sito
$site_title = "TalkToHand";
$site_description = "Traduzione automatica da LIS a italiano scritto e da italiano parlato a scritto";
$contact_email = "info@talktohand.com";
$team_members = [
    "Daniele Porro",
    "Filippo Bolis", 
    "Andrea Proserpio"
];
$link_linkedin = [
    "#",
    "https://www.linkedin.com/in/filippo-bolis-88097a26a/",
    "#"
];
$link_github = [
    "#",
    "https://github.com/FiloBolis",
    "#"
];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_title; ?> - Traduzione LIS Automatica</title>
    <meta name="description" content="<?php echo $site_description; ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <i class="fas fa-hands me-2"></i>
                <?php echo $site_title; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Chi Siamo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Funzionalità</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contatti</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="login.php">Accedi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold text-white mb-4">
                        Comunica senza barriere con 
                        <span class="text-warning"><?php echo $site_title; ?></span>
                    </h1>
                    <p class="lead text-white-50 mb-4">
                        <?php echo $site_description; ?>. 
                        Rendiamo la comunicazione accessibile a tutti.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="register.php" class="btn btn-warning btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i>Registrati Gratis
                        </a>
                        <a href="login.php" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-sign-in-alt me-2"></i>Accedi
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="hero-illustration">
                        <i class="fas fa-hands hero-icon"></i>
                        <div class="floating-elements">
                            <div class="floating-element"><i class="fas fa-microphone"></i></div>
                            <div class="floating-element"><i class="fas fa-file-alt"></i></div>
                            <div class="floating-element"><i class="fas fa-language"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-4">Cos'è <?php echo $site_title; ?>?</h2>
                    <p class="lead mb-4">
                        <?php echo $site_title; ?> è una piattaforma innovativa che utilizza l'intelligenza artificiale 
                        per abbattere le barriere comunicative tra la comunità sorda e udente.
                    </p>
                    <p class="mb-4">
                        La nostra missione è rendere la comunicazione accessibile a tutti, fornendo strumenti 
                        di traduzione automatica dalla Lingua dei Segni Italiana (LIS) all'italiano scritto 
                        e viceversa, utilizzando tecnologie avanzate di riconoscimento gestuale e text-to-speech.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Le nostre funzionalità</h2>
                <p class="lead text-muted">Tecnologie all'avanguardia per una comunicazione senza limiti</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="fas fa-hands"></i>
                        </div>
                        <h4>Riconoscimento LIS</h4>
                        <p>Traduzione automatica dalla Lingua dei Segni Italiana all'italiano scritto utilizzando AI avanzata.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="fas fa-microphone"></i>
                        </div>
                        <h4>Speech-to-Text</h4>
                        <p>Conversione accurata da italiano parlato a testo scritto per una comunicazione fluida.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="fas fa-universal-access"></i>
                        </div>
                        <h4>Accessibilità</h4>
                        <p>Interfaccia progettata per essere completamente accessibile e user-friendly per tutti.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Il nostro Team</h2>
                <p class="lead text-muted">Team Snap - I fondatori di <?php echo $site_title; ?></p>
            </div>
            <div class="row g-4">
                <?php foreach ($team_members as $index => $member): ?>
                <div class="col-md-4">
                    <div class="team-card text-center">
                        <div class="team-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <h5 class="mt-3"><?php echo $member; ?></h5>
                        <p class="text-muted">Co-Fondatore</p>
                        <div class="social-links">
                            <a href="<?php echo $link_linkedin[$index] ?>" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="<?php echo $link_github[$index] ?>" class="text-primary"><i class="fab fa-github"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-4">Contattaci</h2>
                    <p class="lead mb-4">Hai domande o suggerimenti? Siamo qui per aiutarti!</p>
                    <div class="contact-info">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <a href="mailto:<?php echo $contact_email; ?>" class="text-decoration-none">
                                <?php echo $contact_email; ?>
                            </a>
                        </div>
                        <p class="text-muted">
                            Risponderemo a tutte le tue domande nel minor tempo possibile.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><?php echo $site_title; ?></h5>
                    <p class="text-muted">Comunicazione senza barriere per tutti.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">
                        &copy; <?php echo date('Y'); ?> Team Snap. Tutti i diritti riservati.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>