var table = null; // Initialize the DataTable instance
$(document).ready(function () {
    // Determine initial language setting
    var cookieData = getFromCookies();
    var initialData = cookieData.language === 'en' ? tuningParametersEN : tuningParametersFR;

    // Initialize DataTable
    initializeDataTable(initialData, cookieData.language);

    // DataTable initialization event
    table.on('init', function () {
        populateSelectFilters();

        // Apply filters from cookies after DataTable initialization
        applyFiltersFromCookies();
    });
});

// Function to apply filters from cookies
function applyFiltersFromCookies() {
    setTimeout(function () {
        $('#categoryFilter').val(getFilterCookie(0)).trigger('change');
        $('#parameterFilter').val(getFilterCookie(1)).trigger('change');
        $('#settingFilter').val(getFilterCookie(2)).trigger('change');
    }, 1000); // Adjust the delay as needed

    table.draw();
}


// Function to initialize DataTable with language and filters
function initializeDataTable(data, language) {
    if (table) {
        // If a DataTable instance already exists, destroy it
        table.destroy();
    }

    // Initialize DataTables with the new data
    table = $('#tuningTable').DataTable({
        paging: true,
        ordering: true,
        searching: true,
        info: true,
        lengthChange: true,
        autoWidth: true,
        pageLength: 50,
        deferRender: true,
        columns: [
            { title: "Category" },
            { title: "Parameter" },
            { title: "Setting" },
            { title: "Explanations" },
            { title: "More Details" },
        ],
        data: data.map(function (parameter) {
            var categoryName = parameter.category.name;
            return parameter.category.parameters.map(function (param) {
                var paramName = param.name;
                return param.settings.map(function (setting) {
                    var settingName = setting.name;
                    var explanations = setting.explanations;
                    var moreDetails = setting["more details"];
                    return [categoryName, paramName, settingName, explanations, moreDetails];
                });
            }).flat();
        }).flat(),
        "order": [],
    });

    // Populate the select filters
    populateSelectFilters();

    // Set the selected language
    if (language) {
        $('#languageSelect').val(language);
    }
}

// Function to populate select filters
function populateSelectFilters() {
    table.columns([0, 1, 2]).every(function () {
        var column = this;
        var columnIndex = column.index();
        var select = null;

        if (columnIndex === 0) {
            select = $('#categoryFilter');
        } else if (columnIndex === 1) {
            select = $('#parameterFilter');
        } else if (columnIndex === 2) {
            select = $('#settingFilter');
        }

        if (select) {
            select.empty();
            select.append('<option value=""></option>');

            column.data().unique().sort().each(function (d, j) {
                select.append('<option value="' + d + '">' + d + '</option>');
            });

            // Set the select filter from the cookie if available
            var filterCookie = getFilterCookie(columnIndex);
            if (filterCookie) {
                select.val(filterCookie);

                // Trigger a search immediately after setting the filter
                var val = $.fn.dataTable.util.escapeRegex(filterCookie);
                column
                    .search(val ? '^' + val + '$' : '', true, false)
                    .draw();
            }

            select.on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                column
                    .search(val ? '^' + val + '$' : '', true, false)
                    .draw();

                // Save the select filter to a cookie when a selection changes
                saveFilterToCookie(columnIndex, val);
            });
        }
    });
}


// Function to save language to cookies
function saveToCookies(language) {
    document.cookie = "selectedLanguage=" + language;
}

// Function to get language from cookies
function getFromCookies() {
    var cookies = document.cookie.split(';');
    var language = null;

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim().split('=');
        if (cookie[0] === 'selectedLanguage') {
            language = cookie[1];
            break; // Found the language cookie, no need to continue
        }
    }

    return { language: language };
}

// Function to save a select filter to a cookie
function saveFilterToCookie(filterIndex, value) {
    document.cookie = "selectFilter_" + filterIndex + "=" + value;
}

// Function to get a select filter from a cookie
function getFilterCookie(filterIndex) {
    var cookieName = "selectFilter_" + filterIndex;
    var cookies = document.cookie.split(';');

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim().split('=');
        if (cookie[0] === cookieName) {
            return decodeURIComponent(cookie[1]); // Ensure proper decoding
        }
    }

    return null; // Return null if no cookie found
}

// Initialize DataTable with language and filters from cookies
var cookieData = getFromCookies();
initializeDataTable(
    cookieData.language === 'en' ? tuningParametersEN : tuningParametersFR,
    cookieData.language
);

// Language selection event listener
$('#languageSelect').on('change', function () {
    var selectedLanguage = $(this).val();

    if (selectedLanguage === 'fr') {
        // Switch to French data
        initializeDataTable(tuningParametersFR, selectedLanguage);
    } else if (selectedLanguage === 'en') {
        // Switch to English data
        initializeDataTable(tuningParametersEN, selectedLanguage);
    }

    // Save language selection to cookies
    saveToCookies(selectedLanguage);
});

