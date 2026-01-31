<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourist Guide - Backend API Documentation</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; border-radius: 12px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        h1 { color: #333; margin-bottom: 10px; }
        .subtitle { color: #666; margin-bottom: 30px; font-size: 16px; }
        .section { margin-bottom: 40px; padding: 20px; background: #f8f9fa; border-left: 4px solid #667eea; border-radius: 8px; }
        .section h2 { color: #667eea; margin-bottom: 15px; font-size: 20px; }
        .endpoint { background: white; padding: 12px; margin: 10px 0; border-radius: 6px; font-family: 'Courier New'; font-size: 14px; color: #333; border: 1px solid #ddd; }
        .method { display: inline-block; padding: 3px 8px; border-radius: 4px; font-weight: bold; margin-right: 10px; font-size: 12px; }
        .GET { background: #61affe; color: white; }
        .POST { background: #49cc90; color: white; }
        .PUT { background: #fca130; color: white; }
        .DELETE { background: #f93e3e; color: white; }
        .status { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; margin-top: 5px; }
        .status.success { background: #d4edda; color: #155724; }
        .status.error { background: #f8d7da; color: #721c24; }
        .credentials { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 8px; margin-top: 20px; }
        .credentials h3 { color: #856404; margin-bottom: 10px; }
        .credentials p { color: #856404; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #667eea; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌍 Tourist Guide - Backend API</h1>
        <p class="subtitle">Complete API Documentation & Setup Guide</p>

        <div class="credentials">
            <h3>📝 Default Credentials</h3>
            <table>
                <tr>
                    <th>User Type</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
                <tr>
                    <td>Admin</td>
                    <td>admin@admin.com</td>
                    <td>admin123</td>
                </tr>
                <tr>
                    <td>Customer</td>
                    <td>user@demo.com</td>
                    <td>pass123</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>🔐 Authentication</h2>
            <div class="endpoint">
                <span class="method POST">POST</span>
                /backend/api/auth.php?action=register
            </div>
            <div class="endpoint">
                <span class="method POST">POST</span>
                /backend/api/auth.php?action=login
            </div>
            <div class="endpoint">
                <span class="method POST">POST</span>
                /backend/api/auth.php?action=admin-login
            </div>
        </div>

        <div class="section">
            <h2>🏖️ Destinations</h2>
            <div class="endpoint">
                <span class="method GET">GET</span>
                /backend/api/destinations.php?action=list
            </div>
            <div class="endpoint">
                <span class="method GET">GET</span>
                /backend/api/destinations.php?action=get&id=1
            </div>
            <div class="endpoint">
                <span class="method POST">POST</span>
                /backend/api/destinations.php <span class="status success">Admin Only</span>
            </div>
            <div class="endpoint">
                <span class="method PUT">PUT</span>
                /backend/api/destinations.php?id=1 <span class="status success">Admin Only</span>
            </div>
            <div class="endpoint">
                <span class="method DELETE">DELETE</span>
                /backend/api/destinations.php?id=1 <span class="status success">Admin Only</span>
            </div>
        </div>

        <div class="section">
            <h2>📅 Bookings</h2>
            <div class="endpoint">
                <span class="method GET">GET</span>
                /backend/api/bookings.php?action=user&user_id=1
            </div>
            <div class="endpoint">
                <span class="method GET">GET</span>
                /backend/api/bookings.php?action=all <span class="status success">Admin Only</span>
            </div>
            <div class="endpoint">
                <span class="method POST">POST</span>
                /backend/api/bookings.php
            </div>
            <div class="endpoint">
                <span class="method PUT">PUT</span>
                /backend/api/bookings.php?id=1 <span class="status success">Admin Only</span>
            </div>
            <div class="endpoint">
                <span class="method DELETE">DELETE</span>
                /backend/api/bookings.php?id=1
            </div>
        </div>

        <div class="section">
            <h2>❤️ Wishlist</h2>
            <div class="endpoint">
                <span class="method GET">GET</span>
                /backend/api/wishlist.php?user_id=1
            </div>
            <div class="endpoint">
                <span class="method POST">POST</span>
                /backend/api/wishlist.php
            </div>
            <div class="endpoint">
                <span class="method DELETE">DELETE</span>
                /backend/api/wishlist.php?user_id=1&dest_id=1
            </div>
        </div>

        <div class="section">
            <h2>👥 Users</h2>
            <div class="endpoint">
                <span class="method GET">GET</span>
                /backend/api/users.php?action=all <span class="status success">Admin Only</span>
            </div>
            <div class="endpoint">
                <span class="method GET">GET</span>
                /backend/api/users.php?action=get&id=1
            </div>
            <div class="endpoint">
                <span class="method PUT">PUT</span>
                /backend/api/users.php?id=1
            </div>
            <div class="endpoint">
                <span class="method DELETE">DELETE</span>
                /backend/api/users.php?id=1 <span class="status success">Admin Only</span>
            </div>
        </div>

        <div class="section">
            <h2>📚 Database Setup</h2>
            <p style="margin-bottom: 15px; color: #333;">Follow these steps to set up the database:</p>
            <ol style="margin-left: 20px; color: #666; line-height: 1.8;">
                <li>Open phpMyAdmin at <code>http://localhost/phpmyadmin/</code></li>
                <li>Click the "SQL" tab at the top</li>
                <li>Open the file <code>backend/database_schema.sql</code> and copy all content</li>
                <li>Paste into the phpMyAdmin SQL editor</li>
                <li>Click "Go" to execute and create all tables</li>
                <li>Verify by seeing 5 tables in <code>tourist_guide_db</code></li>
            </ol>
        </div>

        <div class="section">
            <h2>🚀 Quick Start</h2>
            <p style="margin-bottom: 15px; color: #333;">Test the API with curl:</p>
            <pre style="background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 6px; overflow-x: auto;">
# Get all destinations
curl http://localhost/tourist_guide/backend/api/destinations.php?action=list

# Login
curl -X POST http://localhost/tourist_guide/backend/api/auth.php?action=login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@demo.com","password":"pass123"}'

# Create a booking
curl -X POST http://localhost/tourist_guide/backend/api/bookings.php \
  -H "Content-Type: application/json" \
  -d '{"user_id":1,"destination_id":1,"check_in":"2026-02-01","check_out":"2026-02-05","travelers":2,"total_price":36000}'
            </pre>
        </div>

        <div style="text-align: center; margin-top: 40px; padding: 20px; background: #f0f4ff; border-radius: 8px;">
            <p style="color: #667eea; font-weight: bold;">✅ Backend is configured and ready to use!</p>
            <p style="color: #666; margin-top: 10px;">For detailed setup instructions, see <code>BACKEND_SETUP.md</code></p>
        </div>
    </div>
</body>
</html>
