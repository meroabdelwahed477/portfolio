<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') - Portfolio Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --border: #e2e8f0;
            --text: #334155;
            --text-light: #64748b;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--light);
            color: var(--text);
            direction: rtl;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }

        .sidebar-menu li {
            margin: 0.25rem 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: var(--text);
            text-decoration: none;
            transition: all 0.3s;
            gap: 0.75rem;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--light);
            color: var(--primary);
            border-right: 3px solid var(--primary);
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-right: 260px;
            padding: 2rem;
        }

        .page-header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
        }

        .page-header p {
            color: var(--text-light);
            margin-top: 0.5rem;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border);
        }

        .card-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-right: 4px solid var(--primary);
        }

        .stat-card h3 {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light);
            color: var(--primary);
            font-size: 1.5rem;
            margin-top: 1rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-group small {
            display: block;
            margin-top: 0.25rem;
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .form-group .error {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-secondary {
            background: var(--light);
            color: var(--text);
            border: 2px solid var(--border);
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead {
            background: var(--light);
        }

        .table th {
            padding: 1rem;
            text-align: right;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 2px solid var(--border);
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .table tbody tr:hover {
            background: var(--light);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-right: 4px solid var(--success);
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-right: 4px solid var(--danger);
        }

        /* Badges */
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-primary {
            background: #e0e7ff;
            color: #3730a3;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
                transition: transform 0.3s;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
                padding: 1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-briefcase"></i> Portfolio Admin</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> لوحة التحكم
                </a></li>
                <li><a href="{{ route('admin.profile.index') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> الملف الشخصي
                </a></li>
                <li><a href="{{ route('admin.skills.index') }}" class="{{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                    <i class="fas fa-code"></i> المهارات
                </a></li>
                <li><a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                    <i class="fas fa-project-diagram"></i> المشاريع
                </a></li>
                <li><a href="{{ route('admin.certificates.index') }}" class="{{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                    <i class="fas fa-certificate"></i> الشهادات
                </a></li>
                <li><a href="{{ route('admin.work-experiences.index') }}" class="{{ request()->routeIs('admin.work-experiences.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i> الخبرات العملية
                </a></li>
                <li><a href="{{ route('admin.social-links.index') }}" class="{{ request()->routeIs('admin.social-links.*') ? 'active' : '' }}">
                    <i class="fas fa-share-alt"></i> روابط التواصل
                </a></li>
                <li><a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> الإعدادات
                </a></li>
                <li><a href="{{ route('admin.contacts.index') }}" class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> الرسائل
                    @if(\App\Models\Contact::where('is_read', false)->count() > 0)
                        <span class="badge badge-danger">{{ \App\Models\Contact::where('is_read', false)->count() }}</span>
                    @endif
                </a></li>
                <li><a href="{{ route('home') }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i> عرض الموقع
                </a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; text-align: right; background: none; border: none; color: var(--text); padding: 0.875rem 1.5rem; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s;">
                            <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-right: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>

