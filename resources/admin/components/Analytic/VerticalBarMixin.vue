<script>
import { mapGetters } from "vuex";
import moment from "moment";

export default {  
  data() {
    return {
      years: [],
      year: false,
      month: false,
      months: [
        { text: "January", value: 1 },
        { text: "February", value: 2 },
        { text: "March", value: 3 },
        { text: "April", value: 4 },
        { text: "May", value: 5 },
        { text: "June", value: 6 },
        { text: "July", value: 7 },
        { text: "August", value: 8 },
        { text: "September", value: 9 },
        { text: "October", value: 10 },
        { text: "November", value: 11 },
        { text: "December", value: 12 }
      ],
      store: "analytic",
      datacollection: null,
      datacollection2: null,
      toolTip: null,
      options: [],
      
      counts: {
        cont1: 0,
        cont2: 0,
        cont3: 0,
        cont4: 0,
        cont5: 0
      },
      yearTotal: {
        cont1: 0,
        cont2: 0,
        cont3: 0,
        cont4: 0,
        cont5: 0
      },
      monthTotal: {
        cont1: 0,
        cont2: 0,
        cont3: 0,
        cont4: 0,
        cont5: 0
      }
    };
  },    
  computed: {
    ...mapGetters({
      loading: "analytic/loading"
    }),
  },
  methods:{
    reset(){
      this.month = null;
      this.year = parseInt(moment().format("Y"));
    },
    printChart() {
      var canvasEle = document.getElementById("bar-chart");
      var win = window.open("", "Print", "height=600,width=800");
      win.document.write("<br><img src='" + canvasEle.toDataURL() + "' />");
      setTimeout(function() {
        //giving it 200 milliseconds time to load
        win.document.close();
        win.focus();
        win.print();
        win.location.reload();
      }, 200);
    }
  },
  
  watch: {
    loading(val) {
      this.$store.dispatch("util/setLoading", val);
    }
  },
  created() {
    let year = parseInt(moment().format("Y"));

    while (true) {
      if (year >= 2019) {
        this.years.push(year--);
      } else {
        break;
      }
    }
    this.year = parseInt(moment().format("Y"));  
  },
  filters:{
    month(val){return moment(val, 'M').format('MMMM')}
  }
};
</script>
