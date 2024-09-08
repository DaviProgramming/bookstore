$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const listeners = () => {
    const buttonEnviar = document.querySelector(
        'button[name="button-enviar-book"]'
    );


    buttonEnviar.addEventListener("click", (e) => {

        formActions.clickedButton(e.target);
    });

    const buttonChangeThumbnail = document.querySelector('button[name="button-thumbnail"]');

    buttonChangeThumbnail.addEventListener('click', (e) => {

        thumbNail.clickButton(e.target);
    
    })

    const thumbnailInput = document.querySelector('input[name="thumbnail-input-new-book"]');

    thumbnailInput.addEventListener('change', (e) => {


        thumbNail.changeInput(e)

            
    })

    
};


const thumbNail = {

    clickButton(button){

        let thumbnailInputToClick = document.querySelector('input[name="thumbnail-input-new-book"]');
        thumbnailInputToClick.click();

    },

    changeInput(e){

            let files = e.target.files;
            let maxSize = 3 * 1024 * 1024;
        
            if (files.length === 1) {

                let file = files[0];
                let fileType = file.type;
                let fileSize = file.size;
                let allowedTypes = ["image/png", "image/jpeg", "image/jpg"];
        
                if (fileSize > maxSize) {
                    Swal.fire({
                        title: "Arquivo maior que o tamanho permitido: 3MB!",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    let spanToChange = document.querySelector('.book-form-content-input-group.thumbnail span');
                    spanToChange.innerHTML = "Adicionar Thumbnail";

                    e.target.value = "";
                    return false;
                }
        
                if (allowedTypes.includes(fileType)) {
                  

                    let spanToChange = document.querySelector('.book-form-content-input-group.thumbnail span');
                    spanToChange.innerHTML = file.name;

                    return true;
                    
                    
                } else {
                    Swal.fire({
                        title: "Tipo de arquivo não permitido.",
                        text: "Apenas são permitidos arquivos JPEG, PNG e JPG.",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3000,
                    });


                    let spanToChange = document.querySelector('.book-form-content-input-group.thumbnail span');
                    spanToChange.innerHTML = "Adicionar Thumbnail";

        
                    e.target.value = "";

                    return false;

                }


            } else if (files.length > 1) {

                Swal.fire({
                    title: "Só é permitido o Upload de 1 arquivo!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3000,
                });

                let spanToChange = document.querySelector('.book-form-content-input-group.thumbnail span');
                    spanToChange.innerHTML = "Adicionar Thumbnail";
        
                e.target.value = "";
                return false;

            }


    }

}

const validations = {
    tituloBook(titulo) {
        // Define as regras de validação
        const minLength = 3;
        const maxLength = 100;
        const invalidChars = /[^a-zA-Z0-9\s]/; // Caracteres inválidos (opcional)

        // Remove espaços em branco das extremidades
        const titleValue = titulo.trim();

        // Valida se o título está vazio
        if (titleValue.length === 0) {
            return false;
        }

        // Valida o comprimento do título
        if (titleValue.length < minLength || titleValue.length > maxLength) {
            return false;
        }

        // Valida caracteres inválidos (opcional)
        if (invalidChars.test(titleValue)) {
            return false;
        }

        // Se todas as validações forem bem-sucedidas
        return true;
    },

    descricaoBook(description) {
        // Define as regras de validação
        const minLength = 10; // Comprimento mínimo recomendado
        const maxLength = 1000; // Comprimento máximo recomendado
        const invalidChars = /[^a-zA-Z0-9\s.,!?'"()-]/; // Caracteres inválidos permitidos (opcional)

        // Remove espaços em branco das extremidades
        const descriptionValue = description.trim();

        // Valida se a descrição está vazia
        if (descriptionValue.length === 0) {
            return false;
        }

        // Valida o comprimento da descrição
        if (
            descriptionValue.length < minLength ||
            descriptionValue.length > maxLength
        ) {
            return false;
        }

        // Valida caracteres inválidos (opcional)
        if (invalidChars.test(descriptionValue)) {
            return false;
        }

        // Se todas as validações forem bem-sucedidas
        return true;

    },
};

const spanErrosActions = {
    activeSpan(span, message) {
        if (!span.classList.contains("active")) {
            span.classList.add("active");
        }

        if (message != null) {
            let spanText = span.querySelector("span");

            spanText.innerHTML = message;
        }
    },

    disableSpan(span) {
        if (span.classList.contains("active")) {
            span.classList.remove("active");
        }
    },
};

const loadingActions = {
    activeLoading() {
        let loader = document.querySelector(".loader-page");

        if (!loader.classList.contains("active")) {
            loader.classList.add("active");
        }
    },

    disableLoading() {
        let loader = document.querySelector(".loader-page");

        if (loader.classList.contains("active")) {
            loader.classList.remove("active");
        }
    },
};

const formActions = {

    getInputsAndSpans(){

        let inputTitulo = document.querySelector('#title-new-book-input');
        let spanErroTitulo = document.querySelector('.book-form-content-input-error.titulo');

        let textareaDescricao = document.querySelector('textarea[name="description"]');
        let spanErroDescricao = document.querySelector('.book-form-content-input-error.description')
        
        let inputImagem = document.querySelector('input[name="thumbnail-input-new-book"]');
        let spanErroImagem = document.querySelector('.book-form-content-input-error.thumbnail')


        return {inputTitulo, textareaDescricao, inputImagem, spanErroTitulo, spanErroDescricao, spanErroImagem}

    },

    verifyInputs(inputTitulo, textareaDescricao, inputImagem, spanTitulo, spanDescricao, spanImagem){

        let erro = 0;

        if(validations.tituloBook(inputTitulo.value) != true){

                erro++;

                spanErrosActions.activeSpan(spanTitulo);


        }else {

                spanErrosActions.disableSpan(spanTitulo);


        }

        if(validations.descricaoBook(textareaDescricao.value) != true){

            erro++;
            spanErrosActions.activeSpan(spanDescricao);


        }else {

            spanErrosActions.disableSpan(spanDescricao);

        }

        let modifyInputToObject = {
            'target': inputImagem
        }


        if(thumbNail.changeInput(modifyInputToObject) != true){

            erro++;
            spanErrosActions.activeSpan(spanImagem);

        }else{

            spanErrosActions.disableSpan(spanImagem);

        }
        

    },

    clickedButton(button){

        let {inputTitulo, textareaDescricao, inputImagem, spanErroTitulo, spanErroDescricao, spanErroImagem} = this.getInputsAndSpans();
        

        if(this.verifyInputs(inputTitulo, textareaDescricao, inputImagem, spanErroTitulo, spanErroDescricao, spanErroImagem) == true){



        } 


    }
}

listeners();
