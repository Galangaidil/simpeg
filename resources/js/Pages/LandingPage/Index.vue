<script setup>
import Header from './partials/Header.vue';
import Hero from './partials/Hero.vue';
import Feature from './partials/Feature.vue';
import Offer from './partials/Offer.vue';
import Testimonial from './partials/Testimonial.vue';
import Footer from './partials/Footer.vue';
import Faq from './partials/Faq.vue';
import {Head} from "@inertiajs/inertia-vue3";
</script>

<template>
    <Head>
        <title>Sistem Informasi kepegawaian</title>
    </Head>

    <div class="bg-white dark:bg-gray-900">
        <Header/>
        <Hero/>
        <Feature/>
        <Offer/>
        <Testimonial/>
        <Faq />
        <Footer/>
    </div>
</template>
