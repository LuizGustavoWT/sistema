
<script>
    $(".corrige").on('click', (e) => {
        e.preventDefault();
        let url = e.target.attributes.getNamedItem('href').value;
        let jwt = localStorage.getItem('jwt');
        $.ajax({
            url,
            type: "POST",
            headers:{
                "Authorization": jwt
            },
            success: (msg) => {
                if(msg.erro == undefined){
                    alert(msg.sucesso);
                }else {
                    alert(msg.erro);
                }
            }
        })
    });
</script>

<div class="tabela">
    <table class="table table-striped">
        <thead>
        <tr class="row">
            <th class="col col-md-3">DESCRIÇÃO HORA</th>
            <th class="col col-md-3">HORAS</th>
            <th class="col col-md-3">DATA</th>
            <th class="col col-md-3">AÇÕES</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lancamentos as $lancamento): ?>
            <tr class="row">
                <td class="col col-md-3"><?php echo $lancamento['tipo_hora'] ?></td>
                <td class="col col-md-3"><?php echo $lancamento['qtd_horas'] ?></td>
                <td class="col col-md-3"><?php echo $lancamento['data_mov'] ?></td>
                <td class="col col-md-3">
                    <a class="btn btn-success corrige"
                       href="<?php echo BASE_URL."/lancamentos/funcionario/".$lancamento['id'].'/corrigir';?>" data-toggle="modal" data-target="#modal">Corrigir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>