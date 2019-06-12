var getURL = window.location;
const BASE_URL = `${getURL.protocol}//${getURL.host}/${getURL.pathname.split('/')[1]}`;

$().ready(() => {

    $('#login').on('submit', (e) => {
        e.preventDefault();
        var url = `${BASE_URL}/logar`;
        var username = $('input[name=user]').val();
        var password = $('input[name=password]').val();
        $.ajax({
            url,
            type: 'POST',
            data:{
                username,
                password
            },
            success: (msg) =>{
                    if(msg.eror != undefined){

                }
            }
        })

    })

})