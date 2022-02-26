<template>
    <div id="postcards">
        <h2>I tuoi menu</h2>

        <div class="mb-2 btn btn-success">create</div>
        
        <table border="2">
            <tr>
                <!-- <th>{{user.id}}</th> -->
                <th>name</th>
                <th>desciption</th>
                <th>price</th>
                <th>user id</th> 
                <th>edit</th>  
                <th>delete</th>
            </tr>

            <tr v-for="dish in dishes" :key="dish.id">
                <td>{{dish.name}}</td>
                <td>{{dish.description}}</td>
                <td>{{dish.price}}</td>
                <td>{{dish.user_id}}</td>
                <td><button class="m-2 btn btn-primary">edit</button></td>
                <td><button class="m-2 btn btn-danger">delete</button></td>

                <!-- <td><img :src="'storage/dishs/' + dish.image"></td> -->
            </tr>
        </table>
    </div>
</template>
<script>
export default {
    data: function(){
        return{
            dishes: []
        };
    },
    props: {

        user: String
    },
    mounted() {
        axios.get('/api/dishes/')
            .then(r=> this.dishes = r.data)
            .catch(e=>console.error(e));
    },

}
</script>