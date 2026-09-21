<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Home' ?></title>

    <?php $faviconB64 = base64_encode("<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><circle cx='16' cy='16' r='14' fill='#ffffff' stroke='#c0392b' stroke-width='3'/><circle cx='16' cy='16' r='4.5' fill='#c0392b'/></svg>"); ?>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,<?= $faviconB64 ?>">

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>


        <div class="row">
<?php
if (isset($view)) {
    require_once PATH_VIEW . $view . '.php';
}
?>
        </div>

</body>

</html>