<template>
	<!--/ Header end -->
	<div v-if="project != null" id="banner-area" class="banner-area" v-bind:style="{ backgroundImage: `url(${require('@/assets/images/banner/banner1.jpg')})` }">
	  <div class="banner-text">
	    <div class="container">
	        <div class="row">
	          <div class="col-lg-12">
	              <div class="banner-heading">
	                <h1 class="banner-title" v-text="project.name"></h1>
	                <nav aria-label="breadcrumb">
	                    <ol class="breadcrumb justify-content-center">
	                      <li class="breadcrumb-item"><a href="#">Home</a></li>
	                      <li class="breadcrumb-item"><a href="#">Project</a></li>
	                      <li class="breadcrumb-item active" aria-current="page" v-text="project.name"></li>
	                    </ol>
	                </nav>
	              </div>
	          </div><!-- Col end -->
	        </div><!-- Row end -->
	    </div><!-- Container end -->
	  </div><!-- Banner text end -->
	</div><!-- Banner area end --> 

	<section id="main-container" class="main-container" v-if="project != null">
	  <div class="container">

	    <div class="row">
	      <div class="col-lg-8">
	        <div id="page-slider" class="page-slider small-bg">
	          <div v-for="image in images" class="item">
	            <img loading="lazy" class="img-fluid" v-bind:src="this.$apiBaseURL + '/storage/' + image.file_path" alt="project-image" />
	          </div>
	        </div><!-- Page slider end -->
	      </div><!-- Slider col end -->

	      <div class="col-lg-4 mt-5 mt-lg-0">

	        <h3 class="column-title mrt-0" v-text="project.name"></h3>
	        <p v-text="project.description"></p>

	        <ul class="project-info list-unstyled">
	          <li>
	            <p class="project-info-label">Client</p>
	            <p class="project-info-content" v-text="project.client"></p>
	          </li>
	          <li>
	            <p class="project-info-label">Architect</p>
	            <p class="project-info-content" v-text="project.architect"></p>
	          </li>
	          <li>
	            <p class="project-info-label">Location</p>
	            <p class="project-info-content" v-text="project.location"></p>
	          </li>
	          <li>
	            <p class="project-info-label">Size</p>
	            <p class="project-info-content" v-text="project.size"></p>
	          </li>
	          <li>
	            <p class="project-info-label">Year Completed</p>
	            <p class="project-info-content" v-text="project.year_completed"></p>
	          </li>
	          <li>
	            <p class="project-info-label">Categories</p>
	            <p class="project-info-content" v-text="project.categories"></p>
	          </li>
	        </ul>

	      </div><!-- Content col end -->

	    </div><!-- Row end -->

	  </div><!-- Conatiner end -->
	</section><!-- Main container end -->
</template>

<script>

	import axios from "axios"
	import swal from "sweetalert2"
	import jQuery from "jquery"

	export default {
		name: "ProjectDetailComponent",

		data() {
			return {
				images: [],
				project: null,
				id: this.$route.params.id
			}
		},

		methods: {
			getProject: async function () {
				const formData = new FormData()
				formData.append("id", this.id)

				const response = await axios.post(
					this.$apiURL + "/projects/fetchSingle",
					formData
				)

				if (response.data.status == "success") {
					this.project = response.data.project
					this.images = response.data.images

					setTimeout(function () {
						jQuery('.page-slider').slick({
							fade: true,
							slidesToShow: 1,
							slidesToScroll: 1,
							autoplay: true,
							dots: false,
							speed: 600,
							arrows: true,
							prevArrow: '<button type="button" class="carousel-control left" aria-label="carousel-control"><i class="fas fa-chevron-left"></i></button>',
							nextArrow: '<button type="button" class="carousel-control right" aria-label="carousel-control"><i class="fas fa-chevron-right"></i></button>'
						})
					}, 500)
				} else {
					swal.fire("Error", response.data.message, "error")
				}
			}
		},

		mounted: function () {
			this.getProject()
		}
	}
</script>