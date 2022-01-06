const submitLogout = document.querySelector(".form-logout");

// const email = document.querySelector(".email");
// const password = document.querySelector(".password");

export default submitLogout?.addEventListener("submit", async (e) => {
  e.preventDefault();
  console.log("dddddddddddddddd");
  const res = await fetch("/api/v1/auth/logout", {
    method: "POST",
    header: {
      "content-type": "application/json",
    },
    body: "",
  });
  //   const data = await res.json();
  //   console.log(data);
  //   if (res.ok) {
  //     window.location.replace("/");
  //   }
});
