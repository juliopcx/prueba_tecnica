<template>
  <section class="text-center sec" cz-shortcut-listen="true">
    <main class="form-signin">
      <form @submit="handleRecoverySubmit">
        <h1 class="h3 mb-3 fw-normal">Recuperación de Contraseña</h1>
        <div class="form-floating mt-2">
          <input v-model="email" type="email" class="form-control" id="floatingEmail" placeholder="correo@dominio.com" required autofocus>
          <label for="floatingEmail">Correo Electrónico</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Enviar Correo</button>
      </form>
      <p><a href="#" @click="handleCancelRecovery">Cancelar</a></p>
    </main>
  </section>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  setup(_, { emit }) {

    const email = ref('');

    const handleRecoverySubmit = async (event) => {
      event.preventDefault();
      await sendRecoveryEmail();
    };

    const sendRecoveryEmail = async () => {
      try {
        const response = await axios.post('/recovery-password', {
          email: email.value
        });
        emit('recovery-password-success', response.data);
      } catch (error) {
        console.log(error);
      }
    };

    const handleCancelRecovery = () => {
      emit('cancel-recovery');
    };

    return {
      email,
      handleRecoverySubmit,
      handleCancelRecovery
    };
  }
};
</script>