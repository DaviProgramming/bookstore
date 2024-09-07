$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const listeners = () => {
    let inputsForm = document.querySelectorAll(
        ".auth-pages-form-content-input-group input"
    );

    if (inputsForm != null) {
        inputsForm.forEach((input) => {
            input.addEventListener("click", (e) => {
                inputsActions.clickInput(e.target);
            });

            input.addEventListener("blur", (e) => {
                inputsActions.blurInput(e.target);
            });

            input.addEventListener("keyup", (e) => {
                inputsActions.digitando(e.target);
            });
        });
    }

    let eyesPassword = document.querySelectorAll(
        ".auth-pages-form-content-input-group-eyes i"
    );

    if (eyesPassword != null) {
        eyesPassword.forEach((eyeButton) => {
            eyeButton.addEventListener("click", (e) => {
                eyesActions.clicked(e.target);
            });
        });
    }

    let labels = document.querySelectorAll("label");

    if (labels != null) {
        labels.forEach((label) => {
            label.addEventListener("click", (e) => {
                labelActions.clickLabel(e.target);
            });
        });
    }

    let buttonCadastrar = document.querySelector(
        'button[name="button-cadastro"]'
    );

    buttonCadastrar.addEventListener("click", (e) => {
        formActions.clickedButton(e.target);
    });
};

const inputsActions = {
    digitando(input) {
        let divContainer = input.parentNode;
        let label = divContainer.querySelector("label");

        if (input.value.length <= 0) {
            labelActions.ativaLabel(label);
        } else {
            labelActions.desativaLabel(label);
        }
    },

    blurInput(input) {
        let divContainer = input.parentNode;
        let label = divContainer.querySelector("label");

        if (input.value.length <= 0) {
            labelActions.ativaLabel(label);
        } else {
            labelActions.desativaLabel(label);
        }
    },

    clickInput(input) {
        let divContainer = input.parentNode;

        let label = divContainer.querySelector("label");

        labelActions.desativaLabel(label);
    },
};

const labelActions = {
    clickLabel(label) {
        let divContainer = label.parentNode;
        let input = divContainer.querySelector("input");
        input.focus();

        this.desativaLabel(label);
    },

    desativaLabel(label) {
        if (!label.classList.contains("disabled")) {
            label.classList.add("disabled");
        }
    },

    ativaLabel(label) {
        if (label.classList.contains("disabled")) {
            label.classList.remove("disabled");
        }
    },
};

const eyesActions = {
    clicked(eye) {
        this.removeActived(eye);
        this.addActive(eye);
    },

    removeActived(eye) {
        let divContainer = eye.parentNode;

        let eyeAtivado = divContainer.querySelectorAll("i.active");

        eyeAtivado.forEach((eye) => {
            if (eye != null) {
                eye.classList.remove("active");
            }
        });
    },

    addActive(eye) {
        let eyeAtivar = null;

        let divContainer = eye.parentNode;

        if (eye.classList.contains("fa-eye")) {
            eyeAtivar = divContainer.querySelector("i.fa-eye-slash");

            let input = divContainer.parentNode.querySelector("input");
            input.type = "password";
        } else if (eye.classList.contains("fa-eye-slash")) {
            eyeAtivar = divContainer.querySelector("i.fa-eye");

            let input = divContainer.parentNode.querySelector("input");
            input.type = "text";
        }

        eyeAtivar.classList.add("active");
    },
};

const validations = {
    name(name) {
        //regex que valida o nome fornecido:
        let nameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s]{2,50}$/;

        let isValid = nameRegex.test(name);

        //retorna se é valido ou n
        return isValid;
    },

    email(email) {
        //regex que verifica o email fornecido:
        let emailRegex =
            /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        //retorna se é valido ou n
        let isValid = emailRegex.test(email);

        return isValid;
    },

    password(password) {
        let erro = null;

        // Verifica o comprimento mínimo (por exemplo, 8 caracteres)
        if (password.length < 5) {
            erro = "A senha deve ter pelo menos 5 caracteres.";
        }

        // Verifica se contém pelo menos uma letra maiúscula
        if (!/[A-Z]/.test(password)) {
            erro = "A senha deve conter pelo menos uma letra maiúscula.";
        }

        // Verifica se contém pelo menos uma letra minúscula
        if (!/[a-z]/.test(password)) {
            erro = "A senha deve conter pelo menos uma letra minúscula.";
        }

        // Se não houver erros, retorna true
        if (erro == null) {
            return { valido: true, mensagem: "Senha válida." };
        } else {
            // Se houver erros, retorna false e a lista de erros
            return { valido: false, mensagem: erro };
        }
    },
    confirmPassword(senha, confirmaSenha) {

        if (senha == confirmaSenha) {

            return true;

        } else {

            return false;

        }

    },
};

const spanErrosActions = {

    activeSpan(span, message){

        if(!span.classList.contains('active')){
            span.classList.add('active');
        }

        if(message != null){


            let spanText = span.querySelector('span');

            spanText.innerHTML = message;


        }

    },

    disableSpan(span){

        if(span.classList.contains('active')){
            span.classList.remove('active');
        }

    }

}

const loadingActions = {

    activeLoading(){

        let loader = document.querySelector('.loader-page');

        if(!loader.classList.contains('active')){

            loader.classList.add('active');

        }

    },

    disableLoading(){

        let loader = document.querySelector('.loader-page');

        if(loader.classList.contains('active')){

            loader.classList.remove('active');

        }
    }

}

const formActions = {

    getInputsAndSpans() {

        let inputName = document.querySelector(
            'input[name="nome-cadastro-input"]'
        );

        let spanErrorName = document.querySelector('.auth-pages-form-content-input-error.name');

        let inputEmail = document.querySelector(
            'input[name="email-cadastro-input"]'
        );

        let spanErrorEmail = document.querySelector('.auth-pages-form-content-input-error.email');

        let inputSenha = document.querySelector(
            'input[name="senha-cadastro-input"]'
        );

        let spanErrorPassword = document.querySelector('.auth-pages-form-content-input-error.password');

        let inputConfirmSenha = document.querySelector(
            'input[name="confirmar-senha-cadastro-input"]'
        );

        let spanErrorConfirmPassword = document.querySelector('.auth-pages-form-content-input-error.confirm-password');


        return {inputName, inputEmail, inputSenha, inputConfirmSenha, spanErrorName, spanErrorEmail, spanErrorPassword, spanErrorConfirmPassword };


    },

    verifyInputs(nameInput, emailInput, senhaInput, confirmaSenhaInput, spanErrorName, spanErrorEmail, spanErrorPassword, spanErrorConfirmPassword) {

        let erro = 0;

        if (validations.name(nameInput.value) != true) {
            erro++;

            spanErrosActions.activeSpan(spanErrorName);

        }else{

            spanErrosActions.disableSpan(spanErrorName);

        }

        if (validations.email(emailInput.value) != true) {
            erro++;

            spanErrosActions.activeSpan(spanErrorEmail);

        }else{

            spanErrosActions.disableSpan(spanErrorEmail);

        }

        if (validations.password(senhaInput.value).valido != true) {
            erro++;

            spanErrosActions.activeSpan(spanErrorPassword, validations.password(senhaInput.value).mensagem);

        }else{

            spanErrosActions.disableSpan(spanErrorPassword);

        }

        if (validations.confirmPassword(senhaInput.value, confirmaSenhaInput.value) != true) {
            erro++;
            spanErrosActions.activeSpan(spanErrorConfirmPassword);
        }else{

            spanErrosActions.disableSpan(spanErrorConfirmPassword);

        }


        if(erro === 0){

            return true;

        }else {

            return false;

        }
    },

    clickedButton(button) {

        let { inputName, inputEmail, inputSenha, inputConfirmSenha, spanErrorName, spanErrorEmail, spanErrorPassword, spanErrorConfirmPassword } = this.getInputsAndSpans();

        if (this.verifyInputs(inputName,inputEmail,inputSenha,inputConfirmSenha, spanErrorName, spanErrorEmail,spanErrorPassword, spanErrorConfirmPassword)) {

            loadingActions.activeLoading();
            this.trySignUp(inputName.value, inputEmail.value.toLowerCase(), inputSenha.value);


        }
    },

    trySignUp(name,email,senha){


        let formData = new FormData();

        formData.append('name', name);
        formData.append('email', email);
        formData.append('password', senha);

        $.ajax({

            type:"POST",
            url:"/evento/cadastro",
            data:formData,
            processData: false, 
            contentType: false, 
            success: (response) => {

                swal.fire({
                    icon:'success',
                    title: response.token,
                    showConfirmButton: false,
                    timer: 1500,
                })

                setTimeout(() => {

                    window.location.href = '/';

                    loadingActions.disableLoading();

                }, 1500)

            },
            error: (xhr, status ,error) => {

                console.log(xhr.responseJSON.message);
                console.log(error);

                swal.fire({
                    title: xhr.responseJSON.message,
                    showConfirmButton: false,
                    icon: 'error',
                    timer: 1500,
                })

                setTimeout(() => {

                    loadingActions.disableLoading();


                }, 1500)

            }
            
        })

    }
};

listeners();
