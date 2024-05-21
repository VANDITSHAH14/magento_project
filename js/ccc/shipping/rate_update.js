var UpdateRate = Class.create();

UpdateRate.prototype = {
    initialize: function (updateButtonId, rates, popupDivId, popDivContentId, closeButtonId) {
        this.updateButton = $(updateButtonId);
        this.popup = $(popupDivId);
        this.popupDivContent = $(popDivContentId);
        this.closePopupButton = $(closeButtonId);
        this.rates = rates;
        this.updateButton.observe('click', this.showpopup.bind(this))
    },

    showpopup: function () {
        var JSONrate = (this.rates);
        this.rateTable = document.createElement("table");
        for (var i = 1; i <= Object.keys((this.rates)).length; i++) {

            // to set Table header From - To - Rate
            if (i == 1) {
                this.rowChild = document.createElement("tr");
                this.colFrom = document.createElement("th");
                this.colTo = document.createElement("th");
                this.ColRate = document.createElement("th");
                this.rateTable.appendChild(this.rowChild);
                this.rowChild.appendChild(this.colFrom);
                this.rowChild.appendChild(this.colTo);
                this.rowChild.appendChild(this.ColRate);
                this.colFrom.innerHTML = "From";
                this.colTo.innerHTML = "To";
                this.ColRate.innerHTML = "Price";
            }
            var index = JSONrate[i];

            // to add rate data in each row
            this.rowChild = document.createElement("tr");
            for (var key in index) {
                this.colChild = document.createElement("td");
                this.input = document.createElement("input");
                this.input.type = "text";
                this.input.id = key + "_" + i;
                this.input.value = index[key];
                this.colChild.appendChild(this.input);
                this.rowChild.appendChild(this.colChild);
            }

            // to add extre button delete record
            this.colChild = document.createElement("td");
            this.deleteButton = document.createElement("button");
            this.deleteButton.innerHTML = "Delete Record";
            this.rowChild.id = i;
            this.deleteButton.observe('click', this.deleteRange.bind(this, this.rowChild.id));
            this.colChild = this.deleteButton;
            this.rowChild.appendChild(this.colChild);
            this.rateTable.appendChild(this.rowChild);
        }
        this.rowChild = document.createElement("tr");
        this.colChild = document.createElement("td");
        this.addButton = document.createElement("button");
        this.addButton.innerHTML = "Add Record";
        this.addButton.observe('click', this.addRangePrice.bind(this));
        this.colChild = this.addButton;
        this.rowChild.appendChild(this.colChild);
        this.rateTable.appendChild(this.rowChild);

        // this.colChild = document.createElement("td");
        // this.rowChild.appendChild(this.colChild);
        this.popup.style.display = "block";
        this.popupDivContent.appendChild(this.rateTable);
        this.closePopupButton.observe('click', this.closePopup.bind(this));
    },

    closePopup: function () {
        if (this.rateTable) {
            this.popupDivContent.removeChild(this.rateTable);
        }
        this.popup.style.display = "none";
    },
    deleteRange: function (id) {
        document.getElementById(id).remove();
    },
    addRangePrice: function () {
        this.rowChild = document.createElement("tr");
        this.colChild = document.createElement("td");
        // this.input = document.createElement("input");
        // this.input.type = "text";
        // this.colChild.appendChild(this.input);
        this.rowChild.appendChild(this.colChild);
        this.rateTable.appendChild(this.rowChild);
    }
}
