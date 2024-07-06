<template>
  <div style="min-height: 400px">
    <el-container
      class="adrm-debug-container"
    >
      <el-col
        v-if="!wpLoading && !serverLoading && !othersLoading"
        class="debug-left-side"
        :lg="18"
        :sm="24"
      >
        <code class="copy">
          <el-icon
            :size="16"
            color="#000"
          >
            <Document />
          </el-icon> Copy
        </code>
        <div class="notice-container">
          <el-icon
            :size="16"
            color="#000"
          >
            <InfoFilled />
          </el-icon>
          <p>Check if there is any item with red color or labeled 'issue'</p>
        </div>
        <div class="adrm-debug-server">
          <div class="adrm-debug-item">
            <h4>#WordPress Info</h4>
            <DebugTemplate :render-content="wordpress" />

            <h4>#Plugin Status</h4>
            <DebugTemplate :render-content="adrmInfo" />


            <h4>#Theme Info</h4>
            <DebugTemplate :render-content="themeInfo" />

            <h4>#Active Plugins: ({{ plugins.total }})</h4>
            <div
              v-for="(plugin, i) in plugins.all"
              :key="i"
              class="adrm-debug-item-line"
            >
              <p>{{ i+1 }}.</p>
              <p
                class="result"
                :class="plugin.status === 'ok' ? 'status-ok' : ''"
              >
                {{ plugin }}
              </p>
            </div>

            <h4>#Server Info</h4>
            <DebugTemplate :render-content="serverInfos" />
          </div>
        </div>
      </el-col>
      <el-col
        class="debug-right-side"
        :lg="6"
        :sm="24"
      >
        <h4>#Debug Log</h4>
        <div class="status-container">
          <div v-if="wpLoading">
            <el-icon
              :size="16"
              color="#096A2E"
            >
              <Loading />
            </el-icon>
            <p>WP Compatibility..</p>
          </div>
          <div v-else>
            <el-icon
              :size="16"
              color="#096A2E"
            >
              <CircleCheck />
            </el-icon>
            <p>WordPress test completed</p>
          </div>
        </div>
        <div class="status-container">
          <div v-if="adrmLoading">
            <el-icon
              :size="16"
              color="#096A2E"
            >
              <Loading />
            </el-icon>
            <p>Plugin test Compatibility..</p>
          </div>
          <div v-else>
            <el-icon
              :size="16"
              color="#096A2E"
            >
              <CircleCheck />
            </el-icon>
            <p>Plugin test completed</p>
          </div>
        </div>
        <div class="status-container">
          <div v-if="serverLoading">
            <el-icon
              :size="16"
              color="#096A2E"
            >
              <Loading />
            </el-icon>
            <p>Server Compatibility..</p>
          </div>
          <div v-else>
            <el-icon
              :size="16"
              color="#096A2E"
            >
              <CircleCheck />
            </el-icon>
            <p>Server config test completed</p>
          </div>
        </div>
        <div class="status-container">
          <div v-if="othersLoading">
            <el-icon
              :size="16"
              color="#096A2E"
            >
              <Loading />
            </el-icon>
            <p>Testing theme & plugins..</p>
          </div>
          <div v-else>
            <el-icon
              :size="16"
              color="#096A2E"
            >
              <CircleCheck />
            </el-icon>
            <p>Others test completed</p>
          </div>
        </div>
        <div
          v-if="downlodable"
          style="margin-top: 45px;"
        >
          <el-button
            type="primary"
            icon="el-icon-download"
            size="mini"
            plain
            @click="download"
          >
            Download Report
          </el-button>
        </div>
      </el-col>
    </el-container>
  </div>
</template>

<script>
    import DebugTemplate from './DebugTemplate.vue';
    import ClipboardJS from 'clipboard';

	export default {
		name: 'Debug',
        components: {
            DebugTemplate
        },
		data() {
			return {
                wpLoading: false,
                serverLoading: false,
                othersLoading: false,
                adrmLoading: false,

				serverInfos: {},
				wordpress: {},
				themeInfo: {},
                plugins: {},
                adrmInfo: {}
			};
		},
        computed: {
            downlodable() {
                return !this.wpLoading &&
                !this.serverLoading &&
                !this.othersLoading &&
                !this.adrmLoading;
            }
        },
		created() {
			this.getWPData();
            this.getADRMData();
            this.getOthersData();
            this.getServerData();

            if(!window.wpf_clip_inited) {
                 var clipboard = new ClipboardJS('.copy', {
                    text: () => {
                        return this.getString();
                    }
                });
                clipboard.on('success', () => {
                    this.$message({
                        offset: 39,
                        message: 'Copied to Clipboard!',
                        type: 'success'
                    });
                });
                window.wpf_clip_inited = true;
            }
		},
		methods: {
            copyData() {
                this.getString();
            },
            download() {
                var str = this.getString();
                const url = window.URL.createObjectURL(new Blob([str]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'file.txt'); //or any other extension
                document.body.appendChild(link);
                link.click();
                document.querySelector('body').removeChild(link);
            },
            getConcatString(obj) {
                let str = '';
                for (var item in obj) {
                    str += `${obj[item].label} : ${obj[item].result}\n`;
                }
                return str;
            },
            getString() {
                var str = '\n#WordPress\n';
                str += this.getConcatString(this.wordpress);
                str += "\n#ADRM Infos\n";
                str += this.getConcatString(this.adrmInfo);
                str += "\n#Theme Infos\n";
                str += this.getConcatString(this.themeInfo);
                str += "\n#Server Infos\n";
                str += this.getConcatString(this.serverInfos);
                str += `\n#All Active Plugins (${this.plugins.total})\n`;
                for (const plugin in this.plugins.all) {
                    str += ` ${this.plugins.all[plugin]} \n`;
                }
                return str;
            },
			getWPData() {
                this.wpLoading = true;
                this.$get('',
                {
                    action: 'ad_review_manager_ajax',
                    route: 'debug_info_wp',
                    nonce: window.ADRMAdmin.adrm_nonce,
                }).then((response) => {
						this.wordpress = response.data;
                        this.wpLoading = false;
                        console.log('wp data', response, 'loading', this.wpLoading);
					})
					.always(() => {
                        this.wpLoading = false;
					});
			},
            getADRMData() {
                this.adrmLoading = true;
                this.$get('',
                {
                    action: 'ad_review_manager_ajax',
                    route: 'debug_info_adrm',
                    nonce: window.ADRMAdmin.adrm_nonce,
                }).then((response) => {
                        this.adrmInfo = response.data;
                        this.adrmLoading = false;
					})
					.always(() => {
                        this.adrmLoading = false;
					});
            },
            getOthersData() {
                this.othersLoading = true;
                this.$get('',
                {
                    action: 'ad_review_manager_ajax',
                    route: 'debug_info_others',
                    nonce: window.ADRMAdmin.adrm_nonce,
                }).then((response) => {
						this.themeInfo = response.data.themes;
                        this.plugins = response.data.plugins;
                        this.othersLoading = false;
                        console.log('others data', response, 'loading', this.othersLoading);
					})
					.always(() => {
                        this.othersLoading = false;
					});
            },
            getServerData() {
                this.serverLoading = true;
                this.$get('',
                {
                    action: 'ad_review_manager_ajax',
                    route: 'debug_info_server',
                    nonce: window.ADRMAdmin.adrm_nonce,
                }).then((response) => {
						this.serverInfos = response.data;
                        this.serverLoading = false;
                        console.log('server data', response, 'loading', this.serverLoading);
                    })
					.always(() => {
                        this.serverLoading = false;
					});
            },

		}
	};
</script>

