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

        console.log(e.target);

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
                    return;
                }
        
                if (allowedTypes.includes(fileType)) {
                  

                    let spanToChange = document.querySelector('.book-form-content-input-group.thumbnail span');
                    spanToChange.innerHTML = file.name;
                    
                    
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
        const titleValue = title.trim();

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

listeners();
