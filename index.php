<?php 
// require_once "api.php";
$total_records = 100;
$limit = 3;
$no_of_pages = ceil($total_records / $limit);
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$offset = (($page - 1) * $limit) + 300;
$data = file_get_contents("https://pokeapi.co/api/v2/pokemon?offset={$offset}&limit={$limit}");
$data = json_decode($data, true);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokedex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <?php for ($i = 0; $i < $limit; $i++) { ?>
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 20rem;">
                        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/<?php echo $i + $offset + 1; ?>.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="card-title p-2 mb-4 bg-danger text-white text-center">
                                <h5><?php echo ucfirst($data["results"][$i]["name"]); ?></h5>
                            </div>
                            <div class="p-1 mb-2 bg-primary text-white text-center">
                                <h5>Abilities</h5>
                            </div>
                            <?php
                            $pokemon = file_get_contents($data["results"][$i]["url"]);
                            $pokemon = json_decode($pokemon, true);
                            $pokemon_abilities = $pokemon["abilities"];
                            $ability_len = count($pokemon_abilities);
                            ?>
                            <ul class="list-group">
                                <?php if ($ability_len == 3) : ?>
                                    <?php for ($j = 0; $j < 3; $j++) :  ?>
                                        <li class="list-group-item"><?php echo $pokemon_abilities[$j]["ability"]["name"]; ?></li>
                                    <?php endfor; ?>
                                <?php elseif ($ability_len == 2) : ?>
                                    <?php for ($j = 0; $j < 2; $j++) :  ?>
                                        <li class="list-group-item"><?php echo $pokemon_abilities[$j]["ability"]["name"]; ?></li>
                                    <?php endfor; ?>
                                <?php elseif ($ability_len == 1) : ?>
                                    <li class="list-group-item"><?php echo $pokemon_abilities[0]["ability"]["name"]; ?></li>
                                <?php endif; ?>
                            </ul>

                            <?php if ($ability_len > 3) : ?>
                                <div class="btn-group float-end mt-2">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Show More
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php for ($j = 3; $j < $ability_len; $j++) { ?>
                                            <li class="dropdown-item"><?php echo $pokemon_abilities[$j]["ability"]["name"]; ?></li>
                                        <?php } ?>
                                    </ul>
                                <?php endif; ?>
                                </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
        </div>
        <div class="row">
            <!-- <div class="col-md-5"></div> -->
            <div class="col-md-12">
                <nav class="mt-5 fixed-bottom">
                    <ul class="pagination">
                    <?php
                        if(!empty($_GET['page']) && $_GET['page'] != 1){
                            ?>
                            <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $_GET['page'] ;?>"><?php echo  'Pervious'; ?></a></li>
                       
                            <?php
                        }
                        ?>
                     <!-- <li class="page-item"><a class="page-link" href="#">Previous</a></li> -->
                        
                        <?php 
    
                        for ($i=1; $i <= $no_of_pages; $i++) {
                            if(!empty($_GET['page']) && (int)$_GET['page'] > $i ){
                                continue;
                            }
                            if($i > (10 + (!empty($_GET['page']) ? (int)$_GET['page'] : 0))){
                               break;
                            } 
                            ?>
                            <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $i;?>"><?php echo $i; ?></a></li>
                            <?php 
                        } ?>    
                        <!-- <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
                        <li class="page-item"><a class="page-link" href="index.php?page=<?php echo  $no_of_pages + 1  ;?>"><?php echo  'Next'; ?></a></li>
                    </ul>
                </nav>
            </div>
            <!-- <div class="col-md-4"></div> -->
        </div>

    </div>
    <!-- <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/132.png" /> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>