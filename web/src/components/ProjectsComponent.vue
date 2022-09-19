<template>
	<!--/ Header end -->
	<div id="banner-area" class="banner-area" v-bind:style="{ backgroundImage: `url(${require('@/assets/images/banner/banner1.jpg')})` }">
	  <div class="banner-text">
	    <div class="container">
	        <div class="row">
	          <div class="col-lg-12">
	              <div class="banner-heading">
	                <h1 class="banner-title">Project</h1>
	                <nav aria-label="breadcrumb">
	                    <ol class="breadcrumb justify-content-center">
	                      <li class="breadcrumb-item"><a href="#">Home</a></li>
	                      <li class="breadcrumb-item"><a href="#">Project</a></li>
	                      <li class="breadcrumb-item active" aria-current="page">All Projects</li>
	                    </ol>
	                </nav>
	              </div>
	          </div><!-- Col end -->
	        </div><!-- Row end -->
	    </div><!-- Container end -->
	  </div><!-- Banner text end -->
	</div><!-- Banner area end --> 

	<section id="main-container" class="main-container">
	  <div class="container">
	    <div class="row">
	      <div class="col-12">
	        
	        <div class="row shuffle-wrapper">
	          <div class="col-1 shuffle-sizer"></div>

	          <div v-for="project in projects" class="col-lg-4 col-md-6 shuffle-item" data-groups="[&quot;government&quot;,&quot;healthcare&quot;]">
	            <div class="project-img-container">
	              <a class="gallery-popup" href="images/projects/project1.jpg">
	                <img v-if="project.images.length > 0" v-for="image in project.images" class="img-fluid" v-bind:src="this.$apiBaseURL + '/storage/' + image.file_path" alt="project-image">
	                <img v-else class="img-fluid" src="../assets/images/projects/project1.jpg" />
	                <span class="gallery-icon"><i class="fa fa-plus"></i></span>
	              </a>
	              <div class="project-item-info">
	                <div class="project-item-info-content">
	                  <h3 class="project-item-title">
	                    <router-link v-bind:to="'/project/' + project.id" v-text="project.name"></router-link>
	                  </h3>
	                  <p class="project-cat" v-text="project.categories"></p>
	                </div>
	              </div>
	            </div>
	          </div><!-- shuffle item 1 end -->

	        </div><!-- shuffle end -->
	      </div>

	      <div class="col-12">
	        <div class="general-btn text-center">
	          <a class="btn btn-primary" href="projects.html">View All Projects</a>
	        </div>
	      </div>

	    </div><!-- Content row end -->

	  </div><!-- Conatiner end -->
	</section><!-- Main container end -->
</template>

<script>

	import axios from "axios"
	import swal from "sweetalert2"

	export default {
		name: "ProjectsComponent",

		data() {
			return {
				projects: []
			}
		},

		methods: {
			getProjects: async function () {
				const response = await axios.post(
					this.$apiURL + "/projects/fetch",
					null
				)

				if (response.data.status == "success") {
					console.log(response.data.projects)
					this.projects = response.data.projects
				} else {
					swal.fire("Error", response.data.message, "error")
				}
			}
		},

		mounted: function () {
			this.getProjects()
		}
	}
</script>