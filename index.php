<?php get_header(); ?>


<div id="app">

	<form v-on:submit="alertBox">
		<button type="submit">
			Submit
		</button>
	</form>

	<pre>
		{{ $data | json }}
	</pre>

</div>

<script>
	new Vue({
		el: '#app',

		methods: {
			alertBox: function () {
				alert('Submitted')
			}
		}

	})
</script>

<div id="app--" class="container">

		<router-view></router-view>

</div>




<template id="post-list-template">

	<div class="overlay" v-if="postPreview" v-on:click="showPostPreview()" transition="overlayshow"></div>

<!-- FILTER -->
	<div class="filter-bar">

		<div class="container">
			<a v-on:click="openFilter()" class="btn-filter open">
				Open Filter
			</a>
			<a v-link="{ path: 'portfolio' }" class="btn-filter">Portfolio</a>
		</div>

		<div class="filter-wrap" v-if="showFilter">
			<div class="container">

				<div class="by-name">
					<h4>Filter by Name</h4>
					<input type="text" name="name" v-model="nameFilter">
				</div>

				<div class="by-category clearfix">

					<h4>Filter by Category</h4>

					<div class="radio-wrap">
						<input id="category-all" type="radio" value="" v-model="categoryFilter">
						<label for="category-all">All</label>
					</div>
					<div class="radio-wrap" v-for="category in categories" v-if="category.id !== 1">
						<input id="category-{{ category.name | lowercase }}" type="radio" value="{{ category.id }}" v-model="categoryFilter">
						<label for="category-{{ category.name | lowercase }}">{{ category.name }}</label>
					</div>


				</div>

			</div>
		</div>
	</div>


<!-- POSTS -->
	<div class="post-list">

		<article class="post" v-for="post in posts |
									 filterBy nameFilter in 'title' |
									 filterBy categoryFilter in 'categories'">

			<a v-on:click="showPostPreview(post.id)">

				<div class="post-content">

					<img v-bind:src="post.thumbnail_url_small" alt="{{ post.title.rendered }}" />
					<h2>{{{ post.title.rendered }}}</h2>
					<small v-for="category in post.category_info">
						{{ $index }}: {{ category.name }}
					</small>

				</div>

			</a>

		</article>

	</div>


<!-- SINGLE -->
	<div class="single-preview" v-if="postPreview" transition="postshow">

		<h2>{{ post[0].title.rendered }}</h2>
		<div class="image">
			<img v-bind:src="post[0].thumbnail_url_medium" alt="{{ post[0].title.rendered }}" />
		</div>
		<div class="post-content">
			{{{ post[0].excerpt.rendered }}}

			<a v-link="{name: 'post', params:{postID: post[0].id}}" class="btn-read-more">Read more</a>
		</div>

		<a v-on:click="adjacentPost(post[0].prev_post)" v-if="post[0].prev_post" class="post-nav prev">
			<span> < </span>
		</a>
		<a v-on:click="adjacentPost(post[0].next_post)" v-if="post[0].next_post" class="post-nav next">
			<span> > </span>
		</a>

		<button class="close-button" v-on:click="showPostPreview()">&times;</button>


	</div>


</template>


<!-- SINGLE POST -->
<template id="single-post-template">


	<div class="post-control">
		<div class="container">
			<a v-link="{ path: '/' }" class="btn-read-more">Back to Start</a>
		</div>

		<a v-link="{ name: 'post', params: { postID: post.prev_post } }" v-if="post.prev_post" class="post-nav prev">
			<span> < </span>
		</a>
		<a v-link="{ name: 'post', params: { postID: post.next_post } }" v-if="post.next_post" class="post-nav next">
			<span> > </span>
		</a>
	</div>


	<div class="container single-post">

		<h2 class="title">{{ post.title.rendered }}</h2>

		<div class="image">
			<img v-bind:src="post.thumbnail_url_large">
		</div>

		<div class="post-content">
			{{{ post.content.rendered }}}
		</div>

	</div>

</template>




<!-- CUSTOM POST TYPE -->
<template id="custom-post-template">

	<div class="overlay" v-if="postPreview" v-on:click="showPostPreview()" transition="overlayshow"></div>

<!-- FILTER -->
	<div class="filter-bar">

		<div class="container">
			<a v-on:click="openFilter()" class="btn-filter open">
				Open Filter
			</a>
		</div>

		<div class="filter-wrap" v-if="showFilter">
			<div class="container">

				<div class="by-name">
					<h4>Filter by Name</h4>
					<input type="text" name="name" v-model="nameFilter">
				</div>

				<div class="by-category clearfix">

					<h4>Filter by Category</h4>

					<div class="radio-wrap">
						<input id="category-all" type="radio" value="" v-model="categoryFilter">
						<label for="category-all">All</label>
					</div>
					<div class="radio-wrap" v-for="category in categories" v-if="category.id !== 1">
						<input id="category-{{ category.name | lowercase }}" type="radio" value="{{ category.id }}" v-model="categoryFilter">
						<label for="category-{{ category.name | lowercase }}">{{ category.name }}</label>
					</div>


				</div>

			</div>
		</div>
	</div>


<!-- POSTS -->
	<div class="post-list">

		<article class="post" v-for="folio in portfolio">

				<div class="post-content">

					<img v-bind:src="folio.thumbnail_url.small" alt="{{ folio.title.rendered }}" />
					<h2>{{{ folio.title.rendered }}}</h2>
					<p>{{{ folio.acf.description }}}</p>
				</div>

			</a>

		</article>

	</div>


<!-- SINGLE -->
	<div class="single-preview" v-if="postPreview" transition="postshow">

		<h2>{{ post[0].title.rendered }}</h2>
		<div class="image">
			<img v-bind:src="post[0].thumbnail_url_medium" alt="{{ post[0].title.rendered }}" />
		</div>
		<div class="post-content">
			{{{ post[0].excerpt.rendered }}}

			<a v-link="{name: 'post', params:{postID: post[0].id}}" class="btn-read-more">Read more</a>
		</div>

		<a v-on:click="adjacentPost(post[0].prev_post)" v-if="post[0].prev_post" class="post-nav prev">
			<span> < </span>
		</a>
		<a v-on:click="adjacentPost(post[0].next_post)" v-if="post[0].next_post" class="post-nav next">
			<span> > </span>
		</a>

		<button class="close-button" v-on:click="showPostPreview()">&times;</button>


	</div>


</template>


<?php get_footer(); ?>
