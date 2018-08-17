<form class="form" action="/submit" method="post">
    <input type="hidden" name="stage" value="2">

    <h3>Select product:</h3>

    @foreach($products as $key => $product)
        <div class="radio">
            <label>
                <input type="radio" name="productId" value="{{ $product->getId() }}"{{ $key === 0 ? 'checked': '' }}>
                {{ $product->getName() }}
            </label>
        </div>
    @endforeach

    <div class="form-group text-right">
        <button class="btn btn-primary">Next ></button>
    </div>
</form>