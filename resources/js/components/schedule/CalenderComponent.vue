<template>
    <div>
        <div class="row">
            <div class="col-lg-12 mb-5">
                <div class="float-right">
                    <button :class="['btn', {'btn-primary':createScheduleButtonClicked == false,'btn-warning': createScheduleButtonClicked}]" @click="toggleScheduleForm">{{toggle_button_text}}</button>
                </div>
            </div>
            <div class="col-lg-12">
                <div>
                    <AddScheduleComponent v-if="createScheduleButtonClicked" :guards="guards"/>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import AddScheduleComponent from './AddScheduleComponent.vue'
    export default {
        props:['guards'],
        name:'CalenderTable',
        components:{AddScheduleComponent},
        data()
        {
            return{
                createScheduleButtonClicked:false,
                toggle_button_text:'Show Create Schedule'
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            toggleScheduleForm(){
                this.createScheduleButtonClicked = !this.createScheduleButtonClicked;
                if(this.createScheduleButtonClicked == true){
                    this.toggle_button_text = 'Hide Create Schedule'
                }else{
                    this.toggle_button_text = 'Show Create Schedule'
                }
            }
        }
    }
</script>
