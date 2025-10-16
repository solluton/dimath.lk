<?php
require_once __DIR__ . '/../config/timezone_helper.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
    <title>Access Denied | Dimath Group Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        
        .icon {
            width: 80px;
            height: 80px;
            background: #e74c3c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 40px;
            color: white;
        }
        
        h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        
        .subtitle {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        
        .description {
            font-size: 16px;
            color: #95a5a6;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 30px;
            color: #856404;
            font-size: 14px;
        }
        
        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #ecf0f1;
            color: #2c3e50;
        }
        
        .btn-secondary:hover {
            background: #bdc3c7;
            transform: translateY(-2px);
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
            font-size: 14px;
            color: #95a5a6;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 40px 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .subtitle {
                font-size: 16px;
            }
            
            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            🔒
        </div>
        
        <h1>Access Denied</h1>
        <div class="subtitle">Unauthorized Access Attempt</div>
        
        <div class="description">
            You are attempting to access a restricted directory or file that requires proper authentication and authorization.
        </div>
        
        <div class="warning-box">
            <strong>Security Notice:</strong> This access attempt has been logged for security purposes. 
            Repeated unauthorized access attempts may result in IP blocking.
        </div>
        
        <div class="buttons">
            <a href="../admin/login.php" class="btn btn-primary">Admin Login</a>
            <a href="../" class="btn btn-secondary">Go to Website</a>
        </div>
        
        <div class="footer">
            <strong>Dimath Sports Admin</strong> - Dimath Sports (Private) Limited<br>
            Error Code: 403 Forbidden | Timestamp: <?= getSriLankaTime('Y-m-d H:i:s') ?>
        </div>
    </div>
</body>
</html>
