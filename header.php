<?php $_SESSION['prev_page'] = basename($_SERVER['PHP_SELF']); ?>

<header class="main-header">
    <!-- Logo -->
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="display: block">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu logo-header">
            <ul class="nav navbar-nav">
                <!-- Date Time -->
                <li class="" style="color: #fff; padding: 15px; font-size: 20px;">
                    <span style="text-transform: uppercase"><?php echo $APP_NAME;?></span>
                </li>
            </ul>
        </div>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Date Time -->
                <li class="" style="color: #fff; padding: 15px; font-size: 20px;">
                    <span><?php echo date('d / m / Y'); ?></span>
                    <span id="current_time" style="margin-left: 10px;"><?php echo date('G:i:s A'); ?></span>
                </li>
            </ul>
        </div>
    </nav>
</header>