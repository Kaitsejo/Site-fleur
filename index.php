<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Fleuropa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Russo+One&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark fixed-top d-flex flex-row">
        <div class="container-fluid">
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                    <section class="d-flex d-flex-row bg-dark justify-content-between text-secondary">
                        <section>
                        <a class="nav-link dropdown-toggle" href="#" id="Selections" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sélection
                        </a>
                        <div class="dropdown-menu" aria-labelledby="Selections">
                            <section>     
                                <a class="dropdown-item" href="#">Fleurs</a>
                            </section>
                            <section>
                                <a class="dropdown-item" href="#">Bouquets</a>
                            </section>
                            <section>
                                <a class="dropdown-item" href="Personnalisation.php">Personnalisations</a>
                            </section>
                        </div>
                        </section>
                        <section>
                        <a class="nav-link dropdown-toggle align-items-start" href="#" id="Boutiques" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Boutiques
                        </a>
                        <?php
						$boutique = $db_handle->runQuery("SELECT * FROM boutique ORDER BY ZIPCODE ASC");
						if (!empty($boutique)) {
							echo '<ul>';
							foreach ($boutique as $b) {
								echo '<li>' . $b["Adresse"] . " " . " " . $b["name"] . ' (' . $b["ZIPCODE"] . ')' . '</li>';
							}
							echo '</ul>';
						} else {
							echo '<p>Aucune boutique trouvée.</p>';
						}
						?>
                        </div>
                    </section>
                </section>
                    </li>
                </ul>
            </div>
            <a class="navbar-brand" href="index.php">
                <img src="fleur.png" width="30" height="30" alt="Fleur">
                Fleuropa
            </a>
            <a class="navbar-brand" href="panier.php">
                <img src="cart.svg" width="30" height="30" alt="Cart">
                Panier
            </a>
        </div>
    </nav>
    <!-- Header-->
    <header class="py-5" style="background-image: url(bg-fleur.jpg);">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark">
                <h1 class="pacifico-regular display-4 fw-bolder">Fleuropa</h1>
                <p class="russo-one-regular text-dark-50 mb-0">Les plus belles fleurs d'Europe</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-around">
				<?php
				$product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
				if (!empty($product_array)) { 
					foreach($product_array as $key=>$value){
				?>
				<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <div class="col mb-5 text-center justify-content-center">
				<form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
					<div class="product-item">
						<form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
						 <!-- Product image-->
						<div class="image-top"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
						<!-- Product details-->
						<div class="product-tile-footer">
						<!-- Product name-->
						<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
						<!-- Product tag-->
						<h8 class="fw-bolder"><?php echo $product_array[$key]["tag"]; ?> <br></h5>
						<!-- Product price-->
						<?php echo "$".$product_array[$key]["price"];?> <br>
						</div>
						<div class="btn mt-auto"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
						</form>
					</div>
                </div>
            </div>
				
				<?php
					}
				}
				?>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
