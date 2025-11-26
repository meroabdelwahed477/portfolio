<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - Portfolio Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #64748b;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #334155;
        }

        .form-group input {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-group .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .remember-me input {
            width: auto;
        }

        .btn-login {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-right: 4px solid #ef4444;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-right: 4px solid #10b981;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-lock"></i> تسجيل الدخول</h1>
            <p>لوحة تحكم Portfolio</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">تذكرني</label>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
            </button>
        </form>
    </div>
</body>
</html>
