function attachEventListeners() {
        jQuery(document).ready(function ($) {
            $('#loadButton').on('click', function () {
                var searchQuery = $('#searchBox').val();
                $.ajax({
                    url: $(this).data('url'),
                    type: 'POST',
                    data: {
                        form_key: FORM_KEY,
                        query: searchQuery,
                    },
                    success: function (response) {
                        // console.log($('#left'));
                        // $('#left').innerHTML =response;
                        document.body.innerHTML = response;
                        attachEventListeners();

                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            });

            $('#show-items').on('click', function () {
                var searchQuery = $(this).data('name');
                $.ajax({
                    url: $(this).data('url'),
                    type: 'POST',
                    data: {
                        form_key: FORM_KEY,
                        is_ajax: true,
                        name: searchQuery,
                    },
                    success: function (response) {
                        document.body.innerHTML = response;
                        attachEventListeners();

                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            });

        });
    }
    jQuery(document).ready(function () {
        attachEventListeners();
    });

