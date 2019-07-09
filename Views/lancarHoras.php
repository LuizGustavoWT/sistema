<script>

    $("#lancarHora").on('submit', (e) => {
        e.preventDefault();

        let jwt = localStorage.getItem('jwt');
        let qtdHoras = $('input[name=qtdHoras]').val();
        let tipoHora = $('select[name=tipoHora] option:selected').val();
        let url = $("#lancarHora").attr('action');

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                "Authorization": jwt
            },
            data: {
                qtdHoras,
                tipoHora
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
<form id="lancarHora" action="">
    <div class="form-group">
        <label><?php echo $funcionario['nome']; ?></label>
    </div>
    <div class="form-group">
        <label>Saldo:</label>
        <label><?php echo $funcionario['saldo']; ?></label>
    </div>
    <div class="form-group">
        <input class="form-control" type="time" name="qtdHoras"/>
    </div>
    <div class="form-group">
        <select class="form-control" name="tipoHora">
            <?php foreach ($horas as $hora): ?>
                <option value="<?php echo $hora['id']?>"><?php echo $hora['descricao']?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="hidden" value="<?php echo $funcionario['id'] ?>">
    <button class="btn btn-success" type="submit">
        <i class="far fa-save"></i>
        Lançar
    </button>
</form>