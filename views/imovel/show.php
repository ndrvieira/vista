<?php
if(isset($resultados['message'])){
    echo $resultados['message'];
    die();
}
foreach($resultados as $resultado):
?>

    <div class="imovel">
        <div class="row">
            <div class="col-6">
                <div class="pt-3 pl-3">
                    <h3><?=$resultado['Categoria'];?> - <?=$resultado['Status'];?></h3>
                    <p><?=$resultado['Cidade'];?>, <?=$resultado['Bairro'];?></p>
                </div>
            </div>
            <div class="col-6">
                <?php if(isset($resultado['ValorVenda']) && !empty($resultado['ValorVenda'])): ?>
                <div class="imovel-precos">
                    Venda: <b><?=$resultado['Moeda'];?><?=number_format($resultado['ValorVenda'], 2, ",", ".");?></b>
                </div>
                <?php endif; ?>

                <?php if(isset($resultado['ValorLocacao']) && !empty($resultado['ValorLocacao'])): ?>
                <div class="imovel-precos">
                    Aluguel: <b><?=$resultado['Moeda'];?><?=number_format($resultado['ValorLocacao'], 2, ",", ".");?></b>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="imovel-botao">
            <div class="text-right">
                <a class="btn btn-info" href="/" >Voltar</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="imovel-imagem" style="background: url('<?=$resultado['FotoDestaque'];?>'); background-repeat:no-repeat; background-position: center;"></div>
            </div>
        </div>
        <div class="imovel-descricao">
            <div class="imovel-segmentos">Descrição</div>
            <div class="row">
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
            <div class="imovel-segmentos">Características</div>
            <div class="row">
                <?php
                foreach($resultado['Caracteristicas'] as $caracteristicas_key => $caracteristicas_value):
                ?>

                    <div class="col-3"><i class="fas fa-info-circle text-info"></i> <?=$caracteristicas_key;?>: 
                    <?php if(!empty($caracteristicas_value)){
                        switch ($caracteristicas_value) {
                            case 'Nao':
                                echo '<span class="text-danger">' . $caracteristicas_value . '</span>';
                                break;
                            case 'Sim':
                                echo '<span class="text-success">' . $caracteristicas_value . '</span>';
                                break;
                            default:
                                echo '<span class="text-info">' . $caracteristicas_value . '</span>';
                                break;
                        }
                    } else {
                        echo "-";
                    }
                    ?>
                    </div>

                <?php
                endforeach;
                ?>
            </div>

            <?php
            // if(!empty($resultado['Latitude']) && !empty($resultado['Longitude'])):
            ?>
            <div class="imovel-segmentos">Localização</div>
            <div class="col-12 ml-auto text-center">
                <iframe width="80%" height="600" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=<?=GOOGLE_MAPS_API_KEY;?>&q=
                <?=$resultado['Latitude'];?>,<?=$resultado['Latitude'];?>" allowfullscreen></iframe>
            </div>
            <?php
            // endif;
            ?>
        </div>
    </div>

<?php
endforeach;
?>