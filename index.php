<!DOCTYPE html>
<html>
<head>
    <title>E-Shop Design</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="design-style.css" />
	<link rel="stylesheet" type="text/css" href="Templates/productTemplate.css">
    <script type="text/javascript" src="JS/jquery-3.2.1.min.js"></script>
</head>

<body>
<?php
	require('vendor/autoload.php');
	
	$dbConfig = include('Config/dbConfig.php');
	$connect = AnvilPHP\Database\Database::getInstance();
	$session = AnvilPHP\Session::getInstance();
	$get = AnvilPHP\Get::getInstance();
	
	$connect->connect(
			$dbConfig['type'],
			$dbConfig['host'],
			$dbConfig['user'], 
			$dbConfig['pass'],
			$dbConfig['name']);//connecting to MySQL database
		
    $productName = $get->filteredInput('searched');
    $productCategory = $get->filteredInput('category');
   
   //Create SearchEngine object and Generating search method's arguments
    $search = new AnvilPHP\SearchEngine($connect, "produkty");
    $searchArray= array();
   
   if(!empty($productName))
    {
       $searchArray[] = ("Nazwa LIKE ".'"%'.$productName.'%"');
    }
    if(!empty($productCategory))
    {
        $searchArray[] =("id_kategorii = ".$productCategory);
    }
    
    
    $select = array("Nazwa", "Opis", "Cena", "id_producent", "ID_Image");
	
    //Search and get result
    $result = $search->search($select, $searchArray);
	$products = new Shop\Product\productsCollection();
	
    //Parsing search result to product and add to productsCollection
	$builder = new Shop\Product\ProductBuilder($connect);
	foreach ($result as $row) 
	{
		$products->addItem($builder->createProduct($row));
	}
?>
<div class="container">
    <div class="header">
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Logo" /></a>
        </div>

        <div class="searchForm">
            <form method="get">
                <input type="search" placeholder="czego szukasz?" value="<?php echo $productName;?>" name="searched" class="search" />
                <select name="category" class="category">
                    <option value="">Wszystkie działy</option>
                    <?php
                        if($connect->isConnected())
                        {
                            $result = $connect->sendQuery('SELECT Nazwa, id_kategorii FROM kategorie;');
                            foreach($result as $row) 
                            {   
								(new AnvilPHP\HTMLGenerators\Form\Option($row['Nazwa'],$row['id_kategorii']))->printHTML($productCategory);
                            }
                        }
                    ?>
                </select>
                <input type="submit" class="submit" value="Szukaj!" name="submit" />
            </form>
        </div>
        <a href="SearchModule2.php"><div class="shopCart"></div></a>
        <div class="clearHeader"></div>
    </div>

    <div class="products">
        <div class="toogle-menu" onclick="openNav()"></div>
        <div class="content">
	<?php
	$display = $products->toArray();
    if(false)
    {
        echo '<pre>';
        
        if(!$products->isEmpty())
        {
            echo 'Lista znalezionych przedmiotów:<br>';
            foreach ($display as $displayed)
			{
				(new Shop\Product\ProductTemplate("Templates/productTemplate.html"))->set($displayed)->printHTML();
			}
        }
        else
        {
            echo 'Nie znaleziono przedmiotu<br>';
        }
        echo '</pre>';
    }
    else
    {
         foreach ($display as $displayed)
			{
				(new Shop\Product\ProductTemplate("Templates/productTemplate.html"))->set($displayed)->printHTML();
			}
    }
	
    ?>
        </div>
        <div class="navigation">
            <a href="#top">1</a>
            <a href="#top">2</a>
            <a href="#top">3</a>
            <a href="#top">4</a>
        </div>
    </div>
</div>
    
<div class="menu" id="menu">
    <div class="closebtn" onclick="closeNav()"></div>
    <div class="menuitem">Strona główna</div>
    <div class="menuitem">Gry</div>
    <div class="menuitem">Łowcy</div>
</div>
	
<script>
    function openNav() {
        $(".menu").css("width", 250+"px");
        $(".toogle-menu").hide();
    }

    function closeNav() {
        $(".menu").css("width", 0+"px");
        $(".toogle-menu").show();
    }
</script>
</body>
</html>