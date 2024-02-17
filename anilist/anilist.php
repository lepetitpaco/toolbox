<?php
// This code imports Guzzle for requests and defines two functions: anilistAuthorizationUrl() and getUserActivity().
// anilistAuthorizationUrl() returns a URL for OAuth authorization.
// getUserActivity() takes in a user ID, page number, and number of items per page, and returns a list of activities for that user.

/**
 * Returns the user ID for a given username.
 *
 * @param string $username The username to retrieve the ID for.
 * @return int The user ID.
 */
function getUserId($username)

{
	// Create a new Guzzle HTTP client
	$http = new GuzzleHttp\Client;

	// Define the GraphQL query to retrieve user ID
	$query = '
 	query{
   User(search: "' . $username . '") {
     id
   }
 }
 	';

	// Send a POST request to the AniList GraphQL API with the query
	$response = $http->post('https://graphql.anilist.co', [
		'headers' => [
			'Content-Type' => 'application/json',
			'Accept' => 'application/json',
		],
		'json' => [
			'query' => $query,
		]
	]);

	// Get the response body and decode it from JSON to an associative array
	$responsedatas = $response->getBody()->getContents();
	$datas = json_decode($responsedatas, true);
	$data = $datas["data"];
	return $data["User"]["id"];
}


/**
 * Returns the user datas for a given user ID.
 *
 * @param int $userId The user ID to retrieve the datas for.
 * @return array The user datas.
 */
function getUserDatas($userId)

{
	// Create a new Guzzle HTTP client
	$http = new GuzzleHttp\Client;
	$data = "";

	// Define the GraphQL query to retrieve user datas
	$query = '
 	query{
   User(id: ' . $userId . ') {
     id
     name

     bannerImage
     avatar {
       medium
     }
   }
 }
 	';

	try {
		// Send a POST request to the AniList GraphQL API with the query
		$response = $http->post('https://graphql.anilist.co', [
			'headers' => [
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
			],
			'json' => [
				'query' => $query,
			]
		]);
	} catch (Exception $e) {
		echo 'Caught exception: ', $e->getMessage(), "\n";
	}


	// Get the response body and decode it from JSON to an associative array
	$responsedatas = $response->getBody()->getContents();
	$datas = json_decode($responsedatas, true);
	$data = $datas["data"];
	return $data["User"];
}

/**
 * Returns a list of activities for a given user ID, page number, and number of items per page.
 *
 * @param int $userId The user ID to retrieve activities for.
 * @param int $page The page number to retrieve activities from.
 * @param int $perPage The number of items per page to retrieve.
 * @return array The list of activities.
 */
function getUserActivity($userId, $page, $perPage)

{
	// Create a new Guzzle HTTP client
	$http = new GuzzleHttp\Client;
	$data = "";

	// Define the GraphQL query to retrieve user activity
	$query = '
 	query{
   Page(page: ' . $page . ', perPage: ' . $perPage . ') {
	pageInfo {
      hasNextPage,
      currentPage,
      lastPage
    }
     activities(isFollowing: true, sort: ID_DESC, userId: ' . $userId . ') {
            ... on ListActivity {
         id
         userId
         type
         status
         progress
         replyCount
         createdAt
 				siteUrl
         user {
           id
           name
           avatar {
             medium
           }
         }
         media {
           id
           title {
             userPreferred
           }
           siteUrl
 					coverImage{
 						medium
 						large
 					}
         }
       }
     }
   }
 }
 	';

	// Send a POST request to the AniList GraphQL API with the query
	$response = $http->post('https://graphql.anilist.co', [
		'headers' => [
			// 'Authorization' => 'Bearer ' . $_COOKIE["access_token"],
			'Content-Type' => 'application/json',
			'Accept' => 'application/json',
		],
		'json' => [
			'query' => $query,
		]
	]);

	// Get the response body and decode it from JSON to an associative array
	$responsedatas = $response->getBody()->getContents();
	$datas = json_decode($responsedatas, true);
	$data = $datas["data"];
	return $data;
}