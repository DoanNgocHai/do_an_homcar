<template>
  <div>
    <Navbar />
    <div class="container-main">
      <router-view></router-view>
    </div>
    <Footer />
  </div>
</template>

<script lang="ts">
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';
import { defineComponent } from 'vue';
import {
  getBrands,
  Brand,

  Figures,
  getFigures,

  Gears,
  getGears,

  Colors,
  getColors,

} from './apis/taxonomy';
import { useStore } from 'vuex';
export default defineComponent({
  components: {
    Navbar,
    Footer,
  },
  setup() {
    const store = useStore();
    return {
      store
    }
  },
  data() {
    return {
      brands: [] as Brand[],

      figures: [] as Figures[],

      gears: [] as Gears[],

      colors: [] as Colors[],
      
    };

  },
  
  methods: {
    async fetchBrands() {
      try {
        const response = await getBrands();
        this.brands = response.data;
        this.store.dispatch('brandsAction', response.data);
      } catch (error) {
        console.error('Error fetching brands:', error);
      }
    },
    async fetchFigures() {
      try {
        const response = await getFigures();
        this.figures = response.data;
        this.store.dispatch('figuresAction', response.data);

      } catch (error) {
        console.error('Error fetching brands:', error);
      }
    },
    async fetchColors() {
      try {
        const response = await getColors();
        this.colors = response.data;
        this.store.dispatch('colorsAction', response.data);

      } catch (error) {
        console.error('Error fetching brands:', error);
      }
    },
    async fetchGears() {
      try {
        const response = await getGears();
        this.gears = response.data;
        this.store.dispatch('gearsAction', response.data);
      } catch (error) {
        console.error('Error fetching brands:', error);
      }
    },
  },
  computed: {
  },
  created() {
    this.fetchBrands();
    this.fetchFigures();
    this.fetchGears();
    this.fetchColors();
  },
});
</script>

<style scoped>
.container-main {
  min-height: 70vh;
  padding: 5rem 0;
}

.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}

.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}

.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
