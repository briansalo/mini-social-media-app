<template>
<main class="content">
    <div class="container p-0 pt-4">

		<div class="card">
			<div class="row g-0">

				<div class="col-12 col-lg-12 col-xl-12">
					<div class="py-2 px-4 border-bottom d-none d-lg-block">
						<div class="d-flex align-items-center py-1">
                            <!--profile pic-->
                            <div class="position-relative" v-if="this.receiveruser.profile_photo">
                                <img :src="'/upload/profile/'+this.receiveruser.profile_photo" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                            </div>
                            <div class="position-relative" v-else>
                                <img :src="'/upload/profile/profile.jpg'" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                            </div>
                                <!---->
                            <a :href="'/stalk_profile/'+this.receiverid" target="_blank">
                                <div class="flex-grow-1 ps-2 toCapitalFirst">
                                    <strong> {{this.receiveruser.name}}</strong>
                                </div>
                            </a>
						</div>
					</div>

					<div class="position-relative" id="containerbrian">
						<div class="chat-messages p-4">
                        <div v-for="message in messages" :key="message.id">
                            
                            <!--condition if the message from authenticated user-->
							<div class="chat-message-right pb-4" v-if="authid==message.user_id">
                                <!---profile pic----->
								<div v-if="message.user.profile_photo">
									<img :src="'/upload/profile/'+message.user.profile_photo" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
									<div class="text-muted small text-nowrap mt-2">2:33 am</div>
								</div>
								<div v-else>
									<img :src="'/upload/profile/profile.jpg'" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
									<div class="text-muted small text-nowrap mt-2">2:33 am</div>
								</div>
                                <!---->
								<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                    
                                        {{message.message}}
								</div>
							</div>

                            <!---else the message is not from authenticated user-->
							<div class="chat-message-left pb-4" v-else>
                                <!---profile pic----->
								<div v-if="message.user.profile_photo">
									<img :src="'/upload/profile/'+message.user.profile_photo" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
									<div class="text-muted small text-nowrap mt-2">2:33 am</div>
								</div>
								<div v-else>
									<img :src="'/upload/profile/profile.jpg'" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
									<div class="text-muted small text-nowrap mt-2">2:33 am</div>
								</div>
                                <!---->
								<div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                        {{message.message}}
								</div>
							</div>
                        </div>
						</div>
					</div>

					<div class="flex-grow-0 py-3 px-4 border-top">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Type your message"
                            v-model="newMessage"
                            @keyup.enter="sendMessage">
							<button class="btn btn-primary" @click="sendMessage">Send</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</main>
</template>


<script>
export default {
     props: ["authid","receiverid","authuser","receiveruser"],

    data() {
        return {
            messages: [],
            newMessage:"",
            test:''
         }
     },
    created() {

        this.fetchmessage();
    
        Echo.private('chat.'+this.authid+this.receiverid)
        .listen('MessageSent', (e) => {
          //  this.fetchmessage();
            this.messages.unshift({
                message: e.message.message,
                user: e.user
            });

        });

    },

    methods:{

        fetchmessage(){
            axios.get('/messages/'+this.receiverid).then(response => {
                this.messages = response.data;
            });
        },

        sendMessage(){
            axios.post('/messages',{
                message:this.newMessage,
                receiver_id:this.receiverid,
            }).then(response => {
                //instead of push i use unshift to reverse. since our css is reverse
                this.messages.unshift(response.data)
                this.newMessage=''
            });
        },

   
    }
}
</script>
<style>

.toCapitalFirst {
  text-transform: capitalize;
}

/* this is css to auto reverse. we're doing this to always scroll to bottom*/
.chat-messages {
  height: 400px;
  overflow: auto;
  display: flex;
  flex-direction: column-reverse;
}

.chat-message-left,
.chat-message-right {
    display: flex;
    flex-shrink: 0
}

.chat-message-left {
    margin-right: auto
}

.chat-message-right {
    flex-direction: row-reverse;
    margin-left: auto
}
.py-3 {
    padding-top: 1rem!important;
    padding-bottom: 1rem!important;
}
.px-4 {
    padding-right: 1.5rem!important;
    padding-left: 1.5rem!important;
}
.flex-grow-0 {
    flex-grow: 0!important;
}
.border-top {
    border-top: 1px solid #dee2e6!important;
}
</style>