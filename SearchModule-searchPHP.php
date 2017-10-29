<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<title>Search</title>
</head>
<body>

<?php
    require_once('Products.php');//Class product and productCollection
    require_once('AnvilPHP/AnvilPHP.php');
    
    $connect = Database::getInstance();
    
    try
    {
        $connect->connect('127.0.0.1', 'admin', '', 'test');
    } 
    catch (connectFailedException $ex) 
    {
          echo $ex->getMessage();
    }
    
    //get data from database
    $result = $connect->sendQuery('SELECT produkty.Nazwa, produkty.Opis, producenci.Nazwa, Cena FROM `produkty`
        INNER JOIN producenci on producenci.id_producent = produkty.id_producent');
    
    
    //Container of available products
    $products = new productsCollection();
    
    //Loading products from database
    while ($row = $result->fetch_row()) 
    {   
        $item;
        if(product::tryParse($row, $item))
        {
            $products->addItem($item);
        }
    }
    
    if(isset($_POST['productName']) || isset($_POST['productCompany']) || isset($_POST['productMinPrice']) || isset($_POST['productMaxPrice']))
    {
        $productName = addslashes($_POST['productName']);
        $productCompany = addslashes($_POST['productCompany']);
        $productMinPrize = addslashes($_POST['productMinPrice']);
        $productMaxPrize = addslashes($_POST['productMaxPrice']);
    }
    else
    {
        $productName = "";
        $productCompany = "";
        $productMinPrize ="";
        $productMaxPrize="";
    }

?>

<form action="searchModule.php" method="post">
    <label>Nazwa produktu: </label><input type="text" name="productName" value="<?php echo $productName; ?>"/><br>
    <label>Producent: </label><select name="productCompany">
      <option value="" <?php if(empty($productCompany)) echo 'selected="selected"'; ?>></option>
    <?php
    $result = $connect->sendQuery('SELECT Nazwa FROM producenci;');
    while ($row = $result->fetch_row()) 
    {   
        (new selectOption($row[0],$row[0]))->printHTML($productCompany);
    }
    ?>
    </select><br>
    <label>Cena od: </label><input type="number" name="productMinPrice" step="0.01" min="0" value="<?php echo $productMinPrize; ?>"/><br>
    <label>do: </label><input type=number name="productMaxPrice" step="0.01" min="0" value="<?php echo $productMaxPrize; ?>"/><br>
    <input type="submit" value='Szukaj!'/>
</form>

<?php 
    if(!empty($_POST['productName']) || !empty($_POST['productCompany']) || !empty($_POST['productMinPrice']) || !empty($_POST['productMaxPrice']))
    {
        echo '<pre>';
        
        $result=($products->findProducts($productName, $productCompany, (float)$productMinPrize, (float)$productMaxPrize));//Przeszukanie kontynera produktów
        
        if(!$result->isEmpty())
        {
            echo 'Lista znalezionych przedmiotów:<br>';
            $result->Show();
        }
        else
        {
            echo 'Nie znaleziono przedmiotu<br>';
        }
        echo '</pre>';
    }
    else
    {
         $products->Show();
    }
    
?>
</body>
</html>
