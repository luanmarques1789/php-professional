 <?php

  return [
    '/' => 'Home@index',
    '/user' => 'User@index',
    '\/user\/[0-9]+\/profile' => 'User@profile',
    '\/user\/[0-9]+' => 'User@user',
    '\/user\/[0-9]+\/name\/[a-z]+' => 'User@show',
  ];

  ?>