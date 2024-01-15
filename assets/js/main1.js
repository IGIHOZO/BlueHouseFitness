document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('loginForm');
    const loadingContainer = document.getElementById('loadingContainer');

    form.addEventListener('submit', function (event) {
      event.preventDefault();
      event.stopPropagation();

      if (form.checkValidity()) {
        showLoadingMessage();
        submitLoginForm();
      }

      form.classList.add('was-validated');
    });

    function showLoadingMessage() {
      loadingContainer.innerHTML = '<p class="text-muted">Checking, please wait...</p>';
    }

    function submitLoginForm() {
      const username = document.getElementById('yourUsername').value;
      const password = document.getElementById('yourPassword').value;
      const rememberMe = document.getElementById('rememberMe').checked;

      fetch('main/action.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          'AdminLogin': '1',
          'phone': username,
          'password': password,
          'rememberMe': rememberMe,
        }),
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Login successful, redirect to index.php
          window.location.href = 'dashboard.php';
        } else {
          // Login failed, display an error message
          document.getElementById('alertContainer').innerHTML =
            `<div class="alert alert-danger" role="alert">${data.message}</div>`;
        }
      })
      .catch(error => {
        console.error('Error:', error);
      })
      .finally(() => {
        // Hide the loading message after login attempt
        loadingContainer.innerHTML = '';
      });
    }
  });


  //============logout
  document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('logoutButton');

    logoutButton.addEventListener('click', function () {
      logout();
    });

    function logout() {
      fetch('logout.php', {
        method: 'GET',
      })
      .then(response => {
        if (response.redirected) {
          // Redirect to the login page after logout
          window.location.href = response.url;
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }
  });
