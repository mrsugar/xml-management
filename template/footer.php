</div>
    <?php
        if( ! is_logged() ): ?>
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
                    <label for="usernameInput" class="form-control-label">Tên đăng nhập:</label>
                    <input type="text" class="form-control" id="usernameInput">
                  </div>
                  <div class="form-group">
                    <label for="passwordInput" class="form-control-label">Mật khẩu:</label>
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
        <!-- end login modal -->
    <?php
        endif; ?>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
      <script src="/script.js"></script>
    </body>
</html>
