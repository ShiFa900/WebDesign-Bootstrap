<?php
function mainHeader(string $title){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Favicon -->
    <link
            rel="apple-touch-icon"
            sizes="57x57"
            href="assets/properties/favicon/apple-icon-57x57.png"
                />
    <link
            rel="apple-touch-icon"
            sizes="60x60"
            href="assets/properties/favicon/apple-icon-60x60.png"
                />
    <link
            rel="apple-touch-icon"
            sizes="72x72"
            href="assets/properties/favicon/apple-icon-72x72.png"
                />
    <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="assets/properties/favicon/apple-icon-76x76.png"
                />
    <link
            rel="apple-touch-icon"
            sizes="114x114"
            href="assets/properties/favicon/apple-icon-114x114.png"
                />
    <link
            rel="apple-touch-icon"
            sizes="120x120"
            href="assets/properties/favicon/apple-icon-120x120.png"
                />
    <link
            rel="apple-touch-icon"
            sizes="144x144"
            href="assets/properties/favicon/apple-icon-144x144.png"
                />
    <link
            rel="apple-touch-icon"
            sizes="152x152"
            href="assets/properties/favicon/apple-icon-152x152.png"
                />
    <link
            rel="apple-touch-icon"
            sizes="180x180"
            href="assets/properties/favicon/apple-icon-180x180.png"
                />
    <link
            rel="icon"
            type="image/png"
            sizes="192x192"
            href="assets/properties/favicon/android-icon-192x192.png"
                />
    <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="assets/properties/favicon/favicon-32x32.png"
                />
    <link
            rel="icon"
            type="image/png"
            sizes="96x96"
            href="assets/properties/favicon/favicon-96x96.png"
                />
    <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="assets/properties/favicon/favicon-16x16.png"
                />
    <link rel="manifest" href="assets/properties/favicon/manifest.json"/>
    <meta name="msapplication-TileColor" content="#ffffff"/>
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png"/>
    <meta name="theme-color" content="#ffffff"/>

    <!-- Link Bootstrap -->
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
                />
    <link
            href="https://getbootstrap.com/docs/5.3/assets/css/docs.css"
            rel="stylesheet"
                />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/@popperjs/core@2"></script>

    <!-- link icon -->
    <script
            type="module"
            src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
                ></script>
    <script
            nomodule
            src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
                ></script>

    <!-- link font -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Open+Sans:wght@400;500;600;700&family=Rubik:wght@400;500;600;700&display=swap"
            rel="stylesheet"
                />

    <!-- link styling -->
    <link rel="stylesheet" href="assets/css/general.css"/>
    <link rel="stylesheet" href="assets/css/persons.css"/>
    <link rel="stylesheet" href="assets/css/add-person.css"/>

    <link rel="stylesheet" href="assets/query/mediaQuery.css"/>

    <title>PerMap &mdash; <?=$title?></title>
</head>

<?php
}
    ?>