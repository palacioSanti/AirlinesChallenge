<template>
    <div class="mb-3 mt-4">
        <input type="text" v-model="cityName" placeholder="Name of the city" class="form-input mt-1 block w-full" />
        <button @click="addCity" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded">Add city</button>
    </div>
</template>

<script>

export default {
    data() {
        return {
            cityName: ''
        };
    },
    methods: {
        addCity() {
            if (!this.cityName) {
                alert('The name of the city cant be empty.');
                return;
            }

            axios.post('/api/cities', {
                name: this.cityName,
            })
            .then(response => {
                alert('The city has been added successfully.');
                this.$emit('cityAdded', response.data.city);
                this.cityName = '';
            })
            .catch(error => {
                if (error.response && error.response.data && error.response.data.errors) {
                    alert(error.response.data.errors.name[0]);
                } else if (error.response && error.response.data && error.response.data.message) {
                    alert(error.response.data.message);
                } else {
                    alert('Unknown error adding city.');
                }
            });
        }
    }
};
</script>

