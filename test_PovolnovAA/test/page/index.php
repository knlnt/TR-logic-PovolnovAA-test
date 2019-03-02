<?php
if( $_SESSION['user_in'] == 1 ){
	exit(header('Location: /profile'));
}
$MAIN = 
'
<msg ref="msg"></msg>
<div v-if="loader" id="loader">Загрузка...</div>
<div class="quest" :class="{questOpen: openQuest}">
	<h2>Правила заполнения полей</h2>
	<ul>
		<li><b>Пароль</b> - должен содержать в себе только латинские буквы(большие и маленькие) и цифры;<br>От 5 до 40 символов, минимум 1 строчная буква, 1 цифра и 1 заглавная буква;<br>Могут присутствовать знак "дефис" и знак "нижнее подчеркивание";<br>Например: <b>Password123</b></li>
		<li><b>E-mail</b> - должен быть настоящим;</li>
		<li>Все поля должны быть заполнены;</li>
		<li>Капча должна совпадать с символами с картинки;</li>
		<li>Поля "Пароль" и поле "Пароль еще раз" должны совпадать;</li>
	</ul>
</div>
<form @submit.prevent="submitForm" name="auth" action="auth/reg" method="POST" class="wrp" autocomplete="off">
	<div v-if="typeForm" id="quest" @click="openQuest = !openQuest">?</div>
	<h1 v-if="typeForm">Регистрация</h1>
	<h1 v-else>Вход</h1>
	<label>E-mail</label>
	<input name="email" type="email" required>
	<label>Пароль</label>
	<input name="pass" type="password" required>
	<label v-if="typeForm">Пароль еще раз</label>
	<input v-if="typeForm" name="passEq" type="password" required>
	<label v-if="typeForm">Имя</label>
	<input v-if="typeForm" name="name" required>
	<label>Капча</label>
	<input name="captcha" v-model="captcha" required>
	<img :src="srcCaptcha" id="captcha">
	<span @click="reCaptcha" id="reCaptcha">Не вижу код на картинке</span>
	<div class="twoFlex">
		<div v-if="typeForm" @click="typeForm = !typeForm" class="btnBackToForm">Вход</div>
		<div v-else @click="typeForm = !typeForm" class="btnBackToForm">Регистрация</div>
		<input v-if="typeForm" type="submit" value="Зарегистрироваться">
		<input v-else type="submit" value="Войти">
	<div>
</form>
';

echo headAndBody_html("Авторизация", $MAIN, "index");

?>