<?php
$host="303.itpwebdev.com";
$username="yunhanm_db_user";
$password="xiaomaodd001127";
$db="yunhanm_dvd_db";

// to establish a connection with db, we will create a new instance of the mysqli class
//the moment we create an instance of the mysqli class, it will also attempt to connect to the database using the credentials that we pass in

$mysqli=new mysqli($host,$username,$password,$db);

//pre-emptively check for erros with the connection
//connect_errno returns an error code if there is an error, if there is no error, it will return false
if($mysqli->connect_errno){
	// display the full error message
	echo $mysqli->connect_error;
	//terminates the program, No subsequent code runs.
	exit();
}


//set a characterset for special characters
$mysqli->set_charset("utf8");


$sql="SELECT 
dvd_titles.title,
dvd_titles.release_date,
genres.genre,
ratings.rating
FROM
dvd_titles
	JOIN
genres ON dvd_titles.genre_id = genres.genre_id
	JOIN
ratings ON dvd_titles.rating_id = ratings.rating_id
JOIN
labels ON dvd_titles.label_id = labels.label_id
JOIN
formats ON dvd_titles.format_id = formats.format_id
JOIN
sounds ON dvd_titles.sound_id = sounds.sound_id
where 1=1";


//title
if(isset($_GET["title"])&&!empty($_GET["title"])){
	//this means the user entered a track anme in the previous form
	$sql=$sql." and dvd_titles.title like '%".$_GET["title"]. "%'";
}

//if user entered in a genre name in the search form, append an and statement in the where clause
//genre
if(isset($_GET["genre"])&&!empty($_GET["genre"])){
//this means the user entered a track anme in the previous form
$sql=$sql." and genres.genre_id = ".$_GET["genre"];
}

//rating
//if user entered in a media type name in the search form, append an and statement in the where clause
if(isset($_GET["rating"])&&!empty($_GET["rating"])){
//this means the user entered a track anme in the previous form
$sql=$sql." and ratings.rating_id = ".$_GET["rating"];
}

//label
if(isset($_GET["label"])&&!empty($_GET["label"])){
	//this means the user entered a track anme in the previous form
	$sql=$sql." and labels.label_id = ".$_GET["label"];
	}
//format
if(isset($_GET["rating"])&&!empty($_GET["rating"])){
		//this means the user entered a track anme in the previous form
	$sql=$sql." and ratings.rating_id = ".$_GET["rating"];
	}
	//sound
	if(isset($_GET["sound"])&&!empty($_GET["sound"])){
			//this means the user entered a track anme in the previous form
	$sql=$sql." and sounds.sound_id = ".$_GET["sound"];
		}
	 if(isset($_GET["award"])&&!empty($_GET["award"])){
		 if($_GET["award"]=="yes"){
			$sql=$sql." and dvd_titles.award is not null";
		 }
		 else if($_GET["award"]=="no"){
			$sql=$sql." and dvd_titles.award is null";
		 }
	 	}
		 
		//from
	if(isset($_GET["release_date_from"])&&!empty($_GET["release_date_from"])){
					//this means the user entered a track anme in the previous form
	$sql=$sql." and dvd_titles.release_date >= '".$_GET["release_date_from"]."'";
		}


	//	to
		if(isset($_GET["release_date_to"])&&!empty($_GET["release_date_to"])){
						//this means the user entered a track anme in the previous form
	$sql=$sql." and dvd_titles.release_date <= '".$_GET["release_date_to"]."'";
		}

$sql=$sql .";";

$results=$mysqli->query($sql);
if(!$results){
echo $mysqli->error;
exit();
}
$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
	<div class="container-fluid">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">
			<?php
				echo "Showing $results->num_rows result(s)";
			?>
			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>DVD Title</th>
							<th>Release Date</th>
							<th>Genre</th>
							<th>Rating</th>
						</tr>
					</thead>
					<tbody>
		<?php while($row=$results->fetch_assoc()):
	?>
	<tr>
		<td><?php echo $row["title"];?> </td>
		<td><?php echo $row["release_date"];?> </td>
		<td><?php echo $row["genre"];?> </td>
		<td><?php echo $row["rating"];?> </td>
	</tr>
	</tr>
	<?php endwhile;?>

					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
</body>
</html>