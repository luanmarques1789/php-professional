<?php

use function PHPSTORM_META\type;

function routes(): array
{
  return require 'routes.php';
}

function router()
{
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $routes = routes();
  $matchedUri = matchExactUriInArrayRoutes($uri, $routes);

  if (empty($matchedUri)) {
    $matchedUri = matchArrayRoutesViaRegEx($uri, $routes);

    // clear '/' of URI's beginning and, after, explode it 
    $explodedUri = explode("/", ltrim($uri, "/"));
    $params = formatParams($explodedUri, $matchedUri);

    echo "<br>";
    var_dump($params);
  }
  die();
}

/**
 * Static routes: match static URIs
 */
function matchExactUriInArrayRoutes(string $uri, array $routes): array
{
  if (array_key_exists($uri, $routes)) {
    echo "Rotas estáticas: " . $uri;
    return [$uri = $routes[$uri]];
  }

  return [];
}

/**
 * Dinamic routes: match dinamic URIs
 */
function matchArrayRoutesViaRegEx(string $uri, array $routes): array
{
  return array_filter(
    $routes,
    function ($route) use ($uri) {

      return preg_match("/^$route$/", $uri);
    },
    ARRAY_FILTER_USE_KEY
  );
}

/**
 * Explode URI in params
 * 
 * @param array $uri cleaned and exploded URI
 * @param array $matchedUri matched URI by routes
 * @return array an array with the params of the URI
 */
function explodeUriInParams(array $uri, array $matchedUri): array
{
  if (!empty($matchedUri)) {

    $matchedToGetParams = array_keys($matchedUri)[0];

    $cleanMatchedToGetParams = ltrim(str_replace("\\", "", $matchedToGetParams), "/");

    return array_diff($uri, explode("/", $cleanMatchedToGetParams));
  }
  return [];
}

/**
 * Convert params' index to params' name
 * 
 * @param array $uri cleaned and exploded URI
 * @param array $matchedUri matched URI by routes
 * @return array an array with the params of the URI
 */
function formatParams(array $uri, array $matchedUri): array
{
  $params = explodeUriInParams($uri, $matchedUri);
  $paramsData = [];

  foreach ($params as $index => $param) {
    $paramsData[$uri[$index - 1]] = $param;
  }
  echo "executou";
  return $paramsData;
}
