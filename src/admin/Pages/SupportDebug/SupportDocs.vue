<template>
  <div>
		<el-row style="border: 1px solid white;">
			<el-col v-for="(item, i) in items" :key="i" :xs="24" :md="8">
				<div class="adrm-support_block_with_img">
					<img :src="assetsUrl(item.img)" alt="" />
					<div class="support_block_header">
						<h3>{{ item.title }}</h3>
					</div>
					<div class="support_block_body">
						<p>
							{{ item.des }}
						</p>
						<a
							target="_blank"
							class="el-button el-button--mini is-plain"
							:href="item.url"
							type="info"
							>{{ item.btn }}</a
						>
					</div>
				</div>
			</el-col>
		</el-row>
		<el-row :gutter="20">
			<el-col :xs="24" :md="16">
				<div class="adrm-support_block">
					<div class="support_block_header">
						<h3>Documentation and User Guide</h3>
					</div>
					<div class="support_block_body">
						<ul class="support_block_lists">
							<li v-for="(list,i) in docs" :key="i">
								<h4>{{ list.title }}</h4>
								<el-carousel indicator-position="outside" height="auto" arrow="always" v-if="i == 'screenshots'">
									<el-carousel-item v-for="(doc, it) in list.docs" :key="it" style="overflow-y: auto">
										<p>{{ doc.title }}</p>
										<img :src="doc.src" alt="" style="width: 100%" />
									</el-carousel-item>
								</el-carousel>
								<ul v-else>
									<li v-for="(doc, it) in list.docs" :key="it">
										<a
											target="_blank"
											rel="noopener"
											:href="doc.url"
										>
											{{ doc.title }}
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</el-col>
			<el-col :xs="24" :md="8">
				<div class="adrm-support_block">
					<div class="support_block_header">
						<h3><i class="el-icon-star-off"/> Top features in V-1.0.0 * *</h3>
					</div>
					<div class="support_block_body">
						<p>
							The current version has some amazing features,
							Check them to get more clear documentation.
						</p>
						<ul class="adrm-no_style top-features">
							<li>
								<el-icon :size="16" color="#096A2E">
                                    <StarFilled />
                                </el-icon>
								<a target="_blank" href="#">Review From Templates</a>
							</li>
                            <li>
								<el-icon :size="16" color="#096A2E">
                                    <StarFilled />
                                </el-icon>
								<a target="_blank" href="#">Edit Review From Templates</a>
							</li>
                            <li>
								<el-icon :size="16" color="#096A2E">
                                    <StarFilled />
                                </el-icon>
								<a target="_blank" href="#">Use Review Form Templates with ShortCode</a>
							</li>
                            <li>
								<el-icon :size="16" color="#096A2E">
                                    <StarFilled />
                                </el-icon>
								<a target="_blank" href="#">Show reviews with ShortCode</a>
							</li>
                            <li>
								<el-icon :size="16" color="#096A2E">
                                    <StarFilled />
                                </el-icon>
								<a target="_blank" href="#">Show Review Form anf Reviews together with ShortCode</a>
							</li>
                            <li>
								<el-icon :size="16" color="#096A2E">
                                    <StarFilled />
                                </el-icon>
								<a target="_blank" href="#">Clean admin dashboard for reviews</a>
							</li>
						</ul>
                        <div class='docs-changelog' style="display: flex; align-items: center; gap: 4px;"> 
                            <el-icon :size="16" color="#096A2E">
                                <Right />
                            </el-icon>
                            <a style="text-decoration: none"
                                target="_blank"
                                href="#"
                            >
                                Check documentation here
                            </a>
                        </div>
						<div class='docs-changelog' style="display: flex; align-items: center; gap: 4px;"> 
                            <el-icon :size="16" color="#096A2E">
                                <Right />
                            </el-icon>
                            <a style="text-decoration: none"
                                target="_blank"
                                href="#"
                            >
                                Check full changelog here
                            </a>
                        </div>
					</div>
				</div>
			</el-col>
		</el-row>
		<el-row v-if="!has_pro" :gutter="20">
			<el-col :xs="24" :md="16">
				<div class="adrm-support_block">
					<div class="support_block_header">
						<h4>Feedback and Support us</h4>
					</div>
					<div class="support_block_body">
						<p>We'd love your help, feedback and support.</p>
						<ul class="support_items">
							<li>
								<a target="_blank" href="https://wordpress.org/plugins/advance-review-manager/#reviews">Rate our plugin</a> and help spread the word!
							</li>
							<li>
								Report bugs (with steps to reproduce) or <a target="_blank" href="#">submit pull requests on GitHub</a>
							</li>
							<li>
								Have a question? <a target="_blank" href="#">Read docs or Frequently asked question</a>
							</li>
							<li>
								Need Expert Support? <a target="_blank" href="#">Open a support Ticket</a>
							</li>
						</ul>
					</div>
				</div>
			</el-col>
		</el-row>
	</div>
</template>

<script type="text/babel">
	export default {
		name: 'documentation',
		data() {
			return {
				docs: {
					getting_started: {
						title: 'Getting Started with Advance Review Manager',
						docs: [
							{
								title: 'Install and Activate - Advance Review Manager',
								url:
									'https://wordpress.org/plugins/advance-review-manager/'
							},
                            {
                                title: 'Create your first review Form in a minute',
                                url:
                                    '#'
                            },
                            {
                                title: 'Configure Review Form Templates and ShortCode',
                                url:
                                    ''
                            },
							{
								title: 'Customize Appearance and Functionality',
								url:
									'#'
							}
						]
					},
					screenshots: {
                        title: 'Plugin overview with screenshots',
                        docs: [
                            {
                                title: 'Choose Templates',
                                src: window.ADRMAdmin.assets_url + 'images/screenshots/adrm-templates.jpg'
                            },
                            {
                                title: 'Editor',
                                src: window.ADRMAdmin.assets_url + 'images/screenshots/adrm-form-editor.jpg'
                            },
                            {
                                title: 'Preview',
                                src: window.ADRMAdmin.assets_url + 'images/screenshots/adrm-preview.jpg'
                            },
                            {
                                title: 'Review Forms',
                                src: window.ADRMAdmin.assets_url + 'images/screenshots/adrm-review-forms-dashboard.jpg'
                            },
                            {
                                title: 'Reviews',
                                src: window.ADRMAdmin.assets_url + 'images/screenshots/adrm-reviews-frontend.jpg'
                            },
                            {
                                title: 'Reviews For Admin view',
                                src: window.ADRMAdmin.assets_url + 'images/screenshots/adrm-reviews-backend.jpg'
                            },
                            {
                                title: 'Review Details For Admin view',
                                src: window.ADRMAdmin.assets_url + 'images/screenshots/adrm-review-backend.jpg'
                            }
                        ]
                    },
					form_configaration: {
						title: 'Review Form Configuration',
						docs: [
							{
								title:
									'Create and Edit Review Form Templates',
								url:
									'#'
							},
						]
					},
					form_entries: {
						title: 'Managing Review Entries',
						docs: [
							{
								title: 'View all Review Form Entries',
								url:
									'#'
							},
							{
								title:
									'View Single Review Submission',
								url:
									'#'
							}
						]
					},
				},
				items: {
					support1: {
						title: 'Need And Expert Support?',
						des:
							'Our EXPERTS would like to assist you for your query and any customization.',
						url: 'https://www.akmelias.com/#contact',
						img: 'images/supports/support.png',
						btn: 'Contact Support'
					},
					support2: {
						title: 'Love this Plugin?',
						des:
							'Please write a review in wp.org plugin repository. We appreciate it!',
						url: 'https://wordpress.org/plugins/advance-review-manager/',
						img: 'images/supports/like.png',
						btn: 'Write a Review'
					},
					support3: {
						title: 'Found a Bug?',
						des:
							'Please report us and we promise we will fix that as soon as humanly possible',
						url: 'https://www.akmelias.com/#contact',
						img: 'images/supports/bug.png',
						btn: 'Let us know'
					}
				}
			};
		},
		methods: {
			assetsUrl(path) {
				return window.ADRMAdmin.assets_url + path;
			}
		}
	};
</script>
<style lang="scss" scoped>
.adrm-support_block {
    background: white;
    margin-top: 20px;

    .support_block_header {
        padding: 10px 15px;
        border-bottom: 1px solid rgb(221, 221, 221);

        h3 {
            margin: 0;
        }
    }

    .support_block_body {
        padding: 10px 20px;

        ul.support_block_lists {
            h4 {
                font-size: 15px;
                margin: 0 0 10px;
                display: block;
            }

            li {
                // display: flex;
                // align-items: center;
                // gap: 4px;
                ul {
                    margin-bottom: 30px;
                    margin-left: 20px;
                    list-style: disc;

                    li a {
                        color: #2271b1 !important;
                        text-decoration: none;
                    }
                }
            }
        }
        ul.top-features{
            li{
                display: flex;
                align-items: center;
                gap: 4px;
            }
        }
    }

    ul.support_items {
        margin: 15px 0px;

        li {
            list-style: disc;
            margin-left: 30px;
            line-height: 25px;
            font-size: 14px;
        }
    }
}



.adrm-tab_title {
    font-size: 17px;
    color: #6e6e6e;
    margin: 20px;
}
.adrm-support_block_with_img {
    padding: 12px;
    background: white;
    text-align: center;
    margin: 12px;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    .support_block_header {
        padding: 10px 15px;
        border-bottom: 1px solid rgb(221, 221, 221);

        h3 {
            margin: 0;
        }
    }

    .support_block_body {
        padding: 10px 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: center;

        ul.support_block_lists {
            h4 {
                font-size: 15px;
                margin: 0 0 10px;
                display: block;
            }

            li {
                ul {
                    margin-bottom: 30px;
                    margin-left: 20px;
                    list-style: disc;

                    li a {
                        text-decoration: none;
                        color: #2271b1 !important;
                    }
                }
            }
        }
    }

ul.support_items {
    margin: 15px 0px;

    li {
        list-style: disc;
        margin-left: 30px;
        line-height: 25px;
        font-size: 14px;
    }
}
}
i.el-icon-star-on {
    color: gold !important;
    margin-right: 12px;
}
ul.adrm-no_style.top-features a {
    text-decoration: none;
    color: #2271b1 !important;
}
.docs-changelog{
    a{
        color: #2271b1 !important;
        text-decoration: none;
    }
}

.el-carousel__item{
	height: 600px;
	background-color: #d3dce6;
}
.el-carousel__arrow{
	color: #096A2E !important
}
.el-carousel__item img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	display: flex;
	color: #475669;
	opacity: 0.75;
	line-height: 300px;
	margin: 0;
}
</style>