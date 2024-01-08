<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style=" padding-top:20px;">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header" style="font-size: 16px;">MAIN MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview <?php echo (strpos($page_name, 'live'))?'active':''; ?>">
                <a href="#">
                    <i class="fa fa-clock-o"></i> <span>LIVE</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($page_name == 'live_1')?'active':''; ?>"><a href="assembly_machine.php" style="text-transform: uppercase;"><i class="fa fa-circle-o"></i> <span>Assy & Machine</span></a></li>
                    <li class="<?php echo ($page_name == 'live_2')?'active':''; ?>"><a href="live2.php" style="text-transform: uppercase;"><i class="fa fa-circle-o"></i> <span>Casting</span></a></li>
                    <li class="<?php echo ($page_name == 'assembly_live')?'active':''; ?>"><a href="assembly.php" style="text-transform: uppercase;"><i class="fa fa-circle-o"></i> <span>Assembly</span></a></li>
                    <li class="<?php echo ($page_name == 'machining_live')?'active':''; ?>"><a href="machining.php" style="text-transform: uppercase;"><i class="fa fa-circle-o"></i> <span>Machining</span></a></li>
                </ul>
            </li>
            <li class="treeview <?php echo (strpos($page_name, 'history'))?'active':''; ?>">
                <a href="#">
                    <i class="fa fa-book"></i> <span>HISTORY</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($page_name == 'history_1')?'active':''; ?>"><a href="history_1.php" style="text-transform: uppercase;"><i class="fa fa-circle-o"></i> <span>HISTORY PAGE 1</span></a></li>
                    <li class="<?php echo ($page_name == 'history_2')?'active':''; ?>"><a href="history_2.php" style="text-transform: uppercase;"><i class="fa fa-circle-o"></i> <span>HISTORY PAGE 2</span></a></li>
                </ul>
            </li>

            <li class="treeview <?php echo (strpos($page_name, 'setting'))?'active':''; ?>">
                <a href="#">
                    <i class="fa fa-gears"></i> <span>ADMINISTRATION</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($page_name == 'shift_settings')?'active':''; ?>"><a href="shift_settings.php"><i class="fa fa-circle-o"></i> SHIFT SETTING</a></li>
                    <li class="<?php echo ($page_name == 'live1_settings')?'active':''; ?>"><a href="live1_settings.php"><i class="fa fa-circle-o"></i> LIVE1 SETTING</a></li>
                    <li class="<?php echo ($page_name == 'live2_settings')?'active':''; ?>"><a href="live2_settings.php"><i class="fa fa-circle-o"></i> LIVE2 SETTING</a></li>
                    <li class="<?php echo ($page_name == 'page_cycle_settings')?'active':''; ?>"><a href="page_cycle_settings.php"><i class="fa fa-circle-o"></i> PAGE CYCLE</a></li>
                    <li class="<?php echo ($page_name == 'user_setting')?'active':''; ?>"><a href="user_setting.php"><i class="fa fa-circle-o"></i> USER SETTING</a></li>

                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>