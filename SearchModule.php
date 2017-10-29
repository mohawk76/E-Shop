<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<title>Powtórzenie</title>
</head>
<body>

<?php
    require_once('ClassLibrary/Database.php');//Dodanie klasy Database
    require_once('ClassLibrary/Form.php');
    require_once('SearchEngine.php');
    require_once('Products.php');
    
    $connect = Database::getInstance();//Get database Object
    
    try
    {
        $connect->connect('127.0.0.1', 'admin', '', 'test');//connecting to MySQL database
    } 
    catch (connectFailedException $ex) 
    {
          echo $ex->getMessage();
    }
    
    //Checking form data
    if(isset($_POST['submit']))
    {
        $productName = addslashes($_POST['productName']);
        $productCompany = addslashes($_POST['productCompany']);
        $productMinPrize = addslashes($_POST['productMinPrice']);
        $productMaxPrize = addslashes($_POST['productMaxPrice']);
        $productSort = $_POST['productSort'];
    }
    else //If the form wasn't sent set variables empty
    {
        $productName = "";
        $productCompany = "";
        $productMinPrize ="";
        $productMaxPrize="";
        $productSort = "ASC";
   }
   
   //Create SearchEngine object and Generating search method's arguments
    $search = new SearchEngine($connect, "produkty");
    $searchArray= array();
   
   if(!empty($productName) || !empty($productCompany) || !empty($productMinPrize) || !empty($productMaxPrize))
    {
       $searchArray[] = new whereArg("Nazwa", '"%'.$productName.'%"', "LIKE");
       $searchArray[] = new whereArg("id_producent", $productCompany);
       $searchArray[] = new whereArg("Cena", $productMinPrize, ">");
       $searchArray[] = new whereArg("Cena", $productMaxPrize, "<");
    }
    
    if($productSort=="DESC")
    {
        $sortArg[] = new orderArg("Cena", orderArg::DESCENDING);
    }
    else 
    {
        $sortArg[] = new orderArg("Cena", orderArg::ASCENDING);
    }
    
    $select = new selectArgs("Nazwa", "Opis", "Cena", "id_producent", "ID_Image");
    //Search and get result
    $result = $search->search($select, $searchArray, $sortArg);
    //Parsing search result to product and add to productsCollection
    $products = new productsCollection();

    while ($row = $result->fetch_assoc())
    {
        $item;
        if ($row["ID_Image"] != NULL) 
        {
            $imagePath = $connect->sendQuery('Select Path From images where ID_Image = ' . $row["ID_Image"])->fetch_row()[0];
        }
        else
        {
            $imagePath = "";
        }
        $company = $connect->sendQuery('Select nazwa From producenci where id_producent = '.$row["id_producent"])->fetch_row();//Get name company
        
        if(product::tryParse(array($row["Nazwa"], $row["Opis"], $company[0], $row["Cena"], $imagePath), $item))//if data cannot be parsed don't add item to products
        {
            $products->addItem($item);
        }
    }
    ?>
    
    <form action="SearchModule2.php" method="post">
        <label>Nazwa produktu: </label><input type="search" placeholder="Czego szukasz?" name="productName" value="<?php echo $productName; ?>"/>
        <label>Producent: </label><select name="productCompany">
          <option value="" <?php if(empty($productCompany)) echo 'selected="selected"'; ?>></option>
        <?php
        //Get companies from database
        $result = $connect->sendQuery('SELECT Nazwa, id_producent FROM producenci;');
        while ($row = $result->fetch_row()) 
        {   
            (new selectOption($row[0],$row[1]))->printHTML($productCompany);
        }
        ?>
        </select>
        
        <label>Cena od: </label><input type="number" width="10px" name="productMinPrice" step="0.01" min="0" value="<?php echo $productMinPrize; ?>"/>
        <label>do: </label><input type=number width="10px" name="productMaxPrice" step="0.01" min="0" value="<?php echo $productMaxPrize; ?>"/>
        <label>Sortuj według: </label><select name="productSort">
            <option value="ASC" <?php if($productSort!="DESC") echo 'selected'; ?> >Cena rosnąco</option>
            <option value="DESC" <?php if($productSort=="DESC") echo 'selected'; ?>>Cena malejąco</option>
        </select>
        <input type="submit" value='Szukaj!' name="submit"/>
    </form>
    <?php 
    if(!empty($_POST['productName']) || !empty($_POST['productCompany']) || !empty($_POST['productMinPrice']) || !empty($_POST['productMaxPrice']) || !empty($_POST["productSort"]))
    {
        echo '<pre>';
        
        if(!$products->isEmpty())
        {
            echo 'Lista znalezionych przedmiotów:<br>';
            $products->Show();
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