<?php

require('functions.php');

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Quản lý mã nguồn website</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
        <style>
            body { padding-top: 2rem; }
            .header { margin-bottom: 4rem }
        </style>
    </head>
    
    <body>
        <div class="container">
            <header class="header clearfix">
                <nav>
                  <ul class="nav nav-pills float-right">
                    <li class="nav-item">
                      <a class="nav-link" href="#">Trang chủ</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="#">Đăng nhập</a>
                    </li>
                  </ul>
                </nav>
                <h3 class="text-muted">Quản lý mã nguồn</h3>
            </header>
            
            <main>
                <div class="row">
                    <div class="col-md-3">
                        <h5>Thể loại sách</h5>
                        <ul class="nav flex-column"><?php get_menu(); ?></ul>
                    </div>
                    <div class="col-md-9">
                        <?php get_source_deck(); ?>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>