<!DOCTYPE html>
<html>

<head>
    <title>Cars Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/myStyle.css') }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/someJavaScript.js') }}"></script>
</head>

<body>
    <div class="main-div">
        <br><br><br>

        <div class="first-div">
            <div style="align-self: flex-start">
                <label for="options"></label>
                <select class="dropdownClass" id="options" name="options">
                    <option value="manufacturer">Manufacturer</option>
                    <option value="model">Model</option>
                    <option value="year">Year</option>
                    <option value="horsepower">Horsepower</option>
                    <option value="price">Price</option>
                </select>

                <label for="options"></label>
                <select class="dropdownClass" id="options2" name="options2">
                    <option value="asc">ASC</option>
                    <option value="desc">DSC</option>
                </select>
            </div>
            <div style="align-self: flex-end">
                Items per page:
                <label for="options3"></label>
                <select class="dropdownClass" id="itemsPerPageDropdown" name="options3">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        <table id="carTable" style="width: 100%;">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>Manufacturer</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Horsepower</th>
                    <th>Price</th>
                </tr>
            </thead>

            <tbody>
                <!-- jQuery will insert rows here -->
            </tbody>

        </table>

        <div class="first-div">
            <button id="button-prev" style="align-self: flex-start" class="btn-class">Prev</button>
            <p style="height: 0px;" class="pages-txt" id="myP">Page 1 of 12</p>
            <button id="button-next" style="align-self: flex-end" class="btn-class">Next</button>
        </div>

        <button id="button-delete" style="align-self: flex-start" class="btn-class">Delete</button>
        
        <div class="alert-success" id="items-deleted-id" style="display:none">
            <p>Item(s) deleted successfully.</p>
        </div>
        <br>
        <details>
            <summary style="cursor: pointer; font-size: 16px;">
                Advanced Filters
            </summary>
            <br>
            <div class="second-div">
                <input type="number" name="asdf" id="price-min" placeholder="Price Min" required style="width: 6%;">
                <input type="number" name="model" id="price-max" placeholder="Price Max" required style="width: 6%;">
                <input type="number" name="model" id="year-min" placeholder="Year Min" required style="width: 6%;">
                <input type="number" name="model" id="year-max" placeholder="Year Max" required style="width: 6%;">
                <input type="number" name="model" id="hp-min" placeholder="HP Min" required style="width: 6%;">
                <input type="number" name="model" id="hp-max" placeholder="HP Max" required style="width: 6%;">
                <button id="filters-btn" class="btn-class">Apply Filters</button>
            </div>
        </details>

        <br>
        <br>
        <br>
        <form id="carForm" class="car-form" action="{{ url('/add-car') }}" method="POST">
            @csrf
            <input type="text" name="manufacturer" placeholder="Manufacturer" required style="width: 18%;">
            <input type="text" name="model" placeholder="Model" required style="width: 18%;">
            <input type="number" name="year" placeholder="Year" required style="width: 18%;">
            <input type="number" name="horsepower" placeholder="Horsepower" required style="width: 18%;">
            <input type="number" name="price" placeholder="Price" required style="width: 18%;">
            <button id="addCarBtn" type="submit" class="btn-class">Add Car</button>
        </form>
        @if (session('success'))
            <div class="alert-success" id="flash-message">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div>
                        * {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif
        <br><br>
    </div>



</body>

</html>