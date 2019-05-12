<div class="row mb-5">
    <div class="col-12">
        <a href="cidade/create" class="btn btn-success">Criar nova cidade</a>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Cidade</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($resultados as $resultado){
            echo '<tr>
                <td>' . $resultado->id . '</td>
                <td>' . $resultado->nome . '</td>
                <td class="row" style="width:200px;">
                    <div class="col-6">
                        <a href="/cidade/edit/' . $resultado->id . '" class="btn btn-primary">Editar</a>
                    </div>
                    <div class="col-6">
                        <form action="/cidade/delete" method="post" onsubmit="return confirm(\'Tem certeza que deseja deletar este registro?\')">
                            <input type="hidden" name="id" value="' . $resultado->id . '">
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </td>         
            </tr>';
        }
        ?>
    </tbody>
</table>