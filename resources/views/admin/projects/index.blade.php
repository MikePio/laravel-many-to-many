@extends('layouts.app')

@section('content')

<div class="container overflow-auto p-5 d-flex flex-column align-items-center" style="max-height: calc(100vh - 70.24px);">

  {{-- * stampo l'alert dopo l'ELIMINAZIONE del progetto e solo se in sessione è presente la variabile "deleted" (in ProjectController.php) --}}
  @if (session('deleted'))
    <div class="alert alert-success" role="alert">
      {{ session('deleted') }}
    </div>
  @endif

  <h1 class="py-4">Projects</h1>

  <table class="table table-hover">
    <thead class="thead-dark">
      <tr class="">
        <th scope="col" style="min-width: 60px"><a href="{{ route('admin.projects.orderby', ['direction' => $direction, 'column' => 'id'] ) }}" class="link-offset-2 link-dark-underline text-black" >#ID <i class="fa-solid fa-caret-{{ $direction == 'desc' && $column == 'id' ? 'up' : 'down' }}"></i></a></th>
        <th scope="col"><a href="{{ route('admin.projects.orderby', ['direction' => $direction, 'column' => 'name'] ) }}" class="link-offset-2 link-dark-underline text-black" >Name <i class="fa-solid fa-caret-{{ $direction == 'desc' && $column == 'name' ? 'up' : 'down' }}"></i></a></th>
        <th scope="col">Type</th>
        <th scope="col">Technology</th>
        <th scope="col">Category</th>
        <th scope="col" style="min-width: 110px"><a href="{{ route('admin.projects.orderby', ['direction' => $direction, 'column' => 'start_date'] ) }}" class="link-offset-2 link-dark-underline text-black" >Start date <i class="fa-solid fa-caret-{{ $direction == 'desc' && $column == 'start_date' ? 'up' : 'down' }}"></i></a></th>
        <th scope="col">Produced for</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($projects as $project)

        <tr>
          <td>{{ $project->id }}</td>
          <td>{{ $project->name }}</td>
          <td>
            @if($project->type?->name)
              <span class="badge bg-primary">{{ $project->type?->name }}</span>
            @else
              <span>No type</span> {{-- si può fare anche senza condizione ma se non c'è nessun dato viene stampato No type --}}
            @endif
          </td>
          <td style="width: 20% !important;">
            @forelse ($project->technologies as $technology)
              <span class="badge bg-warning">{{ $technology->name }}</span>
            @empty
              <span>No technology</span>
            @endforelse
          </td>
          <td>{{ $project->category }}</td>
          @php
            $date = date_create($project->start_date);
            @endphp
          <td>{{ date_format($date, 'd/m/Y') }}</td>
          <td>{{ $project->produced_for }}</td>

          <td style="width: 15% !important;">
            {{--* button per SHOW (mostrare il singolo progetto) --}}
            <a href="{{ route('adminprojects.show', $project) }}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a>
            {{-- OPPURE --}}
            {{-- <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a> --}}
            {{-- <a href="#" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a> --}}
            {{--* button per EDIT (modificare il singolo progetto) --}}
            <a href="{{ route('adminprojects.edit', $project) }}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>

          <!-- {{--! QUESTO BLOCCO DI CODICE è STATO SOSTITUITO DA UN PARTIAL (form-delete.blade.php)   --}}
            {{--* button per DELETE (eliminare il singolo progetto) --}}
            <form action="{{ route('adminprojects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirm deletion of the project: {{ $project->name }} ?')">
              @csrf
              {{--* aggiungere DELETE perchè non è possibile inserire PUT/PATCH nel method del form al posto di POST --}}
              @method('DELETE')
              <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
            </form>
          -->
          @include('admin.partials.form-delete')

          </td>
        </tr>

      @endforeach


    </tbody>
  </table>

  <div>
    {{ $projects->links() }}
  </div>

</div>

@endsection
