
    $(document).on('click', '.drop-menu ul.dropdown li', function (e) {
    e.stopPropagation();

    let $dropdown = $(this).closest('.drop-menu');
    let selectedText = $(this).text().trim();
    let selectedId = $(this).data('id') || '';

    // Update only the clicked dropdown's span + hidden input
    $dropdown.find('.select span').first().text(selectedText);
    $dropdown.find('input[type="hidden"]').val(selectedId).trigger('change');

    // Close that dropdown only
    $dropdown.find('ul.dropdown').hide();


});

    $(document).on('click', '.drop-menu > .toggle', function (e) {
        e.stopPropagation(); // stop bubbling to document
        $(this).siblings('ul.dropdown').toggle();
    });
    $(document).on('click', function (e) {
        // if click is NOT inside the dropdown or its toggle, hide it
        if (!$(e.target).closest('.drop-menu').length) {
            $('.drop-menu ul.dropdown').hide();
        }
    });


    document.querySelector("form").addEventListener("submit", function(e){
        const btn = document.getElementById("submitBtn");
        const text = btn.querySelector(".btn-text");
        const svg = btn.querySelector(".btn-icon");

        const spinner = btn.querySelector(".spinner");

        // Disable the button
        btn.disabled = true;

        // Hide SVG and text, show spinner
        text.style.display = "none";
        svg.style.display = "none";
        spinner.style.display = "inline-block";
    });
