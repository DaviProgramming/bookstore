<div class="container-dashboard">
    <div class="container-dashboard-header">
        <span>Adicionar Livro</span>
        <a class="btn btn-primary" href="{{route('pagina.dashboard', ["page" => 'inicio'])}}"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
    </div>
    <div class="container-dashboard-content">
        <div class="book-form">
            <div class="book-form-content">
                <div class="book-form-content-input-group">
                    <label for="title-new-book-input">Titulo</label>
                    <input type="text" id="title-new-book-input" name="titulo-input">
                </div>
                <span class="book-form-content-input-error email"><i class="fa-solid fa-circle-exclamation"></i> <span>Titulo inválido</span></span>
                <div class="book-form-content-input-group">
                    <textarea name="description"  placeholder="Descrição"></textarea>
                </div>
                <span class="book-form-content-input-error password"><i class="fa-solid fa-circle-exclamation"></i> <span>Descrição inválida</span></span>
                <div class="book-form-content-input-group thumbnail">
                    <span >Adicionar Thumbnail</span>
                    <button type="button" name="button-thumbnail" class="btn btn-light"><i class="fa-solid fa-upload"></i> Upload</button>
                    <input type="text" name="thumbnail-input-new-book" hidden>
                </div>
            </div>
          
            <button type="button" name="button-login"><span>Entrar</span></button>
        </div>
       
    </div>
</div>