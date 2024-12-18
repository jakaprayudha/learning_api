<?php

class WikiController
{
   private $baseUrl;

   public function __construct()
   {
      $this->baseUrl = "https://en.wikipedia.org/w/rest.php/v1/search/page";
   }

   /**
    * Fetch data from Wikipedia API
    *
    * @param string $query The search query
    * @param int $limit Number of results to fetch
    * @return array
    */
   public function fetchWikiData($query, $limit = 1)
   {
      // Construct the full URL with query parameters
      $url = $this->baseUrl . "?q=" . urlencode($query) . "&limit=" . $limit;

      // Use cURL instead of file_get_contents for better error handling
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FAILONERROR, true);

      $response = curl_exec($ch);
      $error = curl_error($ch);
      curl_close($ch);

      // Handle cURL errors
      if ($response === false) {
         return ['error' => 'Failed to fetch data from Wikipedia API: ' . $error];
      }

      // Decode JSON response
      $data = json_decode($response, true);

      // Validate the response structure
      if (!isset($data['pages'])) {
         return ['error' => 'Invalid response from Wikipedia API.'];
      }

      return $data;
   }
}
