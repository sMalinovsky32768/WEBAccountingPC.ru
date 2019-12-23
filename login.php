<form method="POST" action="action_log.php">
	<div class="form-group row">
		<label for="inputLogin" class="col-sm-2 col-form-label">Логин</label>
		<div class="col-sm-10">
			<input type="text" class="form-control-plaintext" name="inputLogin" id="inputLogin" placeholder="Логин">
		</div>
	</div>
	<div class="form-group row">
		<label for="inputPassword" class="col-sm-2 col-form-label">Пароль</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="Пароль">
		</div>
	</div>
	<button type="submit" id="submit" name="submit" class="btn btn-primary">Войти</button>
</form>