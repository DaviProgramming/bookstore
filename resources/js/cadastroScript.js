

const listeners = () => {

    let buttonCadastrar = document.querySelector('button[name="button-cadastro"]');


    buttonCadastrar.addEventListener('click', (e) => {


        

    })


    let eyesPassword = document.querySelectorAll('.auth-pages-form-content-input-group-eyes i');
    
    console.log(eyesPassword);
    
    if(eyesPassword != null){

        eyesPassword.forEach(eyeButton => {

            console.log(eyeButton);

        })

    }

}

listeners();