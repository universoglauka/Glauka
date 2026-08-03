<div class="row">
  <div class="col-12 col-md-10 m-auto">
    <div class="d-flex justify-content-center">
      <div class="mt-4 table-responsive w-100">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Nombre</th>
              <th class="tablaDisplayNone">Usuarios</th>
              <th class="opciones">Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($labels as $label)
            <tr>
              <td>{{ $label->name }}</td>
              <td class="tablaDisplayNone">
                <span>{{ $label->users_count ?? 0 }}</span>
              </td>
              <td class="opciones w-25">

                @include('admin.labels.edit')

                @include('admin.labels.delete')
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>