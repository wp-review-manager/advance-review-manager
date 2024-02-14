<template>
  <div class="wpf_photo_card">
    <div
      v-if="checkHasImage(product)"
      class="wpf_photo_holder mb-2"
    >
      <img :src="getSingleImageLink(product)">
    </div>
    <div class="wpf_photo_media_btn">
      <el-button
        type="warning"
        @click="initUploader"
      >
        {{ buttonText }}
      </el-button>
    </div>
  </div>
</template>
  
<script type="text/babel">
import each from "lodash/each";
// import Button from "../Button/Button.vue";

export default {
    name: "PhotoWidget",
    props: {
        product: {
            type: Object,
            default: () => {
                return {
                    photo: {
                        alt_text: "",
                        image_full: "",
                        image_thumb: "",
                    },
                };
            },
        },
        // custom_width: {
        //     type: String,
        //     default: "100%",
        // },
        // is_multiple: {
        //     type: Boolean,
        //     default: false,
        // },
        // layout: {
        //     type: String,
        //     default: "grid",
        // },
    },
    // components: {
    //     Button,
    // },
    data() {
        return {
            app_ready: false,
            buttonText: "+ Photo",
        };
    },
    mounted() {
        // if (!this.product.photo || typeof this.product.photo != "object") {
        //     this.$set(this.product, "photo", {
        //         alt_text: "",
        //         image_full: "",
        //         image_thumb: "",
        //     });
        // }

        if (this.product[0].image_thumb) {
            this.buttonText = "Change Image";
        }

        if (!window.wpActiveEditor) {
            window.wpActiveEditor = null;
        }

        this.app_ready = true;
    },
    methods: {
        checkHasImage(product) {
            if (product[0]?.image_thumb?.length > 0) {
                return true;
            }
            return false;
        },
        hasMultipleImage(product) {
            if (
                this.is_multiple &&
                this.layout === "grid" &&
                product?.photo?.length > 1
            ) {
                return true;
            }
            return false;
        },
        deleteImage(index) {
            this.product.photo.splice(index, 1);
        },
        getSingleImageLink(product) {
            return product[0].image_thumb;
        },
        initUploader(event) {
            event.preventDefault();
            const that = this;
            const upload = wp
                .media({
                    title: "Choose Image", //Title for Media Box
                    multiple: true, //For limiting multiple image
                })
                .on("select", () => {
                    const select = upload.state().get("selection");
                    const attach = select.first().toJSON();

                    that.product[0]["alt_text"] =
                        attach.alt || attach.title;
                    that.product[0]["image_full"] = attach.url;
                    that.product[0]["image_thumb"] = that.getThumb(attach);
                    return;
                })
                .open();
        },
        getThumb(attachment) {
            let highestSize = attachment.width;
            let maybeUrl = attachment.url;
            let finalUrl = false;
            each(attachment.sizes, (image, name) => {
                if (name == this.preferedThum) {
                    finalUrl = image.url;
                }
                if (!finalUrl || image.width > 300) {
                    if (image.width < 400) {
                        finalUrl = image.url;
                    } else if (image.width < highestSize) {
                        highestSize = image.width;
                        maybeUrl = image.url;
                    }
                }
            });
            return finalUrl || maybeUrl;
        },
    },
};
</script>
<style lang="scss">
.img-btn {
    position: relative;
}

.delete-img {
    position: absolute;
    top: 0;
    right: 1px;
    color: #ff7518;
    padding: 5px;
    border-radius: 50%;
    cursor: pointer;
}
</style>
  