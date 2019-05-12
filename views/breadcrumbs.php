<?php

$explode_route = explode("/", $_SERVER['REQUEST_URI']);
if(!empty($explode_route[1]) && end($explode_route) != 'index.php'):

    $last_bread = "";
    if(isset($explode_route[2])) {

        switch ($explode_route[2]) {
            case 'create':
                $last_bread = "Criar";
                break;
            case 'edit':
                $last_bread = "Editar";
                break;
            case 'show':
                $last_bread = "Visualizar";
                break;
            case 'delete':
                $last_bread = "Deletar";
                break;
            default:
                $last_bread = "Criar";
                break;
        }
    
    }

?>

    <h2><?=$last_bread." ".ucfirst($explode_route[1]);?></h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Início</a></li>
        <?php if(isset($explode_route[2])): ?>
            <li class="breadcrumb-item"><a href="/<?=$explode_route[1];?>"><?=ucfirst($explode_route[1]);?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$last_bread;?></li>
        <?php else: ?>
            <li class="breadcrumb-item active" aria-current="page"><?=ucfirst($explode_route[1]);?></li>
        <?php endif; ?>
        </ol>
    </nav>

<?php
endif;
?>