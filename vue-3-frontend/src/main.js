import { createApp } from "vue"
import App from "./App.vue";
import ECharts from "vue-echarts";
import "echarts/lib/chart/bar";
import "echarts/lib/component/tooltip";
import "echarts/lib/component/legend";
import "echarts/lib/component/title";
import "echarts/lib/component/toolbox";
import "echarts/lib/chart/line";

const app = createApp(App);
app.component("v-chart", ECharts);
app.mount("#app");