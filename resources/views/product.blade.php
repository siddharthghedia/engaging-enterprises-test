<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Test App</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </head>
    <body class="container">
        <div class="row mt-5">
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Active & Verified Users</h5>
                        <h4>{{ $activeAndVerifiedUsers }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Active & Verified Users Who has Active products</h5>
                        <h4>{{ $activeAndVerifiedUsersWhoHasActiveProducts }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Active products</h5>
                        <h4>{{ $activeProducts }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Active Products Which Dont Belong To User</h5>
                        <h4>{{ $activeProductsWhichDontBelongToUser }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Amount Of All Active Attached Products</h5>
                        <h4>{{ $amountOfAllActiveAttachedProducts }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Summarized Price Of All Active attached Products</h5>
                        <h4>{{ $summarizedPrice }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Summarized prices of all active products per user</h5>
                        @foreach($summerizedPricePerUsers as $user)
                            @php
                                $totalPrice = 0;
                                foreach($user->activeProducts as $product)
                                {
                                    $totalPrice += $product->price * $product->pivot->quantity;
                                }
                            @endphp
                            {{ $user->name }} - ${{ $totalPrice }} <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
