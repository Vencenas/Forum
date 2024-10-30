<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VencisForum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    .my-custom-row {
        border: solid black 1px;
    }
    .my-custom-col {
        border: solid black 1px;
    }
    .custom-border {
        padding-bottom: 12px;
    }
    .post {
        background-color: lightblue;

    }
    .user-info {
        background-color: rgb(86, 152, 173);
    }
    .post-info {
        background-color: rgb(191, 235, 250);
        justify-content: flex-end;
        display: flex;
    } 
    .picoviny {
        padding-left: 12px;
        font-size: 20px;
    }
    
    
</style>
</head>
<body> 
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">VencisForum</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
              </li> -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Kategorie
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Všechny Kategorie</a></li>
                  <li><a class="dropdown-item" href="#">Gaming</a></li>
                  <!-- <li><hr class="dropdown-divider"></li> -->
                  <li><a class="dropdown-item" href="#">Vaření</a></li>
                  <li><a class="dropdown-item" href="#">Coding</a></li>
                  <li><a class="dropdown-item" href="#">Meals</a></li>

                
                </ul>
              </li>
            </ul>
             <!--  <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>  -->
            <nav class="navbar bg-body-tertiary">
                <div class="container-fluid">
                  <a class="navbar-brand" href="user.html">
                    Uživatel <i class="fa-solid fa-user"></i>
                  </a>
                </div>
              </nav>
          </div>
        </div>
      </nav>
      <!-- konec navigace což  je sice  vidět ale pro Vencovi oči je to momentálně lepší takhle odděleně komentem :D    -->
      <!-- přidaní příspěvku -->
      <div class="container text-center">
        <div class="row align-items-center">
            <div class="col" style="padding-top: 12px"><a href=""><i class="fa-solid fa-circle-plus"></i></a> Přidat příspěvěk</div>
            <div class="col">                                 
            </div>
            <div class="col"></div>
        </div>
    </div>
    <!-- natvrdo vložené příspěvky z "databaze" přes HTML -->
    <!-- post var 1-->
    <div class="container custom-border">
        <div class="row">
            <div class="user-info"> $username $categories </div>
        </div>
        <div class="row">
            <div class="post">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam repellendus a sequi fugiat beatae illum recusandae perspiciatis. Laudantium beatae, officiis delectus totam sapiente et itaque quas repudiandae eos natus magni omnis, eligendi architecto unde dolore maxime blanditiis fugiat expedita. Neque aliquam, quia dicta nihil sapiente soluta dolore impedit ipsa et. Accusamus iusto incidunt dicta cumque odit, molestias labore in adipisci voluptas ut assumenda. Quas fugit, ipsum quod perferendis at impedit, ducimus illum recusandae nobis, dolores distinctio facilis dolorem quam in necessitatibus aut eaque ullam quidem officia nisi rerum mollitia? Maiores error recusandae incidunt laboriosam ex optio voluptatibus dolore voluptatem mollitia.</div>
        </div>
        <div class="row post-info">
                       
            <div class="post-info">
                <div class="picoviny">$timestamp $likes</div>
                <div class="picoviny"><a href=""><i class="fa-solid fa-thumbs-up"></i></a></div>
                <div class="picoviny"></div><button type="button" class="btn btn-primary" id="addComment">Přidat komentář</button></div>
        </div>
    </div>
    <!-- možnost post 2-->
    <div class="container">
        <div class="row my-custom-row">
            <div class="col-sm-1 col-md-1 col-lg-1 my-custom-col"> $username $categories $timestamp $likes</div>
            <div class="col-sm-9 col-md-9 col-lg-9 my-custom-col">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad nulla suscipit animi soluta obcaecati! Qui tempore iusto, sapiente quasi non similique voluptates deleniti inventore suscipit veritatis ex hic illo veniam quisquam ab voluptatum consequatur sit repellendus dolorem dolor unde earum. Molestiae porro nihil a adipisci iure vitae cumque architecto hic, ex iusto sed earum doloremque accusamus, expedita nulla facere labore consequatur voluptatem reiciendis? Minus eaque molestiae iste nulla esse consectetur pariatur quaerat cum porro rerum laboriosam voluptates minima aliquam dicta numquam, exercitationem repudiandae incidunt, vero perferendis ad ipsa cupiditate velit temporibus? Autem aperiam impedit officiis, delectus minus quasi temporibus labore vel magni id fuga aspernatur, ex et? Voluptatum doloribus, tempore voluptate odio temporibus, vitae provident, officia error qui voluptates magni nam repellendus. Blanditiis minima suscipit assumenda fugit similique cum quo quisquam? Autem aperiam unde in! Ullam blanditiis accusantium, reiciendis illum vero molestiae suscipit corporis tempore cupiditate! Repellendus, quaerat. Similique corrupti repellendus error voluptatem ea rerum quibusdam alias provident recusandae officia omnis vitae assumenda, itaque quia ipsa pariatur officiis velit odio minima facilis animi iste, suscipit debitis eaque. Animi natus, earum similique molestias consectetur consequatur placeat culpa molestiae eligendi asperiores maiores, praesentium at tenetur assumenda eius tempora, totam sequi debitis consequuntur?</div>             
        </div>
        <div class="row my-custom-row">
            <div class="col-lg-9"></div>    
            <div class="col-lg-1">                
                <a href=""><i class="fa-solid fa-thumbs-up"></i></a>
            </div>
            <div class="col-lg-1"><button id="comment">Přidat&nbsp;komentář</button>
            </div>    
        </div>  
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>