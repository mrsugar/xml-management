<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Thư viện mã nguồn website</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
        <script src="/script.js"></script>
        <style>
            .card-columns {
                column-count: 1;
            }
            body {
                padding-top: 2rem;
            }
            .header {
                margin-bottom: 4rem
            }
            .green {
                background-color: #2ecc71!important;
            }
            .fewer-text {
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 2;
                /* number of lines to show */
            }
        </style>
    </head>
    
    <body>
        <div class="container">
            <header class="header clearfix">
                <nav>
                  <ul class="nav nav-pills float-right">
                    <li class="nav-item">
                      <a class="nav-link" href="/">Trang chủ</span></a>
                    </li>
                    <?php if(is_logged()): ?>
                    <li class="nav-item">
                      <a class="nav-link" href="/admin.php">Quản trị</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="/logout.php">Thoát</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                      <a class="nav-link active green" href="#" data-toggle="modal" data-target="#loginModal">Đăng nhập</a>
                    </li>
                    <?php endif; ?>
                  </ul>
                </nav>
                <h3 class="text-muted">Thư viện mã nguồn</h3>
            </header>
