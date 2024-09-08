<div class="container-dashboard">
    <div class="container-dashboard-header">
        <span>Inicio</span>
        <a class="btn btn-primary" href="{{route('pagina.dashboard', ["page" => 'novo-livro'])}}"><i class="fa-solid fa-book-medical"></i> Adicionar Livro</a>
    </div>
    <div class="container-dashboard-content">


        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Capa</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
    
                    @if (!empty($books) && count($books) >= 1)
    
                    @foreach ($books as $book)
                    <tr>
                        <th scope="row">{{$book->id}}</th>
                        <td class="table-titulo"><div class="table-titulo-container">{{$book->title}}</div></td>
                        <td class="table-image"> 
                            <div class="table-image-container">
                                <img src="{{ Storage::url($book->image_path) }}" alt="{{ $book->title }}">
                            </div> 
                        </td>
                        <td class="table-descricao">
                            <div class="table-descricao-container">{{$book->description}}</div>
                        </td>
                        <td class="table-acoes">
                            <div class="table-acoes-container">
                                <div class="table-acoes-container-icon <?php if($favorited_books->contains($book->id)) echo 'favorited'; else echo 'favorite'; ?>" data-book-set="{{$book->id}}">
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <a href="{{ route('pagina.edit-livro', ['id' => $book->id]) }}" 
                                   class="table-acoes-container-icon edit" 
                                   data-book-set="{{$book->id}}">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <div class="table-acoes-container-icon delete" 
                                     data-book-set="{{$book->id}}">
                                    <i class="fa-solid fa-trash"></i>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
    
    
                    @else
    
                    <tr>
                        <th scope="row">#</th>
                        <td>Nenhum</td>
                        <td>Livro</td>
                        <td>Encontrado</td>
                    </tr>
                        
                    @endif
                
                </tbody>
              </table>
        </div>
       
        
    </div>
</div>