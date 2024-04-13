@extends('layout.app')
 
@section('title', 'Select Restaurant')
 
@section('content')
    <form class="form-restaurant" action="/pre-order/select-restaurant" method="POST" onsubmit="clearLocalStorage()">
        @csrf
        <div class="mb-3">
          <label for="" class="form-label">Please select a restaurant</label>
          <select class="form-select" aria-label="Choose Restaurant" name="restaurant" id="restaurant-select" required>
            <option selected value="">---- Choose restaurant ----</option>
            @foreach ($listRetaurants as $restaurant)
                <option value="{{ $restaurant }}" {{ ($restaurantInSession && $restaurantInSession == $restaurant) ? 'selected' : '' }} >{{ $restaurant }}</option>
            @endforeach
          </select>
          @error('restaurant')
                <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="d-flex justify-content-between btn-container-restaurant">
            <a type="button" class="btn btn-primary" href="{{ route('get_meal') }}">Previous</a>
            <button type="submit" class="btn btn-primary" >Next</button>
        </div>
    </form>
@endsection