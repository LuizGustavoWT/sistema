<div class="login-ext">
    <div class="login">
        <form action="<?php echo BASE_URL."/funcionario";?>" id="novoFuncionario">
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
            <div class="form-group">
                <button class="btn btn-success">
                    <i class="far fa-save"></i>
                    <small>Salvar</small>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    $("#novoFuncionario").on('submit', (e) => {
        e.preventDefault();
        let jwt = localStorage.getItem('jwt');
        let nome = $('input[name=nome]').val();
        let cpd = $('input[name=cpd]').val();
        let centrodecusto = $('select[name=cc] option:selected').val();

        const teste = {
            jwt,
            nome,
            cpd,
            centrodecusto,
            url: `${BASE_URL}funcionario`
        }
        console.log(teste);

        /*$.ajax({
            url: `${BASE_URL}funcionario`,
            method: "POST",
            headers: {
                "Authorization": jwt
            },
            data:{
                nome,
                cpd,
                centrodecusto,
            }
            success: (msg) => {
                if(msg.erro != undefined){
                    alert(msg.sucesso)
                }else {
                    alert(msg.erro);
                }
            }
        })*/
    })
</script>