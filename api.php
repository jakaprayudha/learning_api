<?php
class MovieController
{
   private $apiKey;

   public function __construct($apiKey)
   {
      $this->apiKey = $apiKey;
   }

   public function fetchMovies($searchTerm)
   {
      $url = "http://www.omdbapi.com/?apikey={$this->apiKey}&s=" . urlencode($searchTerm);
      $response = file_get_contents($url);

      if ($response === false) {
         return ['error' => 'Failed to fetch data from API.'];
      }

      $data = json_decode($response, true);

      if (isset($data['Response']) && $data['Response'] === 'False') {
         return ['error' => $data['Error']];
      }

      return $data;
   }
}

// Jika ada query `search`, proses dan kembalikan JSON
if (isset($_GET['search'])) {
   $searchTerm = $_GET['search'];
   $movieController = new MovieController("a106cbde");
   $movies = $movieController->fetchMovies($searchTerm);

   header('Content-Type: application/json');
   echo json_encode($movies);
   exit;
}
