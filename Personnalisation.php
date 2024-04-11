<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM fleur WHERE code='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'price' => $productByCode[0]["price"], 'image' => $productByCode[0]["image"]));
			
			if(!empty($_SESSION["personnalisation"])) {
				if(in_array($productByCode[0]["code"],array_keys($_SESSION["personnalisation"]))) {
					foreach($_SESSION["personnalisation"] as $k => $v) {
							if($productByCode[0]["code"] == $k) {
								if(empty($_SESSION["personnalisation"][$k]["quantity"])) {
									$_SESSION["personnalisation"][$k]["quantity"] = 0;
								}
								$_SESSION["personnalisation"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["personnalisation"] = array_merge($_SESSION["personnalisation"],$itemArray);
				}
			} else {
				$_SESSION["personnalisation"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["personnalisation"])) {
			foreach($_SESSION["personnalisation"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["personnalisation"][$k]);				
					if(empty($_SESSION["personnalisation"]))
						unset($_SESSION["personnalisation"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["personnalisation"]);
	break;	
}
}
?>
<HTML>
<HEAD>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Fleuropa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Russo+One&display=swap" rel="stylesheet">
</HEAD>
<BODY>
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
                        <a class="nav-link dropdown-toggle" id="Selections" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <div class="dropdown-menu" aria-labelledby="Boutiques">
                            <a class="dropdown-item" href="#">a</a>
                            <a class="dropdown-item" href="#">b</a>
                            <a class="dropdown-item" href="#">c</a>
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
<div id="shopping-cart">
<div class="txt-heading">Shopping Cart</div>

<a id="btnEmpty" href="personnalisation.php?action=empty">Supprimer sa personnalisation</a>
<?php
if(isset($_SESSION["personnalisation"])){
    $total_quantity = 0;
    $total_price = 0;
?>	
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>	
<?php		
    foreach ($_SESSION["personnalisation"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				<tr>
				<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
				<td><?php echo $item["code"]; ?></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="personnalisation.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>
		
  <?php
} else {
?>
<div class="no-records">Pas encore de personnalisation</div>
<?php 
}
?>
</div>

<section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-around">
				<?php
				$product_array = $db_handle->runQuery("SELECT * FROM fleur ORDER BY id ASC");
				if (!empty($product_array)) { 
					foreach($product_array as $key=>$value){
				?>
				<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <div class="col mb-5 text-center justify-content-center">
				<form method="post" action="Personnalisation.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
					<div class="product-item">
						<form method="post" action="Personnalisation.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</BODY>
</HTML>