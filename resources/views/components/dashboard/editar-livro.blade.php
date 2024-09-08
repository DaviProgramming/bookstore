<div class="container-dashboard">
    <div class="container-dashboard-header">
        <span>Editar Livro</span>
        <a class="btn btn-primary" href="{{route('pagina.dashboard', ["page" => 'inicio'])}}"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
    </div>
    <div class="container-dashboard-content">

        <div class="book-previous">

            <div class="book-previous-title">
                Livro selecionado
            </div>
            <div class="book-previous-header">
                {{$book->title}}
            </div>
            <div class="book-previous-image">
                <img src="{{ Storage::url($book->image_path) }}" alt="{{ $book->title }}">
            </div>
            <div class="book-previous-description">
                {{$book->description}}
            </div>
        </div>
        <div class="book-form">
            <div class="book-form-content">
                <div class="book-form-content-input-group">
                    <input type="text" value="{{$book->title}}" id="title-new-book-input" name="titulo-input" placeholder="Titulo" maxlength="100">
                </div>
                <span class="book-form-content-input-error titulo"><i class="fa-solid fa-circle-exclamation"></i> <span>Titulo inválido</span></span>
                <div class="book-form-content-input-group">
                    <textarea name="description" placeholder="Descrição" maxlength="1000">{{$book->description}}</textarea>
                </div>
                <span class="book-form-content-input-error description"><i class="fa-solid fa-circle-exclamation"></i> <span>Descrição inválida</span></span>
                <div class="book-form-content-input-group thumbnail">
                    <span>Alterar Thumbnail</span>
                    <button type="button" name="button-thumbnail" class="btn btn-light"><i class="fa-solid fa-upload"></i> Upload</button>
                    <input type="file" name="thumbnail-input-new-book" accept="image/jpg, image/png, image/jpeg" hidden>
                </div>
                <span class="book-form-content-input-error thumbnail"><i class="fa-solid fa-circle-exclamation"></i> <span>Imagem inválida</span></span>

            </div>
          
            <button type="button" name="button-editar-book"><span>Editar</span></button>
        </div>
       
    </div>
</div>