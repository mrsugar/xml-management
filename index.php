<?php

require('functions.php');
?><!DOCTYPE html>
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

            body { padding-top: 2rem; }
            .header { margin-bottom: 4rem }
            .green { background-color: #2ecc71!important;}
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
        </div>
        
        <!-- Login modal -->
        <div class="modal fade" id="loginModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Đăng nhập tài khoản</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="alert alert-success" style="display: none" role="alert" id="LoginAlert">
                  <strong>Đăng nhập thành công!</strong> Đợi giây lát
                </div> 
                <div class="alert alert-danger" style="display: none" role="alert" id="LoginFail">
                  <strong>Lỗi!</strong> Sai tên đăng nhập hoặc mật khẩu.
                </div>
                <form action="/login.php" method="POST" id="loginForm">
                  <div class="form-group">
                    <label for="recipient-name" class="form-control-label">Tên đăng nhập:</label>
                    <input type="text" class="form-control" id="usernameInput">
                  </div>
                  <div class="form-group">
                    <label for="message-text" class="form-control-label">Mật khẩu:</label>
                    <input type="password" class="form-control" id="passwordInput"></textarea>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary">Đăng nhập</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
              </div>
            </div>
          </div>
        </div>   
        
    </body>
</html>