<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>



document.addEventListener('DOMContentLoaded', function() {
    // Function to update active link based on current page
    function updateActiveLink() {
        // Get current page filename without .php extension
        const currentPage = window.location.pathname.split('/').pop().replace('.php', '');
        
        // Remove active class from all links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });
        
        // Add active class to current page link
        const currentLink = document.querySelector(`.nav-link[data-page="${currentPage}"]`);
        if (currentLink) {
            currentLink.classList.add('active');
        }
    }

    // Initialize on page load
    updateActiveLink();
});


        
        // Page navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Analytics Chart
            const analyticsCtx = document.getElementById('analyticsChart').getContext('2d');
            
            // Create gradient for Users
            const userGradient = analyticsCtx.createLinearGradient(0, 0, 0, 300);
            userGradient.addColorStop(0, 'rgba(64, 93, 230, 0.4)');
            userGradient.addColorStop(1, 'rgba(64, 93, 230, 0.05)');
            
            // Create gradient for Plays
            const playsGradient = analyticsCtx.createLinearGradient(0, 0, 0, 300);
            playsGradient.addColorStop(0, 'rgba(225, 48, 108, 0.4)');
            playsGradient.addColorStop(1, 'rgba(225, 48, 108, 0.05)');
            
            const analyticsChart = new Chart(analyticsCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [
                        {
                            label: 'Users',
                            data: [12000, 15000, 18000, 21000, 23000, 24800, 26500],
                            borderColor: '#405DE6',
                            backgroundColor: userGradient,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#405DE6',
                            pointBorderWidth: 2,
                            pointRadius: 5
                        },
                        {
                            label: 'Plays',
                            data: [420000, 580000, 750000, 920000, 1100000, 1350000, 1520000],
                            borderColor: '#E1306C',
                            backgroundColor: playsGradient,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#E1306C',
                            pointBorderWidth: 2,
                            pointRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#b3b3b3',
                                font: {
                                    family: "'Poppins', sans-serif"
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(25, 25, 40, 0.9)',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            titleColor: '#f0f0ff',
                            bodyColor: '#c0c0d0',
                            padding: 12,
                            boxPadding: 6,
                            usePointStyle: true
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            ticks: {
                                color: '#a0a0b0'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            ticks: {
                                color: '#a0a0b0'
                            }
                        }
                    }
                }
            });
            
            // User Distribution Chart
            const userCtx = document.getElementById('userChart').getContext('2d');
            const userChart = new Chart(userCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Free Users', 'Premium Users', 'Artists', 'Admins'],
                    datasets: [{
                        data: [65, 25, 8, 2],
                        backgroundColor: [
                            '#405DE6',
                            '#E1306C',
                            '#1DB954',
                            '#FFC107'
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(25, 25, 40, 0.9)',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            titleColor: '#f0f0ff',
                            bodyColor: '#c0c0d0',
                            padding: 12,
                            boxPadding: 6,
                            usePointStyle: true
                        }
                    }
                }
            });
            
            // Add animation to cards on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.card, .stat-card').forEach(card => {
                observer.observe(card);
            });
            
            // User details and edit modals
            const viewButtons = document.querySelectorAll('.view-user');
            const editButtons = document.querySelectorAll('.edit-user');
            const userDetailModal = new bootstrap.Modal(document.getElementById('userDetailModal'));
            const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            
            // Sample user data
            const userData = {
                1: {
                    name: "Sarah Williams",
                    email: "sarah@example.com",
                    avatar: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=80&q=80",
                    status: "Active",
                    joinDate: "Jun 12, 2023",
                    accountType: "Premium",
                    lastLogin: "Today at 9:24 AM",
                    playlists: "12 playlists",
                    genres: ["Pop", "Rock", "Jazz"]
                },
                2: {
                    name: "Michael Chen",
                    email: "michael@example.com",
                    avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=80&q=80",
                    status: "Active",
                    joinDate: "Jun 10, 2023",
                    accountType: "Premium",
                    lastLogin: "Today at 8:15 AM",
                    playlists: "8 playlists",
                    genres: ["EDM", "Hip Hop", "Classical"]
                },
                3: {
                    name: "Robert Johnson",
                    email: "robert@example.com",
                    avatar: "https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=80&q=80",
                    status: "Pending",
                    joinDate: "Jun 8, 2023",
                    accountType: "Free",
                    lastLogin: "Yesterday at 4:30 PM",
                    playlists: "3 playlists",
                    genres: ["Rock", "Blues"]
                },
                4: {
                    name: "Emma Davis",
                    email: "emma@example.com",
                    avatar: "https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=80&q=80",
                    status: "Active",
                    joinDate: "Jun 5, 2023",
                    accountType: "Family",
                    lastLogin: "Today at 10:45 AM",
                    playlists: "15 playlists",
                    genres: ["Pop", "R&B", "Jazz"]
                }
            };
            
            // View user details
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const user = userData[userId];
                    
                    document.getElementById('detailUserAvatar').src = user.avatar;
                    document.getElementById('detailUserName').textContent = user.name;
                    document.getElementById('detailUserEmail').textContent = user.email;
                    document.getElementById('detailUserStatus').textContent = user.status;
                    document.getElementById('detailJoinDate').textContent = user.joinDate;
                    document.getElementById('detailAccountType').textContent = user.accountType;
                    document.getElementById('detailLastLogin').textContent = user.lastLogin;
                    document.getElementById('detailPlaylists').textContent = user.playlists;
                    
                    // Update genres
                    const genresContainer = document.getElementById('detailGenres');
                    genresContainer.innerHTML = '';
                    user.genres.forEach(genre => {
                        const badge = document.createElement('span');
                        badge.className = 'badge bg-primary me-2';
                        badge.textContent = genre;
                        genresContainer.appendChild(badge);
                    });
                    
                    // Update status badge class
                    const statusBadge = document.getElementById('detailUserStatus');
                    statusBadge.className = 'status-badge ';
                    if (user.status === "Active") {
                        statusBadge.classList.add('status-active');
                    } else if (user.status === "Pending") {
                        statusBadge.classList.add('status-pending');
                    } else {
                        statusBadge.classList.add('status-inactive');
                    }
                    
                    userDetailModal.show();
                });
            });
            
            // Edit user
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const user = userData[userId];
                    
                    // In a real app, you would load user data into the form
                    editUserModal.show();
                });
            });
        });
    </script>
</body>
</html>