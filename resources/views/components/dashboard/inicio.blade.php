<div class="container-dashboard">
    <div class="container-dashboard-header">
        <span>Inicio</span>
        <a class="btn btn-primary" href="{{route('pagina.dashboard', ["page" => 'novo-livro'])}}"><i class="fa-solid fa-book-medical"></i> Adicionar Livro</a>
    </div>
    <div class="container-dashboard-content">
        <table class="table table-dark">
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
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>

              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td>@mdo</td>

              </tr>
              <tr>
                <th scope="row">3</th>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
                <td>@mdo</td>

              </tr>
            </tbody>
          </table>
    </div>
</div>