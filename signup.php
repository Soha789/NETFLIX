<?php /* signup.php */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Sign Up • Streamio</title>
<style>
body{
  margin:0;font-family:sans-serif;background:#0b0f19;color:#eaeefc;
  display:flex;align-items:center;justify-content:center;height:100vh;
  background:linear-gradient(135deg,#0b0f19,#121c2e);
}
.container{
  background:#141b2b;border:1px solid rgba(255,255,255,.1);
  border-radius:20px;padding:30px;width:350px;box-shadow:0 0 20px rgba(0,0,0,.6);
}
h1{text-align:center;margin:0 0 20px;}
label{display:block;margin-top:10px;font-size:14px;color:#cfd7ef;}
input{
  width:100%;padding:10px;margin-top:5px;border-radius:8px;
  border:1px solid rgba(255,255,255,.2);background:#1b2338;color:white;
}
input:focus{border-color:#5b9dff;outline:none;}
button{
  width:100%;margin-top:20px;padding:10px;background:linear-gradient(90deg,#5b9dff,#9b6cff);
  border:none;border-radius:8px;color:white;font-weight:600;cursor:pointer;
}
p{font-size:13px;text-align:center;margin-top:15px;}
.msg{margin-top:10px;font-size:13px;text-align:center;}
.ok{color:#46d49a}.bad{color:#ff6b6b}
</style>
</head>
<body>
<div class="container">
  <h1>Create Account</h1>
  <form id="signupForm">
    <label>Name</label>
    <input id="name" required>
    <label>Email</label>
    <input id="email" type="email" required>
    <label>Password</label>
    <input id="password" type="password" required minlength="6">
    <button type="submit">Sign Up</button>
    <div class="msg" id="msg"></div>
  </form>
  <p>Already have an account? <a href="login.php" style="color:#5b9dff;">Login</a></p>
</div>

<script>
async function sha256(text){
  const buf = await crypto.subtle.digest("SHA-256", new TextEncoder().encode(text));
  return Array.from(new Uint8Array(buf)).map(b=>b.toString(16).padStart(2,"0")).join("");
}
document.getElementById("signupForm").addEventListener("submit",async e=>{
  e.preventDefault();
  const name=document.getElementById("name").value.trim();
  const email=document.getElementById("email").value.trim().toLowerCase();
  const pass=document.getElementById("password").value;
  const msg=document.getElementById("msg");
  if(!email||!pass){msg.textContent="Fill all fields";msg.className="msg bad";return;}
  let users=JSON.parse(localStorage.getItem("streamio_users")||"[]");
  if(users.find(u=>u.email===email)){msg.textContent="Email already exists";msg.className="msg bad";return;}
  users.push({name,email,pass:await sha256(pass)});
  localStorage.setItem("streamio_users",JSON.stringify(users));
  msg.textContent="Account created! Redirecting...";msg.className="msg ok";
  setTimeout(()=>{window.location.href="login.php";},1000);
});
</script>
</body>
</html>
