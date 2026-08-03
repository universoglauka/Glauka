<div class="row">
  <div class="col-12 col-md-10 m-auto">
    <div class="d-flex justify-content-center">
      <div class="mt-4 table-responsive w-100">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Nombre</th>
              <th class="tablaDisplayNone">Obras</th>
              <th class="opciones">Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($genres as $genre)
            <tr>
              <td>{{ $genre->name }}</td>
              <td class="tablaDisplayNone">
                <span>{{ $genre->obras_count ?? 0 }}</span>
              </td>
              <td class="opciones w-25">

                @include('admin.genres.edit')

                @include('admin.genres.delete')
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>