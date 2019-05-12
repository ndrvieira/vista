<?php
if(isset($cidade)) {
    $form_rota = "/cidade/update/".$cidade->id;
    $btn_texto = "Atualizar";
} else {
    $form_rota = "/cidade/store";
    $btn_texto = "Cadastrar";
}
?>

<form action="<?=$form_rota;?>" method="post">

    <div class="form-group">
        <label for="nome">Nome da cidade</label>
        <input class="form-control" name="nome" type="text" placeholder="Insira o nome da cidade">
    </div>

    <div class="form-group">
        <button class="btn btn-success" type="submit"><?=$btn_texto;?></button>
        <a href="/cidade" class="btn btn-danger">Voltar</a>
    </div>

</form>

<script>
    $(function() {

        <?php if(isset($cidade)): ?>

        var json_cidade = '<?=json_encode($cidade);?>';
        var cidade = JSON.parse(json_cidade);

        $('[name="nome"]').val(cidade.nome);

        <?php endif; ?>

    });
</script>