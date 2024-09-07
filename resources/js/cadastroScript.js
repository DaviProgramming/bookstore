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

    buttonCadastrar.addEventListener("click", (e) => {});
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
        let emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        //retorna se é valido ou n
        let isValid = emailRegex.test(email);

        return isValid;
    },

    password(password) {

        let erro = null;

        // Verifica o comprimento mínimo (por exemplo, 8 caracteres)
        if (password.length < 8) {
            erro = "A senha deve ter pelo menos 8 caracteres.";
        }

        // Verifica se contém pelo menos uma letra maiúscula
        if (!/[A-Z]/.test(password)) {
            erro = "A senha deve conter pelo menos uma letra maiúscula.";
        }

        // Verifica se contém pelo menos uma letra minúscula
        if (!/[a-z]/.test(password)) {
            erro = "A senha deve conter pelo menos uma letra minúscula.";
        }

        // Verifica se contém pelo menos um número
        if (!/[0-9]/.test(password)) {
            erro = "A senha deve conter pelo menos um número.";
        }

        // Verifica se contém pelo menos um caractere especial
        if (!/[\W_]/.test(password)) {
            erro = "A senha deve conter pelo menos um caractere especial (ex: !@#$%).";
        }

        // Se não houver erros, retorna true
        if (erro.length === 0) {
            return { valido: true, mensagem: "Senha válida." };
        } else {
            // Se houver erros, retorna false e a lista de erros
            return { valido: false, mensagem: erro };
        }
    },
};

const formActions = {};

listeners();
