@extends('layout.app')
 
@section('title', 'Select Restaurant')
 
@section('content')

<form class="form-dish" action="/pre-order/select-dish" method="POST" onsubmit="onSubmitDish(event)">
    @csrf
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="" class="form-label">Please select a dish</label>
            <select class="form-select form-control" aria-label="Choose Dish" name="dish-select" id="dish-select">
              <option selected value="">---- Choose dish ----</option>
              @foreach ($listDishes as $dish)
                  <option value="{{ $dish }}">{{ $dish }}</option>
              @endforeach
            </select>
           
        </div>
      
        <div class="mb-3 col-md-6">
            <label for="" class="form-label">Please enter number of servings</label>
            <input type="number" name="dish-serving" id="dish-serving" min=1 max=10 class="form-control">
            @error('dish-serving')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <button type="button" class="btn-add-dish" onclick="handleAddDishes()" title="Add dishes to list">+</button>
    <ul class="list-added-dist">

    </ul>
    <div class="d-flex justify-content-between btn-container-dish">
        <a type="button" class="btn btn-primary" href="{{ route('get_restaurant') }}">Previous</a>
        <button type="submit" class="btn btn-primary" >Next</button>
    </div>
</form>

@endsection