<script>
    $(".baixar").on('click', (e) => {
        e.preventDefault();
        let url = e.target.attributes.getNamedItem('href').value;
        let jwt = localStorage.getItem('jwt');
        $.ajax({
            url,
            type: "POST",
            contentType: 'binary',
            headers:{
                "Authorization": jwt
            },
            success: (msg) => {
                var encodedUri = 'data:application/csv;charset=utf-8,' + encodeURIComponent(msg);
                $('.download').attr('href', encodedUri)
                    .attr("download", "relatorio.csv")
                    .show();
            }
        })
    });
</script>

<div class="tabela">
    <div>
        <a href="<?php echo BASE_URL . "/relatorio/saldo"; ?>" class="btn btn-success baixar">
            Gerar Relatório
        </a>
        <a class="btn btn-success download" style="display: none;">
            Baixar
        </a>
    </div>
    <table class="table table-striped">
        <thead>
        <tr class="row">
            <th class="col col-md-1"><label>CPD</label></th>
            <th class="col col-md-4"><label>NOME</label></th>
            <th class="col col-md-2"><label>CENTRO DE CUSTO</label></th>
            <th class="col col-md-2"><label>SALDO</label></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($funcionarios as $funcionario): ?>
            <tr class="row">
                <td class="col col-md-1"><?php echo $funcionario['cpd'] ?></td>
                <td class="col col-md-4"><?php echo $funcionario['nome'] ?></td>
                <td class="col col-md-2"><?php echo $funcionario['cod_cc'] . " - " . $funcionario['descricao'] ?></td>
                <td class="col col-md-2"><?php echo $funcionario['saldo'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>