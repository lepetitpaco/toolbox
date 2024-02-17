<?php
// Debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// import stuff
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/anilist.php';
?>

<?php
// This function gets user information based on their username
/**
 * Retrieves user information from AniList API
 *
 * @param string $username The username of the user to retrieve information for
 * @return array An array containing the user's avatar, name, description, and background image
 */
function getUserInfos($username)
{
    // Check if the username is set in the URL parameters, otherwise use default username
    if (isset($_GET['user'])) {
        $username = $_GET['user'];
    } else {
        $username = "lepetitpaco";
    }

    // Get the user ID from AniList API
    $user_id = getUserId($username);

    // Get the user data from AniList API
    $user_data = getUserDatas($user_id);

    // Extract the necessary information from the user data
    $avatar = "";
    $name = "";
    $description = "";
    $bgimg = "";

    if(isset($user_data['avatar']['medium'])){
        $avatar = $user_data['avatar']['medium'];
    }

    if(isset($user_data['name'])){
        $name = $user_data['name'];
    }

    if(isset($user_data['about'])){
        $description = $user_data['about'];
    }

    if(isset($user_data['bannerImage'])){
        $bgimg = $user_data['bannerImage'];
    }


    // Return an array with the extracted information
    return array($avatar, $name, $description, $bgimg);
}

// Call the getUserInfos function with the default username and store the returned values in variables
list($avatar, $name, $description, $bgimg) = getUserInfos("lepetitpaco");



// Get user activity
/**
 * Retrieves user activity from AniList API
 *
 * @param int $page The page number to retrieve
 * @param int $maxPages The maximum number of pages to retrieve
 * @return array The user activity data
 */
function getActivity($page, $maxPages)
{
    $data = array();

    // Get the username from the URL parameters, otherwise use default username
    if (isset($_GET['user'])) {
        $username = $_GET['user'];
    } else {
        $username = "lepetitpaco";
    }

    // Get the user ID from AniList API
    $user_id = getUserId($username);

    // Get the user activity data from AniList API
    $user_activity = getUserActivity($user_id, $page, 50);

    // Add the data from the current page to the result array
    $data = array_merge($data, $user_activity['Page']['activities']);

    // If there is a next page and we haven't reached the maximum number of pages,
    // make a recursive call to get the data from the next page
    if (isset($user_activity['Page']['pageInfo']) && $page < $maxPages) {
        $data = array_merge($data, getActivity($page + 1, $maxPages));
    }

    return $data;
}

/**
 * Retrieves user activity from AniList API
 *
 * @param int $page The page number to retrieve
 * @param int $maxPages The maximum number of pages to retrieve
 * @param string $username The username of the user to retrieve information for
 * @return array The user activity data
 */
$maxPages = isset($_GET['maxPages']) ? $_GET['maxPages'] : 3;
if ($maxPages > 10) {
    $maxPages = 10;
}
$useractivity = getActivity(1, $maxPages);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paco's Weebsite</title>

    <!-- javascript files -->
    <script src="assets/js/jquery-3.6.4.min.js?preload"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/responsive.bootstrap4.min.js  "></script>
    <script src="assets/js/rowReorder.bootstrap4.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/moment-with-locales.js"></script>
    <script src="assets/js/rowGroup.bootstrap4.min.js"></script>

    <!-- css files -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/rowGroup.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/spacers.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/rowReorder.bootstrap4.min.css">
</head> <!-- end of head section -->

<body>

    <?php

    if (empty($bgimg)) {
        $bgimg = get_stylesheet_directory_uri() . '/images/default.jpg';
    }
    ?>

    <div class="subheader"
        style="background:url(<?php echo $bgimg ?>) no-repeat center center transparent;background-size:cover;">
    </div>

    <div class="container">
        <div class="negative-row">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="profile-wrapper">
                        <div class="profile-image">
                            <img src="<?php echo $avatar ?>" alt="">
                        </div>
                        <div class="profile-title">
                            <?php echo $name ?>
                        </div>
                        <?php
                        if (isset($_GET['user'])) {
                            $username = $_GET['user'];
                        } else {
                            $username = "lepetitpaco";
                        }
                        ?>
                        <?php if ($username == "lepetitpaco"): ?>
                            <div class="card-title">
                                Bio
                            </div>
                            <div class="profile-bio">
                                <?php echo "Hi, I'm Paco and I want to return to monke" ?>
                            </div>
                            <div class="profile-details">
                                <div class="card-title">
                                    Interests
                                </div>
                                <ul>
                                    <li>
                                        <a href="https://anilist.co/user/lepetitpaco/animelist" target="_blank">Animes</a>
                                    </li>
                                    <li>
                                        <a href="https://anilist.co/user/lepetitpaco/mangalist" target="_blank">Mangas</a>
                                    </li>
                                    <li>
                                        <a href="https://anilist.co/user/lepetitpaco/mangalist/Manhwas%20(SK)"
                                            target="_blank">Manhwas</a>
                                    </li>
                                    <li>
                                        <a href="https://anilist.co/user/lepetitpaco/mangalist/Manhuas%20(C)"
                                            target="_blank">Manhuas</a>
                                    </li>
                                    <li>
                                        <a href="https://www.novelupdates.com/user/78620/lepetitpaco/"
                                            target="_blank">Novels</a>
                                    </li>
                                    <li>
                                        <a href="https://volt.fm/lepetitpaco" target="_blank">Music</a>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-xs-5 mb-xs-5">
            <select id="type_activity_search">
                <option value="">All Activities</option>
                <option value="plans to watch">Plans to Watch</option>
                <option value="plans to read">Plans to Read</option>
                <option value="watched">Watched</option>
                <option value="read chapter">Read</option>
                <option value="dropped">Dropped</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="col-12">
            <table id="feedTable">
                <thead>
                    <tr>
                        <th><b>Thumbnail</th>
                        <th><b>Title</th>
                        <th><b>What Happened</th>
                        <th><b>When</th>
                        <th><b>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($useractivity as $oneactivity): ?>
                        <?php

                        if (empty($oneactivity))
                            continue;

                        if (isset($oneactivity['user'])) {
                            $username = $oneactivity['user']['name'];
                            $avatar = $oneactivity['user']['avatar']['medium'];
                        }

                        if (isset($oneactivity['siteUrl'])) {
                            $activityurl = $oneactivity['siteUrl'];
                        }

                        if (isset($oneactivity['type'])) {
                            $mediatype = $oneactivity['type']; //manga or anime
                        }

                        $progress = "";
                        if (isset($oneactivity['progress'])) {
                            $progress = $oneactivity['progress']; //number consummed
                        }

                        if (isset($oneactivity['status'])) {
                            $status = $oneactivity['status']; //what happened
                        }

                        if (isset($oneactivity['media']['title']['userPreferred'])) {
                            $mediatitle = $oneactivity['media']['title']['userPreferred'];
                        }

                        if (isset($oneactivity['media']['siteUrl'])) {
                            $mediaurl = $oneactivity['media']['siteUrl'];
                        }

                        if (isset($oneactivity['media']['coverImage']['large'])) {
                            $mediaimage = $oneactivity['media']['coverImage']['large'];
                        }

                        if (isset($oneactivity['createdAt'])) {
                            $activitytime = $oneactivity['createdAt'];
                        }

                        $currentDate = date('d/m');
                        $yesterday = date('d/m', strtotime("-1 days"));

                        $whatinfo = "";
                        if ($mediatype == 'ANIME_LIST' || $mediatype == 'MANGA_LIST' && $status == "plans to read" || $status == "completed" || $status == "dropped") {
                            $whatinfo = $status;
                        }
                        if ($mediatype == 'ANIME_LIST' || $mediatype == 'MANGA_LIST' && $status == "watched episode" || $status == "read chapter") {
                            $whatinfo = $status . ' ' . $progress;
                        }
                        ?>

                        <?php if (!empty($mediatitle)): ?>
                            <tr>
                                <td class="text-center">
                                    <img style="width: 100px;" src="<?php echo $mediaimage; ?>" alt="">
                                </td>
                                <td>
                                    <?php print_r($mediatitle) ?>
                                </td>
                                <td>
                                    <?php print_r($whatinfo); ?>

                                </td>
                                <td>
                                    <?php print_r($activitytime); ?>
                                </td>
                                <td>
                                    <a class="activity-link btn-base orange mb-xs-2" href="<?php echo $mediaurl ?>"
                                        target="_blank">
                                        <?php echo $mediatitle; ?>
                                    </a>
                                    <a class="activity-link btn-base orange" href="<?php echo $activityurl ?>" target="_blank">
                                        Check Activity
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        // BOF JQUERY
        jQuery(document).ready(function ($) {

            $('#feedTable').DataTable({
                paging: true,
                ordering: true,
                searching: true,
                info: true,
                lengthChange: true,
                autoWidth: false,
                columnDefs: [
                    {
                        targets: 3, // The index of the column containing the date
                        render: function (data, type, row) {
                            if (type === 'sort') {
                                // Convert the date to a timestamp for sorting
                                return moment.unix(data, 'DD/MM/YYYY ').valueOf();
                            }
                            // Use moment.js to format the date
                            return moment.unix(data).format('dddd DD/MM/YYYY, hh:mm a');
                        }
                    },
                ],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'colvis'
                ],
            });

            var table = $('#feedTable').DataTable();

            // BOF SELECT SEARCH SPECIFIC COLUMN
            table.columns([2]).every(function () {
                var column = this;
                var select = $('#type_activity_search').on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $('#country_search option:selected').text()
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

            });
            // EOF SELECT SEARCH SPECIFIC COLUMN

        }); // EOF JQUERY
    </script>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const maxPages = urlParams.get('maxPages');
        if (maxPages > 10) {
            urlParams.set('maxPages', '10');
            window.location.search = urlParams.toString();
        }

    </script>

</body>

</html>