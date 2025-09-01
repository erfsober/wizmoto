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


