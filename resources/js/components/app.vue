<template>
<div id="app">
    <Login v-if="currentComponent === 'Login'" @login-success="handleLoginSuccess($event)" @show-recovery="handleShowRecovery" />
    <PasswordRecovery v-if="currentComponent === 'PasswordRecovery'" @cancel-recovery="handleCancelRecovery" @recovery-password-success="recoveryPasswordSuccess($event)" />
      
  </div>
</template>

<script>
import { ref } from 'vue';
import Login from './login.vue';
import PasswordRecovery from './passwordRecovery.vue';

export default {
   components:{ Login, PasswordRecovery },
   setup() {
    const currentComponent = ref('Login');
    const showRecovery = ref(false);
    const message      = ref('');

    const handleShowRecovery = () => {
      currentComponent.value = 'PasswordRecovery';
    };

    const handleCancelRecovery = () => {
      currentComponent.value = 'Login';
    };

    const handleLoginSuccess = (event) => {
      event.ok ? alert('Credenciales correctas') : alert(event.message);
    };

    const recoveryPasswordSuccess = (event) => {
      event.ok ? alert('Mensaje recuperación enviado') : alert(event.message);
    }

    return {
     currentComponent,
     showRecovery,
     message,
     handleLoginSuccess,
     handleShowRecovery,
     handleCancelRecovery,
     recoveryPasswordSuccess
    };
  }

}
</script>

