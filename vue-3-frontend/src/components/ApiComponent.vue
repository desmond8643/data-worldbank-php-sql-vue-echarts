<template>
  <div>
    <h1>GDP (current US$)</h1>
    <div>
      <label for="country-select">Select Country:</label>
      <select
        id="country-select"
        v-model="selectedCountry"
        @change="updateChart"
        style="margin-left: 5px;"
      >
        <option v-for="country in countries" :value="country">
          {{ country }}
        </option>
      </select>
    </div>
    <div ref="chartContainer" style="width: auto; height: 400px"></div>
  </div>
</template>

<script>
import axios from "axios"
import * as echarts from "echarts"
import { use } from "echarts/core"
import { BarChart } from "echarts/charts"
import {
  TitleComponent,
  GridComponent,
  TooltipComponent,
  LegendComponent,
} from "echarts/components"
import { CanvasRenderer } from "echarts/renderers"

use([
  TitleComponent,
  GridComponent,
  TooltipComponent,
  LegendComponent,
  BarChart,
  CanvasRenderer,
])

export default {
  data() {
    return {
      chartData: [],
      chartOptions: {},
      selectedCountry: "",
      countries: [],
    }
  },

  mounted() {
    this.fetchData()
  },

  methods: {
    fetchData() {
      axios
        .get("http://localhost/PHP/index.php")
        .then((response) => {
          console.log(response.data)
          this.chartData = response.data
          this.countries = this.getCountryList()
          this.selectedCountry = this.countries[0]
          this.updateChart()
        })
        .catch((error) => {
          console.error(error)
        })
    },

    getCountryList() {
      const countries = this.chartData.map((data) => data["Country Name"])
      return countries.filter((country) => country !== undefined)
    },

    prepareChartData() {
      const selectedCountryData = this.chartData.find(
        (data) => data["Country Name"] === this.selectedCountry
      )

      const years = Object.keys(selectedCountryData).filter(
        (key) =>
          key !== "Country Name" &&
          key !== "Country Code" &&
          key !== "Indicator Name" &&
          key !== "Indicator Code" &&
          key !== "index" &&
          key !== "Unnamed: 67" &&
          selectedCountryData[key] !== null
      )

      const getValue = years
        .filter((year) => selectedCountryData[year] !== null)
        .map((year) => parseFloat(selectedCountryData[year]))

      this.chartOptions = {
        grid: {
          left: "40",
          right: "60",
          top: "50",
          bottom: "10%",
        },
        xAxis: {
          type: "category",
          data: years,
          name: "Year",
        },
        yAxis: {
          type: "value",
          name: "US$ (Billion)", 
          nameTextStyle: {
            fontSize: 12,
            fontWeight: "bold",
          },
          axisLabel: {
            formatter: function (value) {
              if (value >= 1000000000) {
                return (value / 1000000000).toFixed(1).replace(/\.0$/, "")  
              }
              return value
            },
            textStyle: {
              fontSize: 12,
            },
          },
        },
        series: [
          {
            data: getValue,
            type: "bar",
          },
        ],
      }
    },

    updateChart() {
      this.prepareChartData()
      const container = this.$refs.chartContainer
      const chart = echarts.init(container)
      chart.setOption(this.chartOptions)
    },
  },
}
</script>
