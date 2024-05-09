function handleStockChange(value, id) {
    var datePicker = document.getElementById("datepicker_" + id);
    if (value === "backordered-" + id) {
        datePicker.style.display = "block";
        // Initialize datepicker
        $(function () {
            $("#datepicker_" + id).datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (dateText) {
                    // Store the selected date in backordered
                    var selectedDate = dateText;
                    // Here you can do whatever you want with the selected date, for example, send it to the server.
                    console.log("Selected date: " + selectedDate);
                }
            });
        });
    } else {
        datePicker.style.display = "none";
    }


    const dateInput = document.getElementById('datepicker_' + id);

    // Add an event listener for input event
    dateInput.addEventListener('input', function () {
        // Get the value from the input field
        const inputValue = this.value;

        // Check if the entered value matches the date format (YYYY-MM-DD)
        if (/^\d{4}-\d{2}-\d{2}$/.test(inputValue)) {
            // Check if the entered date is before today's date
            const currentDate = new Date();
            const enteredDate = new Date(inputValue);
            if (enteredDate < currentDate) {
                // Display an alert
                alert("Please select today's date or a future date.");
                // Reset the input field to today's date
                const today = currentDate.toISOString().slice(0, 10);
                this.value = today;
            } else {
                // Set the input field's value to the previous date
                const previousDate = new Date(enteredDate.getTime() - (24 * 60 * 60 * 1000)); // Subtract one day (24 hours * 60 minutes * 60 seconds * 1000 milliseconds)
                const previousDateString = previousDate.toISOString().slice(0, 10);

                // Update the datepicker value
                $(this).datepicker("setDate", previousDateString);
            }
        }
    });
}
function validDate(itemId) {
    var datepickerValue = document.getElementById("datepicker_" + itemId).value;
    document.getElementById("backordered-" + itemId).value = datepickerValue;
}
function updatestock() {
    var items = [];
    var itemElements = Array.from(document.querySelectorAll('[id^="itemid"]'));

    itemElements.forEach(function (itemElement) {
        var itemValue = itemElement.value;
        var selectElement = document.getElementById("stock-" + itemValue);
        var selectedValue = selectElement.value;
        if (selectedValue == "instock-" + itemValue) {
            const currentDate = new Date();
            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, "0"); // Adding 1 because January is 0
            const day = String(currentDate.getDate()).padStart(2, "0");
            const currentDateString = `${year}-${month}-${day}`; // Get the current date in YYYY-MM-DD format
            selectedValue = currentDateString;
        }
        if (selectedValue == "discontinued-" + itemValue) {
            selectedValue = 1;
        }
        if (selectedValue == "backordered-" + itemValue) {
            selectedValue = document.getElementById("datepicker_" + itemValue).value;
        }
        items.push({
            id: itemValue,
            stock: selectedValue,
        });

    });
    var itemData = JSON.stringify(items);
    var url = "http://127.0.0.1/1SBMAGENTO/index.php/admin/orderstock/update";
    url += "/key/" + FORM_KEY;
    var parameters = {
        value: itemData
    };
    new Ajax.Request(url, {
        method: "post",
        parameters: parameters,
    });
}


function mailhandle(){
    var id=[];
    var itemElements = Array.from(document.querySelectorAll('[id^="itemid"]')); // Assuming item ids are "itemid0", "itemid1", etc.
    itemElements.forEach(function (itemElement) {
      var itemValue = itemElement.value;
      id.push(itemValue);
    });
    var jsonData = JSON.stringify(id);
  
    var formData = new FormData();
  
    formData.append("data", jsonData);
  
    formData.append("form_key", FORM_KEY);
    fetch(mailUrl, {
      method: "POST",
      body: formData,
    });
  
  }