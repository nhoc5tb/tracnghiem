const progressJS={defaults:{color:"#003f72",height:"3px",top:0,bottom:0,left:0,right:0,zIndex:9999,ontop:!0,ltr:!0,attach:!1,css:!1,round:!1,nobar:!1},start:function(i={}){let s;i.nobar||(s=document.createElement("div"),s.setAttribute("id","progressbarJS"),document.body.appendChild(s),s.style.position="fixed",s.style.zIndex="99999",s.style.width="0%",i.ontop?s.style.bottom="0":s.style.top=progressJS.defaults.top,i.ltr?s.style.right="0":s.style.left=progressJS.defaults.left,i.height?s.style.height=i.height:s.style.height=progressJS.defaults.height,i.color?s.style.backgroundColor=i.color:s.style.backgroundColor=progressJS.defaults.color);let r=progressJS.defaults.attach,c=progressJS.defaults.round;c=i.round||2,i.attach&&(r=document.querySelector(i.attach)),document.addEventListener("scroll",function(e){var t=document.body.scrollHeight,o=window.innerHeight;const n=window.scrollY/(t-o)*100;i.nobar||(s.style.width=n.toFixed(c)+"%"),r&&(r.innerHTML=n.toFixed(c))})}},flexOnScroll={init:function(e){this.div=document.getElementById(e);window.addEventListener("scroll",()=>{var e=this.div.getBoundingClientRect(),t=parseInt(e.top)-65,o=parseInt(e.width),e=parseInt(e.left);t<=0&&this.div.setAttribute("data-pageYOffset",window.pageYOffset),window.pageYOffset>parseInt(this.div.getAttribute("data-pageYOffset"))?(this.div.style.width=o+"px",this.div.style.top="50px",this.div.style.left=e+"px",this.div.style.position="fixed"):(this.div.style.width="auto",this.div.style.top="auto",this.div.style.left="auto",this.div.style.position="relative")})},applyFlexToDiv:function(){}};var Mio={config:{},option:{url_site:"",csrf_token:"",changeTheme:"",idSearchInput:"",idSearch:"",qMenu:"",stickyBanner:"",countDownTime:10,finger_key:"bget",finger_val:"",notification:""},sendAjaxRequest:function(e,t,o,n,i){var s=new XMLHttpRequest;s.open(e,this.config.url_site+t,!0),s.setRequestHeader("Content-Type","application/json;charset=UTF-8"),null!==n&&s.setRequestHeader("Authorization",n),s.onreadystatechange=function(){var e;s.readyState===XMLHttpRequest.DONE&&(200===s.status?(e=JSON.parse(s.responseText),i(null,e)):i("Lỗi: "+s.status,null))},"POST"===e?(o.ru_csrf_token_name=this.config.csrf_token,o.finger=sessionStorage.getItem("_tmp"),o=JSON.stringify(o),s.send(o)):s.send()},setTheme:function(){if(this.config.changeTheme.addEventListener("click",function(){document.querySelector("html").classList;"theme"in localStorage?"dark"==localStorage.theme?(document.querySelector("html").classList.remove("dark"),localStorage.theme="light"):(document.querySelector("html").classList.add("dark"),localStorage.theme="dark"):window.matchMedia("(prefers-color-scheme: dark)").matches?localStorage.theme="light":localStorage.theme="dark"}),"theme"in localStorage)switch(localStorage.theme){case"dark":document.querySelector("html").classList.add("dark"),this.config.changeTheme.checked=!1;break;case"light":document.querySelector("html").classList.remove("dark"),this.config.changeTheme.checked=!0}else window.matchMedia("(prefers-color-scheme: dark)").matches?(document.documentElement.classList.add("dark"),this.config.changeTheme.checked=!1):(document.documentElement.classList.remove("dark"),this.config.changeTheme.checked=!0)},search:function(){let n=this.config.idSearch;this.config.idSearchInput.addEventListener("focus",function(e){var t=document.querySelector(".psearch").getBoundingClientRect(),o=document.getElementById("navbar").getBoundingClientRect();defaultWidth=t.width;o=t.width+o.width-8;n.style.width=o+"px",13===e.which||e.keyCode}),this.config.idSearchInput.addEventListener("blur",function(){n.style.width="300px"})},menu:function(){this.config.qMenu.forEach(function(t){t.addEventListener("click",function(e){e.preventDefault();e=t.getAttribute("href"),e=document.querySelector(e);e&&e.scrollIntoView({behavior:"smooth"})})})},startTimer:function(e,t){var o,n,i=e,s=setInterval(function(){o=parseInt(i/60,10),n=parseInt(i%60,10),o=o<10?"0"+o:o,n=n<10?"0"+n:n,t.innerHTML="Thời gian hoàn thành còn <strong>"+o+":"+n+"</strong>",--i<0&&(clearInterval(s),t.textContent="Thời gian hoàn thành đã kết thúc")},1e3)},finger:function(){FingerprintJS.load().then(e=>e.get()).then(e=>{e=e.visitorId;localStorage.setItem(this.config.finger_key,e),sessionStorage.setItem("_tmp",e)}).catch(e=>{}),this.config.finger_val=sessionStorage.getItem("_tmp")},lsremove:function(){},modal:function(e){var t=this.config.notification;new Modal(t).toggle(),t.querySelector("#contentModal").innerText=e,t.querySelector("#close-notification-modal").addEventListener("click",function(){document.querySelector("body").classList.remove("overflow-hidden"),document.querySelector("#notification-modal").classList.add("hidden");var e=document.querySelector("div[modal-backdrop]");e&&e.remove()})},process:function(){var e,t={};for(e in this.option)this.option.hasOwnProperty(e)&&(t[e]=this.option[e]);for(e in this.config)this.config.hasOwnProperty(e)&&(t[e]=this.config[e]);this.config=t,this.search(),this.setTheme(),this.menu(),this.finger(),this.lsremove()}};document.addEventListener("DOMContentLoaded",function(e){progressJS.start()}),setInterval(function(){window.location.reload()},17e5);
function dkDaiLy(phone){
    var data = {
        phone: phone
    };
    var xhr = new XMLHttpRequest();
        xhr.open("POST", base_url+"send-dk-dai-ly", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {                    
                    var response = JSON.parse(xhr.responseText);
                    callback(null, response);
                } else {
                    callback("Lỗi: " + xhr.status, null);
                }
            }
        };
        var jsonData = JSON.stringify(data);
            xhr.send(jsonData);
}


var elements = document.getElementsByClassName('ru-js-senddk');
// Lặp qua danh sách các phần tử và thêm sự kiện click
for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', function() {
        var inputs = document.getElementsByClassName('ru-js-input');
        for (var i = 0; i < inputs.length; i++) {
            if(inputs[i].value != ""){
                dkDaiLy(inputs[i].value);
            }
        }
    });
}