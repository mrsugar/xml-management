<?php

require('functions.php');
?>
<?php get_header(); ?>   
            <main>
                <div class="row">
                    <div class="col-md-3">
                        <h5>Ngôn ngữ</h5>
                        <ul class="nav flex-column"><?php get_menu(); ?></ul>
                    </div>
                    <div class="col-md-9">
                        <?php get_sources("manguon.xml"); ?>
                    </div>
                </div>
            </main>
<?php get_footer(); ?>