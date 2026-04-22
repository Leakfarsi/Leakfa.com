/*
Author:         Leakfa Team
Author URI:     https://leakfa.com
Version:        1.2.0
*/

$(document).ready(function () {
    var tagDetailsEl = document.getElementById('breachesGrid');
    var tag_details = [];
    try {
        tag_details = JSON.parse(tagDetailsEl.getAttribute('data-tag-details') || '[]');
    } catch (e) {
        console.error('Failed to parse tag details:', e);
    }

    var activeTagFilter = null;

    $('[data-tag-id]').click(function () {
        var tagId = $(this).attr('data-tag-id');
        var tag_detail = tag_details.filter(function (x) { return x.id == tagId; })[0];
        if (!tag_detail) return;
        Swal.fire({
            icon: 'info',
            title: tag_detail.name,
            text: tag_detail.description,
            confirmButtonText: 'باشه!'
        });
    });

    $('.copy-link-btn').click(function (e) {
        e.stopPropagation();
        var anchorLink = $(this).attr('data-anchor');
        var url = window.location.origin + window.location.pathname + '#' + anchorLink;

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(function () {
                Swal.fire({
                    icon: 'success',
                    title: 'آدرس کپی شد!',
                    text: 'آدرس روایت این نشت در کلیپ‌بورد شما کپی شد.',
                    confirmButtonText: 'باشه!'
                });
            });
        } else {
            var tempInput = document.createElement('input');
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            Swal.fire({
                icon: 'success',
                title: 'آدرس کپی شد!',
                text: 'آدرس روایت این نشت در کلیپ‌بورد شما کپی شد.',
                confirmButtonText: 'باشه!'
            });
        }
    });

    $('.title').click(function () {
        $(this).closest('.title-wrap').find('.copy-link-btn').trigger('click');
    });

    $('#disclaimerToggle').on('click keypress', function (e) {
        if (e.type === 'keypress' && e.which !== 13 && e.which !== 32) return;
        e.preventDefault();
        var body = $('#disclaimerBody');
        var isOpen = body.hasClass('open');
        body.toggleClass('open');
        $(this).attr('aria-expanded', !isOpen);
        $(this).find('.disclaimer-chevron').toggleClass('rotated');
    });

    $('#breachSearch').on('input', function () {
        $('#searchClear').toggleClass('visible', $(this).val().length > 0);
        filterBreaches();
    });

    $('#searchClear').on('click', function () {
        $('#breachSearch').val('').trigger('input').focus();
    });

    $('#breachSort').on('change', function () {
        var sortBy = $(this).val();
        var grid = $('#breachesGrid');
        var cards = grid.children('.breach').detach().toArray();

        cards.sort(function (a, b) {
            if (sortBy === 'magnitude') {
                return parseFloat($(b).data('magnitude')) - parseFloat($(a).data('magnitude'));
            } else {
                return $(a).data('name').localeCompare($(b).data('name'), 'fa');
            }
        });

        $.each(cards, function (i, card) {
            grid.append(card);
        });
    });

    $('.tag-chip[data-filter-tag]').on('click', function () {
        var tagId = $(this).data('filter-tag');

        if (activeTagFilter == tagId) {
            activeTagFilter = null;
            $(this).removeClass('active');
            $('#clearTagFilter').hide();
        } else {
            activeTagFilter = tagId;
            $('.tag-chip[data-filter-tag]').removeClass('active');
            $(this).addClass('active');
            $('#clearTagFilter').show();
        }
        updateTagBadge();
        filterBreaches();
    });

    $('#clearTagFilter').on('click', function () {
        activeTagFilter = null;
        $('.tag-chip[data-filter-tag]').removeClass('active');
        $(this).hide();
        $('#tagActiveCount').hide();
        $('#tagToggleBtn').removeClass('has-filter');
        filterBreaches();
    });

    $('#tagToggleBtn').on('click', function () {
        $('#tagFilterChips').toggleClass('chips-visible');
        $(this).toggleClass('active');
    });

    function updateTagBadge() {
        if (activeTagFilter) {
            $('#tagActiveCount').text('۱').show();
            $('#tagToggleBtn').addClass('has-filter');
        } else {
            $('#tagActiveCount').hide();
            $('#tagToggleBtn').removeClass('has-filter');
        }
    }

    function filterBreaches() {
        var searchTerm = $('#breachSearch').val().toLowerCase().trim();
        var visibleCount = 0;

        $('#breachesGrid .breach').each(function () {
            var name = $(this).data('name').toLowerCase();
            var tags = String($(this).data('tags'));
            var matchSearch = !searchTerm || name.indexOf(searchTerm) !== -1;
            var matchTag = !activeTagFilter || tags.split(',').indexOf(String(activeTagFilter)) !== -1;

            if (matchSearch && matchTag) {
                $(this).removeClass('breach-hidden');
                visibleCount++;
            } else {
                $(this).addClass('breach-hidden');
            }
        });

        $('#noResults').toggle(visibleCount === 0);
    }
});
