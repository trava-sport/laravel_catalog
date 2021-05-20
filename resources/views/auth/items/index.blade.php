@extends('auth.layouts.master')

@section('title', 'Товары')

@section('content')
    <div class="col-md-12">
        <h1>Товары</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Название
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id}}</td>
                    <td>{{ $item->name }}</td>
                    <td></td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('items.destroy', $item) }}" method="POST">
                                <a class="btn btn-success" type="button"
                                   href="{{ route('items.show', $item) }}">Открыть</a>
                                <a class="btn btn-warning" type="button"
                                   href="{{ route('items.edit', $item) }}">Редактировать</a>
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-danger" type="submit" value="Удалить"></form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $items->links() }}
        <br>
        <a class="btn btn-success" type="button" href="{{ route('items.create') }}">Добавить товар</a>
    </div>
@endsection
