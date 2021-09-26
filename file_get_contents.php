<?php
// <= PHP 5
//$fichero = file_get_contents('./gente.txt', true);

// > PHP 5
$fichero = file_get_contents('./comandos_git.txt', FILE_USE_INCLUDE_PATH);

echo $fichero
?>