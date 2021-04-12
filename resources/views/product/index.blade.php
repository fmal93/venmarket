@extends('layouts.app')

@section('title', 'VenMarket  |  Productos')

@section('content')
    <shop-index show-cat-tab-prop v-bind:cat-ids="[]"></shop-index>
@endsection