<?php

include_once('classes/content.php');

if (isset($_POST['getData'])) {
    if (isset($_POST['categories'])) {
        $category = $_POST['categories'];

        $url = "https://api.open5e.com/";

        $content = new Content($url, true, $category);

        $contentInfo = $content->getContentInfo();
    }
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <title>PHP Code to Retrieve Data from MySQL Database and Display in html Table</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Dungeons and Dragons</h2>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <?php
                            foreach ($content->getIndexNames() as $index) {
                            ?>
                                <th><?php echo ucwords(str_replace("_", " ", $index)); ?></th>
                            <?php
                            }
                            ?>
                        </tr>
                    </thead>

                    <tbody>





                        <?php
                        foreach ($contentInfo as $values) {
                        ?>
                            <tr>
                                <?php
                                foreach ($values as $value) {
                                ?>
                                    <td><?php
                                        if (strlen($value) > 50)
                                            $value = substr($value, 0, 45) . '...';
                                        echo $value; ?>
                                    <?php
                                }
                                    ?>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>



</html>