
function ready(){
	
	Vue.component('msg',{
		data: function(){
			return{
				msgTxt: []
			}
		},
		template: '<ul class="msg" v-show="msgTxt.length"><li v-for="msg in msgTxt" v-html="msg.msg" :data-type="msg.type"></li></ul>',
		methods: {
			alertMsg: function(arr){
				var msgArr = this.msgTxt;
				msgArr.unshift(arr);
				
				getMessage(function() {
					msgArr.pop();
				});
				function getMessage(callback) {
					setTimeout(function() {
						callback();
					}, 5000);
				}
			}
		}
	});
	
	new Vue({
		el: '#app',
		data: {
			srcCaptcha: "resource/captcha/captcha.php",
			captcha: "",
			typeForm: true,
			loader: false,
			openQuest: false
		},
		methods: {
			submitForm: function(){
				this.loader = true;
				var
					formData = new FormData(document.forms["auth"]),
					typeUrl;
				this.typeForm ? typeUrl = "reg" : typeUrl = "inp";
				axios.post("http://test/auth/"+typeUrl, formData)
					.then((response) => {
						this.loader = false;
						if( response.data.add ){
							switch( response.data.add ){
								case 1:
									this.reCaptcha();
								break;
								case 2:
									this.typeForm = false;
									this.reCaptcha();
								break;
								case 3:
									window.location.href = "http://test/profile";
								break;
							}
						}
						this.$refs.msg.alertMsg(response.data);
					})
					.catch((error) => {
						this.loader = false;
						this.$refs.msg.alertMsg({msg: 'Что-то пошло не так.', type: 'error'});
					});
			},
			reCaptcha: function(){
				this.srcCaptcha = this.srcCaptcha+'?' + Math.random();
				this.captcha = '';
			}
		}
	})
}

document.addEventListener("DOMContentLoaded", ready);