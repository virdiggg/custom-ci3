<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('dashboard') ?>" class="brand-link">
        <img src="<?= base_url('assets/dist/img/AdminLTELogo.png') ?>" alt="<?= hexa('636F6E66')('app_name_min') ?>" class="brand-image img-circle elevation-3" style="opacity: .8" />
        <span class="brand-text font-weight-light"><?= hexa('636F6E66')('app_name_min') ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <?php foreach($navs as $nav): ?>
                    <li class="nav-item <?= isset($nav['childrens']) ? (strpos(current_url(), base_url($nav['endpoint'])) !== false ? 'menu-is-opening menu-open' : '') : '' ?>">
                        <a href="<?= isset($nav['childrens']) ? '#' : base_url($nav['endpoint']) ?>" class="nav-link <?= (isset($nav['childrens']) ? (strpos(current_url(), base_url($nav['endpoint'])) !== false) : (current_url() === base_url($nav['endpoint']))) ? 'active' : '' ?>">
                            <i class="nav-icon <?= $nav['icon'] ?>"></i>
                            <p><?= $nav['name'] ?> <?= isset($nav['childrens']) ? '<i class="right fas fa-angle-left"></i>' : '' ?></p>
                        </a>
                        <?php if (isset($nav['childrens'])): ?>
                            <ul class="nav nav-treeview">
                                <?php foreach ($nav['childrens'] as $child): ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url($child['endpoint']) ?>" class="nav-link <?= current_url() === base_url($child['endpoint']) ? 'active' : '' ?>">
                                            <i class="nav-icon <?= $child['icon'] ?>"></i>
                                            <p><?= $child['name'] ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>