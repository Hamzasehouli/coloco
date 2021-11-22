const submitLogin = document.querySelector(".form-login");

const email = document.querySelector(".email");
const password = document.querySelector(".password");

submitLogin.addEventListener("submit", async (e) => {
  e.preventDefault();
  const res = await fetch("/api/v1/auth/login", {
    method: "POST",
    header: {
      "content-type": "application/json",
    },
    body: JSON.stringify({
      email: email.value,
      password: password.value,
    }),
  });
  const data = await res.json();
  console.log(data);
  if (res.ok) {
    window.location.replace("/");
  }
});
