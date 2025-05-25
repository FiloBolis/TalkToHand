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
$user_id = $_SESSION['user'];
$user_name = $db->getUsername($user_id) ?? 'Utente';

// Simulazione dati chat per demo
$chats = [
    [
        'id' => 1,
        'name' => 'Marco Rossi',
        'type' => 'private',
        'last_message' => 'Ciao! Come stai?',
        'last_message_time' => '10:30',
        'unread_count' => 2,
        'is_online' => true,
        'avatar' => 'MR',
        'avatar_color' => 'bg-primary'
    ],
    [
        'id' => 2,
        'name' => 'Team Progetto LIS',
        'type' => 'group',
        'last_message' => 'Anna: Perfetto, ci sentiamo domani',
        'last_message_time' => '09:15',
        'unread_count' => 0,
        'is_online' => false,
        'avatar' => 'TP',
        'avatar_color' => 'bg-success',
        'members_count' => 5
    ],
    [
        'id' => 3,
        'name' => 'Sofia Bianchi',
        'type' => 'private',
        'last_message' => 'Grazie per l\'aiuto!',
        'last_message_time' => 'Ieri',
        'unread_count' => 0,
        'is_online' => false,
        'avatar' => 'SB',
        'avatar_color' => 'bg-info'
    ],
    [
        'id' => 4,
        'name' => 'Gruppo Studio',
        'type' => 'group',
        'last_message' => 'Luigi: Chi viene alla riunione?',
        'last_message_time' => 'Ieri',
        'unread_count' => 1,
        'is_online' => false,
        'avatar' => 'GS',
        'avatar_color' => 'bg-warning',
        'members_count' => 8
    ],
    [
        'id' => 5,
        'name' => 'Alessandro Verde',
        'type' => 'private',
        'last_message' => 'Ci vediamo più tardi',
        'last_message_time' => '2 giorni fa',
        'unread_count' => 0,
        'is_online' => true,
        'avatar' => 'AV',
        'avatar_color' => 'bg-secondary'
    ]
];

// Filtra le chat in base ai parametri di ricerca
$search_query = $_GET['search'] ?? '';
$filter_type = $_GET['filter'] ?? 'all'; // all, private, group

if (!empty($search_query)) {
    $chats = array_filter($chats, function($chat) use ($search_query) {
        return stripos($chat['name'], $search_query) !== false;
    });
}

if ($filter_type !== 'all') {
    $chats = array_filter($chats, function($chat) use ($filter_type) {
        return $chat['type'] === $filter_type;
    });
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_title; ?> - Le Mie Chat</title>
    <meta name="description" content="Gestisci le tue conversazioni su TalkToHand">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/chats.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="home.php">
                <i class="fas fa-hands brand-icon me-2"></i>
                <?php echo $site_title; ?>
            </a>
            
            <div class="d-flex align-items-center gap-3">
                <!-- Back to Home -->
                <a href="home.php" class="btn btn-outline-secondary btn-sm d-none d-md-inline-flex">
                    <i class="fas fa-home me-2"></i>Home
                </a>
                
                <!-- User Info -->
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar me-2">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="d-none d-md-inline"><?php echo htmlspecialchars($user_name); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item" href="home.php"><i class="fas fa-home me-2"></i>Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid px-4">
            <!-- Header Section -->
            <div class="chat-header" data-aos="fade-down">
                <div class="row align-items-center mb-4">
                    <div class="col-md-6">
                        <h1 class="page-title mb-2">
                            <i class="fas fa-comments me-3"></i>Le Mie Chat
                        </h1>
                        <p class="page-subtitle mb-0">Gestisci le tue conversazioni e resta connesso</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#newChatModal">
                            <i class="fas fa-plus me-2"></i>Nuova Chat
                        </button>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="search-filters-section" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="form-control" id="searchInput" 
                                   placeholder="Cerca nelle chat..." 
                                   value="<?php echo htmlspecialchars($search_query); ?>">
                            <button class="btn btn-outline-secondary btn-sm clear-search" id="clearSearch" style="display: none;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="filter-tabs">
                            <button class="filter-btn <?php echo $filter_type === 'all' ? 'active' : ''; ?>" data-filter="all">
                                <i class="fas fa-list me-2"></i>Tutte
                            </button>
                            <button class="filter-btn <?php echo $filter_type === 'private' ? 'active' : ''; ?>" data-filter="private">
                                <i class="fas fa-user me-2"></i>Private
                            </button>
                            <button class="filter-btn <?php echo $filter_type === 'group' ? 'active' : ''; ?>" data-filter="group">
                                <i class="fas fa-users me-2"></i>Gruppi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Stats -->
            <div class="chat-stats" data-aos="fade-up" data-aos-delay="200">
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-value"><?php echo count($chats); ?></div>
                            <div class="stat-label">Chat Totali</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-value"><?php echo array_sum(array_column($chats, 'unread_count')); ?></div>
                            <div class="stat-label">Non Letti</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-value"><?php echo count(array_filter($chats, fn($c) => $c['is_online'])); ?></div>
                            <div class="stat-label">Online</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-value"><?php echo count(array_filter($chats, fn($c) => $c['type'] === 'group')); ?></div>
                            <div class="stat-label">Gruppi</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat List -->
            <div class="chat-list" data-aos="fade-up" data-aos-delay="300">
                <?php if (empty($chats)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h4>Nessuna chat trovata</h4>
                        <p>Non hai ancora nessuna conversazione. Inizia creando una nuova chat!</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newChatModal">
                            <i class="fas fa-plus me-2"></i>Crea Prima Chat
                        </button>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($chats as $index => $chat): ?>
                            <div class="col-12 col-lg-6" data-aos="fade-up" data-aos-delay="<?php echo 100 + ($index * 50); ?>">
                                <div class="chat-card" data-chat-id="<?php echo $chat['id']; ?>">
                                    <div class="chat-card-body">
                                        <div class="chat-avatar-section">
                                            <div class="chat-avatar <?php echo $chat['avatar_color']; ?>">
                                                <?php echo $chat['avatar']; ?>
                                                <?php if ($chat['is_online']): ?>
                                                    <div class="online-indicator"></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="chat-info">
                                            <div class="chat-header-info">
                                                <h6 class="chat-name">
                                                    <?php echo htmlspecialchars($chat['name']); ?>
                                                    <?php if ($chat['type'] === 'group'): ?>
                                                        <span class="chat-type-badge">
                                                            <i class="fas fa-users me-1"></i><?php echo $chat['members_count']; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </h6>
                                                <div class="chat-meta">
                                                    <span class="chat-time"><?php echo $chat['last_message_time']; ?></span>
                                                    <?php if ($chat['unread_count'] > 0): ?>
                                                        <span class="unread-badge"><?php echo $chat['unread_count']; ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
                                            <p class="chat-last-message">
                                                <?php echo htmlspecialchars($chat['last_message']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- New Chat Modal -->
    <div class="modal fade" id="newChatModal" tabindex="-1" aria-labelledby="newChatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newChatModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Crea Nuova Chat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newChatForm">
                        <div class="mb-4">
                            <div class="chat-type-selector">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="chatType" id="privateChat" value="private" checked>
                                    <label class="form-check-label chat-type-option" for="privateChat">
                                        <i class="fas fa-user"></i>
                                        <span>Chat Privata</span>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="chatType" id="groupChat" value="group">
                                    <label class="form-check-label chat-type-option" for="groupChat">
                                        <i class="fas fa-users"></i>
                                        <span>Chat di Gruppo</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="groupNameSection" style="display: none;">
                            <div class="mb-3">
                                <label for="groupName" class="form-label">Nome del Gruppo</label>
                                <input type="text" class="form-control" id="groupName" placeholder="Inserisci il nome del gruppo">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="participantSearch" class="form-label">
                                <span id="participantLabel">Invita Utente</span>
                                <small class="text-muted">(Cerca per username)</small>
                            </label>
                            <div class="participant-search-box">
                                <input type="text" class="form-control" id="participantSearch" 
                                       placeholder="Cerca utente...">
                                <div class="search-results" id="searchResults"></div>
                            </div>
                        </div>

                        <div class="selected-participants" id="selectedParticipants">
                            <label class="form-label">Partecipanti Selezionati</label>
                            <div class="participants-list" id="participantsList">
                                <div class="no-participants">
                                    <i class="fas fa-users text-muted"></i>
                                    <span>Nessun partecipante selezionato</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="button" class="btn btn-primary" id="createChatBtn" disabled>
                        <i class="fas fa-plus me-2"></i>Crea Chat
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script src="js/chats.js"></script>
</body>
</html>