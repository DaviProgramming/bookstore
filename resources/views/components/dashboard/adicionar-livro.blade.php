<div class="container-dashboard">
    <div class="container-dashboard-header">
        <span>Adicionar Livro</span>
        <a class="btn btn-primary" href="{{route('pagina.dashboard', ["page" => 'inicio'])}}"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
    </div>
    <div class="container-dashboard-content">
        <div class="book-form">
            <div class="book-form-content">
                <div class="book-form-content-input-group">
                    <input type="text" id="title-new-book-input" name="titulo-input" placeholder="Titulo" maxlength="100">
                </div>
                <span class="book-form-content-input-error titulo"><i class="fa-solid fa-circle-exclamation"></i> <span>Titulo inválido</span></span>
                <div class="book-form-content-input-group">
                    <textarea name="description"  placeholder="Descrição"></textarea>
                </div>
                <span class="book-form-content-input-error description"><i class="fa-solid fa-circle-exclamation"></i> <span>Descrição inválida</span></span>
                <div class="book-form-content-input-group thumbnail">
                    <span >Adicionar Thumbnail</span>
                    <button type="button" name="button-thumbnail" class="btn btn-light"><i class="fa-solid fa-upload"></i> Upload</button>
                    <input type="file" name="thumbnail-input-new-book" accept="image/jpg, image/png, image/jpeg" hidden>
                </div>
                <span class="book-form-content-input-error thumbnail"><i class="fa-solid fa-circle-exclamation"></i> <span>Imagem inválida</span></span>

            </div>
          
            <button type="button" name="button-enviar-book"><span>Enviar</span></button>
        </div>
       
    </div>
</div>