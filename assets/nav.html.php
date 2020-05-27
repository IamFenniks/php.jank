<style type="text/css">
    nav > ul{list-style-type: none; float: none;}
    nav > ul > li{float: left; margin: 5px; padding: 2px; border: 1px solid #999;}
</style>
<header class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="header">
                <div class="row">
                    <nav class="navbar col-md-10">
                        <ul>
                            <li><a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/index.php">Home</a></li>
                            <li><a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/addjoke/index.php">Jokes</a></li>
                            <li><a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/date/today.php">Date</a></li>
                            <li><a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/shopcart/index.php">ShopCart</a></li>
                            <li><a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/admin/index.php">Admin</a></li>
                        </ul>
                    </nav>

                    <div class="account col-md-2">
                        <a href=""><?php echo $user; ?></a>. . .
                        <a href="../admin/dump/index.php">Изменить БД</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
<br><hr>
