<?php
require_once __DIR__ . "/sidebar.php";
function mainFooter(string $link)
{
    mobileSidebar($link);
    ?>

    <script src="assets/vendor/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
    </html>
    <?php
}