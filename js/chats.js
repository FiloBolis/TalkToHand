// TalkToHand Chats JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS Animation
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });

    // Elements
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearch');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const chatCards = document.querySelectorAll('.chat-card');
    const newChatModal = document.getElementById('newChatModal');
    const createChatBtn = document.getElementById('createChatBtn');
    const chatTypeRadios = document.querySelectorAll('input[name="chatType"]');
    const groupNameSection = document.getElementById('groupNameSection');
    const participantSearch = document.getElementById('participantSearch');
    const searchResults = document.getElementById('searchResults');
    const participantsList = document.getElementById('participantsList');
    const participantLabel = document.getElementById('participantLabel');

    // State
    let selectedParticipants = [];
    let searchTimeout;

    // Mock users data for search
    const mockUsers = [
        { id: 1, username: 'marco.rossi', name: 'Marco Rossi', avatar: 'MR', online: true },
        { id: 2, username: 'anna.bianchi', name: 'Anna Bianchi', avatar: 'AB', online: false },
        { id: 3, username: 'luigi.verdi', name: 'Luigi Verdi', avatar: 'LV', online: true },
        { id: 4, username: 'sofia.neri', name: 'Sofia Neri', avatar: 'SN', online: false },
        { id: 5, username: 'alessandro.blu', name: 'Alessandro Blu', avatar: 'AB', online: true },
        { id: 6, username: 'giulia.rosa', name: 'Giulia Rosa', avatar: 'GR', online: false },
        { id: 7, username: 'francesco.oro', name: 'Francesco Oro', avatar: 'FO', online: true },
        { id: 8, username: 'valentina.silver', name: 'Valentina Silver', avatar: 'VS', online: false }
    ];

    // Search functionality
    function handleSearch() {
        const query = searchInput.value.toLowerCase().trim();
        const currentFilter = document.querySelector('.filter-btn.active').dataset.filter;
        
        // Show/hide clear button
        clearSearchBtn.style.display = query ? 'flex' : 'none';
        
        // Filter chats
        chatCards.forEach(card => {
            const chatName = card.querySelector('.chat-name').textContent.toLowerCase();
            const chatType = card.dataset.chatType || 'private'; // Fallback for demo data
            
            const matchesSearch = chatName.includes(query);
            const matchesFilter = currentFilter === 'all' || chatType === currentFilter;
            
            if (matchesSearch && matchesFilter) {
                card.closest('.col-12').style.display = 'block';
                card.style.animation = 'fadeInUp 0.3s ease forwards';
            } else {
                card.closest('.col-12').style.display = 'none';
            }
        });
        
        // Update URL without page reload
        const url = new URL(window.location);
        if (query) {
            url.searchParams.set('search', query);
        } else {
            url.searchParams.delete('search');
        }
        window.history.replaceState({}, '', url);
    }

    // Filter functionality
    function handleFilter(filterType) {
        const query = searchInput.value.toLowerCase().trim();
        
        // Update active filter button
        filterButtons.forEach(btn => btn.classList.remove('active'));
        document.querySelector(`[data-filter="${filterType}"]`).classList.add('active');
        
        // Filter chats
        chatCards.forEach(card => {
            const chatName = card.querySelector('.chat-name').textContent.toLowerCase();
            const chatType = card.dataset.chatType || 'private';
            
            const matchesSearch = !query || chatName.includes(query);
            const matchesFilter = filterType === 'all' || chatType === filterType;
            
            if (matchesSearch && matchesFilter) {
                card.closest('.col-12').style.display = 'block';
                card.style.animation = 'fadeInUp 0.3s ease forwards';
            } else {
                card.closest('.col-12').style.display = 'none';
            }
        });
        
        // Update URL
        const url = new URL(window.location);
        if (filterType !== 'all') {
            url.searchParams.set('filter', filterType);
        } else {
            url.searchParams.delete('filter');
        }
        window.history.replaceState({}, '', url);
    }

    // Chat type selection in modal
    function handleChatTypeChange() {
        const selectedType = document.querySelector('input[name="chatType"]:checked').value;
        
        if (selectedType === 'group') {
            groupNameSection.style.display = 'block';
            participantLabel.textContent = 'Aggiungi Membri';
        } else {
            groupNameSection.style.display = 'none';
            participantLabel.textContent = 'Invita Utente';
        }
        
        // Reset participants if switching to private
        if (selectedType === 'private' && selectedParticipants.length > 1) {
            selectedParticipants = selectedParticipants.slice(0, 1);
            updateParticipantsList();
        }
        
        updateCreateButton();
    }

    // User search in modal
    function searchUsers(query) {
        if (!query.trim()) {
            searchResults.style.display = 'none';
            return;
        }

        const results = mockUsers.filter(user => 
            user.username.toLowerCase().includes(query.toLowerCase()) ||
            user.name.toLowerCase().includes(query.toLowerCase())
        ).filter(user => 
            !selectedParticipants.some(p => p.id === user.id)
        ).slice(0, 5);

        if (results.length > 0) {
            searchResults.innerHTML = results.map(user => `
                <div class="search-result-item" data-user-id="${user.id}">
                    <div class="search-result-avatar bg-primary">
                        ${user.avatar}
                    </div>
                    <div class="search-result-info">
                        <h6>${user.name}</h6>
                        <small>@${user.username} ${user.online ? '• Online' : '• Offline'}</small>
                    </div>
                </div>
            `).join('');
            searchResults.style.display = 'block';
        } else {
            searchResults.innerHTML = '<div class="search-result-item"><small class="text-muted">Nessun utente trovato</small></div>';
            searchResults.style.display = 'block';
        }
    }

    // Add participant
    function addParticipant(userId) {
        const user = mockUsers.find(u => u.id === parseInt(userId));
        if (!user) return;

        const chatType = document.querySelector('input[name="chatType"]:checked').value;
        
        // For private chats, only allow one participant
        if (chatType === 'private') {
            selectedParticipants = [user];
        } else {
            selectedParticipants.push(user);
        }
        
        updateParticipantsList();
        updateCreateButton();
        
        // Clear search
        participantSearch.value = '';
        searchResults.style.display = 'none';
    }

    // Remove participant
    function removeParticipant(userId) {
        selectedParticipants = selectedParticipants.filter(p => p.id !== parseInt(userId));
        updateParticipantsList();
        updateCreateButton();
    }

    // Update participants list display
    function updateParticipantsList() {
        if (selectedParticipants.length === 0) {
            participantsList.innerHTML = `
                <div class="no-participants">
                    <i class="fas fa-users text-muted"></i>
                    <span>Nessun partecipante selezionato</span>
                </div>
            `;
        } else {
            participantsList.innerHTML = selectedParticipants.map(user => `
                <div class="participant-chip">
                    <span>${user.name}</span>
                    <button type="button" class="remove-participant" data-user-id="${user.id}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `).join('');
        }
    }

    // Update create button state
    function updateCreateButton() {
        const chatType = document.querySelector('input[name="chatType"]:checked').value;
        const groupName = document.getElementById('groupName').value.trim();
        
        let isValid = selectedParticipants.length > 0;
        
        if (chatType === 'group') {
            isValid = isValid && groupName.length > 0;
        }
        
        createChatBtn.disabled = !isValid;
    }

    // Create new chat
    function createNewChat() {
        const chatType = document.querySelector('input[name="chatType"]:checked').value;
        const groupName = document.getElementById('groupName').value.trim();
        
        // Prepare chat data
        const chatData = {
            type: chatType,
            participants: selectedParticipants.map(p => p.id),
            name: chatType === 'group' ? groupName : selectedParticipants[0]?.name
        };
        
        // Show loading state
        createChatBtn.disabled = true;
        createChatBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creazione...';
        
        // Simulate API call
        setTimeout(() => {
            // Reset form
            resetNewChatForm();
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(newChatModal);
            modal.hide();
            
            // Show success message
            showToast('Chat creata con successo!', 'success');
            
            // In a real app, you would redirect to the new chat
            console.log('New chat created:', chatData);
        }, 1500);
    }

    // Reset new chat form
    function resetNewChatForm() {
        document.getElementById('newChatForm').reset();
        selectedParticipants = [];
        updateParticipantsList();
        groupNameSection.style.display = 'none';
        searchResults.style.display = 'none';
        participantSearch.value = '';
        createChatBtn.disabled = true;
        createChatBtn.innerHTML = '<i class="fas fa-plus me-2"></i>Crea Chat';
        participantLabel.textContent = 'Invita Utente';
    }

    // Show toast notification
    function showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed`;
        toast.style.cssText = 'top: 100px; right: 20px; z-index: 9999;';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast, { delay: 4000 });
        bsToast.show();
        
        // Remove toast element after hiding
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    // Chat card click handler
    function handleChatClick(chatId) {
        // Add click animation
        const clickedCard = document.querySelector(`[data-chat-id="${chatId}"]`);
        clickedCard.style.transform = 'scale(0.98)';
        
        setTimeout(() => {
            clickedCard.style.transform = '';
            // In a real app, redirect to chat
            window.location.href = `chat.php?id=${chatId}`;
        }, 150);
    }

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .chat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .toast {
            animation: slideInRight 0.3s ease-out;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);

    // Event Listeners
    
    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(handleSearch, 300);
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleSearch();
            }
        });
    }

    // Clear search button
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            clearSearchBtn.style.display = 'none';
            handleSearch();
        });
    }

    // Filter buttons
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const filterType = this.dataset.filter;
            handleFilter(filterType);
        });
    });

    // Chat type radios
    chatTypeRadios.forEach(radio => {
        radio.addEventListener('change', handleChatTypeChange);
    });

    // Group name input
    const groupNameInput = document.getElementById('groupName');
    if (groupNameInput) {
        groupNameInput.addEventListener('input', updateCreateButton);
    }

    // Participant search
    if (participantSearch) {
        participantSearch.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchUsers(this.value);
            }, 300);
        });

        // Hide search results when clicking outside
        participantSearch.addEventListener('blur', function() {
            setTimeout(() => {
                searchResults.style.display = 'none';
            }, 200);
        });
    }

    // Search results clicks
    if (searchResults) {
        searchResults.addEventListener('click', function(e) {
            const resultItem = e.target.closest('.search-result-item');
            if (resultItem && resultItem.dataset.userId) {
                addParticipant(resultItem.dataset.userId);
            }
        });
    }

    // Participants list clicks (remove participant)
    if (participantsList) {
        participantsList.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-participant');
            if (removeBtn) {
                removeParticipant(removeBtn.dataset.userId);
            }
        });
    }

    // Create chat button
    if (createChatBtn) {
        createChatBtn.addEventListener('click', createNewChat);
    }

    // Chat cards clicks
    chatCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't trigger if clicking on action buttons
            if (e.target.closest('.chat-actions')) return;
            
            const chatId = this.dataset.chatId;
            if (chatId) {
                handleChatClick(chatId);
            }
        });
    });

    // Modal reset on close
    if (newChatModal) {
        newChatModal.addEventListener('hidden.bs.modal', function() {
            resetNewChatForm();
        });
    }

    // Chat action buttons
    document.addEventListener('click', function(e) {
        const actionBtn = e.target.closest('.chat-action-btn');
        if (actionBtn) {
            e.stopPropagation();
            const chatCard = actionBtn.closest('.chat-card');
            const chatId = chatCard.dataset.chatId;
            handleChatClick(chatId);
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
        }
        
        // Escape to clear search
        if (e.key === 'Escape' && searchInput === document.activeElement) {
            searchInput.blur();
            if (searchInput.value) {
                searchInput.value = '';
                handleSearch();
            }
        }
    });

    // Initialize on page load
    function init() {
        // Set initial state based on URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('search');
        const filterType = urlParams.get('filter') || 'all';
        
        if (searchQuery) {
            searchInput.value = searchQuery;
            clearSearchBtn.style.display = 'flex';
        }
        
        // Set active filter
        const activeFilterBtn = document.querySelector(`[data-filter="${filterType}"]`);
        if (activeFilterBtn) {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            activeFilterBtn.classList.add('active');
        }
        
        // Apply initial filters
        handleSearch();
        
        // Initialize participants list
        updateParticipantsList();
        
        console.log('TalkToHand Chats initialized');
    }

    // Initialize the page
    init();
});