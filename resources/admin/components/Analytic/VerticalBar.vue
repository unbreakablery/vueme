<script>
import ChartDataLabels from "chartjs-plugin-datalabels";

import { Bar, mixins } from "vue-chartjs";
export default {
  extends: Bar,
  mixins: [mixins.reactiveProp],
  props: ["chartData", "toolTip", "money", "options"],
  mounted() {
    const $this = this;
    const tooltip = this.toolTip;
    const options = this.options;
    this.renderChart(this.chartData, {
      maintainAspectRatio: false,
      plugins: {
        // Change options for ALL labels of THIS CHART
        datalabels: {
          color: "red",
          anchor: "end",
          align: "end",
          display: function(context) {
            return context.dataset.data[context.dataIndex] !== 0; // or >= 1 or ...
          },
          formatter: function(value, context) {
            return $this.money ? new Intl.NumberFormat([],{style: 'currency', currency: 'USD'}).format(value) : new Intl.NumberFormat().format(value); // context.dataIndex + ': ' + Math.round(value*100) + '%';
          },
          labels: {
            title: {
              font: {
                weight: "bold"
              }
            }
          }
        }
      },
      ...tooltip,
      ...options
      
    });
  }
};
</script>