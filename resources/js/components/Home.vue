<template>
    <form action="" @submit.prevent="submitForm">
    <h1> Form </h1>
    <label for="name">Name: </label>
    <input type="text" id="name" v-model="form.name" />

    <label for="email">Email: </label>
    <input type="email" id="email" v-model="form.email" />

    <textarea v-model="form.bio"></textarea>
    <label for="notification">Notification: </label>
    <input type="checkbox" id="notification" v-model="form.notification" />

    <p> Qual sua habilidade?</p>

    <input type="radio" name="skill" value="backend" v-model="form.skill" />
    <label for="backend">Backend</label>
    <input type="radio" name="skill" value="frontend" v-model="form.skill" />
    <label for="frontend">Frontend</label>
    <input type="radio" name="skill" value="fullstack" v-model="form.skill" />
    <label for="fullstack">Fullstack</label>


    <button type="submit">Submit</button>

    <pre>{{ form }}</pre>
    </form>
</template>

<script setup>
import { reactive, render } from 'vue';

        // const props = defineProps({
        //     user: {
        //         type: Object,
        //         required: true
        //     }
        // })

    const props = {
        user: {
            name: 'vanderlei',
            email: 'vanderlei@example.com',
            bio: 'This is a sample bio.',
            notification: false,
            skill: 'fullstack'
        }
    };

    const form = reactive({
        name: props.user.name,
        email: props.user.email,
        bio: props.user.bio,
        notification: props.user.notification,
        skill: props.user.skill
    })

    function submitForm() {
        console.log('Form submitted:', form);
    }


</script>
