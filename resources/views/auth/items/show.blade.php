@extends('auth.layouts.master')

@section('title', 'Продукт ' . $item->name)

@section('content')
    <div class="col-md-12">
        <h1>{{ $item->name }}</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    Поле
                </th>
                <th>
                    Значение
                </th>
            </tr>
            <tr>
                <td>ID</td>
                <td>{{ $item->id}}</td>
            </tr>
            <tr>
                <td>Название</td>
                <td>{{ $item->name }}</td>
            </tr>
            <tr>
                <td>Цена</td>
                <td>{{ $item->price }}</td>
            </tr>
            <tr>
                <td>Картинка</td>
                <td><img src="{{ Storage::url($item->image) }}" height="240px"></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
