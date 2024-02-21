<table class="table table-striped table-hover border">
    <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome tag</th>
            <th scope="col">Q.ta articoli collegati</th>
            <th scope="col">Aggiorna</th>
            <th scope="col">Cancella</th>
        </tr>
    </thead>
    <tbody>
        @if($metaType == "tags")
        @foreach($metaInfos as $metaInfo)
        <tr>
            <th scope="row">{{$metaInfo->id}}</th>
            <td>{{$metaInfo->name}}</td>
            <td>{{count($metaInfo->articles)}}</td>
            <td>
                <form action="{{route('admin.editTag', ['tag' => $metaInfo])}}" method="POST">
                    @csrf
                    @method('put')
                    <input type="text" name="name" placeholder="Nuovo nome" class="form-control w-50 d-inline"> <button type="submit" class="btn btn-info text-white">Aggiorna</button>
                </form>
            </td>
            <td>
                <form action="{{route('admin.deleteTag', ['tag' => $metaInfo])}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger text-white">Elimina</button>
                </form>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td>
                <form action="{{route('admin.editCategory', ['category' => $metaInfo])}}" method="POST">
                    @csrf
                    @method('put')
                    <input type="text" name="name" placeholder="Nuovo nome categoria" class="form-control w-50 d-inline bg-white">
                    <button type="submit" class="btn btn-outline-info text-white">Aggiorna</button>
                </form>
            </td>
            <td>
                <form action="{{route('admin.deleteCategory', ['category' => $metaInfo])}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger text-white">Elimina</button>
                </form>
            </td>
        </tr>
        @endif
    </tbody>
</table>
