@foreach($produtos as $produto)
    @if($produto->trashed())
        <!-- Mostrar produtos excluídos -->
        <form action="{{ route('produtos.restore', $produto->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-warning btn-sm">Restaurar</button>
        </form>
    @endif
@endforeach