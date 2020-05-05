<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        $title = $_SERVER['DOCUMENT_ROOT'] . '/' . $pageTitle;
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
    ?>
    <style type="text/css">
        form>div{position: relative;}
        form>div>label>input{position: absolute; right: 0;}
    </style>
</head>

<body>
<main class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                        <h1><?php htmlout($pageTitle); ?></h1>

                        <form action="?<?php htmlout($action); ?>" method="post" class="col-md-4">
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
                                <label for="password">Задать пароль:
                                    <input type="password" id="password" name="password">
                                </label>
                            </div>

                            <fieldset>
                                <legend>Роли:</legend>
                                <?php for($i = 0; $i < count($roles); $i++): ?>
                                    <div>
                                        <label for="role<?php echo $i; ?>">
                                            <input type="checkbox"
                                                   name="roles[]"
                                                   id="role<?php echo $i; ?>"
                                                   value="<?php htmlout($roles[$i]['id']); ?>"
                                                    <?php
                                                        if($roles[$i]['selected']) echo ' checked';
                                                    ?>
                                            >
                                            <?php htmlout($roles[$i]['id']); ?>
                                        </label>
                                        <?php htmlout($description[$i]['description']); ?>
                                    </div>
                                <?php endfor; ?>

                            </fieldset>

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

