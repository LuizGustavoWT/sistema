
<script>
    $('.editar').on('click', (e) => {
        e.preventDefault();
        let url = e.target.attributes.getNamedItem('href').value;

        let jwt = localStorage.getItem('jwt');

        $.ajax({
            url,
            type: 'GET',
            headers:{
                "Authorization": jwt
            },
            success: (msg) => {
                $("div.modal-body").html("").html(msg);
                $("div.modal-body > form#editarFuncionario").attr("action", url);
            }
        })
    });

    $("#editar").on('hidden.bs.modal', (e) => {
        let url = `${BASE_URL}/funcionarios/listar`;

        let jwt = localStorage.getItem('jwt');

        $.ajax({
            url,
            type: 'GET',
            headers:{
                "Authorization": jwt
            },
            success: (msg) => {
                $(".conteudo").html("").html(msg);
            }
        });
    });

    $('.desligar').on('click', (e) => {
        e.preventDefault();
        let url = e.target.attributes.getNamedItem('href').value;

        $("div.modal-footer > button.demitir").attr("href", url);

    });
    $(".demitir").on('click', (e) => {
        e.preventDefault();
        let url = e.target.attributes.getNamedItem('href').value;
        let jwt = localStorage.getItem('jwt');
        $.ajax({
            url,
            type: "DELETE",
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
    $("#demitir").on('hidden.bs.modal', (e) => {
        let url = `${BASE_URL}/funcionarios/listar`;

        let jwt = localStorage.getItem('jwt');

        $.ajax({
            url,
            type: 'GET',
            headers:{
                "Authorization": jwt
            },
            success: (msg) => {
                $(".conteudo").html("").html(msg);
            }
        });
    });
</script>

<div class="tabela">
    <table class="table table-striped">
        <thead>
        <tr class="row">
            <th class="col col-md-1">CPD</th>
            <th class="col col-md-5">NOME</th>
            <th class="col col-md-1">SALDO</th>
            <th class="col col-md-2">CENTRO DE CUSTO</th>
            <th class="col col-md-3">AÇÕES</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($funcionarios as $funcionario): ?>
            <tr class="row">
                <td class="col col-md-1"><?php echo $funcionario['cpd'] ?></td>
                <td class="col col-md-5"><?php echo $funcionario['nome'] ?></td>
                <td class="col col-md-1"><?php echo $funcionario['saldo'] ?></td>
                <td class="col col-md-2"></td>
                <td class="col col-md-3">
                    <a class="btn btn-success lancar"
                            href="#">Lancar</a>
                    <a class="btn btn-primary editar"
                            href="<?php echo BASE_URL."/funcionarios/editar/".$funcionario['id'];?>" data-toggle="modal" data-target="#editar">Editar</a>
                    <a class="btn btn-danger desligar"
                            href="<?php echo BASE_URL."/funcionarios/demitir/".$funcionario['id'];?>" data-toggle="modal" data-target="#demitir">Desligar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Funcionário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="demitir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Desligar Funcionário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza que deseja desligar esse colaborador?</p>
                    <p>Esta ação após confirmada pode ser desfeita somente pelo administrador do sistema</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                    <button type="button" class="btn btn-danger demitir" data-dismiss="modal">Sim</button>
                </div>
            </div>
        </div>
    </div>
</div>