<template>
  <section class="text-center sec" cz-shortcut-listen="true">
    <main class="form-signin">
      <form @submit="handleSubmit">
        <h1 class="h3 mb-3 fw-normal">Login Form</h1>
        <div class="form-floating">
          <input v-model="username" type="text" class="form-control" id="floatingInput" placeholder="correo@dominio.com" required autofocus>
          <label for="floatingInput">Usuario</label>
        </div>
        <div class="form-floating">
          <input v-model="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required autofocus>
          <label for="floatingPassword">Contraseña</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Entrar</button>
      </form>
      <p><a href="#" @click="handlePasswordRecovery">¿Olvidaste tu contraseña?</a></p>
    </main>
  </section>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  setup(_, { emit }) {
    
    const username = ref('');
    const password = ref('');
    const error    = ref(null);

    const handleSubmit = async (event) => {
      event.preventDefault();
      await login();
    };

    const login = async () => {
      try {
          const response = await axios.post('/login', {
          username: username.value,
          password: password.value,
        });
        emit('login-success', response.data);
      } catch (error) {
        console.log(error); 
      }
    };

    const handlePasswordRecovery = () => {
      emit('show-recovery');
    };

    return {
      username,
      password,
      error,
      handleSubmit,
      handlePasswordRecovery
    };
  }
};
</script>