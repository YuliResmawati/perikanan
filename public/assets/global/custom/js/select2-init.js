/* Select2 Init*/
function modelMatcher(params, data) {
    data.parentText = data.parentText || "";

    // Always return the object if there is nothing to compare
    if ($.trim(params.term) === '') {
        return data;
    }

    // Do a recursive check for options with children
    if (data.children && data.children.length > 0) {
        // Clone the data object if there are children
        // This is required as we modify the object to remove any non-matches
        var match = $.extend(true, {}, data);

        // Check each child of the option
        for (var c = data.children.length - 1; c >= 0; c--) {
            var child = data.children[c];
            child.parentText += data.parentText + " " + data.text;

            var matches = modelMatcher(params, child);

            // If there wasn't a match, remove the object in the array
            if (matches == null) {
                match.children.splice(c, 1);
            }
        }

        // If any children matched, return the new object
        if (match.children.length > 0) {
            return match;
        }

        // If there were no matching children, check just the plain object
        return modelMatcher(params, match);
    }

    // If the typed-in term matches the text of this term, or the text from any
    // parent term, then it's a match.
    var original = (data.parentText + ' ' + data.text).toUpperCase();
    var term = params.term.toUpperCase();

    // Check if the text contains the term
    if (original.indexOf(term) > -1) {
        return data;
    }

    // If it doesn't contain the term, don't return anything
    return null;
}

function init_select2() {
    "use strict";
    $(".select2").select2({
        matcher: modelMatcher,
    });
    $(".select2[data-search='false']").select2({
        minimumResultsForSearch: Infinity
    });
    $(".select2[data-search='false']").on('select2:opening select2:closing', function (event) {

        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
    });
    $("#input_tags").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });
}

function init_ajax_select2(options){
    if(options.type == undefined) {
        options.type = "post";
    }

    options.element.select2({
        language: "id",
        ajax: { 
          url: options.url,
          type: options.type,
          dataType: 'json',
          delay: 200,
          data: function (params) {
             let data = options.data;
             let search = {searchTerm: params.term};

             return Object.assign(data, search);
          },
          processResults: function (response) {
             return {
                results: response.data
             };
          },
          cache: true
        }
    });
}

 function init_ajax_select2_paging(options) {
    if (options.type == undefined) {
        options.type = "post";
    }

    if (options.minimunLength == undefined) {
        options.minimunLength = 3;
    }

    options.element.select2({
        language: "id",
        ajax: { 
            url: options.url,
            type: options.type,
            dataType: 'json',
            delay: 250,
            data: function (params) {
               let data = options.data;
               let search = {search: params.term};
               let page = {page: params.page};
     
               return Object.assign(data, search, page);
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: options.placeholder,
        minimumInputLength: options.minimunLength,
        templateResult: format,
        templateSelection: formatSelection
    });
}

function format(repo) {
    if (repo.loading) {
       return repo.text;
    }

    var $container = $(
       "<div class='select2-result-repository clearfix'>" +
       "<div class='select2-result-repository__title'></div>" +
       "</div>"
    );

    $container.find(".select2-result-repository__title").text(repo.text);

    return $container;
 }

 function formatSelection(repo) {
    return repo.text;
 }

init_select2();