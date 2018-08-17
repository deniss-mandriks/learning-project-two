@extends('layout')

@section('content')
    @if($stage === 1)
        @include('form-stage-one')
    @elseif($stage === 2)
        @include('form-stage-two')
    @else
        @if($selectedProductTypeId === SUBSCRIPTION_PRODUCT_TYPE_ID)
            @include('products.subscription')
        @elseif($selectedProductTypeId === SERVICES_PRODUCT_TYPE_ID)
            @include('products.services')
        @elseif($selectedProductTypeId === GOODS_PRODUCT_TYPE_ID)
            @include('products.goods')
        @else
            <h3>Whoops! Something went wrong. Please try again later.</h3>
            <a class="btn btn-primary" href="/">Back to home</a>
        @endif
    @endif
@endsection