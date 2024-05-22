<template>
    <div class="d-flex card beer flex-row">
        <!-- <div class="image-wrapper">
            <img :src="props.brewery.image_url">
        </div> -->
        <!-- 
          {
        address_1
        address_2
        address_3
        city
        state_province
        postal_code
        country
        longitude
        latitude
        phone
        website_url
        state
        street
    }
         -->
        <div class="beer-infos flex-grow-1">
            <div class="beer-description"><b>{{ t('name') }}</b>: {{ props.brewery.name }}</div>
            <div class="beer-description"><b>{{ t('brewery_type') }}</b>: {{ props.brewery.brewery_type }}</div>
            <div class="beer-description"><b>{{ t('address_1') }}</b>: {{ props.brewery.address_1 }}</div>
            <div class="beer-description"><b>{{ t('address_2') }}</b>: {{ props.brewery.address_2 }}</div>
            <div class="beer-description"><b>{{ t('address_3') }}</b>: {{ props.brewery.address_3 }}</div>
            <div class="beer-description"><b>{{ t('city') }}</b>: {{ props.brewery.city }}</div>
            <div class="beer-description"><b>{{ t('state_province') }}</b>: {{ props.brewery.state_province }}</div>
            <div class="beer-description"><b>{{ t('postal_code') }}</b>: {{ props.brewery.postal_code }}</div>
            <div class="beer-description"><b>{{ t('country') }}</b>: {{ props.brewery.country }}</div>
            <div class="beer-description"><b>{{ t('longitude') }}</b>: {{ props.brewery.longitude }}</div>
            <div class="beer-description"><b>{{ t('latitude') }}</b>: {{ props.brewery.latitude }}</div>
            <div class="beer-description"><b>{{ t('phone') }}</b>: {{ props.brewery.phone }}</div>
            <div class="beer-description"><b>{{ t('website_url') }}</b>: {{ props.brewery.website_url }}</div>
            <div class="beer-description"><b>{{ t('state') }}</b>: {{ props.brewery.state }}</div>
            <div class="beer-description"><b>{{ t('street') }}</b>: {{ props.brewery.street }}</div>
        </div>
    </div>

  </template>

  <script setup>
  import { onMounted } from "vue";
import { useI18n } from "vue-i18n";
  const { t, locale } = useI18n();
  const props = defineProps({
    brewery: Object
  });

  onMounted(function () {
    console.log(props.brewery);
  })
  </script>

  <style scoped>
  .beer {
    padding: 20px;
    margin-bottom: 20px;
  }

  .beer .beer-more-info {
    display: flex;
    justify-content: space-between;
  }

  @media (max-width: 762px) {
    .beer .beer-more-info {
        display: block;
    }
  }
  .beer .bold {
    font-weight: bold;
  }

  .beer .image-wrapper {
    min-width: 150px;
  }

  .beer .image-wrapper img {
    height: 200px;
  }

  .beer .beer-infos {
    margin-left: 20px;
  }

  .beer .beer-name {
    font-size: 20px;
    font-weight: bold;
  }
  </style>
