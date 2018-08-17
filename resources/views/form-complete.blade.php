@extends('layout')

@section('content')
    <h3>Process finished</h3>
    <p>Unique id: {{ $quoteSummary->getId() }}</p>
    <hr>
    <p>User's name: {{ $quoteSummary->getUserName() }}</p>
    <p>Encrypted password: {{ $quoteSummary->getPassword() }}</p>
    <hr>
    <p>Product type: {{ $quoteSummary->getProductType() }}</p>
    <p>Product name: {{ $quoteSummary->getProductName() }}</p>
    <hr>
    @if($quoteSummary->getProductTypeId() === SUBSCRIPTION_PRODUCT_TYPE_ID)
        <p>Start date: {{ $quoteSummary->getStartDate()->format('d M Y') }}</p>
        <p>End date: {{ $quoteSummary->getEndDate()->format('d M Y') }}</p>
        <p>Price per day: {{ $quoteSummary->getPricePerDay() }}</p>
    @elseif($quoteSummary->getProductTypeId() === SERVICES_PRODUCT_TYPE_ID)
        <p>Day of week: {{ $quoteSummary->getDayOfWeek() }}</p>
        <p>Start time: {{ $quoteSummary->getStartTime()->format('g:i A') }}</p>
        <p>End time: {{ $quoteSummary->getEndTime()->format('g:i A') }}</p>
        <p>Amount of weeks: {{ $quoteSummary->getWeekCount() }}</p>
        <p>Price per hour: {{ $quoteSummary->getPricePerHour() }}</p>
    @elseif($quoteSummary->getProductTypeId() === GOODS_PRODUCT_TYPE_ID)
        <p>Start date: {{ $quoteSummary->getQuantity() }}</p>
        <p>Price per item: &pound;{{ $quoteSummary->getPricePerItem() }}</p>
    @else
        <p><strong>Could not find product details.</strong></p>
    @endif

    <hr>
    <p>Total price: &pound;{{ $quoteSummary->getTotalPrice() }}</p>

    <a class="btn btn-primary" href="/">Back</a>
@endsection