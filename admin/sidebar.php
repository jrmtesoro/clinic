<?php
    if (isset($_GET['do']) && $_GET['do'] != "")
    {
        $do = $_GET['do'];
        $highlight = array(
            "employee" => "",
            "misc" => ""
        );

        $highlight[$do] = "text-light font-weight-bold bg-info";
    }
?>

<nav class="col-md-2 d-none d-md-block bg-light sidebar border-right">
    <div class="sidebar-sticky">
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link <?php echo $highlight['employee']; ?>" href="admin.php?do=employee">
                    <img src="/clinic1/svg/si-glyph-person-public.svg" class="mb-2 mr-1" height="20" width="20">
                    Employee
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $highlight['misc']; ?>" href="admin.php?do=misc">
                    <img src="/clinic1/svg/si-glyph-folder.svg" class="mb-2 mr-1" height="20" width="20">
                    Miscellaneous
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $highlight['logs']; ?>" href="admin.php?do=logs">
                    <img src="/clinic1/svg/si-glyph-foot-sign.svg" class="mb-2 mr-1" height="20" width="20">
                    Logs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $highlight['request']; ?>" href="admin.php?do=request">
                    <img src="/clinic1/svg/si-glyph-bullet-checked-list.svg" class="mb-2 mr-1" height="20" width="20">
                    Request
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?do="<?php echo $_SESSION['permission'][0] ?>>
                    <img src="/clinic1/svg/si-glyph-arrow-backward.svg" class="mb-2 mr-1" height="20" width="20">
                    Go Back
                </a>
            </li>
        </ul>
    </div>
</nav>