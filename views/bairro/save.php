<?php
if (isset($bairro)) {
    $form_rota = "/bairro/update/" . $bairro->id;
    $btn_texto = "Atualizar";
} else {
    $form_rota = "/bairro/store";
    $btn_texto = "Cadastrar";
}
?>

<form action="<?= $form_rota; ?>" method="post">

    <div class="form-group">
        <label for="nome">Nome do bairro</label>
        <input class="form-control" name="nome" type="text" placeholder="Insira o nome do bairro">
    </div>

    <?php
    if (isset($cidades)) :
    ?>
        <div class="form-group">
            <label for="cidade">Cidade</label>
            <select class="form-control js-select2-cidade" name="cidade">
                <?php
                foreach($cidades as $cidade){
                    echo '<option value="' . $cidade->id . '">' . $cidade->nome . '</option>';
                }
                ?>
            </select>
        </div>
    <?php
    else:
        die('Falha ao carregar cidades');
    endif;
    ?>

    <div class="form-group">
        <button class="btn btn-success" type="submit"><?= $btn_texto; ?></button>
        <a href="/bairro" class="btn btn-danger">Voltar</a>
    </div>

</form>

<script>
    $(function() {

        $('.js-select2-cidade').select2();

        <?php if (isset($bairro)) : ?>

            var json_bairro = '<?= json_encode($bairro); ?>';
            var bairro = JSON.parse(json_bairro);

            $('[name="nome"]').val(bairro.nome);
            $('[name="cidade"]').val(bairro.cidade).change();

        <?php endif; ?>

    });
</script>