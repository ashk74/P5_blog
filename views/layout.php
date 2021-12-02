<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="Description" content="Enter your description here" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.1.3/dist/pulse/bootstrap.min.css" integrity="sha256-d3j6nPvgdSos3dIAmJSHebf76C5yAALgWwcHIom40Mo=" crossorigin="anonymous"/>
        <link rel="stylesheet" href="<?= SCRIPTS . 'css' . DIRECTORY_SEPARATOR . 'style.css' ?>" />
        <title>Blog - Jonathan Secher</title>
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container">
                    <a class="navbar-brand" href="index.php">
                        <i class="fas fa-code fa-2x"></i>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggler-nav" aria-controls="toggler-nav" aria-expanded="false">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="toggler-nav">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php" >Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="blog.php">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.php">Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="signup.php">Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Connexion</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Header -->
            <div class="container-fluid">
                <div class="row">
                    <div class="hero-blog"></div>
                </div>
            </div>
        </header>

        <section class="container mt-4">
            <div class="row">
                <div class="input-group col-12 mb-4">
                    <input type="text" class="form-control" placeholder="Rechercher">
                    <button class="btn btn-lg btn-primary" type="button" id="button-addon2"><i class="fas fa-search fa-sm  "></i></button>
                </div>
            </div>
            <?= $pageContent ?>
            <div class="row">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white">
            <div class="container py-4">
                <div class="row">
                    <!-- Footer - Menu -->
                    <div class="col-sm-12 col-lg-8 text-start">
                        <h3 class="text-uppercase">Menu</h3>
                        <ul class="footer-items list-unstyled">
                            <li>
                                <a href="index.php">Accueil</a>
                            </li>
                            <li class="text-bold">
                                <a href="blog.php">Blog</a>
                            </li>
                            <li>
                                <a href="contact.php">Contact</a>
                            </li>
                            <li>
                                <a href="signup.php">Inscription</a>
                            </li>
                            <li>
                                <a href="login.php">Connexion</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Footer - Social media -->
                    <div class="footer-items col-sm-12 col-lg-4 text-end">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="https://github.com/ashk74" target="_blank" rel="noopener noreferrer" ><i class="fab fa-github fa-3x"></i></a>
                            </li>
                            <li class="list-inline-item ms-4 mx-4">
                                <a href="#" target="_blank" rel="noopener noreferrer" ><i class="fab fa-linkedin-in fa-3x"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" target="_blank" rel="noopener noreferrer" ><i class="fab fa-twitter fa-3x"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer - Copyright -->
            <div class="copyright text-center py-2">
                <span>Jonathan Secher - Copyright © 2021</span> 
            </div>
        </footer>
        <script  src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/54ac40310e.js" crossorigin="anonymous"></script>
    </body>
</html>