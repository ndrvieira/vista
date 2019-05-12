<h2>Busque imóveis na sua região</h2>
<form id="form-imoveis" action="/api/request/" method="post">

    <?php
    if (isset($cidades)) :
    ?>
        <div class="form-group">
            <label for="cidade">Cidade</label>
            <select class="form-control js-select2-cidade" name="cidade" required>
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
        <label for="bairro">Bairro</label>
        <select class="form-control js-select2-bairro" name="bairro[]" multiple="multiple" required>
            <option>Selecione uma cidade primeiro</option>
        </select>
    </div>

    <div class="form-group">
        <button class="btn btn-info" type="submit">Consultar imóveis</button>
    </div>

</form>

<script>
    $(function() {

        $('.js-select2-cidade').select2();

        toastr.options = {
            positionClass : "toast-top-center"
        }

        $("[name='cidade']").change(function() {
            let cidade_select = $('[name="cidade"]').val();
            let pageURL = location.origin+'/api/bairro/getBairrosFromCidade';
            $.ajax({
                url: pageURL,
                data: {cidade: cidade_select},
                type: 'POST',
                success: function(data) {
                    let json = JSON.parse(data);
                    if(json){
                        $('[name="bairro[]"]').empty();
                    }
                    $.each(json, function(key, value){
                        $('[name="bairro[]"]').append($('<option>', {value: value.id, text: value.nome}));
                    });
                    $('.js-select2-bairro').select2();
                }
            });
        }).change();

        $("#form-imoveis").on('submit', function(event){
            event.preventDefault();
            let pageURL = location.origin+'/api/imovel/getImoveis';
            let form = new FormData($("#form-imoveis")[0]);
            $.ajax({
                url: pageURL,
                data: form,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data) {
                    if(data == 'A pesquisa não retornou resultados.'){
                        $('.resultados').empty();
                        toastr.error('Nenhum imóvel foi encontrado com estes filtros');
                    } else {
                        $('.resultados').empty();
                        $('.resultados').html(data);
                    }
                },
                error: function(data) {
                    $('.resultados').empty();
                    $('.resultados').html(data);
                }
            });
        });

    });

</script>

<div class="resultados">
</div>