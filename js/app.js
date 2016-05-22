'use strict';




// The router needs a root component to render.
var App = Vue.extend({});


// Define Components
var postList = Vue.extend({
    template: '#post-list-template',

    data: function() {
        return {
            posts: '',
            nameFilter: '',
            categoryFilter: '',
            categories: '',
            showFilter: false,
            post: '',
        //    showSidebar: ''
            postPreview: false
        }
    },

    ready: function() {
        var posts = this.$resource('/wp-json/wp/v2/posts?per_page=6');
        var categories = this.$resource('/wp-json/wp/v2/categories');

        posts.get( function(posts) {
            this.$set('posts', posts);
        });

        categories.get( function(categories) {
            this.$set('categories', categories);
        });
    },

    methods: {

        getThePost: function(id) {                    // Get ID of clicked Post
            var posts = this.posts;                   // Get Info from API

            function filterPosts(posts) {
                return posts.id == id;                // Get ID of clicked Post
            }

            this.$set('post', posts.filter(filterPosts));    // Set single Post with clicked ID
        },

        showPostPreview: function(id) {
            this.postPreview = !this.postPreview       // Show/Hide
            this.getThePost(id);
        },

        adjacentPost: function(id) {                   // Next/Prev Post
            this.getThePost(id);
        },


        openFilter: function() {
            this.showFilter = !this.showFilter        // Toggle true/false
        },

    }
 });


var singlePost = Vue.extend({
    template: '#single-post-template',
    props: ['seo'],
    route: {
        data: function() {
            this.$http.get('/wp-json/wp/v2/posts/' + this.$route.params.postID, function(post) {
                this.$set('post', post);
                //$('title').text(post.title.rendered);
            });
        }
    }
});


var customPost = Vue.extend({
    template: '#custom-post-template',
    route: {
        data: function() {
            this.$http.get('/wp-json/wp/v2/portfolio', function(portfolio) {
                this.$set('portfolio', portfolio);
            });
        }
    }
});



var router = new VueRouter({                         // Create a router instance.
    history: true
});


router.map({                                         // Routes: Map to Component or its Options

    '/': {
        component: postList
    },

    '/post/:postID': {
        name: 'post',
        component: singlePost
    },

    'portfolio': {
        component: customPost
    }



});


// Mount App Instance to Selector
router.start(App, 'html');
