@foreach ($items as $item)
    <!-- Item -->  
    <div class="column col-4">
        <div class="element">
            <div class="element-image">
                <img src="{{ Storage::url($item->image) }}" alt="">
            </div>
            <div class="element-title">
                <a href="">{{$item->name}}</a>
            </div>
            <div class="element-price">{{$item->price}}</div>
        </div>
    </div>   
@endforeach 