let currentPage = 1;
let carsPerPage = 5;   // By default
let sortOrder = "asc";   // By default
let orderBy = "manufacturer";   // By default

let switchPagesAllowed = true; // This prevents switching too many pages before Ajax has loaded the page the user is looking for (in case of double-click on PREV/NEXT buttons, etc)

$(document).ready(function () {
    $('#filters-btn').on('click', function () {
        currentPage = 1;
        updateTable();
    });

    $("#button-delete").on('click', function () {
        deleteCars();
    });

    $("#options").on("change", function () {
        orderBy = $("#options").val();
        updateTable();
    });

    $("#options2").on("change", function () {
        sortOrder = $("#options2").val();   // ASC or DSC
        updateTable();
    });

    // How many cars to show
    $('#itemsPerPageDropdown').on('change', function () {
        let newValue = $('#itemsPerPageDropdown').val();
        carsPerPage = Number(newValue);
        currentPage = 1;
        updateTable();
    });

    assignButtons(); // Next and Prev buttons

    updateTable(); // Update (or create) the cars table

    removeSuccessMessage(); // Remove the "Car Successfully Created" message after 5 seconds
});

function deleteCars() {
    const selected_cars = document.querySelectorAll(".checkbox-class:checked");
    const IDs = Array.from(selected_cars).map(cb => cb.value);

    if (IDs.length === 0) {
        alert("Please select at least 1 car to delete.");
        return;
    }

    if (!confirm("Are you sure you want to delete selected cars?")) return;

    $.ajax({
        url: "/api/deleteCars",
        type: "POST",
        data: { carIDs: IDs },
        success: function () {
            updateTable();
            $('#items-deleted-id').prop('style', 'display:block'); // Show that items have been deleted

            $('#button-delete').prop('disabled', true); // Reset to disabled, since no cars are selected anymore
        },
        error: function (xhr, status, error) {
            alert(error + "|" + xhr + "|" + status);
        }
    });
}

function removeSuccessMessage() {
    setTimeout(() => {
        const el = $("#flash-message");
        if (el) {
            el.remove();
        }
    }, 4000);
}

function assignButtons() {
    $('#button-next').click(() => {
        if (switchPagesAllowed == true) {
            currentPage++;
            switchPagesAllowed = false;
        }
        updateTable();
    });
    $('#button-prev').click(() => {
        if (switchPagesAllowed == true) {
            currentPage--;
            switchPagesAllowed = false;
        }
        updateTable();
    });
}

function updatePagesButtons(pagesTotal, carsTotal) {
    $('#myP').text("Page " + currentPage + " of " + pagesTotal + " --- (" + carsTotal + " cars found)");

    $("#button-prev").prop("disabled", currentPage === 1);
    $("#button-next").prop("disabled", currentPage === pagesTotal);
}

function updateTable() {
    $.ajax({
        url: '/api/requestCars?page=' + currentPage + '&carsPerPage=' + carsPerPage
            + '&sortorder=' + sortOrder + '&orderBy=' + orderBy + '&priceMin=' + $("#price-min").val()
            + '&priceMax=' + $("#price-max").val() + '&yearMin=' + $("#year-min").val()
            + '&yearMax=' + $("#year-max").val() + '&hpMin=' + $("#hp-min").val()
            + '&hpMax=' + $('#hp-max').val(),
        method: 'GET',
        success: function (cars) {

            switchPagesAllowed = true;

            const cars_var = cars.CARS.data;
            const table_body = $('#carTable tbody');
            table_body.empty();

            cars_var.forEach(car => {
                const row = `<tr>
                                <td><input type="checkbox" class="checkbox-class" value=${car.id}></td>
                                <td>${car.manufacturer}</td>
                                <td>${car.model}</td>
                                <td>${car.year}</td>
                                <td>${car.horsepower}</td>
                                <td>$${car.price}</td>
                            </tr>`;
                table_body.append(row);
            });

            updatePagesButtons(cars.PAGESTOTAL, cars.CARSTOTAL);

            $("#checkAll").prop("checked", false);


            // Work on this
            $('#checkAll').on('change', function () {
                $('.checkbox-class').prop('checked', this.checked);
                const selected_cars2 = document.querySelectorAll(".checkbox-class:checked");
                const IDs2 = Array.from(selected_cars2).map(cb => cb.value);

                if (IDs2.length > 0) {
                    $('#button-delete').prop('disabled', false);
                } else {
                    $('#button-delete').prop('disabled', true);
                }
            });

            // Work on this
            $('.checkbox-class').on('change', function () {
                const selected_cars = document.querySelectorAll(".checkbox-class:checked");
                const IDs = Array.from(selected_cars).map(cb => cb.value);

                if (IDs.length > 0) {
                    $('#button-delete').prop('disabled', false);
                } else {
                    $('#button-delete').prop('disabled', true);
                }
            });
        },
        error: function (err) {
            console.error(err);
        }
    });


}