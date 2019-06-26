var getURL = window.location;
const BASE_URL = `${getURL.protocol}//${getURL.host}/${getURL.pathname.split('/')[1]}/`;

$().ready(() => {

    $('#login').on('submit', (e) => {
        e.preventDefault();
        var url = `${BASE_URL}logar`;
        var username = $('input[name=user]').val();
        var password = $('input[name=password]').val();
        $.ajax({
            url,
            type: 'POST',
            data: {
                username,
                password
            },
            success: (msg) => {
                if (msg.eror == undefined) {
                    localStorage.setItem('jwt', msg.token);
                    window.location = BASE_URL;
                }else {
                    alert(msg.eror);
                }
            }
        })

    });

    $("#sair").on('click', (e) => {
        e.preventDefault();
        url = $('#sair').attr('href');
        $.ajax({
            url,
            type: 'GET',
            success: (msg) =>{
                console.log(msg);
                if(msg.jwt == ''){
                    localStorage.setItem('jwt', msg.token);
                    window.location = `${BASE_URL}login`;
                }
            }
        });
    });

    $(".modal-ajax").on('click', (e) => {
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
                $(".conteudo").html("").html(msg);
            }
        })
    });

    $("#editar").on('hide.bs.modal', (e) => alert("teste"))//{
        let url = `${BASE_URL}/funcionarios/listar`;

        let jwt = localStorage.getItem('jwt');

        $.ajax({
            url,
            type: 'GET',
            headers:{
                "Authorization": jwt
            },
            success: (msg) => {
                console.log("Funcionou");
            }
        });
    //});

});