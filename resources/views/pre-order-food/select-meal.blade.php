@extends('layout.app')
 
@section('title', 'Select Meal')
 
@section('content')
    <form class="form-meal" action='/pre-order/select-meal' method="POST">
        @csrf
        <div class="mb-3">
          <label for="" class="form-label">Please select a meal</label>
          <select class="form-select" aria-label="Choose Meal" name="meal" id="meal-select" required>
              <option selected value="">---- Choose meal ----</option>
              <option value="breakfast" {{ $nameMeal == 'breakfast' ? 'selected' : '' }} >Breakfast</option>
              <option value="lunch" {{ $nameMeal == 'lunch' ? 'selected' : '' }} >Lunch</option>
              <option value="dinner" {{ $nameMeal == 'dinner' ? 'selected' : '' }} >Dinner</option>
          </select>
          <span id="error-meal-select"></span>
        </div>
        <br>
        <div class="mb-3">
          <label for="" class="form-label">Please select the number of people</label>
            <input type="number" class="form-control" id="meal-quantity" min=0 max=10 required name="quantity" value="{{ isset($quantityMeal) ?  $quantityMeal : 0 }}"> 
          <span id="error-meal-quantity"></span>
        </div>
        <br>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Next</button>
        </div>
    </form>
@endsection