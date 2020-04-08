<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        $title = $_SERVER['DOCUMENT_ROOT'] . '/' . $pageTitle;
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
    ?>
</head>

<body>
<main class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                        <h1><?php htmlout($pageTitle); ?></h1>

                        <form action="?<?php htmlout($action); ?>" method="post">
                            <div>
                                <label for="name">Имя:
                                    <input type="text" id="name" name="name" value="<?php htmlout($name); ?>">
                                </label>
                            </div>
                            <div>
                                <label for="email">Почта:
                                    <input type="text" id="email" name="email" value="<?php htmlout($email); ?>">
                                </label>
                            </div>
                            <div>
                                <input type="hidden" name="id" value="<?php htmlout($id); ?>">

                                <input class="btn btn-info" type="submit" value="<?php htmlout($button); ?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <br><hr>

        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/footer.html.php'; ?>
        </footer>
    </body>
</html>

