<?php
if(isset($resultados['message'])){
    echo $resultados['message'];
    die();
}
foreach($resultados as $resultado):
?>

    <div class="row imoveis">
        <div class="col-4">
            <div class="imoveis-imagem" style="background: url('<?=$resultado['FotoDestaque'];?>');"></div>
        </div>
        <div class="col-8">
            <h3><?=$resultado['Categoria'];?> - <?=$resultado['Status'];?></h3>
            <p><?=$resultado['Cidade'];?>, <?=$resultado['Bairro'];?></p>
            <div class="row mb-5">

                <div class="col-3">
                    <i class="fas fa-bed"></i> Quartos: 
                    <?php if(!empty($resultado['Dormitorios'])){
                        echo $resultado['Dormitorios'];
                    } else {
                        echo "-";
                    }
                    ?>
                </div>
                <div class="col-3"><i class="fas fa-shower"></i> Suites: 
                    <?php if(!empty($resultado['Suites'])){
                        echo $resultado['Suites'];
                    } else {
                        echo "-";
                    }
                    ?>
                </div>
                <div class="col-3"><i class="fas fa-expand"></i> Área Total: 
                    <?php if(!empty($resultado['AreaTotal'])){
                        echo $resultado['AreaTotal']." m²";
                    } else {
                        echo "-";
                    }
                    ?>
                </div>
                <div class="col-3"><i class="fas fa-expand"></i> Área Privativa: 
                    <?php if(!empty($resultado['AreaPrivativa'])){
                        echo $resultado['AreaPrivativa']." m²";
                    } else {
                        echo "-";
                    }
                    ?>
                </div>
                
            </div>

            <?php if(isset($resultado['ValorVenda']) && !empty($resultado['ValorVenda'])): ?>
            <div class="row mt-2">
                Venda: <b><?=$resultado['Moeda'];?><?=number_format($resultado['ValorVenda'], 2, ",", ".");?></b>
            </div>
            <?php endif; ?>

            <?php if(isset($resultado['ValorLocacao']) && !empty($resultado['ValorLocacao'])): ?>
            <div class="row mt-2">
                Aluguel: <b><?=$resultado['Moeda'];?><?=number_format($resultado['ValorLocacao'], 2, ",", ".");?></b>
            </div>
            <?php endif; ?>

            <div class="row imoveis-botao">
                <div class="col-4 mx-auto">
                    <a class="btn btn-info" href="/imovel/show/<?=$resultado['Codigo'];?>" target="_blank">Visualizar</a>
                </div>
            </div>
        </div>
    </div>

<?php
endforeach;
?>