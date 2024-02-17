<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuning Parameters</title>
    <!-- Include necessary CSS and JS libraries for DataTables, Bootstrap, and FontAwesome -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src="fr.js"></script> <!-- Include your French data -->
    <script src="en.js"></script> <!-- Include your English data -->

</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4">Tuning Parameters</h2>
            </div>
            <div class="col-md-6">
                <!-- Language selection dropdown -->
                <div class="form-group">
                    <label for="languageSelect" class="mr-2">Select Language:</label>
                    <select id="languageSelect" class="form-control">
                        <option value="fr" selected>French</option>
                        <option value="en">English</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <!-- Filter row for select elements -->
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <label for="categoryFilter">Category:</label>
                    <select id="categoryFilter" class="form-control">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <label for="parameterFilter">Parameter:</label>
                    <select id="parameterFilter" class="form-control">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <label for="settingFilter">Setting:</label>
                    <select id="settingFilter" class="form-control">
                        <option value=""></option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <table id="tuningTable" class="table table-bordered">
                </table>
            </div>
        </div>
    </div>
</body>

<script src="custom.js"></script> <!-- Include your French data -->

</html>