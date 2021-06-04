<?php

// Import in the config.php file that holds our credentials
// To import, use either require or include keywords. Using require means the file MUST exist and import properly, otherwise the program will not continue
require "config/config.php";
// include "config/confi.php";

// Validation - make sure that edit_form has received a track_id. 
if( !isset($_GET["dvd_id"]) || empty($_GET["dvd_id"]) ) {

	echo "Invalid DVD ID!!";
	// Terminates the program at this point. Subsequent code does not run.
	exit();
}


// If this code runs, that means a track id was given

// DB Connection.
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

// -- Get details of this track
$sql = "SELECT * FROM dvd_titles 
	WHERE dvd_title_id = " . $_GET["dvd_id"] . ";";

// Submit the query
$results = $mysqli->query($sql);
if(!$results) {
	echo $mysqli->error;
	exit();
} 

// The query will return just ONE song result
$row_track = $results->fetch_assoc();

$sql_genre="select * from genres;";

$sql_rating="select * from ratings;";

$sql_label="select * from labels;";

$sql_format="select * from formats;";

$sql_sound="select * from sounds;";

$results_genre= $mysqli->query($sql_genre);
$results_rating= $mysqli->query($sql_rating);
$results_label= $mysqli->query($sql_label);
$results_format= $mysqli->query($sql_format);
$results_sound= $mysqli->query($sql_sound);

if(!$results_genre){
	echo $mysqli->error;
	exit();
}
if(!$results_rating){
	echo $mysqli->error;
	exit();
}
if(!$results_label){
	echo $mysqli->error;
	exit();
}
if(!$results_format){
	echo $mysqli->error;
	exit();
}
if(!$results_sound){
	echo $mysqli->error;
	exit();
}

// Close DB Connection
$mysqli->close();

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Form | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
</head>
<body>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php?dvd_title_id=<?php echo $_GET['dvd_title_id']; ?>">Details</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Edit a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

	<?php if ( isset($error) && !empty($error) ) : ?>

<div class="text-danger">
	<?php echo $error; ?>
</div>

<?php else : ?>

			<form action="edit_confirmation.php?dvd_id=<?php echo $_GET['dvd_id']; ?>" method="POST">

				<div class="form-group row">
					<label for="title-id" class="col-sm-3 col-form-label text-sm-right">Title: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="title-id" name="title" value="<?php echo $row_track['title'];?>">
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="release-date-id" class="col-sm-3 col-form-label text-sm-right">Release Date:</label>
					<div class="col-sm-9">
						<input type="date" class="form-control" id="release-date-id" name="release_date" value="<?php echo $row_track['release_date'];?>">
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="label-id" class="col-sm-3 col-form-label text-sm-right">Label:</label>
					<div class="col-sm-9">
						<select name="label" id="label-id" class="form-control">
							<option value="" selected>-- Select One --</option>
							<?php while( $row = $results_label->fetch_assoc() ): ?>

<!-- If the genre option matches the one we pulled from the db, add the "selected" attribute to that <option> tag -->

<?php if( $row["label_id"] == $row_track["label_id"] ) :?>

	<option selected value="<?php echo $row['label_id']; ?>">
		<?php echo $row['label']; ?>
	</option>

<?php else: ?>

	<option value="<?php echo $row['label_id']; ?>">
		<?php echo $row['label']; ?>
	</option>

<?php endif; ?>

<?php endwhile; ?>
						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="sound-id" class="col-sm-3 col-form-label text-sm-right">Sound:</label>
					<div class="col-sm-9">
						<select name="sound" id="sound-id" class="form-control">
							<option value="" selected>-- Select One --</option>
							<?php while( $row = $results_sound->fetch_assoc() ): ?>

<!-- If the genre option matches the one we pulled from the db, add the "selected" attribute to that <option> tag -->

<?php if( $row["sound_id"] == $row_track["sound_id"] ) :?>

	<option selected value="<?php echo $row['sound_id']; ?>">
		<?php echo $row['sound']; ?>
	</option>

<?php else: ?>

	<option value="<?php echo $row['sound_id']; ?>">
		<?php echo $row['sound']; ?>
	</option>

<?php endif; ?>

<?php endwhile; ?>
						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
					<div class="col-sm-9">
						<select name="genre" id="genre-id" class="form-control">
							<option value="" selected>-- Select One --</option>
							<?php while( $row = $results_genre->fetch_assoc() ): ?>

<!-- If the genre option matches the one we pulled from the db, add the "selected" attribute to that <option> tag -->

<?php if( $row["genre_id"] == $row_track["genre_id"] ) :?>

	<option selected value="<?php echo $row['genre_id']; ?>">
		<?php echo $row['genre']; ?>
	</option>

<?php else: ?>

	<option value="<?php echo $row['genre_id']; ?>">
		<?php echo $row['genre']; ?>
	</option>

<?php endif; ?>

<?php endwhile; ?>
						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="rating-id" class="col-sm-3 col-form-label text-sm-right">Rating:</label>
					<div class="col-sm-9">
						<select name="rating" id="rating-id" class="form-control">
							<option value="" selected>-- Select One --</option>
							<?php while( $row = $results_rating->fetch_assoc() ): ?>

<!-- If the genre option matches the one we pulled from the db, add the "selected" attribute to that <option> tag -->

<?php if( $row["rating_id"] == $row_track["rating_id"] ) :?>

	<option selected value="<?php echo $row['rating_id']; ?>">
		<?php echo $row['rating']; ?>
	</option>

<?php else: ?>

	<option value="<?php echo $row['rating_id']; ?>">
		<?php echo $row['rating']; ?>
	</option>

<?php endif; ?>

<?php endwhile; ?>
						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="format-id" class="col-sm-3 col-form-label text-sm-right">Format:</label>
					<div class="col-sm-9">
						<select name="format" id="format-id" class="form-control">
							<option value="" selected>-- Select One --</option>
							<?php while( $row = $results_format->fetch_assoc() ): ?>

<!-- If the genre option matches the one we pulled from the db, add the "selected" attribute to that <option> tag -->

<?php if( $row["format_id"] == $row_track["format_id"] ) :?>

	<option selected value="<?php echo $row['format_id']; ?>">
		<?php echo $row['format']; ?>
	</option>

<?php else: ?>

	<option value="<?php echo $row['format_id']; ?>">
		<?php echo $row['format']; ?>
	</option>

<?php endif; ?>

<?php endwhile; ?>



						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="award-id" class="col-sm-3 col-form-label text-sm-right">Award:</label>
					<div class="col-sm-9">
						<textarea name="award" id="award-id" class="form-control">
						<?php echo $row_track['award'];?></textarea>
					</div>
				</div> <!-- .form-group -->


				<input type="hidden" name="dvd_id" value="<?php echo $_GET['dvd_id']; ?>">
				<div class="form-group row">
					<div class="ml-auto col-sm-9">
						<span class="text-danger font-italic">* Required</span>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-9 mt-2">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-light">Reset</button>
					</div>
				</div> <!-- .form-group -->

			</form>
		<?php endif; ?>
	</div> <!-- .container -->
</body>
</html>