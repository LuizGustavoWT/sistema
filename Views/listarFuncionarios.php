
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
                $("div.modal-header > h5.modal-title").text("").text("Editar Dados Colaborador");
                $("div.modal-body").html("").html(msg);
            }
        })
    });

    $("#modal").on('hidden.bs.modal', (e) => {
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

    $(".lancar").on('click', (e) => {
        e.preventDefault();
        let url = e.target.attributes.getNamedItem('href').value;
        console.log(url)
        let jwt = localStorage.getItem('jwt');

        $.ajax({
            url,
            type: 'GET',
            headers:{
                "Authorization": jwt
            },
            success: (msg) => {
                $("div.modal-header > h5.modal-title").text("").text("Lançamento De Horas");
                $("div.modal-body").html("").html(msg);
            }
        })
    });

    $(".corrigir").on('click', (e) => {
        e.preventDefault();
        let url = e.target.attributes.getNamedItem('href').value;
        console.log(url)
        let jwt = localStorage.getItem('jwt');

        $.ajax({
            url,
            type: 'GET',
            headers:{
                "Authorization": jwt
            },
            success: (msg) => {
                if(msg.erro == undefined) {
                    $("div.modal-header > h5.modal-title").text("").text("Corrigir Lançamentos");
                    $("div.modal-body").html("").html(msg);
                }else {
                    alert(msg.erro);
                    $('#modal').hidden();
                }
            }
        })
    });




</script>

<div class="tabela">
    <table class="table table-striped">
        <thead>
        <tr class="row">
            <th class="col col-md-1"><label>CPD</label></th>
            <th class="col col-md-5"><label>NOME</label></th>
            <th class="col col-md-1"><label>SALDO</label></th>
            <th class="col col-md-5"><label>AÇÕES</label></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($funcionarios as $funcionario): ?>
            <tr class="row">
                <td class="col col-md-1"><?php echo $funcionario['cpd'] ?></td>
                <td class="col col-md-5"><?php echo $funcionario['nome'] ?></td>
                <td class="col col-md-1"><?php echo $funcionario['saldo'] ?></td>
                <td class="col col-md-5">
                    <a class="btn btn-success lancar"
                            href="<?php echo BASE_URL."/lancar/".$funcionario['id'];?>" data-toggle="modal" data-target="#modal">Lancar</a>
                    <a class="btn btn-primary editar"
                            href="<?php echo BASE_URL."/funcionarios/editar/".$funcionario['id'];?>" data-toggle="modal" data-target="#modal">Editar</a>
                    <a class="btn btn-danger desligar"
                            href="<?php echo BASE_URL."/funcionarios/demitir/".$funcionario['id'];?>" data-toggle="modal" data-target="#demitir">Desligar</a>
                    <a class="btn btn-dark corrigir"
                       href="<?php echo BASE_URL."/lancamentos/funcionario/".$funcionario['id'];?>" data-toggle="modal" data-target="#modal">Corrigir Lançamentos</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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