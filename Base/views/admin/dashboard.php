<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard - Tour Du Lịch</title>

    <!-- Google Font: Roboto (hiện đại, dễ đọc) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    
    <!-- Icon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- Chart.js (biểu đồ) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Reset & Font */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Roboto', sans-serif;
            background: #f0f8ff;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1e90ff, #00bfff);
            color: white;
            padding: 20px 0;
        }
        .logo {
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .menu {
            list-style: none;
            margin-top: 20px;
        }
        .menu li {
            padding: 0px 25px;
        }
        .menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 16px;
            border-radius: 10px;
            padding: 10px;
            transition: 0.3s;
        }
        .menu a:hover, .menu .active a {
            background: rgba(255,255,255,0.2);
            padding-left: 20px;
            
        }
        .menu i {
            width: 30px;
            font-size: 18px;
        }
        .logout {
            margin-top: 100px;
        }

        /* Main Content */
        .main {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background: #f8fbff;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1e90ff;
        }
        .user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        /* Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-8px);
        }
        .card i {
            font-size: 40px;
            color: #00bfff;
            margin-bottom: 15px;
        }
        .card h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 28px;
            font-weight: 700;
            color: #1e90ff;
        }

        /* Chart + Table Container */
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }
        .box {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .box h2 {
            margin-bottom: 20px;
            color: #1e90ff;
            font-size: 20px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #f0f8ff;
            color: #1e90ff;
            font-weight: 500;
        }
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .paid { background: #d4edda; color: #155724; }
        .pending { background: #fff3cd; color: #856404; }
        .cancelled { background: #f8d7da; color: #721c24; }

        /* Responsive */
        @media (max-width: 992px) {
            .cards, .row { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo">
            <i class="fas fa-plane-departure"></i> TourTravel
        </div>
        <ul class="menu">
            <li class="active"><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-map-marked-alt"></i> Quản lý Tour</a></li>
            <li><a href="#"><i class="fas fa-book"></i> Đặt Tour</a></li>
            <li><a href="#"><i class="fas fa-user-tie"></i> Hướng dẫn viên</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Khách hàng</a></li>
            <li><a href="#"><i class="fas fa-concierge-bell"></i> Dịch vụ</a></li>
            <li><a href="#"><i class="fas fa-notes-medical"></i> Ghi chú khách</a></li>
            <li><a href="#"><i class="fas fa-chart-line"></i> Doanh thu</a></li>
            <li class="logout"><a href="?action=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">
        <div class="header">
            <h1>Dashboard</h1>
            <div class="user">
                <i class="fas fa-user-circle" style="font-size:24px;"></i>
                Chào mừng, <?= $_SESSION['user']['name'] ?? 'Admin' ?>!
            </div>
        </div>

        <!-- Cards thống kê -->
        <div class="cards">
            <div class="card">
                <i class="fas fa-map-marked-alt"></i>
                <h3>Tổng Tour</h3>
                <p>156</p>
            </div>
            <div class="card">
                <i class="fas fa-users"></i>
                <h3>Tổng Khách</h3>
                <p>2,843</p>
            </div>
            <div class="card">
                <i class="fas fa-dollar-sign"></i>
                <h3>Doanh Thu</h3>
                <p>528 Triệu</p>
            </div>
            <div class="card">
                <i class="fas fa-user-tie"></i>
                <h3>HDV Hoạt Động</h3>
                <p>32</p>
            </div>
        </div>

        <!-- Biểu đồ + Bảng -->
        <div class="row">
            <!-- Biểu đồ doanh thu -->
            <div class="box">
                <h2>Doanh Thu 6 Tháng Gần Nhất</h2>
                <canvas id="myChart" height="200"></canvas>
            </div>

            <!-- Bảng đặt tour gần nhất -->
            <div class="box">
                <h2>Đặt Tour Gần Nhất</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tour</th>
                            <th>Khách</th>
                            <th>Ngày</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>Đà Lạt 3N2Đ</td>
                            <td>Nguyễn An</td>
                            <td>15/11/2025</td>
                            <td><span class="status paid">Đã thanh toán</span></td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Phú Quốc 4N3Đ</td>
                            <td>Trần Bình</td>
                            <td>20/11/2025</td>
                            <td><span class="status pending">Chờ xử lý</span></td>
                        </tr>
                        <tr>
                            <td>#003</td>
                            <td>Hạ Long 2N1Đ</td>
                            <td>Lê Cường</td>
                            <td>18/11/2025</td>
                            <td><span class="status paid">Đã thanh toán</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Script Chart.js -->
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11'],
                datasets: [{
                    label: 'Doanh thu (triệu VND)',
                    data: [65, 78, 92, 88, 105, 128],
                    backgroundColor: '#00bfff',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>