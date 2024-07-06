<template>
  <div>
    <div class="nav-wrapper">
      <li>
        <router-link to="/">
          <Icon icon="LeftBack" />
          Back to Review Forms
        </router-link>
      </li>
      <nav>
        <ul class="nav-menu">
          <li>
            <router-link :to="`/form/edit/${template_id}`">
              <Icon icon="Editor" />
              Editor
            </router-link>
          </li>
          <li>
            <router-link :to="`/form/edit/${template_id}/settings/general`">
              <Icon icon="Settings" />
              Settings
            </router-link>
          </li>
          <li>
            <router-link :to="`/form/edit/${template_id}/reviews`">
              <Icon icon="List" />
              Reviews
            </router-link>
          </li>
          <li>
            <div class="adrm-form-editor__action_right">
              <button
                v-clipboard:success="clipboardSuccessHandler"
                v-clipboard="shortcode"
                class="adrm-shortcode"
              >
                {{ shortcode }}
              </button>
            </div>
          </li>
        </ul>
      </nav>
    </div>
    <router-view />
  </div>
</template>
<script>
import { ElNotification } from 'element-plus';
import Icon from '../../Icons/Index.vue';
export default {
    components: {
        Icon
    },
    data() {
        return {
            template_id: this.$route.params.id,
            shortcode: `[advance-review-manager id="${this.$route.params.id}"]`,
        };
    },
    methods: {
        clipboardSuccessHandler() {
            ElNotification({
                title: 'Success',
                message: 'Copied to clipboard',
                type: 'success',
                position: 'bottom-right'
            });
        },
    }
};
</script>

<style lang="scss">
.nav-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px;
    background-color: #FFF;
    border-bottom: 1px solid #E5E5E5;
    list-style-type: none;
    font-size: 16px;
    margin-top: -63px;
    position: relative;
    // z-index: 9999999;

    li {
        a {
            margin: 0 10px;
            display: flex;
            gap: 4px;
            font-size: 16px;
            text-decoration: none;
            color: #565865;
            font-family: Inter;
            font-style: normal;
            font-weight: 500;
            line-height: 20px;
            align-items: center;

            &.router-link-exact-active {
                color: green;
            }
        }

        &:hover {
            cursor: pointer;
            color: green;

            a {
                color: green;
            }
        }
    }

    .nav-menu {
        display: flex;
        gap: 10px;
        list-style-type: none;
        align-items: center;
    }
}
</style>