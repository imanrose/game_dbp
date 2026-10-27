<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Baling Craftverse</title>
<style>
*{box-sizing:border-box}
html,body{margin:0;height:100%;overflow:hidden;font-family:"Trebuchet MS",Arial,sans-serif;background:#9be7ff;color:#1c2b4a}
#c{position:fixed;inset:0;width:100%;height:100%;display:block}
.scr{position:fixed;inset:0;display:none;flex-direction:column;align-items:center;justify-content:center;gap:16px;padding:16px;text-align:center}
.scr.on{display:flex}
.panel{background:rgba(255,255,255,.93);border:6px solid #ffd43b;border-radius:28px;padding:22px;max-width:640px;width:100%;box-shadow:0 8px 0 rgba(0,0,0,.15)}
h1{margin:0;font-size:clamp(28px,6vw,52px);color:#e8590c}
p{margin:4px 0;font-size:clamp(16px,2.6vw,22px)}
.rb{font:inherit;font-weight:800;font-size:clamp(18px,3vw,26px);min-height:64px;min-width:64px;padding:10px 26px;border-radius:999px;border:5px solid #fff;color:#fff;background:#339af0;box-shadow:0 5px 0 rgba(0,0,0,.25);cursor:pointer}
.rb:active{transform:translateY(3px)}
.rb:disabled{background:#adb5bd;cursor:default}
.rb.g{background:#40c057}.rb.r{background:#fa5252}.rb.o{background:#fd7e14}.rb.sm{min-height:48px;min-width:48px;font-size:16px;padding:6px 14px}
.rb.on{outline:5px solid #ffd43b}
textarea{width:100%;height:130px;font:inherit;font-size:20px;border-radius:16px;border:4px solid #74c0fc;padding:10px}
#list{display:flex;flex-direction:column;gap:10px;max-height:34vh;overflow:auto;margin:10px 0}
#hudwrap{position:fixed;inset:0;display:none;pointer-events:none}
#hudwrap.on{display:block}
#hudwrap button,#bar{pointer-events:auto}
#bar{position:absolute;top:0;left:0;right:0;z-index:20;display:flex;flex-wrap:wrap;gap:8px;align-items:center;padding:8px 10px;background:rgba(255,255,255,.88)}
#bar span{font-weight:800;font-size:18px}
.grp{display:flex;gap:6px;align-items:center}
#card{position:absolute;top:84px;left:50%;transform:translateX(-50%);width:min(92vw,720px);background:#fffbe6;border:6px solid #ffd43b;border-radius:24px;padding:12px 16px;text-align:center;display:none;pointer-events:none}
#card.on{display:block}
#card .k{font-size:16px;color:#e8590c;font-weight:800}
#card .p{font-size:clamp(22px,4.4vw,38px);font-weight:800}
#card .p b{color:#1971c2;border-bottom:5px solid #1971c2;padding:0 6px}
#card .m{font-size:clamp(14px,2.4vw,20px)}
#answers{position:absolute;bottom:18px;left:0;right:0;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;padding:0 8px}
#dpad{position:absolute;left:16px;bottom:16px;display:grid;grid-template-columns:repeat(3,68px);grid-template-rows:repeat(3,68px);gap:4px}
#dpad.off{display:none}
#dpad button{touch-action:none;font-size:28px;padding:0;min-height:0;border-radius:50%}
#arrow{position:absolute;top:78px;right:16px;width:74px;height:74px;border-radius:50%;background:rgba(255,255,255,.9);border:5px solid #ffd43b;display:flex;align-items:center;justify-content:center;font-size:44px;color:#e8590c;transition:transform .2s}
#arrow.off{display:none}
#toast{position:absolute;bottom:110px;left:50%;transform:translateX(-50%);background:#fff;border:5px solid #40c057;border-radius:999px;padding:10px 24px;font-size:clamp(18px,3.4vw,28px);font-weight:800;display:none;text-align:center}
#toast.on{display:block}
#win{z-index:30;background:rgba(255,255,255,.35)}
#fatal{position:fixed;inset:0;display:none;align-items:center;justify-content:center;background:#fff;z-index:99;padding:24px;font-size:22px;text-align:center}
@media (prefers-reduced-motion:reduce){*{transition:none!important;animation:none!important}}
</style>
</head>
<body>
<canvas id="c"></canvas>

<div id="menu" class="scr on">
 <div class="panel">
  <h1>🧱 Baling Craftverse</h1>
  <p>Baling blok ke tong yang betul!</p>
  <p>Siapkan peribahasa, dapat baju zirah! 🛡️</p>
  <div style="display:flex;flex-direction:column;gap:12px;margin-top:14px;align-items:center">
   <button class="rb g" id="bSingle">🙋 Murid Tunggal</button>
   <button class="rb o" id="bClass">👥 Senarai Kelas (Kongsi 1 Laptop)</button>
   <a id="lobi" href="{{ url('/peribahasa/lobby') }}" style="display:none;font-size:20px;font-weight:800;color:#1971c2">🏠 Kembali ke Lobi</a>
  </div>
 </div>
</div>

<div id="kelas" class="scr">
 <div class="panel">
  <h1 style="font-size:clamp(24px,5vw,40px)">👥 Senarai Kelas</h1>
  <p>Tampal nama. Satu nama satu baris.</p>
  <textarea id="names" placeholder="Ali&#10;Siti&#10;Ravi"></textarea>
  <div style="margin-top:8px"><button class="rb sm g" id="bSave">💾 Simpan Senarai</button></div>
  <p><b>Pilih nama untuk bermain:</b></p>
  <div id="list"></div>
  <button class="rb sm r" id="bBack">⬅ Kembali</button>
 </div>
</div>

<div id="hudwrap">
 <div id="bar">
  <button class="rb sm r" id="bEnd">⏹ Tamat</button>
  <span id="who"></span><span id="prog"></span>
  <div class="grp"><span>🔍</span>
   <button class="rb sm zb" data-z="0">Dekat</button><button class="rb sm zb on" data-z="1">Biasa</button><button class="rb sm zb" data-z="2">Jauh</button></div>
  <div class="grp"><span>🔊</span>
   <button class="rb sm vb" data-v="1">Kuat</button><button class="rb sm vb on" data-v=".6">Sederhana</button><button class="rb sm vb" data-v="0">Senyap</button></div>
 </div>
 <div id="arrow">⬆</div>
 <div id="card"></div>
 <div id="toast"></div>
 <div id="dpad">
  <button class="rb" data-d="u" style="grid-area:1/2">▲</button>
  <button class="rb" data-d="l" style="grid-area:2/1">◀</button>
  <button class="rb" data-d="r" style="grid-area:2/3">▶</button>
  <button class="rb" data-d="d" style="grid-area:3/2">▼</button>
 </div>
 <div id="answers"></div>
</div>

<div id="win" class="scr">
 <div class="panel">
  <h1>🎉 Tahniah! 🎉</h1>
  <p id="winName" style="font-size:28px;font-weight:800"></p>
  <p>Mahkota emas sudah dipasang! 👑</p>
  <button class="rb g" id="bNext">➡ Seterusnya</button>
 </div>
</div>
<div id="fatal"></div>

<script>window.BC_BASE="{{ asset('baling') }}/";</script>
<script src="{{ asset('baling/three.min.js') }}"></script>
<script>
(function(){
'use strict';
function $(id){return document.getElementById(id);}
function fatal(m){var f=$('fatal');f.textContent=m;f.style.display='flex';}

function boot(){
var RM=!!(window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches);
var TOTAL=8;
/* Bank soalan peribahasa: p = ayat (___ = tempat kosong), w = jawapan, x = pilihan salah */
var QS=[
{e:'⛏️',p:'Diam penggali ___.',w:'BERKARAT',x:['BERKILAT','BERLUBANG'],m:'Ilmu yang tidak diamalkan akan hilang.'},
{e:'🦆',p:'Hendak belajar berenang dapatkan ___, hendak belajar memanjat dapatkan tupai.',w:'ITIK',x:['KUCING','KERBAU'],m:'Hendak belajar sesuatu, carilah orang yang pakar.'},
{e:'🐔',p:'Seperti ayam ___ anak.',w:'MEMATUK',x:['MENARI','MENCIUM'],m:'Ibu bapa menghukum anak untuk membetulkan kelakuan mereka.'},
{e:'🎣',p:'Kalau kail panjang sejengkal, lautan dalam usah ___.',w:'DIDUGA',x:['DIMINUM','DIBELI'],m:'Jangan memandang rendah kebolehan orang lain.'},
{e:'🌊',p:'Kalau takut dilambung ___, jangan berumah di tepi pantai.',w:'OMBAK',x:['HUJAN','PASIR'],m:'Jangan ambil risiko jika takut akibatnya.'},
{e:'🔪',p:'Belakang parang kalau diasah lagikan ___.',w:'TAJAM',x:['TUMPUL','BESAR'],m:'Jika berusaha gigih, orang yang kurang pandai akan berjaya juga.'},
{e:'⛵',p:'Malas berdayung, perahu ___.',w:'HANYUT',x:['TERBANG','KERING'],m:'Kejayaan tidak dicapai jika seseorang malas berusaha.'},
{e:'✒️',p:'Alang-alang berdakwat biarlah ___.',w:'HITAM',x:['PUTIH','MERAH'],m:'Jika mengerjakan sesuatu, janganlah sekerat jalan.'}
];
var PN=['Topi Besi','Baju Zirah','Bahu Besi','Sarung Tangan','Kasut Kuat','Jubah Ungu','Perisai Hijau','Tali Pinggang'];
var SP=[[0,-22],[28,-26],[44,0],[28,28],[0,30],[-28,28],[-44,0],[-28,-26]];
var ZM=[16,26,38];
var BCOL=[0xff6b6b,0x4dabf7,0x51cf66];

/* ===== Semua pembolehubah dinyatakan SEBELUM gelung bermula ===== */
var mode='menu',classMode=false,cur=null,done=new Set(),won=false;
var qs=null,flight=null,wob=null,finTimer=null,pops=[],conf=null,confV=null;
var px=0,pz=10,vx=0,vz=0,ang=Math.PI,ph=0,zoom=1,tm=0,last=0;
var data={},names=[];
var keys={},touch={};
var AC=null,master=null,mus=null,mp3=null,mp3Ok=null,musTimer=null,wantMusic=false,vol=0.6,step=0;
var toastT=null;

try{data=JSON.parse(localStorage.getItem('bc_prog')||'{}')||{};}catch(e){data={};}
try{names=(localStorage.getItem('bc_names')||'').split('\n').filter(Boolean);}catch(e){names=[];}

/* ===== Three.js ===== */
var renderer;
try{renderer=new THREE.WebGLRenderer({canvas:$('c'),antialias:true});}
catch(e){fatal('Pelayar ini tidak menyokong WebGL 3D. Cuba pelayar Chrome atau Edge.');return;}
renderer.setPixelRatio(Math.min(window.devicePixelRatio||1,2));
var scene=new THREE.Scene();
scene.background=new THREE.Color(0x9be7ff);
scene.fog=new THREE.Fog(0x9be7ff,60,150);
var camera=new THREE.PerspectiveCamera(50,1,0.1,300);
var look=new THREE.Vector3(0,1.5,10);
scene.add(new THREE.HemisphereLight(0xffffff,0x88cc88,0.95));
var sun=new THREE.DirectionalLight(0xffffff,0.55);sun.position.set(30,50,20);scene.add(sun);
function resize(){var w=window.innerWidth,h=window.innerHeight;renderer.setSize(w,h,false);camera.aspect=w/h;camera.updateProjectionMatrix();}
window.addEventListener('resize',resize);resize();

function M(c){return new THREE.MeshLambertMaterial({color:c});}
function bx(w,h,d,c,x,y,z,par){var m=new THREE.Mesh(new THREE.BoxGeometry(w,h,d),M(c));m.position.set(x,y,z);(par||scene).add(m);return m;}

/* tanah petak mainan */
(function(){
 var cv=document.createElement('canvas');cv.width=cv.height=64;var c=cv.getContext('2d');
 c.fillStyle='#8ce99a';c.fillRect(0,0,64,64);c.fillStyle='#69db7c';c.fillRect(0,0,32,32);c.fillRect(32,32,32,32);
 var t=new THREE.CanvasTexture(cv);t.wrapS=t.wrapT=THREE.RepeatWrapping;t.repeat.set(40,40);
 var g=new THREE.Mesh(new THREE.PlaneGeometry(160,160),new THREE.MeshLambertMaterial({map:t}));
 g.rotation.x=-Math.PI/2;scene.add(g);
})();

/* ===== Halangan (jarak lapang dijamin) ===== */
var obst=[],placed=[],seed=12345;
function rnd(){seed=(seed*16807)%2147483647;return seed/2147483647;}
function okPos(x,z,big){
 if(Math.hypot(x,z)<14||Math.hypot(x,z-10)<10)return false;
 for(var i=0;i<SP.length;i++){if(Math.hypot(x-SP[i][0],z-SP[i][1])<(big?12:8))return false;}
 for(var j=0;j<placed.length;j++){var o=placed[j];if(Math.hypot(x-o.x,z-o.z)<((big||o.big)?11:8))return false;}
 return true;
}
var BC=[0xff8787,0x74c0fc,0xffd43b,0xb197fc,0xffa94d,0x63e6be];
var tries=0,nb=0;
while(nb<14&&tries<600){tries++;
 var bxp=(rnd()-0.5)*124,bzp=(rnd()-0.5)*124;
 if(!okPos(bxp,bzp,true))continue;
 var bw=4+rnd()*3,bd=4+rnd()*3,bh=4+rnd()*5,bcol=BC[nb%BC.length];
 bx(bw,bh,bd,bcol,bxp,bh/2,bzp);
 var roof=new THREE.Mesh(new THREE.ConeGeometry(Math.max(bw,bd)*0.75,2.2,4),M(0xe03131));
 roof.rotation.y=Math.PI/4;roof.position.set(bxp,bh+1.1,bzp);scene.add(roof);
 obst.push({x:bxp,z:bzp,hw:bw/2,hd:bd/2});placed.push({x:bxp,z:bzp,big:true});nb++;}
tries=0;var nt=0;
while(nt<22&&tries<800){tries++;
 var tx=(rnd()-0.5)*128,tz=(rnd()-0.5)*128;
 if(!okPos(tx,tz,false))continue;
 bx(0.5,2,0.5,0x8d5524,tx,1,tz);
 var fol=new THREE.Mesh(new THREE.SphereGeometry(1.5,12,10),M(0x2f9e44));fol.position.set(tx,3.3,tz);scene.add(fol);
 obst.push({x:tx,z:tz,hw:0.35,hd:0.35});placed.push({x:tx,z:tz,big:false});nt++;}
var PR=0.6;
function blocked(x,z){
 for(var i=0;i<obst.length;i++){var o=obst[i];
  var cx=Math.max(o.x-o.hw,Math.min(x,o.x+o.hw)),cz=Math.max(o.z-o.hd,Math.min(z,o.z+o.hd));
  if((x-cx)*(x-cx)+(z-cz)*(z-cz)<PR*PR)return true;}
 return false;
}

/* ===== Papan tanda (Kanvas 2D) ===== */
function mkSign(e){
 var cv=document.createElement('canvas');cv.width=cv.height=256;
 var tex=new THREE.CanvasTexture(cv);
 var spr=new THREE.Sprite(new THREE.SpriteMaterial({map:tex,transparent:true}));
 spr.scale.set(5.5,5.5,1);scene.add(spr);
 return {cx:cv.getContext('2d'),tex:tex,spr:spr,e:e};
}
function drawSign(s,num,dn){
 var c=s.cx;c.clearRect(0,0,256,256);
 c.beginPath();c.arc(128,128,120,0,7);c.fillStyle=dn?'#b2f2bb':'#fff3bf';c.fill();
 c.lineWidth=12;c.strokeStyle=dn?'#2f9e44':'#f08c00';c.stroke();
 c.font='110px "Segoe UI Emoji","Apple Color Emoji","Noto Color Emoji",sans-serif';
 c.textAlign='center';c.textBaseline='middle';c.fillStyle='#000';
 c.fillText(dn?'✅':s.e,128,112);
 if(num){c.font='bold 52px Arial';c.fillStyle='#d9480f';c.fillText(String(num),128,205);}
 s.tex.needsUpdate=true;
}
var stations=SP.map(function(p,i){
 var ring=new THREE.Mesh(new THREE.RingGeometry(3.6,4.6,40),new THREE.MeshBasicMaterial({color:0xff922b,side:THREE.DoubleSide}));
 ring.rotation.x=-Math.PI/2;ring.position.set(p[0],0.05,p[1]);scene.add(ring);
 var s=mkSign(QS[i].e);s.spr.position.set(p[0],7,p[1]);s.ring=ring;s.x=p[0];s.z=p[1];
 drawSign(s,i+1,false);return s;
});
var plaza=mkSign('👑');plaza.spr.position.set(0,7,0);drawSign(plaza,0,false);
var plRing=new THREE.Mesh(new THREE.RingGeometry(4,5.2,40),new THREE.MeshBasicMaterial({color:0xffd700,side:THREE.DoubleSide}));
plRing.rotation.x=-Math.PI/2;plRing.position.y=0.05;scene.add(plRing);

/* ===== Watak + zirah ===== */
var hero=new THREE.Group();scene.add(hero);
var legL=new THREE.Group(),legR=new THREE.Group(),armL=new THREE.Group(),armR=new THREE.Group();
legL.position.set(-0.3,1,0);legR.position.set(0.3,1,0);armL.position.set(-0.8,2.1,0);armR.position.set(0.8,2.1,0);
[legL,legR,armL,armR].forEach(function(g){hero.add(g);});
bx(0.4,1,0.4,0x3b82f6,0,-0.5,0,legL);bx(0.4,1,0.4,0x3b82f6,0,-0.5,0,legR);
bx(1.1,1.2,0.6,0xffd43b,0,1.6,0,hero);
bx(0.35,1,0.35,0xffd6a5,0,-0.45,0,armL);bx(0.35,1,0.35,0xffd6a5,0,-0.45,0,armR);
bx(0.8,0.8,0.8,0xffd6a5,0,2.6,0,hero);
bx(0.12,0.12,0.05,0x000000,-0.2,2.65,0.41,hero);bx(0.12,0.12,0.05,0x000000,0.2,2.65,0.41,hero);
bx(0.3,0.06,0.05,0xe03131,0,2.4,0.41,hero);
var P=[
 [bx(0.95,0.4,0.95,0xe03131,0,3.05,0,hero),bx(0.25,0.25,0.25,0xffd43b,0,3.35,0,hero)],
 [bx(1.25,0.9,0.7,0xced4da,0,1.75,0,hero)],
 [bx(0.5,0.3,0.5,0xadb5bd,-0.8,2.35,0,hero),bx(0.5,0.3,0.5,0xadb5bd,0.8,2.35,0,hero)],
 [bx(0.45,0.35,0.45,0xff922b,0,-0.95,0,armL),bx(0.45,0.35,0.45,0xff922b,0,-0.95,0,armR)],
 [bx(0.5,0.35,0.6,0x8d5524,0,-0.9,0.05,legL),bx(0.5,0.35,0.6,0x8d5524,0,-0.9,0.05,legR)],
 [bx(1.1,1.4,0.1,0x9c36b5,0,1.8,-0.4,hero)],
 [bx(0.15,0.9,0.7,0x37b24d,-0.3,-0.6,0.2,armL),bx(0.18,0.3,0.3,0xffd43b,-0.4,-0.6,0.2,armL)],
 [bx(1.2,0.2,0.7,0xf59f00,0,1.15,0,hero)]
];
var crown=[bx(0.9,0.25,0.9,0xffd700,0,3.5,0,hero),bx(0.2,0.35,0.2,0xffd700,-0.3,3.8,0,hero),bx(0.2,0.45,0.2,0xffd700,0,3.85,0,hero),bx(0.2,0.35,0.2,0xffd700,0.3,3.8,0,hero)];
function allPieces(){var a=[];P.forEach(function(g){a=a.concat(g);});return a.concat(crown);}
function showPiece(list,anim){list.forEach(function(m){m.visible=true;if(anim&&!RM){m.scale.setScalar(0.01);pops.push({m:m,t:0});}});}
function resetPieces(){allPieces().forEach(function(m){m.visible=false;m.scale.setScalar(1);});pops=[];}
resetPieces();

/* ===== Sasaran (tong) + blok ===== */
var tgt=[0,1,2].map(function(i){
 var g=new THREE.Group(),mat=M(BCOL[i]);
 var cyl=new THREE.Mesh(new THREE.CylinderGeometry(1.4,1.1,1.6,20),mat);cyl.position.y=0.8;g.add(cyl);
 var rim=new THREE.Mesh(new THREE.TorusGeometry(1.4,0.14,8,20),M(0xffffff));rim.rotation.x=Math.PI/2;rim.position.y=1.6;g.add(rim);
 var cv=document.createElement('canvas');cv.width=512;cv.height=160;
 var tex=new THREE.CanvasTexture(cv);
 var spr=new THREE.Sprite(new THREE.SpriteMaterial({map:tex,transparent:true}));spr.scale.set(5.6,1.75,1);spr.position.y=3.3;g.add(spr);
 g.visible=false;scene.add(g);
 return {g:g,mat:mat,cv:cv,tex:tex,col:BCOL[i]};
});
function drawLabel(t,txt){
 var c=t.cv.getContext('2d');c.clearRect(0,0,512,160);
 c.fillStyle='#fff';c.strokeStyle='#333';c.lineWidth=8;c.fillRect(8,8,496,144);c.strokeRect(8,8,496,144);
 var fs=80;c.font='bold '+fs+'px Arial';
 while(c.measureText(txt).width>470&&fs>24){fs-=4;c.font='bold '+fs+'px Arial';}
 c.fillStyle='#222';c.textAlign='center';c.textBaseline='middle';c.fillText(txt,256,84);t.tex.needsUpdate=true;
}
var block=new THREE.Group();scene.add(block);
bx(0.8,0.8,0.8,0xffd43b,0,0,0,block);bx(0.25,0.15,0.25,0xffd43b,-0.2,0.45,0,block);bx(0.25,0.15,0.25,0xffd43b,0.2,0.45,0,block);
block.visible=false;

/* ===== Audio (Web Audio API) ===== */
function initAudio(){
 if(!AC){try{AC=new (window.AudioContext||window.webkitAudioContext)();
  master=AC.createGain();master.gain.value=vol;master.connect(AC.destination);
  mus=AC.createGain();mus.gain.value=0.35;mus.connect(master);}catch(e){AC=null;}}
 if(AC&&AC.state==='suspended')AC.resume();
}
function tone(f,d,type,v,delay,dest){
 if(!AC)return;var t=AC.currentTime+(delay||0),o=AC.createOscillator(),g=AC.createGain();
 o.type=type||'sine';o.frequency.setValueAtTime(f,t);
 g.gain.setValueAtTime(0.0001,t);g.gain.exponentialRampToValueAtTime(v||0.3,t+0.02);g.gain.exponentialRampToValueAtTime(0.0001,t+d);
 o.connect(g);g.connect(dest||master);o.start(t);o.stop(t+d+0.05);
}
function sOk(){[523,659,784,1047].forEach(function(f,i){tone(f,0.25,'triangle',0.4,i*0.09);});}
function sNo(){tone(330,0.25,'sine',0.3,0);tone(262,0.35,'sine',0.3,0.18);}
function sThrow(){tone(300,0.12,'square',0.15,0);tone(500,0.12,'square',0.12,0.08);}
function sPop(){tone(880,0.12,'sine',0.35,0);tone(1320,0.18,'sine',0.25,0.1);}
function sWin(){[523,659,784,1047,784,1047,1319,1568].forEach(function(f,i){tone(f,0.35,'triangle',0.45,i*0.16);tone(f/2,0.35,'sine',0.3,i*0.16);});}
var MEL=[523,587,659,784,659,587,523,392,440,523,587,659,587,523,440,392],BAS=[131,196,175,196];
function useSynth(){
 mp3Ok=false;if(mp3){try{mp3.pause();}catch(e){}mp3=null;}
 if(!wantMusic||!AC||musTimer)return;
 musTimer=setInterval(function(){
  var n=MEL[step%16];tone(n,0.2,'triangle',0.5,0,mus);tone(n*2,0.1,'square',0.07,0,mus);
  if(step%4===0)tone(BAS[(step/4|0)%4],0.5,'sine',0.7,0,mus);
  step++;},230);
}
function startMusic(){
 stopMusic();wantMusic=true;if(!AC)return;
 if(mp3Ok===false){useSynth();return;}
 try{mp3=new Audio((window.BC_BASE||'')+'muzik.mp3');mp3.loop=true;mp3.volume=vol*0.6;
  mp3.addEventListener('error',useSynth);
  var pr=mp3.play();if(pr&&pr.then){pr.then(function(){mp3Ok=true;}).catch(useSynth);}}
 catch(e){useSynth();}
}
function stopMusic(){wantMusic=false;if(musTimer){clearInterval(musTimer);musTimer=null;}if(mp3){try{mp3.pause();}catch(e){}mp3=null;}}
function setVol(v){vol=v;if(master)master.gain.value=v;if(mp3)mp3.volume=v*0.6;}

/* ===== Simpan / UI ===== */
function save(){if(!cur)return;data[cur]={done:Array.from(done),won:won};try{localStorage.setItem('bc_prog',JSON.stringify(data));}catch(e){}}
function show(id){['menu','kelas','hudwrap','win'].forEach(function(s){$(s).classList.toggle('on',s===id);});}
function toast(t,ms){var e=$('toast');e.textContent=t;e.classList.add('on');clearTimeout(toastT);toastT=setTimeout(function(){e.classList.remove('on');},ms||2200);}
function hud(){$('who').textContent='👤 '+cur;$('prog').textContent='⭐ '+done.size+'/'+TOTAL;}
function renderList(){
 var l=$('list');l.innerHTML='';
 names.forEach(function(n){
  var p=data[n]||{},c=(p.done||[]).length,b=document.createElement('button');
  b.className='rb'+(p.won?' g':'');b.textContent=n+' — '+c+'/'+TOTAL+(p.won?' 🏆':'');
  b.onclick=function(){startPlayer(n);};l.appendChild(b);});
 if(!names.length)l.innerHTML='<p>Belum ada nama.</p>';
}
function saveNames(){
 var seen={};names=$('names').value.split(/\r?\n/).map(function(s){return s.trim();}).filter(function(s){if(!s||seen[s])return false;seen[s]=1;return true;});
 try{localStorage.setItem('bc_names',names.join('\n'));}catch(e){}
 renderList();
}
function shuffle(a){for(var i=a.length-1;i>0;i--){var j=Math.floor(Math.random()*(i+1)),t=a[i];a[i]=a[j];a[j]=t;}return a;}

/* ===== Alir permainan ===== */
function startPlayer(n){
 initAudio();cur=n;var p=data[n]||{};
 done=new Set(p.won?[]:(p.done||[]));won=false;
 resetPieces();
 stations.forEach(function(s,i){var d=done.has(i);drawSign(s,i+1,d);s.ring.material.color.set(d?0x40c057:0xff922b);if(d)showPiece(P[i],false);});
 plRing.material.color.set(0xffd700);
 if(confV){scene.remove(conf);conf=null;confV=null;}
 px=0;pz=10;vx=vz=0;ang=Math.PI;qs=null;flight=null;
 hero.position.set(px,0,pz);
 camera.position.set(px,ZM[zoom]*0.55,pz+ZM[zoom]*0.86);look.set(px,1.5,pz);
 mode='play';show('hudwrap');$('dpad').classList.remove('off');hud();startMusic();
 toast('Jom! Ikut anak panah 🧭',2600);
}
function closeQ(){
 qs=null;flight=null;block.visible=false;
 tgt.forEach(function(t){t.g.visible=false;t.g.scale.set(1,1,1);});
 $('card').classList.remove('on');$('answers').innerHTML='';$('dpad').classList.remove('off');
}
function endTurn(){
 save();clearTimeout(finTimer);stopMusic();closeQ();mode='menu';
 if(confV){scene.remove(conf);conf=null;confV=null;}
 if(classMode){renderList();show('kelas');}else{show('menu');}
}
function openQ(i){
 var d=QS[i],s=stations[i];
 var opts=shuffle([{w:d.w,ok:true},{w:d.x[0],ok:false},{w:d.x[1],ok:false}]);
 qs={i:i,done:false,busy:false,o:opts};
 px=s.x;pz=s.z+2.2;vx=vz=0;ang=Math.PI;
 var pos=[[-3.4,-2.2],[0,-3.2],[3.4,-2.2]];
 $('answers').innerHTML='';
 opts.forEach(function(o,k){
  var t=tgt[k];t.g.position.set(s.x+pos[k][0],0,s.z+pos[k][1]);t.g.visible=true;t.mat.color.set(t.col);t.g.scale.set(1,1,1);
  drawLabel(t,o.w);
  var b=document.createElement('button');b.className='rb';b.style.background='#'+('000000'+t.col.toString(16)).slice(-6);
  b.textContent='🧱 '+o.w;b.onclick=function(){throwTo(k);};$('answers').appendChild(b);
 });
 $('card').innerHTML='<div class="k">Lengkapkan peribahasa:</div><div class="p">'+d.p.replace('___','<b id="bl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>')+'</div><div class="m">💡 '+d.m+'</div>';
 $('card').classList.add('on');$('dpad').classList.add('off');$('arrow').classList.add('off');
}
function throwTo(k){
 if(!qs||qs.busy||qs.done||qs.o[k].used)return;
 qs.busy=true;sThrow();
 var t=tgt[k].g.position;
 ang=Math.atan2(t.x-px,t.z-pz);
 flight={t:0,a:new THREE.Vector3(px,2.8,pz),b:new THREE.Vector3(t.x,1.7,t.z),k:k};
 block.visible=true;block.position.copy(flight.a);
}
function land(k){
 var o=qs.o[k],btns=$('answers').children;
 if(o.ok){
  qs.done=true;sOk();wob={k:k,t:0};
  tgt.forEach(function(t,j){if(j!==k)t.mat.color.set(0xadb5bd);});
  for(var j=0;j<btns.length;j++)btns[j].disabled=true;
  var bl=$('bl');if(bl)bl.textContent=o.w;
  toast('⭐ Betul! Hebat!',1000);
  block.position.y=1.2;
  finTimer=setTimeout(finishStation,1000);
 }else{
  sNo();o.used=true;qs.busy=false;wob={k:k,t:0};
  tgt[k].mat.color.set(0xadb5bd);btns[k].disabled=true;
  toast('Cuba lagi 😊',1400);
  setTimeout(function(){if(qs&&!qs.done)block.visible=false;},450);
 }
}
function finishStation(){
 if(!qs)return;var i=qs.i;
 done.add(i);showPiece(P[i],true);sPop();
 drawSign(stations[i],i+1,true);stations[i].ring.material.color.set(0x40c057);
 closeQ();save();hud();
 toast(done.size===TOTAL?'👑 Pergi ke dataran tengah!':'🎁 Dapat: '+PN[i]+'!',2800);
}
function victory(){
 won=true;mode='win';save();showPiece(crown,true);sWin();
 var n=RM?60:240,pos=new Float32Array(n*3),col=new Float32Array(n*3);confV=new Float32Array(n);
 var pal=[[1,.3,.3],[.3,.6,1],[1,.85,.2],[.3,.85,.4],[.8,.4,1]];
 for(var i=0;i<n;i++){pos[i*3]=(Math.random()-.5)*28;pos[i*3+1]=Math.random()*22;pos[i*3+2]=(Math.random()-.5)*28;
  var c=pal[i%5];col[i*3]=c[0];col[i*3+1]=c[1];col[i*3+2]=c[2];confV[i]=2.5+Math.random()*2.5;}
 var g=new THREE.BufferGeometry();g.setAttribute('position',new THREE.BufferAttribute(pos,3));g.setAttribute('color',new THREE.BufferAttribute(col,3));
 conf=new THREE.Points(g,new THREE.PointsMaterial({size:0.8,vertexColors:true}));conf.frustumCulled=false;scene.add(conf);
 $('winName').textContent=cur;$('arrow').classList.add('off');
 setTimeout(function(){if(mode==='win')show('win');},1500);
}

/* ===== Input ===== */
window.addEventListener('keydown',function(e){
 if(mode!=='play')return;
 keys[e.code]=true;
 if(qs&&(e.code==='Digit1'||e.code==='Digit2'||e.code==='Digit3'))throwTo(parseInt(e.code.slice(5),10)-1);
 if(e.code.indexOf('Arrow')===0||e.code==='Space')e.preventDefault();
});
window.addEventListener('keyup',function(e){keys[e.code]=false;});
window.addEventListener('blur',function(){keys={};touch={};});
Array.prototype.forEach.call(document.querySelectorAll('#dpad button'),function(b){
 var d=b.getAttribute('data-d');
 b.addEventListener('pointerdown',function(e){e.preventDefault();touch[d]=true;});
 ['pointerup','pointerleave','pointercancel'].forEach(function(ev){b.addEventListener(ev,function(){touch[d]=false;});});
});
Array.prototype.forEach.call(document.querySelectorAll('.zb'),function(b){
 b.onclick=function(){zoom=parseInt(b.getAttribute('data-z'),10);Array.prototype.forEach.call(document.querySelectorAll('.zb'),function(x){x.classList.toggle('on',x===b);});};});
Array.prototype.forEach.call(document.querySelectorAll('.vb'),function(b){
 b.onclick=function(){setVol(parseFloat(b.getAttribute('data-v')));Array.prototype.forEach.call(document.querySelectorAll('.vb'),function(x){x.classList.toggle('on',x===b);});};});
$('bSingle').onclick=function(){classMode=false;startPlayer('Murid');};
$('bClass').onclick=function(){classMode=true;$('names').value=names.join('\n');renderList();show('kelas');};
$('bSave').onclick=saveNames;
$('bBack').onclick=function(){saveNames();classMode=false;show('menu');};
$('bEnd').onclick=endTurn;
$('bNext').onclick=endTurn;
if(location.protocol!=='file:')$('lobi').style.display='inline';

/* ===== Kemas kini setiap bingkai ===== */
function update(dt){
 var sp=0;
 if(mode==='play'&&!qs){
  var ix=((keys.ArrowRight||keys.KeyD||touch.r)?1:0)-((keys.ArrowLeft||keys.KeyA||touch.l)?1:0);
  var iz=((keys.ArrowDown||keys.KeyS||touch.d)?1:0)-((keys.ArrowUp||keys.KeyW||touch.u)?1:0);
  var len=Math.hypot(ix,iz);if(len>0){ix/=len;iz/=len;}
  var k=1-Math.exp(-3*dt);
  vx+=(ix*4.5-vx)*k;vz+=(iz*4.5-vz)*k;
  var nx=px+vx*dt;if(!blocked(nx,pz))px=nx;else vx=0;
  var nz=pz+vz*dt;if(!blocked(px,nz))pz=nz;else vz=0;
  px=Math.max(-66,Math.min(66,px));pz=Math.max(-66,Math.min(66,pz));
  sp=Math.hypot(vx,vz);
  if(sp>0.3){var ta=Math.atan2(vx,vz),da=ta-ang;while(da>Math.PI)da-=2*Math.PI;while(da<-Math.PI)da+=2*Math.PI;ang+=da*(1-Math.exp(-6*dt));}
  /* masuk bulatan stesen */
  for(var i=0;i<stations.length;i++){
   if(!done.has(i)&&Math.hypot(px-stations[i].x,pz-stations[i].z)<4.6){openQ(i);break;}}
  if(!qs&&done.size===TOTAL&&!won&&Math.hypot(px,pz)<5)victory();
  /* anak panah */
  var tx=0,tz=0,found=false;
  for(var j=0;j<stations.length;j++){if(!done.has(j)){tx=stations[j].x;tz=stations[j].z;found=true;break;}}
  if(!qs&&!won){
   $('arrow').classList.remove('off');
   $('arrow').style.transform='rotate('+(Math.atan2(tx-px,-(tz-pz))*180/Math.PI)+'deg)';
  }
 }
 ph+=dt*sp*2.2;var a=sp/4.5;
 legL.rotation.x=Math.sin(ph)*0.6*a;legR.rotation.x=-Math.sin(ph)*0.6*a;
 armL.rotation.x=-Math.sin(ph)*0.5*a;armR.rotation.x=Math.sin(ph)*0.5*a;
 hero.position.set(px,(!RM&&sp>0.3)?Math.abs(Math.sin(ph))*0.1:0,pz);hero.rotation.y=ang;
 /* lontaran blok */
 if(flight){
  flight.t+=dt/0.9;var t=Math.min(1,flight.t);
  block.position.lerpVectors(flight.a,flight.b,t);block.position.y+=Math.sin(Math.PI*t)*3;block.rotation.x+=dt*8;
  if(t>=1){var kk=flight.k;flight=null;land(kk);}
 }
 if(wob){wob.t+=dt*3;var w=wob.t>=1?1:1+0.2*Math.sin(wob.t*Math.PI);tgt[wob.k].g.scale.y=w;if(wob.t>=1)wob=null;}
 for(var q=pops.length-1;q>=0;q--){var pp=pops[q];pp.t+=dt*2.5;
  if(pp.t>=1){pp.m.scale.setScalar(1);pops.splice(q,1);}else pp.m.scale.setScalar(pp.t*1.1);}
 if(!RM){for(var s=0;s<stations.length;s++)stations[s].spr.position.y=7+Math.sin(tm*2+s)*0.3;plaza.spr.position.y=7+Math.sin(tm*2)*0.3;}
 if(confV){var ps=conf.geometry.attributes.position;
  for(var c=0;c<confV.length;c++){var y=ps.array[c*3+1]-confV[c]*dt;if(y<0)y=22;ps.array[c*3+1]=y;}
  ps.needsUpdate=true;}
 /* kamera lembut, tidak berpusing */
 var fx=px,fz=pz;if(qs){fx=stations[qs.i].x;fz=stations[qs.i].z-0.5;}
 var D=ZM[zoom],kc=1-Math.exp(-2*dt);
 camera.position.x+=(fx-camera.position.x)*kc;
 camera.position.y+=(D*0.55-camera.position.y)*kc;
 camera.position.z+=(fz+D*0.86-camera.position.z)*kc;
 look.x+=(fx-look.x)*kc;look.y+=(1.5-look.y)*kc;look.z+=(fz-look.z)*kc;
 camera.lookAt(look);
}
function loop(now){
 requestAnimationFrame(loop);
 var dt=Math.min(0.05,(now-last)/1000);if(!(dt>=0))dt=0.016;last=now;tm+=dt;
 update(dt);renderer.render(scene,camera);
}
last=performance.now();
requestAnimationFrame(loop);
}

var errShown=false;
window.addEventListener('error',function(e){if(errShown)return;errShown=true;fatal('Ralat JavaScript: '+(e.message||'tidak diketahui')+' (baris '+(e.lineno||'?')+')');});
function run(){try{boot();}catch(e){fatal('Ralat permainan: '+(e&&e.message?e.message:e));}}
var cands=[(window.BC_BASE||'')+'three.min.js','/baling/three.min.js'];
function load(i){
 if(i>=cands.length){fatal('three.min.js tidak dijumpai. Letakkan fail itu dalam public/baling/ dan muat semula (Ctrl+F5).');return;}
 var s=document.createElement('script');s.src=cands[i];
 s.onload=function(){if(typeof THREE==='undefined'){fatal('three.min.js dimuat tetapi BUKAN fail Three.js yang sah (rosak atau dibungkus HTML). Salin semula isi failnya ke fail baharu.');}else{run();}};
 s.onerror=function(){load(i+1);};
 document.head.appendChild(s);
}
if(typeof THREE!=='undefined'){run();}else{load(0);}
})();
</script>
</body>
</html>
