<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="/css/templateStyle.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



  <title>
    Welcome to Max's bin!
  </title>
</head>
<header class="navbar fixed-top">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class=" p-4">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <div class="nav-item ml-1"><a title="ab" href='/Pages/homeredirect'>Home</a></div>
        </li>
        <li class="nav-item ml-1">
          <div class="nav-item "><a title="ab" href='/Pages/aboutredirect'>About</a></div>
        </li>
        <li class="nav-item ml-1">
          <div class="nav-item"><a title="ab" href='<?php if (isset($_SESSION['id'])) {
                                                      echo '/profile';
                                                    } else {
                                                      echo '/login';
                                                    } ?>'>Account</a></div>
        </li>
        <li class="nav-item ml-1">
          <div class="nav-item"><?php if (isset($_SESSION['name'])) {
                                  echo "Currently logged in: ", $_SESSION['name'];
                                } ?></div>
        </li>
        <li class="nav-item ml-1">
          <form class="form-inline my-2 my-lg-0" action="/SearchController/index" method="post">
          <?= csrf_field() ?>  
          <input class="form-control mr-sm-2" name ="search" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            <div class="form-group d-inline-flex">
              <select class="form-control" id="searchtype" name="searchtype">
                <option>Search by itemname</option>
                <option>Search by seller</option>
                <option>Search max price</option>
                <option>Search user</option>
              </select>
            </div>
          </form>
        </li>
      </ul>
      
    </div>
  </div>
  <nav class="navbar navbar-dark">
    <div class="container-fluid">
      <button class="navbar-toggler bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>
</header>


<body class=" min-vh-100 ownBgColor">