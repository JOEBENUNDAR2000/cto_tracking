<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HR Management System' ?></title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* =====================================
           SIDEBAR STYLE
        ===================================== */

        .app-sidebar .sidebar-menu {
            padding: 10px;
        }

        .app-sidebar .sidebar-menu .nav-link {
            display: flex !important;
            align-items: center !important;
            gap: 14px;
            padding: 12px 18px;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .app-sidebar .sidebar-menu .nav-icon {
            font-size: 1.35rem !important;
            width: 34px;
            min-width: 34px;
            text-align: center;
        }

        .app-sidebar .sidebar-menu .nav-link p {
            margin: 0 !important;
            font-size: 1rem;     /* balanced size */
            font-weight: 500;
        }

        .app-sidebar .sidebar-menu .nav-link:hover {
            background-color: rgba(255,255,255,0.08);
        }

        .app-sidebar .sidebar-menu .nav-link.active {
            background-color: rgba(255,255,255,0.12) !important;
        }

        /* =====================================
           NAVBAR STYLE
        ===================================== */

        .hr-title {
            font-weight: 700;
            font-size: 1.2rem;   /* improved size */
            color: #0d6efd;
            line-height: 1.2;
        }

        .hr-subtitle {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 2px;
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #0d6efd;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-avatar i {
            font-size: 1.1rem;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

<nav class="app-header navbar navbar-expand bg-white shadow-sm border-bottom">
    <div class="container-fluid">

        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link fs-5" data-lte-toggle="sidebar" href="#">
                    <i class="bi bi-list"></i>
                </a>
            </li>

            <li class="nav-item ms-3">
                <div class="hr-title">
                    Human Resources Management System
                </div>
                <div class="hr-subtitle">
                    CTO Monitoring & Employee Records
                </div>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center"
                   href="#"
                   role="button"
                   data-bs-toggle="dropdown">

                    <div class="me-2 fw-semibold">
                        <?= session()->get('username') ?? 'Administrator' ?>
                    </div>

                    <div class="admin-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <a class="dropdown-item text-danger"
                           href="<?= base_url('logout') ?>">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>