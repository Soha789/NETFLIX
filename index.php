<?php /* index.php */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Streamio • Watch</title>
<style>
body{margin:0;font-family:sans-serif;background:#0a0e17;color:#eaf0ff;}
.nav{background:#101826;padding:10px 15px;display:flex;align-items:center;gap:10px;}
.logo{width:25px;height:25px;border-radius:6px;
background:conic-gradient(from 220deg,#5b9dff,#9b6cff,#5b9dff);}
.nav h1{font-size:18px;margin:0;color:#fff;}
.btn{background:linear-gradient(90deg,#5b9dff,#9b6cff);border:none;
padding:8px 14px;border-radius:8px;color:#fff;font-weight:600;cursor:pointer;}
.grid{padding:15px;}
.row{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;}
.card{background:#141b2b;border-radius:12px;overflow:hidden;cursor:pointer;
transition:.2s;}
.card:hover{transform:translateY(-3px);}
.thumb{aspect-ratio:16/9;background:#1f2a48;}
.title{padding:8px;font-weight:600;}
dialog{border:none;border-radius:12px;width:min(800px,95%);
background:#0e1626;color:white;box-shadow:0 10px 40px rgba(0,0,0,.5);}
iframe,video{width:100%;border-radius:10px;}
</style>
</head>
<body>
<div class="nav">
  <div class="logo"></div><h1>Streamio</h1>
  <span id="welcome" style="margin-left:auto"></span>
  <button class="btn" id="logout">Logout</button>
</div>

<div class="grid">
  <h2>Available Movies</h2>
  <div class="row" id="row"></div>
</div>

<dialog id="player">
  <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;">
    <h3 id="dlgTitle">Playing…</h3>
    <button class="btn" onclick="player.close()">Close</button>
  </div>
  <div style="padding:10px;">
    <div id="videoArea"></div>
  </div>
</dialog>

<script>
// ===== Check Login =====
const user=JSON.parse(localStorage.getItem("streamio_currentUser")||"null");
if(!user)location.href="login.php";
document.getElementById("welcome").textContent=`Hi, ${user.name.split(" ")[0]}!`;
document.getElementById("logout").onclick=()=>{localStorage.removeItem("streamio_currentUser");location.href="login.php";};

// ===== Movie Catalog =====
const catalog=[
 {id:1,title:"Skyline Chase",src:"videos/skyline.mp4"},
 {id:2,title:"Quantum Class",src:"videos/quantum.mp4"},
 {id:3,title:"Laugh Lane",src:"videos/laughlane.mp4"},
 {id:4,title:"Deep Blue",src:"videos/deepblue.mp4"},
 // 👇 This one plays your YouTube video with full voice
 {id:5,title:"Neon Drift (Official Video)",src:"https://www.youtube.com/embed/MyqZf8LiWvM"},
 // 👇 Rehan Documentary stays as before
 {id:6,title:"Rehan Documentary",src:"https://www.youtube.com/embed/-q6gUoJgZCM"}
];

// ===== Render Movie Cards =====
const row=document.getElementById("row");
row.innerHTML=catalog.map(m=>`
 <div class="card" onclick="openPlayer(${m.id})">
   <div class="thumb"></div>
   <div class="title">${m.title}</div>
 </div>`).join("");

// ===== Player =====
const player=document.getElementById("player"),area=document.getElementById("videoArea");
function openPlayer(id){
 const m=catalog.find(x=>x.id===id);if(!m)return;
 if(m.src.includes("youtube.com")){
   // autoplay with voice enabled
   area.innerHTML=`<iframe src="${m.src}?autoplay=1"
     frameborder="0"
     allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
     allowfullscreen></iframe>`;
 } else {
   area.innerHTML=`<video controls autoplay src="${m.src}" style="width:100%" preload="auto"></video>`;
 }
 document.getElementById("dlgTitle").textContent=m.title;
 player.showModal();
}
</script>
</body></html>
