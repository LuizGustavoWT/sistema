<?php
require_once 'header.php';
require_once 'imports.php';
?>
<div class="login-ext">
    <div class="login">
        <form method="post" action="<?php echo BASE_URL; ?>/logar" id="login">
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" class="form-control input-form" placeholder="Usuário" name="user">
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" class="form-control" placeholder="Senha" name="password">
            </div>
            <button class="btn btn-primary btn_login" id="btnLogin">
                <small for="btnLogin">Login</small>
            </button>
        </form>
    </div>
</div>

<?php
require_once 'footer.php';
?>




