<!DOCTYPE html>
<html lang="id" class="{{ session('theme', 'dark') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - DentalCare Expert</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-baru.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-bg: #0f172a;
            --dark-card: #1e293b;
            --dark-text: #f1f5f9;
            --light-bg: #f8fafc;
            --light-card: #ffffff;
            --light-text: #334155;
        }

        .light {
            --bg-color: var(--light-bg);
            --card-bg: var(--light-card);
            --text-color: var(--light-text);
            --border-color: #e2e8f0;
        }

        .dark {
            --bg-color: var(--dark-bg);
            --card-bg: var(--dark-card);
            --text-color: var(--dark-text);
            --border-color: #374151;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color 0.3s, color 0.3s;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--card-bg);
            border-right: 1px solid var(--border-color);
            padding: 1.5rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            padding: 0.5rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 0.75rem;
            padding-left: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            color: var(--text-color);
            text-decoration: none;
            margin-bottom: 0.25rem;
            transition: all 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 0;
        }

        /* Navbar Header */
        .navbar-header {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .breadcrumb a {
            color: #6b7280;
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumb a:hover {
            color: var(--primary-color);
        }

        .breadcrumb .separator {
            color: #9ca3af;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Search Bar */
        .search-container {
            position: relative;
        }

        .search-input {
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 2rem;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            width: 300px;
            color: var(--text-color);
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        /* Navbar Icons */
        .navbar-icons {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .nav-icon:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 2rem;
            padding: 0.5rem 0.75rem 0.5rem 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-btn:hover {
            border-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.5rem;
            min-width: 200px;
            margin-top: 0.5rem;
            display: none;
            z-index: 1000;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .user-dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background: var(--primary-color);
            color: white;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 0.5rem 0;
        }

        /* Theme Toggle */
        .theme-toggle {
            position: relative;
        }

        .theme-btn {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            color: var(--text-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .theme-btn:hover {
            border-color: var(--primary-color);
        }

        .theme-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.5rem;
            min-width: 150px;
            display: none;
            z-index: 1000;
            margin-top: 0.5rem;
        }

        .theme-dropdown.show {
            display: block;
        }

        .theme-option {
            padding: 0.5rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .theme-option:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Tab Content */
        .tab-content {
            background: var(--card-bg);
            border-radius: 1rem;
            border: 1px solid var(--border-color);
            padding: 2rem;
        }

        /* Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .stat-users {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .stat-diagnoses {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stat-diseases {
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
        }

        .stat-symptoms {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Tables */
        .table-container {
            background: var(--card-bg);
            border-radius: 1rem;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .table th {
            background: var(--card-bg);
            font-weight: 600;
            color: #6b7280;
        }

        /* Buttons */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-success {
            background: var(--success-color);
            color: white;
        }

        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            background: var(--card-bg);
            color: var(--text-color);
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: var(--card-bg);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6b7280;
            cursor: pointer;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .modal-close:hover {
            background: rgba(0, 0, 0, 0.1);
            color: var(--danger-color);
        }

        .modal-body {
            margin-bottom: 1.5rem;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        /* Confirmation Modal */
        .confirmation-modal .modal-content {
            text-align: center;
            max-width: 400px;
        }

        .confirmation-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        .confirmation-icon.warning {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .confirmation-icon.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .confirmation-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .confirmation-message {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        /* Notification System */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        }

        .notification {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1rem 1.25rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }

        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification.hide {
            transform: translateX(400px);
            opacity: 0;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .notification-success {
            border-left: 4px solid var(--success-color);
        }

        .notification-success .notification-icon {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .notification-error {
            border-left: 4px solid var(--danger-color);
        }

        .notification-error .notification-icon {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .notification-warning {
            border-left: 4px solid var(--warning-color);
        }

        .notification-warning .notification-icon {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .notification-info {
            border-left: 4px solid var(--primary-color);
        }

        .notification-info .notification-icon {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary-color);
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .notification-message {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .notification-close {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 0.25rem;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .notification-close:hover {
            background: rgba(0, 0, 0, 0.1);
            color: var(--danger-color);
        }

        /* Spinner */
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Alert */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger-color);
            color: var(--danger-color);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                margin-left: 220px;
            }

            .search-input {
                width: 250px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }

            .admin-container {
                flex-direction: column;
            }

            .navbar-header {
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .navbar-left {
                width: 100%;
                justify-content: space-between;
            }

            .navbar-right {
                width: 100%;
                justify-content: space-between;
            }

            .search-input {
                width: 200px;
            }

            .content-area {
                padding: 1rem;
            }

            .modal-content {
                margin: 1rem;
                width: calc(100% - 2rem);
            }

            .notification-container {
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }

        @media (max-width: 480px) {
            .navbar-right {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .search-container {
                width: 100%;
            }

            .search-input {
                width: 100%;
            }

            .navbar-icons {
                width: 100%;
                justify-content: space-between;
            }

            .modal-footer {
                flex-direction: column;
            }

            .modal-footer .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-tooth"></i>
                </div>
                <div class="logo-text">DentalCare Admin</div>
            </div>

            <div class="nav-section">
                <div class="nav-title">Main Menu</div>
                <a href="#" class="nav-link active" data-tab="dashboard">
                    <i class="fas fa-chart-bar"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-link" data-tab="users">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <a href="#" class="nav-link" data-tab="diseases">
                    <i class="fas fa-disease"></i>
                    <span>Diseases</span>
                </a>
                <a href="#" class="nav-link" data-tab="symptoms">
                    <i class="fas fa-stethoscope"></i>
                    <span>Symptoms</span>
                </a>
                <a href="#" class="nav-link" data-tab="diagnoses">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Diagnoses</span>
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar Header -->
            <header class="navbar-header">
                <div class="navbar-left">
                    <h1 class="page-title" id="pageTitle">Admin Dashboard</h1>
                    <div class="breadcrumb" id="breadcrumb">
                        <!-- <a href="#">Home</a>
                        <span class="separator">/</span>
                        <span>Dashboard</span> -->
                    </div>
                </div>

                <div class="navbar-right">
                    <!-- Search Bar -->
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search patients, diseases...">
                    </div>

                    <!-- Navbar Icons -->
                    <div class="navbar-icons">
                        <!-- Theme Toggle -->
                        <div class="theme-toggle">
                            <button class="nav-icon theme-btn" id="themeToggle">
                                <i class="fas fa-palette"></i>
                            </button>
                            <div class="theme-dropdown" id="themeDropdown">
                                <div class="theme-option" data-theme="light">
                                    <i class="fas fa-sun"></i> Light Mode
                                </div>
                                <div class="theme-option" data-theme="dark">
                                    <i class="fas fa-moon"></i> Dark Mode
                                </div>
                                <div class="theme-option" data-theme="system">
                                    <i class="fas fa-desktop"></i> System Default
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="user-dropdown">
                        <button class="user-btn" id="userToggle">
                            <div class="user-avatar">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="user-info">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role">Administrator</span>
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="user-dropdown-menu" id="userDropdown">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                <span>Account Settings</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Tab Content -->
                <div class="tab-content" id="tabContent">
                    <div class="text-center py-8">
                        <div class="spinner"></div>
                        <p class="text-gray-400 mt-4">Memuat dashboard...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer"></div>

    <script>
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Theme Management
        const themeToggle = document.getElementById('themeToggle');
        const themeDropdown = document.getElementById('themeDropdown');
        const html = document.documentElement;

        // User Dropdown
        const userToggle = document.getElementById('userToggle');
        const userDropdown = document.getElementById('userDropdown');

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'dark';
        applyTheme(savedTheme);

        // Theme toggle functionality
        themeToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            themeDropdown.classList.toggle('show');
        });

        document.querySelectorAll('.theme-option').forEach(option => {
            option.addEventListener('click', () => {
                const theme = option.dataset.theme;
                applyTheme(theme);
                themeDropdown.classList.remove('show');

                // Save to server
                fetch('/admin/settings/theme', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        theme: theme
                    })
                });
            });
        });

        function applyTheme(theme) {
            html.className = theme;
            localStorage.setItem('theme', theme);
        }

        // User dropdown functionality
        userToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!themeToggle.contains(e.target) && !themeDropdown.contains(e.target)) {
                themeDropdown.classList.remove('show');
            }

            if (!userToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });

        // Tab Management
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Update active state
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                // Load tab content
                const tab = this.dataset.tab;
                loadTabContent(tab);
            });
        });

        function loadTabContent(tab) {
            const tabContent = document.getElementById('tabContent');
            const pageTitle = document.getElementById('pageTitle');
            const breadcrumb = document.getElementById('breadcrumb');

            // Show loading
            tabContent.innerHTML = `
                <div class="text-center py-8">
                    <div class="spinner"></div>
                    <p class="text-gray-400 mt-4">Memuat ${tab}...</p>
                </div>
            `;

            // Update page title and breadcrumb
            const titles = {
                'dashboard': 'Admin Dashboard',
                'users': 'User Management',
                'diseases': 'Disease Management',
                'symptoms': 'Symptom Management',
                'diagnoses': 'Diagnosis History',
                'settings': 'Settings'
            };

            const breadcrumbs = {
                'dashboard': '<a href="#">Home</a><span class="separator">/</span><span>Dashboard</span>',
                'users': '<a href="#">Home</a><span class="separator">/</span><span>User Management</span>',
                'diseases': '<a href="#">Home</a><span class="separator">/</span><span>Disease Management</span>',
                'symptoms': '<a href="#">Home</a><span class="separator">/</span><span>Symptom Management</span>',
                'diagnoses': '<a href="#">Home</a><span class="separator">/</span><span>Diagnosis History</span>',
                'settings': '<a href="#">Home</a><span class="separator">/</span><span>Settings</span>'
            };

            pageTitle.textContent = titles[tab] || 'Admin Panel';
            breadcrumb.innerHTML = breadcrumbs[tab] || '<a href="#">Home</a><span class="separator">/</span><span>Dashboard</span>';

            // Load content via AJAX
            fetch(`/admin/load/${tab}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    tabContent.innerHTML = html;
                    // Re-initialize any JavaScript for the loaded content
                    initializeTabScripts(tab);
                })
                .catch(error => {
                    console.error('Error loading tab:', error);
                    tabContent.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        Gagal memuat konten: ${error.message}
                    </div>
                `;
                });
        }

        function initializeTabScripts(tab) {
            // Initialize scripts based on the loaded tab
            if (tab === 'users') {
                initializeUserScripts();
            } else if (tab === 'symptoms') {
                initializeSymptomScripts();
            } else if (tab === 'diseases') {
                initializeDiseaseScripts();
            } else if (tab === 'diagnoses') {
                initializeDiagnosisScripts();
            }
        }

        // Load default tab
        loadTabContent('dashboard');

        // GLOBAL FUNCTIONS - Available for all tabs
        function initializeTabScripts(tab) {
            console.log('Initializing scripts for tab:', tab);
            // Functions will be available globally
        }

        // Global utility functions
        function showAlert(message, type = 'info') {
            alert(message);
        }

        // Global error handler
        window.addEventListener('error', function(e) {
            console.error('Global error:', e.error);
        });

        // ==================== NOTIFICATION SYSTEM ====================
        function showNotification(title, message, type = 'info', duration = 5000) {
            const notificationContainer = document.getElementById('notificationContainer');
            const notificationId = 'notification-' + Date.now();
            
            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-circle',
                warning: 'fas fa-exclamation-triangle',
                info: 'fas fa-info-circle'
            };

            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.id = notificationId;
            notification.innerHTML = `
                <div class="notification-icon">
                    <i class="${icons[type]}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">${title}</div>
                    <div class="notification-message">${message}</div>
                </div>
                <button class="notification-close" onclick="closeNotification('${notificationId}')">
                    <i class="fas fa-times"></i>
                </button>
            `;

            notificationContainer.appendChild(notification);

            // Show notification with animation
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);

            // Auto remove notification
            if (duration > 0) {
                setTimeout(() => {
                    closeNotification(notificationId);
                }, duration);
            }

            return notificationId;
        }

        function closeNotification(notificationId) {
            const notification = document.getElementById(notificationId);
            if (notification) {
                notification.classList.remove('show');
                notification.classList.add('hide');
                
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }
        }

        // ==================== CONFIRMATION MODAL ====================
        function showConfirmationModal(title, message, type = 'warning', confirmText = 'Delete', cancelText = 'Cancel') {
            return new Promise((resolve) => {
                const modalHtml = `
                    <div class="modal show confirmation-modal" id="confirmationModal">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="confirmation-icon ${type}">
                                    <i class="fas fa-${type === 'warning' ? 'exclamation-triangle' : 'check-circle'}"></i>
                                </div>
                                <h3 class="confirmation-title">${title}</h3>
                                <p class="confirmation-message">${message}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cancelBtn">${cancelText}</button>
                                <button type="button" class="btn ${type === 'warning' ? 'btn-danger' : 'btn-success'}" id="confirmBtn">${confirmText}</button>
                            </div>
                        </div>
                    </div>
                `;

                document.body.insertAdjacentHTML('beforeend', modalHtml);
                
                const modal = document.getElementById('confirmationModal');
                const confirmBtn = document.getElementById('confirmBtn');
                const cancelBtn = document.getElementById('cancelBtn');

                const handleConfirm = () => {
                    closeModal('confirmationModal');
                    resolve(true);
                };

                const handleCancel = () => {
                    closeModal('confirmationModal');
                    resolve(false);
                };

                confirmBtn.addEventListener('click', handleConfirm);
                cancelBtn.addEventListener('click', handleCancel);

                // Close modal when clicking outside
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        handleCancel();
                    }
                });
            });
        }

        // ==================== GLOBAL CRUD FUNCTIONS ====================

        // ==================== USER MANAGEMENT FUNCTIONS ====================
        let currentUserId = null;

        function editUser(userId) {
            console.log('Editing user:', userId);
            currentUserId = userId;

            fetch(`/admin/users/${userId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (!result.success) throw new Error(result.message);

                    const user = result.data;

                    // Create and show modal
                    showUserEditModal(user);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error', 'Failed to load user: ' + error.message, 'error');
                });
        }

        function showUserEditModal(user) {
            const modalHtml = `
            <div class="modal show" id="userEditModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edit User</h3>
                        <button class="modal-close" onclick="closeModal('userEditModal')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editUserForm">
                            <div class="form-group">
                                <label class="form-label">Name *</label>
                                <input type="text" id="editUserName" class="form-control" value="${user.name || ''}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email *</label>
                                <input type="email" id="editUserEmail" class="form-control" value="${user.email || ''}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Age</label>
                                <input type="number" id="editUserAge" class="form-control" value="${user.age || ''}" min="1" max="120">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select id="editUserGender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male" ${user.gender==='male' ? 'selected' : ''}>Male</option>
                                    <option value="female" ${user.gender==='female' ? 'selected' : ''}>Female</option>
                                    <option value="other" ${user.gender==='other' ? 'selected' : ''}>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Role</label>
                                <select id="editUserRole" class="form-control">
                                    <option value="user" ${!user.is_admin ? 'selected' : ''}>User</option>
                                    <option value="admin" ${user.is_admin ? 'selected' : ''}>Admin</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('userEditModal')">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveUserChanges()">Save Changes</button>
                    </div>
                </div>
            </div>
            `;

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }

        function saveUserChanges() {
            if (!currentUserId) return;

            const formData = {
                name: document.getElementById('editUserName').value,
                email: document.getElementById('editUserEmail').value,
                age: document.getElementById('editUserAge').value || null,
                gender: document.getElementById('editUserGender').value || null,
                role: document.getElementById('editUserRole').value,
                _token: csrfToken,
                _method: 'PUT'
            };

            fetch(`/admin/users/${currentUserId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Success', 'User updated successfully', 'success');
                        closeModal('userEditModal');
                        // Reload the current tab content instead of full page reload
                        const activeTab = document.querySelector('.nav-link.active').dataset.tab;
                        loadTabContent(activeTab);
                    } else {
                        showNotification('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Error', 'Failed to update user: ' + error.message, 'error');
                });
        }

        async function deleteUser(userId) {
            const confirmed = await showConfirmationModal(
                'Delete User',
                'Are you sure you want to delete this user? This action cannot be undone.',
                'warning',
                'Delete User',
                'Cancel'
            );

            if (!confirmed) return;

            fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Success', 'User deleted successfully', 'success');
                        // Reload the current tab content instead of full page reload
                        const activeTab = document.querySelector('.nav-link.active').dataset.tab;
                        loadTabContent(activeTab);
                    } else {
                        showNotification('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Error', 'Failed to delete user: ' + error.message, 'error');
                });
        }

        // ==================== SYMPTOM MANAGEMENT FUNCTIONS ====================
        let currentSymptomId = null;

        function showSymptomModal() {
            console.log('Showing symptom modal');
            // Load empty modal for new symptom
            showSymptomEditModal();
        }

        function editSymptom(symptomId) {
            console.log('Editing symptom:', symptomId);
            currentSymptomId = symptomId;

            fetch(`/admin/symptoms/${symptomId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (!result.success) throw new Error(result.message);
                    showSymptomEditModal(result.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error', 'Failed to load symptom: ' + error.message, 'error');
                });
        }

        function showSymptomEditModal(symptom = null) {
            const isEdit = !!symptom;
            const modalHtml = `
            <div class="modal show" id="symptomEditModal">
                <div class="modal-content" style="max-width: 600px;">
                    <div class="modal-header">
                        <h3 class="modal-title">${isEdit ? 'Edit Symptom' : 'Add New Symptom'}</h3>
                        <button class="modal-close" onclick="closeModal('symptomEditModal')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form id="symptomForm" onsubmit="saveSymptom(event)">
                        <div class="modal-body">
                            <input type="hidden" id="symptomId" name="id" value="${symptom?.id || ''}">

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="form-group">
                                    <label for="code" class="form-label">Code *</label>
                                    <input type="text" id="code" name="code" class="form-control"
                                        value="${symptom?.code || ''}" required placeholder="e.g., Q1, Q2">
                                </div>
                                <div class="form-group">
                                    <label for="order" class="form-label">Order *</label>
                                    <input type="number" id="order" name="order" class="form-control"
                                        value="${symptom?.order || ''}" required min="1">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="question" class="form-label">Question *</label>
                                <textarea id="question" name="question" class="form-control" rows="3" required>${symptom?.question || ''}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="form-group">
                                    <label for="type" class="form-label">Type *</label>
                                    <select id="type" name="type" class="form-control" required onchange="toggleOptionsField()">
                                        <option value="yes_no" ${symptom?.type==='yes_no' ? 'selected' : ''}>Yes/No</option>
                                        <option value="multiple_choice" ${symptom?.type==='multiple_choice' ? 'selected' : ''}>Multiple Choice</option>
                                        <option value="scale" ${symptom?.type==='scale' ? 'selected' : ''}>Scale</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <div class="flex items-center gap-4 mt-2">
                                        <label class="flex items-center">
                                            <input type="radio" name="is_active" value="1" ${!symptom || symptom.is_active ? 'checked' : ''} class="mr-2">
                                            <span class="text-sm">Active</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="is_active" value="0" ${symptom && !symptom.is_active ? 'checked' : ''} class="mr-2">
                                            <span class="text-sm">Inactive</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4" id="optionsField" style="display: none;">
                                <label class="form-label">Options</label>
                                <div class="space-y-2" id="optionsContainer">
                                    <!-- Options will be populated here -->
                                </div>
                                <button type="button" onclick="addOption()" class="btn btn-secondary btn-sm mt-2">
                                    <i class="fas fa-plus"></i> Add Option
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="closeModal('symptomEditModal')" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Save Symptom
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Initialize options if editing
            if (isEdit && symptom.options) {
                initializeOptions(symptom.options);
            }

            toggleOptionsField();
        }

        function saveSymptom(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const symptomId = formData.get('id');
            const url = symptomId ? `/admin/symptoms/${symptomId}` : '/admin/symptoms';

            // Get options
            const options = getOptionsFromForm();

            const data = {
                code: formData.get('code'),
                question: formData.get('question'),
                type: formData.get('type'),
                order: parseInt(formData.get('order')),
                is_active: formData.get('is_active') === '1',
                options: options,
                _token: csrfToken
            };

            if (symptomId) {
                data._method = 'PUT';
            }

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Success', 'Symptom saved successfully', 'success');
                        closeModal('symptomEditModal');
                        // Reload the current tab content instead of full page reload
                        const activeTab = document.querySelector('.nav-link.active').dataset.tab;
                        loadTabContent(activeTab);
                    } else {
                        showNotification('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Error', 'Failed to save symptom: ' + error.message, 'error');
                });
        }

        async function deleteSymptom(symptomId) {
            const confirmed = await showConfirmationModal(
                'Delete Symptom',
                'Are you sure you want to delete this symptom? This action cannot be undone.',
                'warning',
                'Delete Symptom',
                'Cancel'
            );

            if (!confirmed) return;

            fetch(`/admin/symptoms/${symptomId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Success', 'Symptom deleted successfully', 'success');
                        // Reload the current tab content instead of full page reload
                        const activeTab = document.querySelector('.nav-link.active').dataset.tab;
                        loadTabContent(activeTab);
                    } else {
                        showNotification('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Error', 'Failed to delete symptom: ' + error.message, 'error');
                });
        }

        // function toggleSymptomStatus(symptomId, newStatus) {
        //     const action = newStatus ? 'activate' : 'deactivate';
        //     if (!confirm(`Are you sure you want to ${action} this symptom?`)) return;

        //     // Implementation for status toggle
        //     console.log('Toggle symptom status:', symptomId, newStatus);
        // }

        // ==================== DISEASE MANAGEMENT FUNCTIONS ====================
        let currentDiseaseId = null;

        function showDiseaseModal() {
            showDiseaseEditModal();
        }

        function editDisease(diseaseId) {
            console.log('Editing disease:', diseaseId);
            currentDiseaseId = diseaseId;

            fetch(`/admin/diseases/${diseaseId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (!result.success) throw new Error(result.message);
                    showDiseaseEditModal(result.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error', 'Failed to load disease: ' + error.message, 'error');
                });
        }

        function showDiseaseEditModal(disease = null) {
            const isEdit = !!disease;
            const modalHtml = `
            <div class="modal show" id="diseaseEditModal">
                <div class="modal-content" style="max-width: 700px;">
                    <div class="modal-header">
                        <h3 class="modal-title">${isEdit ? 'Edit Disease' : 'Add New Disease'}</h3>
                        <button class="modal-close" onclick="closeModal('diseaseEditModal')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form id="diseaseForm" onsubmit="saveDisease(event)">
                        <div class="modal-body">
                            <input type="hidden" id="diseaseId" name="id" value="${disease?.id || ''}">

                            <div class="form-group mb-4">
                                <label class="form-label">Name *</label>
                                <input type="text" id="diseaseName" name="name" class="form-control"
                                    value="${disease?.name || ''}" required>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="form-group">
                                    <label class="form-label">Severity *</label>
                                    <select id="diseaseSeverity" name="severity" class="form-control" required>
                                        <option value="low" ${disease?.severity==='low' ? 'selected' : ''}>Low</option>
                                        <option value="medium" ${disease?.severity==='medium' ? 'selected' : ''}>Medium</option>
                                        <option value="high" ${disease?.severity==='high' ? 'selected' : ''}>High</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Emergency Case</label>
                                    <div class="flex items-center mt-2">
                                        <input type="checkbox" name="is_emergency" value="1"
                                            ${disease?.is_emergency ? 'checked' : ''} class="mr-2">
                                        <span class="text-sm">Mark as emergency case</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Description *</label>
                                <textarea id="diseaseDescription" name="description" class="form-control" rows="3" required>${disease?.description || ''}</textarea>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Treatment *</label>
                                <textarea id="diseaseTreatment" name="treatment" class="form-control" rows="3" required>${disease?.treatment || ''}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="closeModal('diseaseEditModal')" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Save Disease
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }

        function saveDisease(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const diseaseId = formData.get('id');
            const url = diseaseId ? `/admin/diseases/${diseaseId}` : '/admin/diseases';

            const data = {
                name: formData.get('name'),
                description: formData.get('description'),
                treatment: formData.get('treatment'),
                severity: formData.get('severity'),
                is_emergency: formData.get('is_emergency') === '1',
                _token: csrfToken
            };

            if (diseaseId) {
                data._method = 'PUT';
            }

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Success', 'Disease saved successfully', 'success');
                        closeModal('diseaseEditModal');
                        // Reload the current tab content instead of full page reload
                        const activeTab = document.querySelector('.nav-link.active').dataset.tab;
                        loadTabContent(activeTab);
                    } else {
                        showNotification('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Error', 'Failed to save disease: ' + error.message, 'error');
                });
        }

        async function deleteDisease(diseaseId) {
            const confirmed = await showConfirmationModal(
                'Delete Disease',
                'Are you sure you want to delete this disease? This action cannot be undone.',
                'warning',
                'Delete Disease',
                'Cancel'
            );

            if (!confirmed) return;

            fetch(`/admin/diseases/${diseaseId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Success', 'Disease deleted successfully', 'success');
                        // Reload the current tab content instead of full page reload
                        const activeTab = document.querySelector('.nav-link.active').dataset.tab;
                        loadTabContent(activeTab);
                    } else {
                        showNotification('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Error', 'Failed to delete disease: ' + error.message, 'error');
                });
        }

        // ==================== DIAGNOSIS MANAGEMENT FUNCTIONS ====================
        async function deleteDiagnosis(diagnosisId) {
            const confirmed = await showConfirmationModal(
                'Delete Diagnosis',
                'Are you sure you want to delete this diagnosis? This action cannot be undone.',
                'warning',
                'Delete Diagnosis',
                'Cancel'
            );

            if (!confirmed) return;

            fetch(`/admin/diagnoses/${diagnosisId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Success', 'Diagnosis deleted successfully', 'success');
                        // Reload the current tab content instead of full page reload
                        const activeTab = document.querySelector('.nav-link.active').dataset.tab;
                        loadTabContent(activeTab);
                    } else {
                        showNotification('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Error', 'Failed to delete diagnosis: ' + error.message, 'error');
                });
        }

        // ==================== UTILITY FUNCTIONS ====================
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.remove();
            }
        }

        function toggleOptionsField() {
            const type = document.getElementById('type')?.value;
            const optionsField = document.getElementById('optionsField');
            if (!optionsField) return;

            optionsField.style.display = type === 'multiple_choice' ? 'block' : 'none';
        }

        function addOption() {
            const optionsContainer = document.getElementById('optionsContainer');
            if (!optionsContainer) return;

            optionsContainer.innerHTML += `
            <div class="flex gap-2 mb-2">
                <input type="text" name="option_keys[]" class="form-control flex-1" placeholder="Key (e.g., yes)">
                <input type="text" name="option_values[]" class="form-control flex-1" placeholder="Value (e.g., Ya)">
                <button type="button" onclick="removeOption(this)" class="btn btn-danger btn-sm">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            `;
        }

        function removeOption(button) {
            const optionsContainer = document.getElementById('optionsContainer');
            if (optionsContainer.querySelectorAll('div').length > 1) {
                button.parentElement.remove();
            }
        }

        function initializeOptions(options) {
            const optionsContainer = document.getElementById('optionsContainer');
            if (!optionsContainer || !options) return;

            optionsContainer.innerHTML = '';

            let optionsObj = options;
            if (typeof options === 'string') {
                try {
                    optionsObj = JSON.parse(options);
                } catch (e) {
                    optionsObj = null;
                }
            }

            if (optionsObj && Object.keys(optionsObj).length > 0) {
                Object.entries(optionsObj).forEach(([key, value]) => {
                    optionsContainer.innerHTML += `
                    <div class="flex gap-2 mb-2">
                        <input type="text" name="option_keys[]" class="form-control flex-1" value="${key}" placeholder="Key">
                        <input type="text" name="option_values[]" class="form-control flex-1" value="${value}" placeholder="Value">
                        <button type="button" onclick="removeOption(this)" class="btn btn-danger btn-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    `;
                });
            } else {
                addOption(); // Add one empty option
            }
        }

        function getOptionsFromForm() {
            const optionKeys = document.querySelectorAll('input[name="option_keys[]"]');
            const optionValues = document.querySelectorAll('input[name="option_values[]"]');
            const options = {};

            optionKeys.forEach((keyInput, index) => {
                const key = keyInput.value.trim();
                const value = optionValues[index]?.value.trim();
                if (key && value) {
                    options[key] = value;
                }
            });

            return Object.keys(options).length > 0 ? options : null;
        }

        // ==================== EXPORT FUNCTIONS ====================
        function exportUsers() {
            window.open('/admin/users/export/csv', '_blank');
        }

        function exportDiagnoses() {
            window.open('/admin/diagnoses/export/csv', '_blank');
        }

        // Make functions globally available
        window.editUser = editUser;
        window.deleteUser = deleteUser;
        window.showSymptomModal = showSymptomModal;
        window.editSymptom = editSymptom;
        window.deleteSymptom = deleteSymptom;
        window.showDiseaseModal = showDiseaseModal;
        window.editDisease = editDisease;
        window.deleteDisease = deleteDisease;
        window.deleteDiagnosis = deleteDiagnosis;
        window.closeModal = closeModal;
        window.toggleOptionsField = toggleOptionsField;
        window.addOption = addOption;
        window.removeOption = removeOption;
        window.exportUsers = exportUsers;
        window.exportDiagnoses = exportDiagnoses;
        window.showNotification = showNotification;
        window.closeNotification = closeNotification;
    </script>
</body>

</html>