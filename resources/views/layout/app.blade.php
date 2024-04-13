<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Pre Order Food</title>
</head>
<body>
      <div class="tab-header">
        <button type="button" id="meal-tab" class="btn btn-secondary">Step 1</button>
        <button type="button" id="restaurant-tab" class="btn btn-secondary">Step 2</button>
        <button type="button" id="dish-tab" class="btn btn-secondary">Step 3</button>
        <button type="button" id="review-tab" class="btn btn-secondary">Review</button>
      </div>
      <div class="tab-content">
        @yield('content')
      </div>


    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" defer>
        // get element from tab 
        let mealTabElement = document.querySelector("#meal-tab");
        let restaurantTabElement = document.querySelector("#restaurant-tab");
        let dishTabElement = document.querySelector("#dish-tab");
        let reviewTabElement = document.querySelector("#review-tab");

        // get element display error message in form meal
        let errorMealSelect = document.querySelector("#error-meal-select");
        let errorMealQuantity = document.querySelector("#error-meal-quantity");

        // get button add dish element
        let buttonAddDish = document.querySelector(".btn-add-dish");

        // get element in form dish
        let dishSelect = document.querySelector("#dish-select");
        let dishServing = document.querySelector("#dish-serving");

        // get ul list added dish element
        let listAddedDish = document.querySelector(".list-added-dist");

        // get btn submit in form restaurant
        let btnSubmitRestaurant = document.querySelector(".btn-submit-restaurant");

        // process active button
        let currentUrl =  window.location.href;
        let currentUrlWithoutDomain = currentUrl.replace(window.location.origin, "");


        // get element in form review
        let nameMealReview = document.querySelector("#name-meal-review");
        let quantityMealReview = document.querySelector("#quantity-meal-review");
        let restaurantReview = document.querySelector("#name-restaurant-review");
        let dishesReview = document.querySelectorAll(".dish-review");

        switch (currentUrlWithoutDomain) {
            case '/pre-order/select-meal':
                if(!mealTabElement.classList.contains('active-btn'))
                {
                    mealTabElement.classList.add('active-btn');
                }

                if(restaurantTabElement.classList.contains('active-btn'))
                {
                    restaurantTabElement.classList.remove('active-btn');
                }

                if(dishTabElement.classList.contains('active-btn'))
                {
                    dishTabElement.classList.remove('active-btn');
                }

                if(reviewTabElement.classList.contains('active-btn'))
                {
                    reviewTabElement.classList.remove('active-btn');
                }
            break;

            case '/pre-order/select-restaurant':
                if(!restaurantTabElement.classList.contains('active-btn'))
                {
                    restaurantTabElement.classList.add('active-btn');
                }

                if(mealTabElement.classList.contains('active-btn'))
                {
                    mealTabElement.classList.remove('active-btn');
                }

                if(dishTabElement.classList.contains('active-btn'))
                {
                    dishTabElement.classList.remove('active-btn');
                }

                if(reviewTabElement.classList.contains('active-btn'))
                {
                    reviewTabElement.classList.remove('active-btn');
                }
            break;

            case '/pre-order/select-dish':
                if(!dishTabElement.classList.contains('active-btn'))
                {
                    dishTabElement.classList.add('active-btn');
                }

                if(restaurantTabElement.classList.contains('active-btn'))
                {
                    restaurantTabElement.classList.remove('active-btn');
                }

                if(mealTabElement.classList.contains('active-btn'))
                {
                    mealTabElement.classList.remove('active-btn');
                }

                if(reviewTabElement.classList.contains('active-btn'))
                {
                    reviewTabElement.classList.remove('active-btn');
                }
            break;

            case '/pre-order/review':
                if(!reviewTabElement.classList.contains('active-btn'))
                {
                    reviewTabElement.classList.add('active-btn');
                }

                if(dishTabElement.classList.contains('active-btn'))
                {
                    dishTabElement.classList.remove('active-btn');
                }

                if(restaurantTabElement.classList.contains('active-btn'))
                {
                    restaurantTabElement.classList.remove('active-btn');
                }

                if(mealTabElement.classList.contains('active-btn'))
                {
                    mealTabElement.classList.remove('active-btn');
                }
            break;
            default:
                break;
        }
        
        // process add dishes from local storage into form select dishes
        if(currentUrlWithoutDomain == '/pre-order/select-dish')
        {
            let getExistDish = localStorage.getItem('list_dishes');
            let arrDishes = [];
            if(getExistDish)
            {
                JSON.parse(getExistDish).forEach((element,index) => {
                    arrDishes.push(element)
                });

                arrDishes.forEach((element,index) => {
                    let newLiElement = document.createElement('li');
                    newLiElement.innerText = element.dish_name + ' - ' + element.dish_servings;
                    newLiElement.style.marginBottom = '5px';
                    newLiElement.setAttribute('data-index', index)

                    let removeBtnElement = document.createElement('button');
                    removeBtnElement.innerText = 'x';
                    removeBtnElement.style.marginLeft = '10px';
                    removeBtnElement.setAttribute('title', 'Remove this dish');
                    removeBtnElement.classList.add('remove-dish')

                    newLiElement.appendChild(removeBtnElement);
                    listAddedDish.appendChild(newLiElement);
                });
            }
        }
        
        // handle add dishes when click plus button in form select dishes
        function handleAddDishes()
        {
            let maxQuantityMealCanServe = 10;
            let dishSelectValue = dishSelect.value;
            let dishServingValue = dishServing.value;


            if(dishSelectValue == "" && dishServingValue == "")
            {
                Swal.fire({
                    title: 'Thông báo',
                    text: 'Please choose dish and select the number of servings !!!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if(dishSelectValue != "" && dishServingValue != "")
            {
                let arrDishes = [];
                let getExistDish = localStorage.getItem('list_dishes');

                if(!getExistDish)
                {
                    arrDishes.push({
                        dish_name: dishSelectValue,
                        dish_servings: dishServingValue
                    });

                    localStorage.setItem('list_dishes', JSON.stringify(arrDishes));
                    console.log(dishServingValue, maxQuantityMealCanServe)
                    if(dishServingValue <= maxQuantityMealCanServe)
                    {
                        arrDishes.forEach((element,index) => {
                            let newLiElement = document.createElement('li');
                            newLiElement.innerText = element.dish_name + ' - ' + element.dish_servings;
                            newLiElement.style.marginBottom = '5px';
                            newLiElement.setAttribute('data-index', index)

                            let removeBtnElement = document.createElement('button');
                            removeBtnElement.innerText = 'x';
                            removeBtnElement.style.marginLeft = '10px';
                            removeBtnElement.setAttribute('title', 'Remove this dish');
                            removeBtnElement.classList.add('remove-dish')
                            
                            newLiElement.appendChild(removeBtnElement);
                        });

                        window.location.reload();
                    }else{
                        Swal.fire({
                            title: 'Thông báo',
                            text: 'The total number of dishes has to less than 10 !!!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }else
                {
                    let totalServed = 0;

                    JSON.parse(getExistDish).forEach((element,index) => {
                        totalServed += parseInt(element.dish_servings);
                    });

                    if( (parseInt(totalServed) + parseInt(dishServingValue)) <= 10 )
                    {
                        arrDishes.push({
                            dish_name: dishSelectValue,
                            dish_servings: dishServingValue
                        });

                        JSON.parse(getExistDish).forEach((element,index) => {
                        if(element.dish_name != dishSelectValue)
                        {
                            arrDishes.push(element)
                        }
                        });

                        localStorage.removeItem('list_dishes');
                        localStorage.setItem('list_dishes', JSON.stringify(arrDishes));
                        window.location.reload();
                    }else {
                        Swal.fire({
                            title: 'Thông báo',
                            text: 'The total number of dishes has to less than 10 !!!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            }

            return;
        }
        
        // set cookies for pass values from local storage to server
        function setCookie(name,value,days) {
            let expires = "";
            if (days) {
                let date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }

        var listDish = localStorage.getItem('list_dishes');
        setCookie('listDishes', listDish, 7);

        // clear local storage when submit form select restaurant
        function clearLocalStorage(){
            let getExistDish = localStorage.getItem('list_dishes');
            if(getExistDish)
            {
                localStorage.removeItem('list_dishes');
            }
        }  

        // handle submit form dish
        function onSubmitDish(event)
        {
            // event.preventDefault();
            let getExistDish = localStorage.getItem('list_dishes');
            if(!getExistDish)
            {
                Swal.fire({
                    title: 'Thông báo',
                    text: 'Please add dish and the number of servings to the list below add button',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }

            setTimeout(function() {
                document.querySelector('.form-dish').submit();
            }, 3000);
        }

        // console infomation about order detail to log
        function handldeFinalOutPut(){
            console.log('Meal: ', nameMealReview.innerText);
            console.log('Number of servings: ', quantityMealReview.innerText);
            console.log('Restaurant: ', restaurantReview.innerText);

            let dishesString = "";
            dishesReview.forEach((element, index) => {
                dishesString +=  element.innerText;
                if (index < dishesReview.length - 1) {
                    dishesString += ', ';
                }

            })
            console.log('Dishes: ', dishesString)
        }


        // handle remove dishes from list dishes
        let removeDish = document.querySelectorAll('.remove-dish');
        if(removeDish)
        {
            removeDish.forEach(function(item) {
                item.addEventListener('click', function() {
                    let listItem = this.parentNode;
                    let indexLi = listItem.getAttribute('data-index');
                    listItem.parentNode.removeChild(listItem);
                    removeItemFromLocalStorage(indexLi)
                });
            });
        }

        function removeItemFromLocalStorage(index)
        {
            let getListDishes = localStorage.getItem('list_dishes');
            if(getListDishes)
            {
                console.log('vao day r')
                let items = JSON.parse(localStorage.getItem('list_dishes')) || [];
                items.splice(index, 1);
                localStorage.removeItem('list_dishes');
                if(items.length > 0)
                {
                    localStorage.setItem('list_dishes', JSON.stringify(items));
                }else {
                    document.cookie = 'listDishes' + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                }
                
            }
        }
    </script>
</body>
</html>