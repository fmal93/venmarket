@extends('layouts.app')

@section('title', 'VenMarket  |  Productos')

@section('content')
    <p class="text-2xl font-bold text-center py-5 undeline"><em>{{ $category->name }}</em></p>
    <shop-index  v-bind:show-cat-tab-prop="false" v-bind:cat-ids="[{{ $category->id }},]"></shop-index>
@endsection