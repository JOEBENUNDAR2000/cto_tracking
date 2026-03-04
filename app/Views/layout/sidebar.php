<?php $segment = service('uri')->getSegment(1); ?>

<aside class="app-sidebar bg-body-secondary shadow d-flex flex-column"
       data-bs-theme="dark"
       style="height: 100vh;">

    <!-- Brand Logo -->
    <div class="sidebar-brand px-3 py-3 border-bottom">
        <a href="<?= base_url('dashboard') ?>"
           class="brand-link d-flex align-items-center text-decoration-none">

            <img src="<?= base_url('assets/adminlte/dist/assets/img/AdminLTELogo.png'); ?>"
                 alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-2 me-2"
                 width="35" height="35">

            <span class="brand-text fw-light fs-5">
               EMB Region VI
            </span>
        </a>
    </div>

    <!-- Main Menu -->
    <div class="sidebar-wrapper flex-grow-1">
        <nav>
            <ul class="nav sidebar-menu flex-column mt-2">

                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>"
                       class="nav-link <?= ($segment == '' || $segment == 'dashboard') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('cto-application') ?>"
                       class="nav-link <?= ($segment == 'cto-application') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p>CTO Application</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('cto-ledger') ?>"
                       class="nav-link <?= ($segment == 'cto-ledger') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-journal-text"></i>
                        <p>CTO Ledger</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('report') ?>"
                       class="nav-link <?= ($segment == 'report') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-bar-chart"></i>
                        <p>Generate Report</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('event') ?>"
                       class="nav-link <?= ($segment == 'event') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-calendar-event"></i>
                        <p>Event</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

   

</aside>