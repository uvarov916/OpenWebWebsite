<?php get_header(); ?>

<div class="container content">
	<div class="row">

		<div class="col-sm-8">
			<div class="pe-container pe-block">
				<div claass="image post post-single" style="padding-bottom: 15px;
/*border-bottom: 1px solid #e9e9e9;*/ margin-bottom: 50px;">
					<div class="post-title">
						<h2><?php the_title(); ?></h2>
					</div>
					<div class="post-body pe-wp-default">
						<p><?php the_field("description"); ?></p>
					</div>
				</div>

				<div id="resources">
					<h4>Useful resources</h4>
					<?php the_field("resources"); ?>
				</div>

			</div>
		</div>
		<div class="col-sm-4">
			<div class="sidebar">	
				
				<div class="widget widget-archive clearfix">
					<h5>Project files</h5>
					<ul>
						<li><a href="<?php the_field("project_files"); ?>">ZIP</a></li>
						<li><a href="<?php the_field("github_link"); ?>">Github</a></li>
					</ul>
				</div>

				<div class="widget widget-archive">
					<h5>Lecture materials</h5>
					<ul>
						<li><a href="<?php the_field("workshop_pdf"); ?>">PDF (includes the whole workshop)</a></li>
					</ul>
				</div>

				<div class="widget widget-archive">
					<h5>Mentioned links</h5>
					<?php the_field("mlinks"); ?>
				</div>

			</div>
		</div>


	</div>
</div>

<?php get_footer(); ?>