<?php

setcookie('access_token', '', time() - 360);
setcookie('refresh_token', '', time() - 360);
setcookie('expires_in', '', time() - 360);

header('Location: http://' . $_SERVER['HTTP_HOST']);
