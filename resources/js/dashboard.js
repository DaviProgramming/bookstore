$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const listeners = () => {


    const buttonEnviar = document.querySelector(
        'button[name="button-enviar-book"]'
    );


    if(buttonEnviar != null){

        buttonEnviar.addEventListener("click", (e) => {

            formActions.clickedButton(e.target);
        });

    }

    const buttonEditar = document.querySelector('button[name="button-editar-book"]');

    if(buttonEditar != null){

        buttonEditar.addEventListener('click', (e) => {

            formActions.clickedButton(e.target);

        })

    }

    const buttonChangeThumbnail = document.querySelector('button[name="button-thumbnail"]');
    

    if(buttonChangeThumbnail != null){
        buttonChangeThumbnail.addEventListener('click', (e) => {

            thumbNail.clickButton(e.target);
        
        })
    }
    

    const thumbnailInput = document.querySelector('input[name="thumbnail-input-new-book"]');

    if(thumbnailInput != null){

        thumbnailInput.addEventListener('change', (e) => {


            thumbNail.changeInput(e)
    
                
        })

    }

    const getAllDeleteButtons = document.querySelectorAll('.table-acoes-container-icon.delete');

    if(getAllDeleteButtons != null){


        getAllDeleteButtons.forEach(deleteButton => {

            deleteButton.addEventListener('click', (e) => {

                console.log(e);


                let elementoClicado = e.target;

                let id = elementoClicado.dataset.bookSet;

                if(id != null){

                    dashboardButtonsActions.deleteClick(id);

                }else {

                    elementoClicado = elementoClicado.parentNode;

                    id = elementoClicado.dataset.bookSet;

                    dashboardButtonsActions.deleteClick(id);


                }


            })

        })

    }

    const getAllFavoriteButtons = document.querySelectorAll('.table-acoes-container-icon.favorite');

    if(getAllFavoriteButtons != null){


        getAllFavoriteButtons.forEach(favoriteButton => {


            favoriteButton.addEventListener('click', (e) => {

                let elementoClicado = e.target;

                let id = elementoClicado.dataset.bookSet;

                if(id != null){

                    dashboardButtonsActions.favoriteClick(id);

                }else {

                    elementoClicado = elementoClicado.parentNode;

                    id = elementoClicado.dataset.bookSet;

                    dashboardButtonsActions.favoriteClick(id);

                }

            })

        })

    }

    const getAllUnfavoriteButtons = document.querySelectorAll('.table-acoes-container-icon.favorited');

    if(getAllUnfavoriteButtons != null){


        getAllUnfavoriteButtons.forEach(unfavoritedButton => {

            unfavoritedButton.addEventListener('click', (e) => {
                

                let elementoClicado = e.target;

                let id = elementoClicado.dataset.bookSet;

                if(id != null){

                    dashboardButtonsActions.unfavoriteClick(id);

                }else {

                    elementoClicado = elementoClicado.parentNode;

                    id = elementoClicado.dataset.bookSet;

                    dashboardButtonsActions.unfavoriteClick(id);

                }


            })

        })

    }

    
};

const dashboardButtonsActions = {

    deleteClick(id){

        Swal.fire({
            icon: 'question',
            title: "Tem certeza que deseja deletar o Livro?",
            showCancelButton: true,
            confirmButtonText: "Deletar",
            cancelButtonText: `Cancelar`
          }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    
                    type:"DELETE",
                    url:"/book/delete-livro",
                    data:{'book_id' : id},

                    success: (response) => {

                        swal.fire({
                            icon:'success',
                            title:response.message,
                            showConfirmButton: false,
                            timer: 1500,
                        })
        
                        setTimeout(() => {
        
                            loadingActions.disableLoading();
                            window.location.reload();
        
                        }, 1500)

                    },
                    error:(xhr, status, error) => {

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
          });


    },

    favoriteClick(id){

        $.ajax({

            url: "/book/favoritar",
            type:"POST",
            data:{
                book_id: id
            },
            success: (response) => {

                swal.fire({
                    icon:'success',
                    title:response.message,
                    showConfirmButton: false,
                    timer: 1500,
                })

                setTimeout(() => {

                    loadingActions.disableLoading();
                    window.location.reload();

                }, 1500)

            },
            error(xhr, status, error){

                console.log(xhr.responseJSON.message)

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

    },

    unfavoriteClick(id){

        $.ajax({

            url: "/book/unfavorite",
            type:"POST",
            data:{
                book_id: id
            },
            success: (response) => {

                swal.fire({
                    icon:'success',
                    title:response.message,
                    showConfirmButton: false,
                    timer: 1500,
                })

                setTimeout(() => {

                    loadingActions.disableLoading();
                    window.location.reload();

                }, 1500)

            },
            error(xhr, status, error){

                console.log(xhr.responseJSON.message)

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

}

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
            return {'status': false, 'error': 'Comprimento mínimo de 10 caracteres'};
        }

        // Valida o comprimento da descrição
        if (
            descriptionValue.length < minLength ||
            descriptionValue.length > maxLength
        ) {
            return {'status': false, 'error': 'Comprimento maior ou menor que o tamanho recomendado'};
        }

        // Valida caracteres inválidos (opcional)
        if (invalidChars.test(descriptionValue) == false) {
            return {'status': false, 'error': 'Caracteres inválidos'};
        }

        // Se todas as validações forem bem-sucedidas
        return {'status': true, 'error': null};

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

    verifyInputs(inputTitulo, textareaDescricao, inputImagem, spanTitulo, spanDescricao, spanImagem, tipoButton){

        let erro = 0;

        if(validations.tituloBook(inputTitulo.value) != true){

                erro++;

                spanErrosActions.activeSpan(spanTitulo);


        }else {

                spanErrosActions.disableSpan(spanTitulo);


        }


        if(validations.descricaoBook(textareaDescricao.value).status != true){

            erro++;
            spanErrosActions.activeSpan(spanDescricao, validations.descricaoBook(textareaDescricao.value).error);


        }else {

            spanErrosActions.disableSpan(spanDescricao);

        }

        let modifyInputToObject = {
            'target': inputImagem
        }


        if(tipoButton == 'button-editar-book'){


            if(inputImagem.files.length >= 1){


                if(thumbNail.changeInput(modifyInputToObject) != true){

                    erro++;
                    spanErrosActions.activeSpan(spanImagem);
        
                }else{
        
                    spanErrosActions.disableSpan(spanImagem);
        
                }

            }

        }else if(tipoButton == 'button-enviar-book'){

            if(thumbNail.changeInput(modifyInputToObject) != true){

                erro++;
                spanErrosActions.activeSpan(spanImagem);
    
            }else{
    
                spanErrosActions.disableSpan(spanImagem);
    
            }

        }


    
        if(erro == 0){

            return true;

        }else {

            return false;

        }
        

    },

    clickedButton(button){

        let {inputTitulo, textareaDescricao, inputImagem, spanErroTitulo, spanErroDescricao, spanErroImagem} = this.getInputsAndSpans();

        let tipoButton = button.name;

        if(tipoButton == null){

            tipoButton = button.parentNode.name;
                
        }
        

        if(this.verifyInputs(inputTitulo, textareaDescricao, inputImagem, spanErroTitulo, spanErroDescricao, spanErroImagem, tipoButton) == true){

            if(tipoButton == 'button-editar-book'){

                loadingActions.activeLoading();

                this.tryEditNewBook(inputTitulo.value, textareaDescricao.value, inputImagem.files[0]);


            }else if(tipoButton == 'button-enviar-book'){

                loadingActions.activeLoading();
                this.tryRegisterNewBook(inputTitulo.value, textareaDescricao.value, inputImagem.files[0]);
    

            }

        } 


    },

    tryEditNewBook(titulo, descricao, imagem){

        let bookId = document.querySelector('input[name="book_id"]').value;

        let formData = new FormData();

        formData.append('titulo', titulo);
        formData.append('descricao', descricao);

        if(imagem != null){

            formData.append('imagem', imagem);

        }
        formData.append('book_id', bookId);
        formData.append('_method', 'PUT');

        $.ajax({

            url: "/book/editar-livro",
            data: formData,
            type: 'POST',
            processData: false, 
            contentType: false, 
            success: (response) => {
                swal.fire({
                    icon:'success',
                    title:response.message,
                    showConfirmButton: false,
                    timer: 1500,
                })

                setTimeout(() => {

                    loadingActions.disableLoading();
                    window.location.href = '/dashboard/inicio';

                }, 1500)
                

            },

            error: (xhr, status, erro) => {



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
    },

    tryRegisterNewBook(titulo, descricao, imagem){

        let formData = new FormData();

        formData.append('titulo', titulo);
        formData.append('descricao', descricao);
        formData.append('imagem', imagem);

        $.ajax({

            url: "/book/novo-livro",
            data: formData,
            type: 'POST',
            processData: false, 
            contentType: false, 
            success: (response) => {

                swal.fire({
                    icon:'success',
                    title:response.message,
                    showConfirmButton: false,
                    timer: 1500,
                })

                setTimeout(() => {

                    loadingActions.disableLoading();
                    window.location.href = '/dashboard/inicio';

                }, 1500)
                

            },

            error: (xhr, status, erro) => {

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


}

listeners();
