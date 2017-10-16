<?php
	require_once "database.php";
	include "header.php";
	getHeader("Page", "Submit Startup");
?>
<main id="content">
	<div class="container pt-4 mt-4 pb-4">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<h2>Submit Startup</h2>
				<form class="mt-4" method="post" action="/preview">
					<div class="form-group">
						<label for="startupname">Startup Name</label>
						<input type="text" class="form-control" name="startupname" id="startupname" placeholder="Enter the name of the startup" required>
					</div>
					<div class="form-group">
						<label for="subtitle">Subtitle</label>
						<input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter a short subtitle, eg. Uber for cats" required>
					</div>
					<div class="form-group">
						<label for="url">Website URL</label>
						<input type="text" class="form-control" name="url" id="url" placeholder="Enter the website URL" required>
					</div>
					<div class="form-group">
						<label for="email">Official Email</label>
						<input type="email" class="form-control" name="email" id="email" placeholder="Enter the startup email" required>
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea class="form-control" name="description" id="description" placeholder="Enter the description for the startup." rows="4"></textarea>
					</div>
					<button class="btn btn-primary" type="submit">Continue<i class="ion ion-md-arrow-forward ml-2"></i></button>
				</form>
			</div>
		</div>
	</div>
</main>
<script src="https://cdn.ckeditor.com/4.7.3/basic/ckeditor.js"></script>
<script> CKEDITOR.replace("description"); </script>
<?php getFooter(); ?>