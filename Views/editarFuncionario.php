<script>

    $("#editarFuncionario").on('submit', (e) => {
        e.preventDefault();

        let jwt = localStorage.getItem('jwt');
        let nome = $('input[name=nome]').val();
        let cpd = $('input[name=cpd]').val();
        let centrodecusto = $('select[name=cc] option:selected').val();

        let url = $("#editarFuncionario").attr('action');


        const obj = {
            jwt,
            nome,
            cpd,
            centrodecusto,
            url,
        }



        $.ajax({
            url: url,
            type: "PUT",

            headers: {
                "Authorization": jwt
            },
            data: {
                nome,
                cpd,
                centrodecusto
            },
            success: (mens) => {
                if (mens.erro == undefined) {
                    alert(mens.sucesso);
                } else {
                    alert(mens.erro);
                }
            }
        });
    })
</script>
<form id="editarFuncionario" action="">
    <div class="form-group">
        <label>Nome</label>
        <input class="form-control" placeholder="Nome" name="nome" value="<?php echo $funcionario['nome']; ?>">
    </div>
    <div class="form-group">
        <label>CPD</label>
        <input class="form-control" placeholder="CPD" name="cpd" value="<?php echo $funcionario['cpd']; ?>">
    </div>
    <div class="form-group">
        <label>Centro De Custo</label>
        <select class="form-control" name="cc">
            <?php foreach ($cc as $c): ?>
                <option value="<?php echo (isset($c['id']) && !empty($c['id'])) ? $c['id'] : ""; ?>" <?php echo ($funcionario['id_centro_de_custo'] == $c['id']) ? "selected" : "" ?>>
                    <?php echo (isset($c['cod_cc']) && !empty($c['cod_cc'])) ?
                        $c['cod_cc'] . " - " . $c['descricao'] : ""; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="hidden" value="<?php echo $funcionario['id'] ?>">
    <button class="btn btn-success" type="submit">
        <i class="far fa-save"></i>
        Salvar
    </button>

</form>
