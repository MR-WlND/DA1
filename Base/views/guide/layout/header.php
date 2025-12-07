<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gradient: linear-gradient(180deg, #4e54c8, #8f94fb);
            --card-bg: #ffffff;
            --muted: #6b7280;
            --success: #10b981;
            --danger: #ef4444;
            --shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
            --radius: 14px;
            --max-w: 1200px;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            background: #f3f4f6;
            color: #0f172a
        }

        header {
            background: var(--gradient);
            color: white;
            padding: 28px 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 30px rgba(78, 84, 200, 0.08);
        }

        .container {
            width: 100%;
            max-width: var(--max-w);
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px
        }

        .brand h1 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 0.2px
        }

        .brand p {
            margin: 4px 0 0;
            font-size: 13px;
            opacity: 0.95
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600
        }

        main {
            max-width: var(--max-w);
            margin: 20px auto;
            padding: 0 18px 48px;
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 20px
        }

        footer {
            max-width: var(--max-w);
            margin: 18px auto 60px;
            text-align: center;
            color: #94a3b8;
            font-size: 13px
        }

        .search-row {
            display: flex;
            gap: 8px
        }

        input[type="search"] {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid #e6e9ef;
            border-radius: 10px;
            font-size: 14px
        }

        .panel {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 16px;
            box-shadow: var(--shadow)
        }

        .detail {
            display: flex;
            flex-direction: column;
            gap: 14px
        }

        .detail .row {
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .actions {
            display: flex;
            gap: 10px
        }

        .primary {
            background: #4e54c8;
            color: white;
            border: 0;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer
        }

        .ghost {
            background: white;
            border: 1px solid #e6e9ef;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer
        }


        input[type="search"] {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid #e6e9ef;
            border-radius: 10px;
            font-size: 14px
        }

        .btn {
            background: #f3f4f6;
            border: 0;
            padding: 8px 10px;
            border-radius: 10px;
            cursor: pointer
        }

        .filters {
            display: flex;
            gap: 8px;
            margin-top: 12px
        }

        .chip {
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 13px;
            background: #f3f4f6;
            border: 1px solid #eef2ff;
            cursor: pointer
        }

        .chip.active {
            background: #4e54c8;
            color: white;
            border-color: transparent
        }

        .list {
            margin-top: 14px;
            max-height: 56vh;
            overflow: auto;
            padding-right: 6px
        }

        .item {
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #eef2ff;
            margin-bottom: 10px;
            cursor: pointer
        }

        .item.selected {
            box-shadow: 0 6px 18px rgba(78, 84, 200, 0.12);
            border-color: transparent
        }

        .item .meta {
            font-size: 12px;
            color: var(--muted);
            margin-top: 6px
        }

        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            color: white;
            font-size: 12px
        }

        /* Right panel */

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px
        }

        .stat {
            background: var(--card-bg);
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            box-shadow: var(--shadow)
        }

        .itinerary {
            background: var(--card-bg);
            padding: 14px;
            border-radius: 12px;
            box-shadow: var(--shadow)
        }

        .stops {
            margin-top: 10px
        }

        .stop {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px dashed #eef2ff
        }

        .time {
            width: 64px;
            height: 36px;
            border-radius: 8px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600
        }

        .primary {
            background: #4e54c8;
            color: white;
            border: 0;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer
        }

        .ghost {
            background: white;
            border: 1px solid #e6e9ef;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer
        }

        .danger {
            background: white;
            border: 1px solid #fee2e2;
            color: var(--danger);
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer
        }

        /* Guest list */
        .guest-list {
            margin-top: 14px;
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #eef2ff
        }

        .guest {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px;
            border-radius: 8px
        }

        .guest+.guest {
            margin-top: 8px
        }

        .guest .left {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700
        }

        .checkbox {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer
        }

        .checkbox.checked {
            background: var(--success);
            border-color: var(--success);
            color: white
        }

        .checked-time {
            font-size: 12px;
            color: var(--muted)
        }

        .guest-controls {
            display: flex;
            gap: 8px;
            margin-top: 10px
        }

        footer {
            max-width: var(--max-w);
            margin: 18px auto 60px;
            text-align: center;
            color: #94a3b8;
            font-size: 13px
        }
    </style>
</head>

<body>

    <header>
        <div class="container">
            <div class="brand">
                <h1>Bảng điều khiển Hướng dẫn viên</h1>
                <p>Xem và quản lý lịch trình — nhanh, rõ ràng.</p>
            </div>

            <div class="profile">
                <span><?= $_SESSION['user']['name'] ?? 'guide' ?></span>
                <div class="avatar"><i class="fa-regular fa-user"></i></div>
            </div>
        </div>
    </header>
    <main>