<h3>Авторизация</h3>
<div class="row">
    <div class="col-md-6">
        <form action="/user/login" method="post">
            <div class="form-group">
                <label for="login">Login</label>
                <input name="login" type="text" class="form-control" id="login">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input name="password" type="password" class="form-control" id="password">
            </div>
            <button type="submit" class="btn btn-secondary">Вход</button>
        </form>
        <a href="/user/signup">Зарегистрироваться</a>
    </div>
</div>
