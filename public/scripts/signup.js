const submiSignup = document.querySelector(".form-signup");
const firstname = document.querySelector(".firstname");
const lastname = document.querySelector(".lastname");
const username = document.querySelector(".username");
const email = document.querySelector(".email");
const password = document.querySelector(".password");

submiSignup.addEventListener("submit", async (e) => {
  e.preventDefault();
  const res = await fetch("/api/v1/auth/signup", {
    method: "POST",
    header: {
      "content-type": "application/json",
    },
    body: JSON.stringify({
      firstname: firstname.value,
      lastname: lastname.value,
      username: username.value,
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
