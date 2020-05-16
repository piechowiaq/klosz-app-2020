<template>


    <div>

        <label>
            <input type="text" v-model="message">
        </label>
        <p>Value of this input is {{message}}</p>

    </div>

</template>

<script>


    export default {

        data()  {
            return {
                message: 'Lucas'
            };

        }




};

</script>
