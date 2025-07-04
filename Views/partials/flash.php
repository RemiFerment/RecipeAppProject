<div class="alert alert-<?= key($_SESSION['flash']) ?> flash-message" role="alert" id="flash-message"><?= $_SESSION['flash'][$type] ?></div>
<?php
unset($_SESSION['flash']);
