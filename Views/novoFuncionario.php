<script>
    $(() => {
        $("#novoFuncionario").on('submit', (e) => {
            debugger;
            e.preventDefault();
            let jwt = localStorage.getItem('jwt');
            let nome = $('input[name=nome]').val();
            let cpd = $('input[name=cpd]').val();
            let centrodecusto = $('select[name=cc] option:selected').val();

            $.ajax({
                url: `${BASE_URL}funcionario`,
                method: "POST",
                headers: {
                    "Authorization": jwt
                },
                data: {
                    nome,
                    cpd,
                    centrodecusto,
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
    })
</script>
<div class="form-ext">
    <div class="form">
        <form id="novoFuncionario" onsubmit="">
            <div class="form-group">
                <label>Nome</label>
                <input class="form-control" placeholder="Nome" name="nome">
            </div>
            <div class="form-group">
                <label>CPD</label>
                <input class="form-control" placeholder="CPD" name="cpd">
            </div>
            <div class="form-group">
                <label>Centro De Custo</label>
                <select class="form-control" name="cc">
                    <option value="1">Teste</option>
                </select>
            </div>
            <button class="btn btn-success" type="submit">
                <i class="far fa-save"></i>
                Salvar
            </button>

        </form>
    </div>
</div>
