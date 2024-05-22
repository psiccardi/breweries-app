<template>
    <div ref="breweriesList" class="infinite-scroll beers_wrapper" id="beers_wrapper">
      <brewery v-for="brewery in breweries"  :brewery="brewery" :key="'breweries_' + brewery.id">
      </brewery>
    </div>
  </template>

  <script setup>
  import { ref, watch, toRaw, onMounted, reactive } from "vue";
  import { useI18n } from "vue-i18n";
  import loadingSvg from './../../images/loading.svg'
  import {
    getBreweriesAPI
  } from "../../js/utilities/api.js";
  import GenericModal from "../modals/GenericModal.vue";
  import Utils from "../../js/utilities/utils.js";
  import Brewery from "../components/Brewery.vue";
  const { t, locale } = useI18n();
  const props = defineProps({
    refreshUser: Function,
  });

  const emit = defineEmits(["update-user"]);
  const user = ref({});
  const page = ref(0);
  const limit = ref(20);
  const breweries = ref([]);
  const breweriesList = ref(null);
  const refreshUser = props.refreshUser;
  const data_finished = ref(false);
  const fetching_breweries_data = ref(false);

  const resetData = () => {
    breweries.value = [];
    page.value = 0;
    data_finished.value = false;
  };

  const getBreweries = () => {
    const data = {
      page: page.value,
      limit: limit.value,
    };
    fetching_breweries_data.value = true;
    Utils.DOM.addLoading(loadingSvg);
    getBreweriesAPI(
      data,
      (resp) => {
        Utils.DOM.removeLoading();
        fetching_breweries_data.value = false;
        Utils.response.handleError(resp);
        const _breweries = breweries.value;
        _breweries.push(...resp);
        breweries.value = _breweries;
        if (resp.length === 0) {
          data_finished.value = true;
        }
      },
      (err) => {
        // Utils.DOM.removeLoading();
        // fetching_breweries_data.value = false;
        // Utils.DOM.toast(err.message, "error", t);
        // console.log(err.stack);
      }
    );
  };

  onMounted(() => {
    refreshUser(null, emit, user, {}, function () {
      getBreweries();
    });

    Utils.functions.initInfiniteScroll(breweriesList.value, () => {
      console.log('scrolling');
      if (data_finished.value == false && !fetching_breweries_data.value) {
        page.value += 1;
        getBreweries();
      }
    });
  });
  </script>

  <style scoped>
  #full_name_wrapper {
    top: 40px;
  }

  #full_name_wrapper ul {
    list-style-type: none;
    padding: 5px;
    border: 1px solid #828da0;
    background-color: white;
  }

  #full_name_wrapper ul li {
    background-color: white;
  }

  .beers_wrapper {
    max-height: calc(100vh - 40px); /* -40px -40px -40px */
    overflow: auto;
    padding: 20px;
  }
  </style>
