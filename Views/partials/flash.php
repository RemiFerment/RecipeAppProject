<h5 class="flash-message <?= key($_SESSION['flash']) ?>" id="flash-message"> <?= $_SESSION['flash'][$type] ?> </h5>
<?php
unset($_SESSION['flash']);
