<template>
    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Verified at</th>
                <th>Actions</th>
            </tr>
            <tr v-for="user in users">
                <td>{{user.id}}</td>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td v-if="user.role_id === 1">Administrator</td>
                <td v-else>Regular</td>
                <td>{{user.email_verified_at}}</td>
                <td>
                    <input type="button" value="DELETE" style="color: red" @click="deleteUser(user.id)">
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";
    export default {
        name: "Users",
        data(){
            return {
                users : null
            }
        },
        beforeRouteEnter(to, from, next){
            //TODO handle pagination for both end
            HTTP.GET("/admin/users")
                .then(res => {
                    let users = res.data.data;
                    console.log(users);
                    next(vm => vm.users = res.data.data);
                }).catch(err => {
                    console.log(err);
                })
        },

        methods: {
            async deleteUser(user_id){
                await HTTP.DELETE("/admin/users/"+user_id);
                this.users = this.users.filter(user => user.id != user_id);
                window.alert("User Deleted!");
            }
        }
    }
</script>