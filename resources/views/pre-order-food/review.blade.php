@extends('layout.app')
 
@section('title', 'Select Restaurant')
 
@section('content')

<form class="form-review" >
    @csrf
    <div class="row">
        <div class="col-md-6">
            <p>Meal</p>
        </div>
        <div class="col-md-6">
            <p id="name-meal-review">{{ $nameMeal }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <p>Number of people</p>
        </div>
        <div class="col-md-6">
            <p id="quantity-meal-review">{{ $quantityMeal }}</p>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <p>Restaurant</p>
        </div>
        <div class="col-md-6">
            <p id="name-restaurant-review">{{ $nameRestaurant }}</p>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <p>Dishes</p>
        </div>
        <div class="col-md-6 container-dish-div">
            <ul class="container-dish-ul"> 
                @foreach ($listDishes as $item)
                    <li class="dish-review">{{ $item['dish_name'] }} - {{ $item['dish_servings'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>


    <div class="d-flex justify-content-between btn-container-dish">
        <a type="button" class="btn btn-primary" href="{{ route('get_dish') }}">Previous</a>
        <button type="button" class="btn btn-primary" onclick="handldeFinalOutPut()">Submit</button>
    </div>
</form>


@endsection