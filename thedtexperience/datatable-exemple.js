var people = [];
var names = [
  "Emma",
  "Liam",
  "Olivia",
  "Noah",
  "Ava",
  "William",
  "Isabella",
  "James",
  "Sophia",
  "Oliver",
  "Jean-Paul",
  "Jean-Paul II",
];
var surnames = [
  "Smith",
  "Johnson",
  "Williams",
  "Brown",
  "Jones",
  "Garcia",
  "Miller",
  "Davis",
  "Rodriguez",
  "Martinez",
];
var cities = [
  "New York",
  "Los Angeles",
  "Chicago",
  "Houston",
  "Phoenix",
  "Philadelphia",
  "San Antonio",
  "San Diego",
  "Dallas",
];
var countries = [
  "United States",
  "Canada",
  "Mexico",
  "United Kingdom",
  "Germany",
  "France",
  "Spain",
  "Italy",
];

for (var i = 0; i < 200; i++) {
  var person = {
    name: names[Math.floor(Math.random() * names.length)],
    surname: surnames[Math.floor(Math.random() * surnames.length)],
    age: Math.floor(Math.random() * 100),
    birthday:
      Math.floor(Math.random() * 12) +
      1 +
      "/" +
      (Math.floor(Math.random() * 28) + 1) +
      "/" +
      (Math.floor(Math.random() * 100) + 1920),
    cityOfBirth: cities[Math.floor(Math.random() * cities.length)],
    countryOfOrigin: countries[Math.floor(Math.random() * countries.length)],
  };
  people.push(person);
}

$(document).ready(function () {
  // BOF JQUERY
  $("#myTable").DataTable({
    paging: true,
    ordering: true,
    searching: true,
    info: true,
    lengthChange: true,
    autoWidth: true,
    columns: [
      { title: "name" },
      { title: "surname" },
      { title: "age" },
      { title: "birthday" },
      { title: "cityOfBirth" },
      { title: "countryOfOrigin" },
    ],
  });

  var table = $("#myTable").DataTable();

  people.forEach((person) => {
    table.row
      .add([
        person.name,
        person.surname,
        person.age,
        person.birthday,
        person.cityOfBirth,
        person.countryOfOrigin,
      ])
      .draw();
  });

  // BOF SEARCH FOOTER SELECTS
  // Recherche dans footer par select
  table.columns().every(function () {
    var column = this;
    var select = $('<select><option value=""></option></select>')
      .appendTo($(column.footer()).empty())
      .on("change", function () {
        var val = $.fn.dataTable.util.escapeRegex($(this).val());

        column.search(val ? "^" + val + "$" : "", true, false).draw();
      });

    column
      .data()
      .unique()
      .sort()
      .each(function (d, j) {
        select.append('<option value="' + d + '">' + d + "</option>");
      });
  });
  // EOF SEARCH FOOTER SELECTS

  // EOF SEARCH FOOTER TEXT INPUTS
  // Recherche dans footer par input text
  // $('#myTable tfoot th').each(function () {
  //     var title = $(this).text();
  //     $(this).html('<input type="text" placeholder="Search ' + title + '" />');
  // });

  // table.columns()
  //     .every(function () {
  //         var that = this;

  //         $('input', this.footer()).on('keyup change clear', function () {
  //             if (that.search() !== this.value) {
  //                 that.search(this.value).draw();
  //             }
  //         });
  //     });
  // EOF SEARCH FOOTER TEXT INPUTS

  // BOF TEXT INPUT SEARCH SPECIFIC COLUMN
  // #name_search is a <input type="text"> element
  $("#name_search").on("keyup", function () {
    // Search the third column of the table
    table
      .columns(0)
      // Set the search term to the value of the input
      /*
       * 0 -> name
       * 1 -> surname
       * 2 -> age
       * 3 -> birthday
       * 4 -> cityOfBirth
       * 5 -> countryOfOrigin
       */
      .search(
        // value to search
        this.value,
        // Treat the search term as a regular expression (default: false)
        false,
        // smart search (default: true)
        true,
        // Make the search case-insensitive (default: true)
        true
      )
      // Update the table with the search results
      .draw();
  });
  // EOF TEXT INPUT SEARCH SPECIFIC COLUMN

  // BOF SELECT SEARCH SPECIFIC COLUMN
  table.columns([5]).every(function () {
    var column = this;
    var select = $("#country_search").on("change", function () {
      var val = $.fn.dataTable.util.escapeRegex(
        $("#country_search option:selected").text()
      );
      column
        .search(
          // value to search
          this.value,
          // Treat the search term as a regular expression (default: false)
          true,
          // smart search (default: true)
          false,
          // Make the search case-insensitive (default: true)
          true
        )
        .draw();
    });
    column
      .data()
      .unique()
      .sort()
      .each(function (d, j) {
        select.append('<option value="' + d + '">' + d + "</option>");
      });
  });
  // EOF SELECT SEARCH SPECIFIC COLUMN
}); // EOF JQUERY
