<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreOrderController extends Controller
{
    public function selectMeal(Request $request)
    {
        $quantityMeal = session('meal_info')['quantity'];
        $nameMeal = session('meal_info')['meal'];

        return view('pre-order-food.select-meal', compact('quantityMeal', 'nameMeal'));
    }

    public function selectPostMeal(Request $request)
    {
        $validated = $request->validate([
            'meal' => 'required',
            'quantity' => 'required|min:1|max:10',
        ]);

        $listDishes = $this->getListDishes();
        $availableRestaurants = [];
        if (count($listDishes['dishes']) > 0) {
            foreach ($listDishes['dishes'] as $dish) {
                if (in_array($validated['meal'], $dish['availableMeals'])) {
                    $availableRestaurants[] = $dish['restaurant'];
                }
            }

            $availableRestaurants = array_unique($availableRestaurants);
        }

        $validated['list_restaurants'] = $availableRestaurants;
        $request->session()->put('meal_info', $validated);
        return redirect()->route('get_restaurant');
    }

    public function selectRestaurant(Request $request)
    {
        $listRetaurants = [];
        if ($request->session()->has('meal_info')) {
            $mealInfo = $request->session()->get('meal_info');
            $listRetaurants = $mealInfo['list_restaurants'];
        }

        $restaurantInSession = session('restaurant_info')['restaurant'];
        return view('pre-order-food.select-restaurant', compact('listRetaurants', 'restaurantInSession'));
    }

    public function selectPostRestaurant(Request $request)
    {
        $validated = $request->validate([
            'restaurant' => 'required',
        ]);

        $listDishes = $this->getListDishes();
        $chosenRestaurant = $validated['restaurant'];
        $chosenMeal = "";
        if ($request->session()->has('meal_info')) {
            $mealInfo = $request->session()->get('meal_info');
            $chosenMeal = $mealInfo['meal'];
        }
        $availableDishes = [];
        if (count($listDishes['dishes']) > 0) {
            foreach ($listDishes['dishes'] as $dish) {
                if (in_array($chosenMeal, $dish['availableMeals']) && $chosenRestaurant == $dish['restaurant']) {
                    $availableDishes[] = $dish['name'];
                }
            }

            $availableDishes = array_unique($availableDishes);
        }

        $validated['available_dishes'] = $availableDishes;
        $request->session()->put('restaurant_info', $validated);
        if($validated)
        {
            return redirect()->route('get_dish');
        }else {
            return view('pre-order-food.select-restaurant');
        }
    }

    public function selectDish(Request $request)
    {
        $listDishes = [];
        $quantityMeal = 0;
        if ($request->session()->has('restaurant_info')) {
            $restaurantInfo = $request->session()->get('restaurant_info');
            $listDishes = $restaurantInfo['available_dishes'];
        }

        if ($request->session()->has('meal_info')) {
            $mealInfo = $request->session()->get('meal_info');
            $quantityMeal = $mealInfo['quantity'];
        }

        
        return view('pre-order-food.select-dish', compact('listDishes', 'quantityMeal'));
    }

    public function selectPostDish(Request $request)
    {
        if (isset($_COOKIE['listDishes'])) {
            $listDishes = json_decode($_COOKIE['listDishes'], true);
        }

        if(!empty($listDishes))
        {
            return redirect()->route('review');
        }else {
            return redirect()->route('get_dish');
        }
    }

    public function review(Request $request)
    {
        $quantityMeal = 0;
        $nameMeal = "";
        $nameRestaurant = "";
        $listDishes = [];

        if ($request->session()->has('meal_info')) {
            $mealInfo = $request->session()->get('meal_info');
            $quantityMeal = $mealInfo['quantity'];
            $nameMeal = $mealInfo['meal'];
        }

        if ($request->session()->has('restaurant_info')) {
            $restaurantInfo = $request->session()->get('restaurant_info');
            $nameRestaurant = $restaurantInfo['restaurant'];
        }

        if (isset($_COOKIE['listDishes'])) {
            $listDishes = json_decode($_COOKIE['listDishes'], true);
        }

        if(!empty($listDishes))
        {
            return view('pre-order-food.review', compact('nameMeal', 'quantityMeal', 'nameRestaurant', 'listDishes'));
        }
        else {
            return redirect()->route('get_dish');
        }
    }

    public function getListDishes()
    {
        $fileDishesJson = file_get_contents(storage_path('app/dishes.json'));
        $listDishes = json_decode($fileDishesJson, true);
        return $listDishes;
    }
}
