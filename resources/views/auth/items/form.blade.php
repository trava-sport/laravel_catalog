@extends('auth.layouts.master')

@isset($item)
    @section('title', 'Редактировать товар ' . $item->name)
@else
    @section('title', 'Создать товар')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($item)
            <h1>Редактировать товар <b>{{ $item->name }}</b></h1>
        @else
            <h1>Добавить товар</h1>
        @endisset
        <form method="POST" enctype="multipart/form-data"
              @isset($item)
              action="{{ route('items.update', $item) }}"
              @else
              action="{{ route('items.store') }}"
            @endisset
        >
            <div>
                @isset($item)
                    @method('PUT')
                @endisset
                @csrf
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'name'])
                        <input type="text" class="form-control" name="name" id="name"
                               value="@isset($item){{ $item->name }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="code" class="col-sm-2 col-form-label">Цена: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'price'])
                        <input type="text" class="form-control" name="price" id="price"
                               value="@isset($item){{ $item->price }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="size_id" class="col-sm-2 col-form-label">Размер: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'size_id'])
                        <select name="size_id" id="size_id" class="form-control">
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}"
                                        @isset($item)
                                        @if($item->size_id == $size->id)
                                        selected
                                    @endif
                                    @endisset
                                >{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="fabric_id" class="col-sm-2 col-form-label">Ткань: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'fabric_id'])
                        <select name="fabric_id" id="fabric_id" class="form-control">
                            @foreach($fabrics as $fabric)
                                <option value="{{ $fabric->id }}"
                                        @isset($item)
                                        @if($item->fabric_id == $fabric->id)
                                        selected
                                    @endif
                                    @endisset
                                >{{ $fabric->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                    <div class="col-sm-10">
                        <label class="btn btn-default btn-file">
                            Загрузить <input type="file" style="display: none;" name="image" id="image">
                        </label>
                    </div>
                </div>
                <br>

                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
