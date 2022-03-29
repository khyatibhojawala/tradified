<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
	<style>
		ul, #myUL {
		  list-style-type: none;
		}

		#myUL {
		  margin: 0;
		  padding: 0;
		}

		.caret {
		  cursor: pointer;
		  -webkit-user-select: none; /* Safari 3.1+ */
		  -moz-user-select: none; /* Firefox 2+ */
		  -ms-user-select: none; /* IE 10+ */
		  user-select: none;
		}

		.caret::before {
		  content: "\25B6";
		  color: black;
		  display: inline-block;
		  margin-right: 6px;
		}

		.caret-down::before {
		  -ms-transform: rotate(90deg); /* IE 9 */
		  -webkit-transform: rotate(90deg); /* Safari */'
		  transform: rotate(90deg);  
		}

		.nested {
		  display: none;
		}

		.active {
		  display: block;
		}
	</style>
</head>
<body>

	<a href="<?php echo base_url('add/category'); ?>" class="btn btn-primary">Add</a>
	<div class="container mt-3">
	  <h2>Categories</h2>
	  <ul id="myUL">
	  	<?php 
	  	foreach ($parent_categories as $category)
	  	{ 
	  		$count = get_count_subcategories($category['id']);
	  	?>
	  	<li class="category_<?php echo $category['id']; ?>" data-id="<?php echo $category['id']; ?>">
	  		<?php 
	  		if($count > 0)
	  		{
	  		?>
	  		<span class="caret"><?php echo $category['category_name']; ?></span>
	  		<?php 
	  		} 
	  		else
	  		{
	  			echo $category['category_name'];
	  		}
	  		?>
	  	</li>
	  	<?php 
	  	} 
	  	?>
	  </ul>
	</div>
</body>
<script>
	var BASE_URL = "<?php echo base_url(); ?>";
	$(document).on('click', '.caret', function(e) {
		e.preventDefault();
		var parent_category_id = $(this).parent().attr('data-id');
		$.ajax({
			url: BASE_URL + 'categories/get_child_categories',
			type: 'POST',
			dataType: 'json',
			data: { parent_category_id: parent_category_id},
			success : (response) => {
				if(response.flag){
					$(`.category_${parent_category_id}`).append(response.child_categories);
					this.parentElement.querySelector(".nested").classList.toggle("active");
    				this.classList.toggle("caret-down");
				}

			}
		});
	});
</script>
</html>
