<?php
// Connect to the database
require_once('database.php');
// Set the default category to the ID of 1
if (!isset($category_id)) {
$category_id = filter_input(INPUT_GET, 'category_id', 
FILTER_VALIDATE_INT);
if ($category_id == NULL || $category_id == FALSE) {
$category_id = 1;
}
}
// Get name for current category
$queryCategory = "SELECT * FROM categories
WHERE categoryID = :category_id";
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$statement1->closeCursor();
$category_name = $category['categoryName'];
// Get all categories
$queryAllCategories = 'SELECT * FROM categories
ORDER BY categoryID';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();
// Get records for selected category
$queryRecords = "SELECT * FROM records
WHERE categoryID = :category_id
ORDER BY recordID";
$statement3 = $db->prepare($queryRecords);
$statement3->bindValue(':category_id', $category_id);
$statement3->execute();
$records = $statement3->fetchAll();
$statement3->closeCursor();
?>
<!DOCTYPE html>
<html>
<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
<!-- the head section -->
<head>
<title>NETFLIX</title>
<link rel="stylesheet" type="text/css" href="sass/main.css">
</head>
<!-- the body section -->
<body>
<header>
<h1>NETFLIX</h1>
<nav>
<a href ="show.php">Shows</a>
<a href="login.php">Login</a>
<a href="register.php">Register</a>
<a href="logout.php">Logout</a>
<nav>
</header>
<main>
<h1>Films</h1>
<aside>
<!-- display a list of categories in the sidebar-->
<h2>Genres</h2>
<nav>
<ul>
<?php foreach ($categories as $category) : ?>
<li><a href=".?category_id=<?php echo $category['categoryID']; ?>">
<?php echo $category['categoryName']; ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</nav>
</aside>
<section>
<!-- display a table of records from the database -->
<h2><?php echo $category_name; ?></h2>
<table>
<tr>
<th>Image</th>
<th>Name</th>
<th>Description</th>
<th>Cast</th>
<th>Release Date</th>
<th>Price</th>
</tr>
<?php foreach ($records as $record) : ?>
<tr>
<td><img src="image_uploads/<?php echo $record['image']; ?>" width="150px" height="170px" /></td>
<td><?php echo $record['name']; ?></td>
<td><?php echo $record['description']; ?></td>
<td><?php echo $record['cast']; ?></td>
<td><?php echo $record['releaseDate']; ?></td>
<td><?php echo $record['price']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</section>
</main>
<footer>
<p>&copy; <?php echo date("Y"); ?> NETFLIX, Roisin McPhillips.</p>
</footer>
</body>
</html>